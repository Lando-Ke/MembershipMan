<?php
  /**
   * User Class
   */

  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  class Users
  {
      const uTable = "users";
      public $logged_in = null;
      public $uid = 0;
      public $userid = 0;
      public $username;
      public $email;
      public $name;
      public $membership_id = 0;
      public $userlevel;
      public $cookie_id = 0;
	  public $last;
	  public $avatar;
	  public $country;
      private $lastlogin = "NOW()";
      private static $db;


      /**
       * Users::__construct()
       * 
       * @return
       */
      function __construct()
      {
          self::$db = Registry::get("Database");

          $this->startSession();
      }

      /**
       * Users::startSession()
       * 
       * @return
       */
      private function startSession()
      {
          if (strlen(session_id()) < 1)
              session_start();

          $this->logged_in = $this->loginCheck();

          if (!$this->logged_in) {
              $this->username = $_SESSION['username'] = "Guest";
              $this->sesid = sha1(session_id());
              $this->userlevel = 0;
          }
      }

      /**
       * Users::loginCheck()
       * 
       * @return
       */
      private function loginCheck()
      {
          if (isset($_SESSION['username']) && $_SESSION['username'] != "Guest") {
			  
              $row = $this->getUserInfo($_SESSION['username']);
              $this->uid = $row->id;
              $this->username = $row->username;
              $this->email = $row->email;
              $this->name = $row->fname . ' ' . $row->lname;
              $this->userlevel = $row->userlevel;
              $this->cookie_id = $row->cookie_id;
			  $this->last = $row->lastlogin;
			  $this->avatar = $row->avatar;
			  $this->country = $row->country;
              $this->membership_id = $row->membership_id;
              return true;
          } else {
              return false;
          }
      }

      /**
       * Users::is_Admin()
       * 
       * @return
       */
      public function is_Admin()
      {
          return ($this->userlevel == 9);

      }

      /**
       * Users::login()
       * 
       * @param mixed $username
       * @param mixed $pass
       * @return
       */
      public function login($username, $pass)
      {
          if ($username == "" && $pass == "") {
              Filter::$msgs['username'] = Core::$word->LG_ERROR1;
          } else {
              $status = $this->checkStatus($username, $pass);

              switch ($status) {
                  case 0:
                      Filter::$msgs['username'] = Core::$word->LG_ERROR2;
                      break;

                  case 1:
                      Filter::$msgs['username'] = Core::$word->LG_ERROR3;
                      break;

                  case 2:
                      Filter::$msgs['username'] = Core::$word->LG_ERROR4;
                      break;

                  case 3:
                      Filter::$msgs['username'] = Core::$word->LG_ERROR5;
                      break;
              }
          }
          if (empty(Filter::$msgs) && $status == 5) {
              $row = $this->getUserInfo($username);
              $this->uid = $_SESSION['userid'] = $row->id;
              $this->username = $_SESSION['username'] = $row->username;
              $this->email = $_SESSION['email'] = $row->email;
              $this->name = $_SESSION['name'] = $row->fname . ' ' . $row->lname;
              $this->userlevel = $_SESSION['userlevel'] = $row->userlevel;
              $this->cookie_id = $_SESSION['cookie_id'] = $this->generateRandID();
			  $this->last = $_SESSION['last'] = $row->lastlogin;
			  $this->avatar = $_SESSION['avatar'] = $row->avatar;
			  $this->country = $_SESSION['country '] = $row->country;
              $this->membership_id = $_SESSION['membership_id'] = $row->membership_id;

              $data = array(
                  'lastlogin' => $this->lastlogin,
                  //'cookie_id' => $this->cookie_id,
                  'lastip' => sanitize($_SERVER['REMOTE_ADDR'])
				  );
				  
              self::$db->update(self::uTable, $data, "username='" . $this->username . "'");
              if (!$this->validateMembership()) {
                  $data = array('membership_id' => 0, 'mem_expire' => "0000-00-00 00:00:00");
                  self::$db->update(self::uTable, $data, "username='" . $this->username . "'");
              }


              return true;
          } else
              Filter::msgStatus();
      }

      /**
       * Users::logout()
       * 
       * @return
       */
      public function logout()
      {

          unset($_SESSION['username']);
          unset($_SESSION['email']);
          unset($_SESSION['name']);
          unset($_SESSION['membership_id']);
          unset($_SESSION['userid']);
          unset($_SESSION['cookie_id']);
          session_destroy();
          session_regenerate_id();

          $this->logged_in = false;
          $this->username = "Guest";
          $this->userlevel = 0;
      }

      /**
       * User::confirmUserID()
       * 
       * @param mixed $username
       * @param mixed $cookie_id
       * @return
       */
      function confirmUserID($username, $cookie_id)
      {

          $sql = "SELECT cookie_id FROM users WHERE username = '" . self::$db->escape($username) . "'";
          $result = self::$db->query($sql);
          if (!$result || (self::$db->numrows($result) < 1)) {
              return 1;
          }

          $row = self::$db->fetch($result);
          $row->cookie_id = sanitize($row->cookie_id);
          $cookie_id = sanitize($cookie_id);

          if ($cookie_id == $row->cookie_id) {
              return 0;
          } else {
              return 2;
          }
      }

      /**
       * Users::getUserInfo()
       * 
       * @param mixed $username
       * @return
       */
      private function getUserInfo($username)
      {
          $username = sanitize($username);
          $username = self::$db->escape($username);

          $sql = "SELECT * FROM " . self::uTable . " WHERE username = '" . $username . "' OR email ='" . $username . "'";
          $row = self::$db->first($sql);
          if (!$username)
              return false;

          return ($row) ? $row : 0;
      }

      /**
       * Users::checkStatus()
       * 
       * @param mixed $username
       * @param mixed $pass
       * @return
       */
      public function checkStatus($username, $pass)
      {

          $username = sanitize($username);
          $username = self::$db->escape($username);
          $pass = sanitize($pass);

          $sql = "SELECT password, active FROM " . self::uTable 
		  . "\n WHERE username = '" . $username . "' OR email = '" . $username . "'";
          $result = self::$db->query($sql);

          if (self::$db->numrows($result) == 0)
              return 0;

          $row = self::$db->fetch($result);
          $entered_pass = sha1($pass);

          switch ($row->active) {
              case "b":
                  return 1;
                  break;

              case "n":
                  return 2;
                  break;

              case "t":
                  return 3;
                  break;

              case "y" && $entered_pass == $row->password:
                  return 5;
                  break;
          }
      }

      /**
       * Users::getUsers()
       * 
       * @param bool $from
       * @return
       */
      public function getUsers($from = false)
      {

          if (isset($_GET['letter']) and (isset($_POST['fromdate_submit']) && $_POST['fromdate_submit'] <> "" || isset($from) && $from != '')) {
              $enddate = date("Y-m-d");
              $letter = sanitize($_GET['letter'], 2);
              $fromdate = (empty($from)) ? sanitize($_POST['fromdate_submit']) : $from;
              if (isset($_POST['enddate_submit']) && $_POST['enddate_submit'] <> "") {
                  $enddate = sanitize($_POST['enddate_submit']);
              }
              $q = ("SELECT COUNT(*) FROM " . self::uTable . " WHERE created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59' AND username REGEXP '^" . $letter . "'");
              $and = "WHERE created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59' AND username REGEXP '^" . $letter . "'";

          } elseif (isset($_POST['fromdate_submit']) && $_POST['fromdate_submit'] <> "" || isset($from) && $from != '') {
              $enddate = date("Y-m-d");
              $fromdate = (empty($from)) ? sanitize($_POST['fromdate_submit']) : $from;
              if (isset($_POST['enddate_submit']) && $_POST['enddate_submit'] <> "") {
                  $enddate = sanitize($_POST['enddate_submit']);
              }
              $q = ("SELECT COUNT(*) FROM " . self::uTable . " WHERE created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'");
              $and = "WHERE created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'";

          } elseif (isset($_GET['letter'])) {
              $letter = sanitize($_GET['letter'], 2);
              $and = "WHERE username REGEXP '^" . $letter . "'";
              $q = ("SELECT COUNT(*) FROM " . self::uTable . " WHERE username REGEXP '^" . $letter . "' LIMIT 1");
          } else {
              $q = ("SELECT COUNT(*) FROM " . self::uTable);
              $and = null;
          }

          $record = self::$db->query($q);
          $total = self::$db->fetchrow($record);
          $counter = $total[0];
		  
          if (isset($_GET['order'])) {
              list($sort, $order) = explode("-", $_GET['order']);
              $sort = sanitize($sort, 10);
              $order = sanitize($order, 4);
              if (in_array($sort, array(
                  "username",
                  "fname",
                  "email",
                  "active"))) {
                  $ord = ($order == 'DESC') ? " DESC" : " ASC";
                  $sorting = $sort . $ord;
              } else {
                  $sorting = " created DESC";
              }
          } else {
              $sorting = " created DESC";
          }

          $pager = Paginator::instance();
          $pager->items_total = $counter;
          $pager->default_ipp = Registry::get("Core")->perpage;
          $pager->paginate();
		  
          $sql = "SELECT u.*, CONCAT(u.fname,' ',u.lname) as name, m.title, m.id as mid, c.name as cname" 
		  . "\n FROM " . self::uTable . " as u" 
		  . "\n LEFT JOIN " . Membership::mTable . " as m ON m.id = u.membership_id"
		  . "\n LEFT JOIN " . Content::cTable . " as c ON c.abbr = u.country"
		  . "\n $and"
		  . "\n ORDER BY " . $sorting . $pager->limit;
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Users::processUser()
       * 
       * @return
       */
      public function processUser()
      {

          if (!Filter::$id) {
			  Filter::checkPost('username', Core::$word->UR_USERNAME_R);
			  Filter::checkPost('password', Core::$word->PASSWORD);

			  if ($this->emailExists($_POST['email']))
				  Filter::$msgs['email'] = Core::$word->UR_EMAIL_R1;
				  
              if ($value = $this->usernameExists($_POST['username'])) {
				  if ($value == 1)
					  Filter::$msgs['username'] = Core::$word->UR_USERNAME_R1;
				  if ($value == 2)
					  Filter::$msgs['username'] = Core::$word->UR_USERNAME_R2;
				  if ($value == 3)
					  Filter::$msgs['username'] = Core::$word->UR_USERNAME_R3;
              }
          }

		  Filter::checkPost('fname', Core::$word->UR_FNAME);
		  Filter::checkPost('lname', Core::$word->UR_LNAME);
          Filter::checkPost('email', Core::$word->EMAIL);
		  Filter::checkPost('address', Core::$word->UR_ADDRESS);
		  Filter::checkPost('city', Core::$word->UR_CITY);
		  Filter::checkPost('country', Core::$word->UR_COUNTRY);
		  Filter::checkPost('state', Core::$word->UR_STATE);
		  Filter::checkPost('zip', Core::$word->UR_ZIP);
		  
          if (!$this->isValidEmail($_POST['email']))
              Filter::$msgs['email'] = Core::$word->UR_EMAIL_R2;

          if (!empty($_FILES['avatar']['name'])) {
              if (!preg_match("/(\.jpg|\.png)$/i", $_FILES['avatar']['name'])) {
                  Filter::$msgs['avatar'] = Core::$word->CG_LOGO_R;
              }
              $file_info = getimagesize($_FILES['avatar']['tmp_name']);
              if (empty($file_info))
                  Filter::$msgs['avatar'] = Core::$word->CG_LOGO_R;
          }
		  
		  if(Filter::$id) {
			  $this->verifyCustomFields("profile");
		  } else {
			  $this->verifyCustomFields("register");
		  }

          if (empty(Filter::$msgs)) {

              $trial = getValueById("trial", Membership::mTable, intval($_POST['membership_id']));
			  $cur_mem = Filter::$id ? getValueById("membership_id", self::uTable, Filter::$id) : 0;
			  $mem_exp = Filter::$id ? getValueById("mem_expire", self::uTable, Filter::$id) : 0;
              $data = array(
                  'username' => sanitize($_POST['username']),
                  'email' => sanitize($_POST['email']),
                  'lname' => sanitize($_POST['lname']),
                  'fname' => sanitize($_POST['fname']),
				  'address' => sanitize($_POST['address']),
				  'city' => sanitize($_POST['city']),
				  'country' => sanitize($_POST['country']),
				  'state' => sanitize($_POST['state']),
				  'zip' => sanitize($_POST['zip']),
                  'membership_id' => ($cur_mem != intval($_POST['membership_id'])) ? intval($_POST['membership_id']) : 0,
                  'mem_expire' => ($cur_mem != intval($_POST['membership_id'])) ? $this->calculateDays($_POST['membership_id']) : $mem_exp,
				  'notes' => sanitize($_POST['notes']),
                  'trial_used' => ($trial) ? 1 : 0,
                  'newsletter' => intval($_POST['newsletter']),
                  'userlevel' => intval($_POST['userlevel']),
                  'active' => sanitize($_POST['active'])
				  );

              if (!Filter::$id)
                  $data['created'] = "NOW()";

              if (Filter::$id)
                  $userrow = Registry::get("Core")->getRowById(self::uTable, Filter::$id);

              if ($_POST['password'] != "") {
                  $data['password'] = sha1($_POST['password']);
              } else {
                  $data['password'] = $userrow->password;
              }

			  // Start Custom Fields
			  $fl_array = array_key_exists_wildcard($_POST, 'custom_*', 'key-value');
			  if (isset($fl_array)) {
				  $fields = $fl_array;
				  $total = count($fields);
				  if (is_array($fields)) {
					  $fielddata = '';
					  foreach ($fields as $fid) {
						  $fielddata .= $fid . "::";
					  }
				  }
				  $data['custom_fields'] = $fielddata;
			  }
			  
              // Procces Avatar
              if (!empty($_FILES['avatar']['name'])) {
                  $thumbdir = UPLOADS;
                  $tName = "AVT_" . randName();
                  $text = substr($_FILES['avatar']['name'], strrpos($_FILES['avatar']['name'], '.') + 1);
                  $thumbName = $thumbdir . $tName . "." . strtolower($text);
                  if (Filter::$id && $thumb = getValueById("avatar", self::uTable, Filter::$id)) {
                      @unlink($thumbdir . $thumb);
                  }
                  move_uploaded_file($_FILES['avatar']['tmp_name'], $thumbName);
                  $data['avatar'] = $tName . "." . strtolower($text);
              }

              (Filter::$id) ? self::$db->update(self::uTable, $data, "id=" . Filter::$id) : $last_id = self::$db->insert(self::uTable, $data);
			  $message = (Filter::$id) ? Core::$word->UR_UPDATED : Core::$word->UR_ADDED;

              if (self::$db->affected()) {
				  $json['type'] = 'success';
				  $json['title'] = Core::$word->SUCCESS;
				  $json['message'] = $message;
				  print json_encode($json);

                  if (isset($_POST['notify']) && intval($_POST['notify']) == 1) {
					  if(Filter::$id) {
						  $randpass = $this->getUniqueCode(12);
						  $newpass = sha1($randpass);
						  $pass = $randpass;
						  $pdata['password'] = $newpass;
						  self::$db->update(self::uTable, $pdata, "id=" . Filter::$id);
					  } else {
						  $pass = $_POST['password'];
					  }
					  
                      require_once (BASEPATH . "lib/class_mailer.php");
                      $mailer = Mailer::sendMail();
                      $row = Registry::get("Core")->getRowById("email_templates", 3);

                      $body = str_replace(array(
                          '[USERNAME]',
                          '[PASSWORD]',
                          '[NAME]',
                          '[SITE_NAME]',
                          '[URL]'), array(
                          $data['username'],
                          $pass,
                          $data['fname'] . ' ' . $data['lname'],
                          Registry::get("Core")->site_name,
                          SITEURL), $row->body);

                      $message = Swift_Message::newInstance()
								->setSubject($row->subject)
								->setTo(array($data['email'] => $data['fname'] . ' ' . $data['lname']))
								->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
								->setBody(cleanOut($body), 'text/html');

                      $numSent = $mailer->send($message);
				  }
			  } else {
				  $json['type'] = 'warning';
				  $json['title'] = Core::$word->ALERT;
				  $json['message'] = Core::$word->SYSTEM_PROCCESS;
				  print json_encode($json);
			  }
	
		  } else {
			  $json['type'] = 'error';
			  $json['title'] = Core::$word->SYSTEM_ERR;
			  $json['message'] = Filter::msgSingleStatus();
			  print json_encode($json);
		  }
	  }

      /**
       * Users::updateProfile()
       * 
       * @return
       */
      public function updateProfile()
      {

		  Filter::checkPost('fname', Core::$word->UR_FNAME);
		  Filter::checkPost('lname', Core::$word->UR_LNAME);
          Filter::checkPost('email', Core::$word->EMAIL);
		  Filter::checkPost('address', Core::$word->UR_ADDRESS);
		  Filter::checkPost('city', Core::$word->UR_CITY);
		  Filter::checkPost('country', Core::$word->UR_COUNTRY);
		  Filter::checkPost('state', Core::$word->UR_STATE);
		  Filter::checkPost('zip', Core::$word->UR_ZIP);
		  
          if (!$this->isValidEmail($_POST['email']))
              Filter::$msgs['email'] = Core::$word->UR_EMAIL_R2;

          if (!empty($_FILES['avatar']['name'])) {
              if (!preg_match("/(\.jpg|\.png)$/i", $_FILES['avatar']['name'])) {
                  Filter::$msgs['avatar'] = Core::$word->CG_LOGO_R;
              }
              $file_info = getimagesize($_FILES['avatar']['tmp_name']);
              if (empty($file_info))
                  Filter::$msgs['avatar'] = Core::$word->CG_LOGO_R;
          }
		  
		  $this->verifyCustomFields("profile");

          if (empty(Filter::$msgs)) {

              $data = array(
                  'email' => sanitize($_POST['email']),
                  'lname' => sanitize($_POST['lname']),
                  'fname' => sanitize($_POST['fname']),
				  'address' => sanitize($_POST['address']),
				  'city' => sanitize($_POST['city']),
				  'country' => sanitize($_POST['country']),
				  'state' => sanitize($_POST['state']),
				  'zip' => sanitize($_POST['zip']),
                  'newsletter' => intval($_POST['newsletter'])
				  );

              // Procces Avatar
              if (!empty($_FILES['avatar']['name'])) {
                  $thumbdir = UPLOADS;
                  $tName = "AVT_" . randName();
                  $text = substr($_FILES['avatar']['name'], strrpos($_FILES['avatar']['name'], '.') + 1);
                  $thumbName = $thumbdir . $tName . "." . strtolower($text);
                  if (Filter::$id && $thumb = getValueById("avatar", self::uTable, Filter::$id)) {
                      @unlink($thumbdir . $thumb);
                  }
                  move_uploaded_file($_FILES['avatar']['tmp_name'], $thumbName);
                  $data['avatar'] = $tName . "." . strtolower($text);
              }

              $userpass = getValueById("password", self::uTable, $this->uid);

              if ($_POST['password'] != "") {
                  $data['password'] = sha1($_POST['password']);
              } else
                  $data['password'] = $userpass;

			  $fl_array = array_key_exists_wildcard($_POST, 'custom_*', 'key-value');
			  if (isset($fl_array)) {
				  $fields = $fl_array;
				  $total = count($fields);
				  if (is_array($fields)) {
					  $fielddata = '';
					  foreach ($fields as $fid) {
						  $fielddata .= $fid . "::";
					  }
				  }
				  $data['custom_fields'] = $fielddata;
			  } 
			  
              self::$db->update(self::uTable, $data, "id=" . $this->uid);
			  
              if (self::$db->affected()) {
				  $json['type'] = 'success';
				  $json['title'] = Core::$word->SUCCESS;
				  $json['message'] = Core::$word->UA_UPDATEOK;
				  print json_encode($json);
			  } else {
				  $json['type'] = 'warning';
				  $json['title'] = Core::$word->ALERT;
				  $json['message'] = Core::$word->SYSTEM_PROCCESS;
				  print json_encode($json);
			  }
		  } else {
			  $json['type'] = 'error';
			  $json['title'] = Core::$word->SYSTEM_ERR;
			  $json['message'] = Filter::msgSingleStatus();
			  print json_encode($json);
		  }
	  }

      /**
       * User::register()
       * 
       * @return
       */
      public function register()
      {

		  Filter::checkPost('username', Core::$word->UR_USERNAME_R);
	
		  if ($value = $this->usernameExists($_POST['username'])) {
			  if ($value == 1)
				  Filter::$msgs['username'] = Core::$word->UR_USERNAME_R1;
			  if ($value == 2)
				  Filter::$msgs['username'] = Core::$word->UR_USERNAME_R2;
			  if ($value == 3)
				  Filter::$msgs['username'] = Core::$word->UR_USERNAME_R3;
		  }

		  Filter::checkPost('fname', Core::$word->UR_FNAME);
		  Filter::checkPost('lname', Core::$word->UR_LNAME);
		  Filter::checkPost('address', Core::$word->UR_ADDRESS);
		  Filter::checkPost('city', Core::$word->UR_CITY);
		  Filter::checkPost('state', Core::$word->UR_STATE);
		  Filter::checkPost('zip', Core::$word->UR_ZIP);
		  Filter::checkPost('country', Core::$word->UR_COUNTRY);
		  Filter::checkPost('pass', Core::$word->UR_PASSWORD_R);

          if (strlen($_POST['pass']) < 6)
              Filter::$msgs['pass'] = Core::$word->UR_PASSWORD_R1;
          elseif (!preg_match("/^.*(?=.{6,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", ($_POST['pass'] = trim($_POST['pass']))))
              Filter::$msgs['pass'] = Core::$word->UR_PASSWORD_R2;
          elseif ($_POST['pass'] != $_POST['pass2'])
              Filter::$msgs['pass'] = Core::$word->UR_PASSWORD_R3;

		  Filter::checkPost('email', Core::$word->UR_EMAIL_R);
	
		  if ($this->emailExists($_POST['email']))
			  Filter::$msgs['email'] = Core::$word->UR_EMAIL_R1;
	
		  if (!$this->isValidEmail($_POST['email']))
			  Filter::$msgs['email'] = Core::$word->UR_EMAIL_R2;
	
		  Filter::checkPost('captcha', Core::$word->UA_REG_RTOTAL_R);
	
		  if ($_SESSION['captchacode'] != $_POST['captcha'])
			  Filter::$msgs['captcha'] = Core::$word->UA_REG_RTOTAL_R1;

          $this->verifyCustomFields("register");
		  
          if (empty(Filter::$msgs)) {
              $token = (Registry::get("Core")->reg_verify == 1) ? $this->generateRandID() : 0;
              $pass = sanitize($_POST['pass']);

              if (Registry::get("Core")->reg_verify == 1) {
                  $active = "t";
              } elseif (Registry::get("Core")->auto_verify == 0) {
                  $active = "n";
              } else {
                  $active = "y";
              }

              $data = array(
                  'username' => sanitize($_POST['username']),
                  'password' => sha1($_POST['pass']),
                  'email' => sanitize($_POST['email']),
                  'fname' => sanitize($_POST['fname']),
                  'lname' => sanitize($_POST['lname']),
				  'address' => sanitize($_POST['address']),
				  'city' => sanitize($_POST['city']),
				  'country' => sanitize($_POST['country']),
				  'state' => sanitize($_POST['state']),
				  'zip' => sanitize($_POST['zip']),
                  'token' => $token,
                  'active' => $active,
                  'created' => "NOW()"
				  );

			  $fl_array = array_key_exists_wildcard($_POST, 'custom_*', 'key-value');
			  if (isset($fl_array)) {
				  $fields = $fl_array;
				  $total = count($fields);
				  if (is_array($fields)) {
					  $fielddata = '';
					  foreach ($fields as $fid) {
						  $fielddata .= $fid . "::";
					  }
				  }
				  $data['custom_fields'] = $fielddata;
			  }
			  
              self::$db->insert(self::uTable, $data);

              require_once (BASEPATH . "lib/class_mailer.php");

              if (Registry::get("Core")->reg_verify == 1) {
				  $actlink = SITEURL . "/activate.php?token=" . $token . "&email=" . $data['email'];
                  $row = Registry::get("Core")->getRowById(Content::eTable, 1);

                  $body = str_replace(array(
                      '[NAME]',
                      '[USERNAME]',
                      '[PASSWORD]',
                      '[TOKEN]',
                      '[EMAIL]',
                      '[URL]',
                      '[LINK]',
                      '[SITE_NAME]'), array(
                      $data['fname'] . ' ' . $data['lname'],
                      $data['username'],
                      $_POST['pass'],
                      $token,
                      $data['email'],
                      SITEURL,
                      $actlink,
                      Registry::get("Core")->site_name), $row->body);

                  $newbody = cleanOut($body);

                  $mailer = Mailer::sendMail();
                  $message = Swift_Message::newInstance()
							->setSubject($row->subject)
							->setTo(array($data['email'] => $data['username']))
							->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
							->setBody($newbody, 'text/html');

                  $mailer->send($message);

              } elseif (Registry::get("Core")->auto_verify == 0) {
                  $row = Registry::get("Core")->getRowById(Content::eTable, 14);

                  $body = str_replace(array(
                      '[NAME]',
                      '[USERNAME]',
                      '[PASSWORD]',
                      '[URL]',
                      '[SITE_NAME]'), array(
                      $data['fname'] . ' ' . $data['lname'],
                      $data['username'],
                      $_POST['pass'],
                      SITEURL,
                      Registry::get("Core") > site_name), $row->body);

                  $newbody = cleanOut($body);

                  $mailer = Mailer::sendMail();
                  $message = Swift_Message::newInstance()
							->setSubject($row->subject)
							->setTo(array($data['email'] => $data['username']))
							->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
							->setBody($newbody, 'text/html');

                  $mailer->send($message);

              } else {
                  $row = Registry::get("Core")->getRowById(Content::eTable, 7);

                  $body = str_replace(array(
                      '[NAME]',
                      '[USERNAME]',
                      '[PASSWORD]',
                      '[URL]',
                      '[SITE_NAME]'), array(
                      $data['fname'] . ' ' . $data['lname'],
                      $data['username'],
                      $_POST['pass'],
                      SITEURL,
                      Registry::get("Core")->site_name), $row->body);

                  $newbody = cleanOut($body);

                  $mailer = Mailer::sendMail();
                  $message = Swift_Message::newInstance()
							->setSubject($row->subject)
							->setTo(array($data['email'] => $data['username']))
							->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
							->setBody($newbody, 'text/html');

                  $mailer->send($message);
              }
              if (Registry::get("Core")->notify_admin) {
                  $arow = Registry::get("Core")->getRowById(Content::eTable, 13);

                  $abody = str_replace(array(
                      '[USERNAME]',
                      '[EMAIL]',
                      '[NAME]',
                      '[IP]'), array(
                      $data['username'],
                      $data['email'],
                      $data['fname'] . ' ' . $data['lname'],
                      $_SERVER['REMOTE_ADDR']), $arow->body);

                  $anewbody = cleanOut($abody);

				  $amailer = Mailer::sendMail();
                  $amessage = Swift_Message::newInstance()
							->setSubject($arow->subject)
							->setTo(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
							->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
							->setBody($anewbody, 'text/html');

                  $amailer->send($amessage);
              }

              if (self::$db->affected() && $mailer) {
				  $json['type'] = 'success';
				  $json['title'] = Core::$word->SUCCESS;
				  $json['message'] = Core::$word->UA_REG_OK;
				  print json_encode($json);

			  } else {
				  $json['type'] = 'error';
				  $json['title'] = Core::$word->ERROR;
				  $json['message'] = Core::$word->UA_REG_ERR;
				  print json_encode($json);
			  }
		  } else {
			  $json['type'] = 'error';
			  $json['title'] = Core::$word->SYSTEM_ERR;
			  $json['message'] = Filter::msgSingleStatus();
			  print json_encode($json);
		  }
	  }

      /**
       * User::passReset()
       * 
       * @return
       */
      public function passReset()
      {

          Filter::checkPost('uname', Core::$word->UR_USERNAME_R);
		  Filter::checkPost('email', Core::$word->UR_EMAIL_R);

          $uname = $this->usernameExists($_POST['uname']);
          if (strlen($_POST['uname']) < 4 || strlen($_POST['uname']) > 30 || !preg_match("/^[a-zA-Z0-9_-]{4,15}$/", $_POST['uname']) || $uname != 3)
              Filter::$msgs['uname'] = Core::$word->UR_USERNAME_R0;

          if (!$this->emailExists($_POST['email']))
              Filter::$msgs['uname'] = Core::$word->UR_EMAIL_R3;

		  Filter::checkPost('captcha', Core::$word->UA_PASS_RTOTAL_R);
		  if ($_SESSION['captchacode'] != $_POST['captcha'])
			  Filter::$msgs['captcha'] = Core::$word->UA_PASS_RTOTAL_R1;

          if (empty(Filter::$msgs)) {

              $user = $this->getUserInfo($_POST['uname']);
              $randpass = $this->getUniqueCode(12);
              $newpass = sha1($randpass);

              $data['password'] = $newpass;

              self::$db->update(self::uTable, $data, "username = '" . $user->username . "'");

              require_once (BASEPATH . "lib/class_mailer.php");
              $row = Registry::get("Core")->getRowById(Content::eTable, 2);

              $body = str_replace(array(
                  '[USERNAME]',
                  '[PASSWORD]',
                  '[URL]',
                  '[LINK]',
                  '[IP]',
                  '[SITE_NAME]'), array(
                  $user->username,
                  $randpass,
                  SITEURL,
                  SITEURL,
                  $_SERVER['REMOTE_ADDR'],
                  Registry::get("Core")->site_name), $row->body);

              $newbody = cleanOut($body);

              $mailer = Mailer::sendMail();
              $message = Swift_Message::newInstance()
						->setSubject($row->subject)
						->setTo(array($user->email => $user->username))
						->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
						->setBody($newbody, 'text/html');

              if (self::$db->affected() && $mailer->send($message)) {
				  $json['type'] = 'success';
				  $json['title'] = Core::$word->SUCCESS;
				  $json['message'] = Core::$word->UA_PASS_R_OK;
				  print json_encode($json);

			  } else {
				  $json['type'] = 'warning';
				  $json['title'] = Core::$word->ALERT;
				  $json['message'] = Core::$word->UA_PASS_R_ERR;
				  print json_encode($json);
			  }
			  
		  } else {
			  $json['type'] = 'error';
			  $json['title'] = Core::$word->SYSTEM_ERR;
			  $json['message'] = Filter::msgSingleStatus();
			  print json_encode($json);
		  }
	  }

      /**
       * User::activateAccount()
       * 
       * @return
       */
      public function activateAccount()
      {

          $data['active'] = "y";
		  self::$db->update(self::uTable, $data, "id = " . Filter::$id);
		  
		  require_once (BASEPATH . "lib/class_mailer.php");
		  $row = Registry::get("Core")->getRowById(Content::eTable, 16);
		  $usr = Registry::get("Core")->getRowById(self::uTable, Filter::$id);

		  $body = str_replace(array(
			  '[NAME]',
			  '[URL]',
			  '[SITE_NAME]'), array(
			  $usr->fname . ' ' .$usr->lname,
			  SITEURL,
			  Registry::get("Core")->site_name), $row->body);

		  $newbody = cleanOut($body);

		  $mailer = Mailer::sendMail();
		  $message = Swift_Message::newInstance()
					->setSubject($row->subject)
					->setTo(array($usr->email => $usr->username))
					->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
					->setBody($newbody, 'text/html');

		  if ($data['active'] =="y") {
			  $json['type'] = 'success';
			  $json['title'] = Core::$word->SUCCESS;
			  $json['message'] = Core::$word->UR_ACCOK;
			  print json_encode($json);
		  } else {
			  $json['type'] = 'error';
			  $json['title'] = Core::$word->ERROR;
			  $json['message'] = Core::$word->UR_ACCERR;
			  print json_encode($json);
		  }
      }
	  
      /**
       * User::activateUser()
       * 
       * @return
       */
      public function activateUser()
      {

		  Filter::checkPost('email', Core::$word->UR_EMAIL_R);
	
		  if (!$this->emailExists($_POST['email']))
			  Filter::$msgs['email'] = Core::$word->UR_EMAIL_R3;
	
		  Filter::checkPost('token', Core::$word->UA_TOKEN_R1);
	
		  if (!$this->validateToken($_POST['token']))
			  Filter::$msgs['token'] = Core::$word->UA_TOKEN_R;

          if (empty(Filter::$msgs)) {
              $email = sanitize($_POST['email']);
              $token = sanitize($_POST['token']);
              $data = array('token' => 0, 'active' => (Registry::get("Core")->auto_verify) ? "y" : "n");

              self::$db->update(self::uTable, $data, "email = '" . $email . "' AND token = '" . $token . "'");
			  $message = (Registry::get("Core")->auto_verify == 1) ? Core::$word->UA_TOKEN_OK1 : Core::$word->UA_TOKEN_OK2;
			  
              if (Registry::get("Core")->auto_verify == 1) {
				  $json['type'] = 'success';
				  $json['title'] = Core::$word->UA_TOKEN_OK1;
				  $json['message'] = $message;
				  print json_encode($json);
			  } else {
				  $json['type'] = 'error';
				  $json['title'] = Core::$word->ERROR;
				  $json['message'] = Core::$word->UA_TOKEN_R_ERR;
				  print json_encode($json);
			  }
			  
		  } else {
			  $json['type'] = 'error';
			  $json['title'] = Core::$word->SYSTEM_ERR;
			  $json['message'] = Filter::msgSingleStatus();
			  print json_encode($json);
		  }
	  }

      /**
       * Users::getUserData()
       * 
       * @return
       */
      public function getUserData()
      {

          $sql = "SELECT *, DATE_FORMAT(created, '%a. %d, %M %Y') as cdate," 
		  . "\n DATE_FORMAT(lastlogin, '%a. %d, %M %Y') as ldate" 
		  . "\n FROM " . self::uTable 
		  . "\n WHERE id = " . $this->uid;
          $row = self::$db->first($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Users::getUserMembership()
       * 
       * @return
       */
      public function getUserMembership()
      {

          $sql = "SELECT u.*, m.title" 
		  . "\n FROM " . self::uTable . " as u" 
		  . "\n LEFT JOIN " . Membership::mTable . " as m ON m.id = u.membership_id" 
		  . "\n WHERE u.id = " . $this->uid;
          $row = self::$db->first($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Users::calculateDays()
       * 
       * @return
       */
      public function calculateDays($membership_id)
      {

          $now = date('Y-m-d H:i:s');
          $row = self::$db->first("SELECT days, period FROM " . Membership::mTable . " WHERE id = '" . (int)$membership_id . "'");
          if ($row) {
              switch ($row->period) {
                  case "D":
                      $diff = $row->days;
                      break;
                  case "W":
                      $diff = $row->days * 7;
                      break;
                  case "M":
                      $diff = $row->days * 30;
                      break;
                  case "Y":
                      $diff = $row->days * 365;
                      break;
              }
              $expire = date("Y-m-d H:i:s", strtotime($now . + $diff . " days"));
          } else {
              $expire = "0000-00-00 00:00:00";
          }
          return $expire;
      }

      /**
       * User::trialUsed()
       * 
       * @return
       */
      public function trialUsed()
      {
          $sql = "SELECT trial_used" 
		  . "\n FROM " . self::uTable 
		  . "\n WHERE id = " . $this->uid
		  . "\n LIMIT 1";
          $row = self::$db->first($sql);

          return ($row->trial_used == 1) ? true : false;
      }

      /**
       * Users::validateMembership()
       * 
       * @return
       */
      public function validateMembership()
      {

          $sql = "SELECT mem_expire" 
		  . "\n FROM " . self::uTable 
		  . "\n WHERE id = " . $this->uid
		  . "\n AND TO_DAYS(mem_expire) > TO_DAYS(NOW())";
          $row = self::$db->first($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Users::checkMembership()
       * 
       * @param string $memids
       * @return
       */
      public function checkMembership($memids)
      {

          $m_arr = explode(",", $memids);
          reset($m_arr);

          if ($this->logged_in and $this->validateMembership() and in_array($this->membership_id, $m_arr)) {
              return true;
          } else
              return false;
      }

	  /**
	   * verifyCustomFields()
	   * 
	   * @param mixed $type
	   * @return
	   */
	  public function verifyCustomFields($type)
	  {
	
		  if ($fdata = self::$db->fetch_all("SELECT * FROM " . Content::fTable . " WHERE type = '" . $type . "' AND active = 1 AND req = 1")) {
	
			  $res = '';
			  foreach ($fdata as $cfrow) {
				  if (empty($_POST['custom_' . $cfrow->name]))
					  $res .= Filter::$msgs['custom_' . $cfrow->name] = "Please Enter " . $cfrow->title;
			  }
			  return $res;
			  unset($cfrow);
	
		  }
	
	  } 
	  
      /**
       * Users::usernameExists()
       * 
       * @param mixed $username
       * @return
       */
      private function usernameExists($username)
      {

          $username = sanitize($username);
          if (strlen(self::$db->escape($username)) < 4)
              return 1;

          //Username should contain only alphabets, numbers, underscores or hyphens.Should be between 4 to 15 characters long
		  $valid_uname = "/^[a-zA-Z0-9_-]{4,15}$/"; 
          if (!preg_match($valid_uname, $username))
              return 2;

          $sql = self::$db->query("SELECT username" 
		  . "\n FROM " . self::uTable 
		  . "\n WHERE username = '" . $username . "'" 
		  . "\n LIMIT 1");

          $count = self::$db->numrows($sql);

          return ($count > 0) ? 3 : false;
      }

      /**
       * User::emailExists()
       * 
       * @param mixed $email
       * @return
       */
      private function emailExists($email)
      {

          $sql = self::$db->query("SELECT email" 
		  . "\n FROM " . self::uTable 
		  . "\n WHERE email = '" . sanitize($email) . "'" 
		  . "\n LIMIT 1");

          if (self::$db->numrows($sql) == 1) {
              return true;
          } else
              return false;
      }

      /**
       * User::isValidEmail()
       * 
       * @param mixed $email
       * @return
       */
      private function isValidEmail($email)
      {
          if (function_exists('filter_var')) {
              if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                  return true;
              } else
                  return false;
          } else
              return preg_match('/^[a-zA-Z0-9._+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/', $email);
      }

      /**
       * User::validateToken()
       * 
       * @param mixed $token
       * @return
       */
      private function validateToken($token)
      {
          $token = sanitize($token, 40);
          $sql = "SELECT token" 
		  . "\n FROM " . self::uTable 
		  . "\n WHERE token ='" . self::$db->escape($token) . "'" 
		  . "\n LIMIT 1";
          $result = self::$db->query($sql);

          if (self::$db->numrows($result))
              return true;
      }

      /**
       * Users::getUniqueCode()
       * 
       * @param string $length
       * @return
       */
      private function getUniqueCode($length = "")
      {
          $code = sha1(uniqid(rand(), true));
          if ($length != "") {
              return substr($code, 0, $length);
          } else
              return $code;
      }

      /**
       * Users::generateRandID()
       * 
       * @return
       */
      private function generateRandID()
      {
          return sha1($this->getUniqueCode(24));
      }

      /**
       * Users::levelCheck()
       * 
       * @param string $levels
       * @return
       */
      public function levelCheck($levels)
      {
          $m_arr = explode(",", $levels);
          reset($m_arr);

          if ($this->logged_in and in_array($this->userlevel, $m_arr))
              return true;
      }

      /**
       * Users::getAccountMapStats()
       * 
       * @return
       */
      public function getAccountMapStats()
      {
		  
          $sql = "
		  SELECT
			 COUNT(*) as hits,
			 c.abbr as country_abbr,
			 c.name as country_name      
		  FROM
			 " . self::uTable . " as u 
		  LEFT JOIN
			 " . Content::cTable . " as c 
				ON u.country = c.abbr
				WHERE u.active = 'y'
		  GROUP BY
			 c.abbr";

          $row = self::$db->fetch_all($sql);
          return ($row) ? $row : 0;

      }
  }
?>