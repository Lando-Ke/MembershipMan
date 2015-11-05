<?php
  /**
   * Content Class
   */

  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  class Content
  {

      const cTable = "countries";
      const eTable = "email_templates";
      const nTable = "news";
	  const fTable = "custom_fields";
	  const dTable = "coupons";
	  const crTable = "cart";
	  
      private static $db;

	  

      /**
       * Content::__construct()
       * 
       * @return
       */
      function __construct()
      {
		  self::$db = Registry::get("Database");

      }

      /**
       * Content::getCountryList()
       * 
       * @return
       */
      public function getCountryList()
      {
          $sql = "SELECT * FROM " . self::cTable . " ORDER BY sorting DESC";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0; 

      }

      /**
       * Content:::processCountry()
       * 
       * @return
       */
      public function processCountry()
      {

		  Filter::checkPost('name', Core::$word->CNT_TITLE);

          if (empty(Filter::$msgs)) {
              $data = array(
                  'name' => sanitize($_POST['name']),
                  'abbr' => sanitize($_POST['abbr']),
                  'active' => intval($_POST['active']),
                  'home' => intval($_POST['home']),
				  'vat' => floatval($_POST['vat']),
				  'sorting' => intval($_POST['sorting']),
				  );

			  if ($data['home'] == 1) {
				  self::$db->query("UPDATE `" . self::cTable . "` SET `home`= DEFAULT(home);");
			  }	
			  
              Registry::get("Database")->update(self::cTable, $data, "id=" . Filter::$id);
			  
              if (self::$db->affected()) {
				  $json['type'] = 'success';
				  $json['title'] = Core::$word->SUCCESS;
				  $json['message'] = Core::$word->CNT_UPDATED;
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
       * Content::getNews()
       * 
       * @return
       */
      public function getNews()
      {
          $sql = "SELECT * FROM " . self::nTable . " ORDER BY title ASC";
          $row = Registry::get("Database")->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::renderNews()
       * 
       * @return
       */
      public function renderNews()
      {
          $sql = "SELECT * FROM " . self::nTable . " WHERE active = 1";
          $row = Registry::get("Database")->first($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::processNews()
       * 
       * @return
       */
      public function processNews()
      {

		  Filter::checkPost('title', Core::$word->NM_TTITLE);
		  Filter::checkPost('created', Core::$word->CREATED);
		  Filter::checkPost('body', Core::$word->NM_CONTENT);
		  
          if (empty(Filter::$msgs)) {
              $data = array(
                  'title' => sanitize($_POST['title']),
                  'author' => sanitize($_POST['author']),
                  'body' => $_POST['body'],
                  'created' => sanitize($_POST['created_submit']),
                  'active' => intval($_POST['active']));

              if ($data['active'] == 1) {
                  $news['active'] = "DEFAULT(active)";
                  Registry::get("Database")->update(self::nTable, $news);
              }

              (Filter::$id) ? Registry::get("Database")->update(self::nTable, $data, "id=" . Filter::$id) : Registry::get("Database")->insert(self::nTable, $data);
			  $message = (Filter::$id) ? Core::$word->NM_UPDATED : Core::$word->NM_ADDED;

              if (self::$db->affected()) {
				  $json['type'] = 'success';
				  $json['title'] = Core::$word->SUCCESS;
				  $json['message'] = $message;
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
	   * Content::getCustomFields()
	   * 
	   * @return
	   */
	  public function getCustomFields()
	  {
	
		  $sql = "SELECT * FROM " . self::fTable . " ORDER BY sorting, type";
		  $row = Registry::get("Database")->fetch_all($sql);
	
		  return ($row) ? $row : 0;
	  }

      /**
       * Content::fieldSection()
       * 
	   * @param mixed $section
       * @return
       */
      public static function fieldSection($section)
      {
          switch($section) {
			  case "profile":
			  return Core::$word->CF_SECP;
			  break;

			  case "register":
			  return Core::$word->CF_SECR;
			  break;

		  }
      }

      /**
       * Content::getFieldSection()
       * 
       * @param bool $section
       * @return
       */
      public static function getFieldSection($section = false)
      {
		  
          $arr = array(
				 'profile' => Core::$word->CF_SECP,
				 'register' => Core::$word->CF_SECR
		  );

          $html = '';
          foreach ($arr as $key => $val) {
              if ($key == $section) {
                  $html .= "<option selected=\"selected\" value=\"" . $key . "\">" . $val . "</option>\n";
              } else
                  $html .= "<option value=\"" . $key . "\">" . $val . "</option>\n";
          }
          unset($val);
          return $html;
      }

      /**
       * Content::processField()
       * 
       * @return
       */
	  public function processField()
	  {
	
		  Filter::checkPost('title', Core::$word->CF_TTITLE);
	
		  if (empty(Filter::$msgs)) {
			  $data = array(
				  'title' => sanitize($_POST['title']),
				  'tooltip'  => sanitize($_POST['tooltip']),
				  'req' => intval($_POST['req']),
				  'active' => intval($_POST['active']),
				  'type' => sanitize($_POST['type'])
				  );
				  
			  if (!Filter::$id) {
				  $data['name'] = sanitize($_POST['type']) . randName(2);
			  }
	
			  (Filter::$id) ? Registry::get("Database")->update(self::fTable, $data, "id=" . Filter::$id) : Registry::get("Database")->insert(self::fTable, $data);
              $message = (Filter::$id) ? Core::$word->CF_UPDATED : Core::$word->CF_ADDED;
			  
              if (self::$db->affected()) {
				  $json['type'] = 'success';
				  $json['title'] = Core::$word->SUCCESS;
				  $json['message'] = $message;
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
	   * Content::rendertCustomFields()
	   * 
	   * @param mixed $type
	   * @param mixed $data
	   * @param str $wrap
	   * @param bool $labels
	   * @return
	   */
	  public function rendertCustomFields($type, $data, $wrap = "two", $labels = true)
	  {
	
		  $html = '';
		  if ($fdata = Registry::get("Database")->fetch_all("SELECT *"
		  . "\n FROM " . self::fTable
		  . "\n WHERE type = '" . $type . "'"
		  . "\n AND active = 1"
		  . "\n ORDER BY sorting")) {
			  $value = ($data) ? explode("::", $data) : null;
			  $group_nr = 1;
			  $last_row = count($fdata) - 1;
			  $wrapper = wordsToNumber($wrap);
			  foreach ($fdata as $id => $cfrow) {
				  if ($id % $wrapper == 0) {
					  $html .= '<div class="' . $wrap . ' fields">';
					  $i = 0;
					  $group_nr++;
				  }
				  
	              $tip = ($cfrow->tooltip) ? $cfrow->tooltip : $cfrow->title;
				  $html .= '<div class="field">';
				  if($labels) {
				    $html .= '<label>' . $cfrow->title . '</label>';
				  }
					  
				  $html .= '<label class="input">';
				  if ($cfrow->req) {
					  $html .= '<i class="icon-append icon asterisk"></i>';
				  }
				  $html .= '<input name="custom_' . $cfrow->name . '" type="text" placeholder="' . $tip . '" value="' . $value[$id] . '">';
				  $html .= '</label>';
				  $html .= '</div>';
	
				  $i++;
				  if ($i == $wrapper || $id == $last_row)
					  $html .= '</div>';
			  }
			  unset($cfrow);
		  }
	
		  return $html;
	  }
	  

      /**
       * Content::getEmailTemplates()
       * 
       * @return
       */
      public function getEmailTemplates()
      {
          $sql = "SELECT * FROM " . self::eTable . " ORDER BY name ASC";
          $row = Registry::get("Database")->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content:::processEmailTemplate()
       * 
       * @return
       */
      public function processEmailTemplate()
      {

		  Filter::checkPost('name', Core::$word->ET_TTITLE);
		  Filter::checkPost('subject', Core::$word->ET_SUBJECT);
		  Filter::checkPost('body', Core::$word->ET_BODY);

          if (empty(Filter::$msgs)) {
              $data = array(
                  'name' => sanitize($_POST['name']),
                  'subject' => sanitize($_POST['subject']),
                  'body' => $_POST['body'],
                  'help' => $_POST['help']
				  );

              Registry::get("Database")->update(self::eTable, $data, "id=" . Filter::$id);
			  
              if (self::$db->affected()) {
				  $json['type'] = 'success';
				  $json['title'] = Core::$word->SUCCESS;
				  $json['message'] = Core::$word->ET_UPDATED;
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
       * Content:::processCoupon()
       * 
       * @return
       */
      public function processCoupon()
      {

		  Filter::checkPost('title', Core::$word->DC_TTITLE);
		  Filter::checkPost('code', Core::$word->DC_CODE);
		  Filter::checkPost('discount', Core::$word->DC_DISC);
		  Filter::checkPost('mid', Core::$word->DC_MEMERR);

          if (empty(Filter::$msgs)) {
			  $data = array(
				  'title' => sanitize($_POST['title']), 
				  'code' => sanitize($_POST['code']), 
				  'discount' => intval($_POST['discount']),
				  'mid' => Core::_implode($_POST['mid']),
				  'type' => sanitize($_POST['type']),
				  'created' => "NOW()",
				  'active' => intval($_POST['active'])
			  );

			  (Filter::$id) ? self::$db->update(self::dTable, $data, "id=" . Filter::$id) : self::$db->insert(self::dTable, $data);
			  $message = (Filter::$id) ? Core::$word->DC_UPDATED : Core::$word->DC_ADDED;
			  
              if (self::$db->affected()) {
				  $json['type'] = 'success';
				  $json['title'] = Core::$word->SUCCESS;
				  $json['message'] = $message;
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
	   * Content::getDiscounts()
	   * 
	   * @return
	   */
	  public function getDiscounts()
	  {
		  
		  $sql = "SELECT * FROM " . self::dTable;
          $row = self::$db->fetch_all($sql);
          
		   return ($row) ? $row : 0;
	  }
	  
      /**
       * Content::processNewsletter()
       * 
       * @return
       */
      public function processNewsletter()
      {

          Filter::checkPost('subject', Core::$word->NL_SUBJECT);
          Filter::checkPost('body', Core::$word->NL_BODY);
		  Filter::checkPost('recipient', Core::$word->NL_RCPT);

          if (empty(Filter::$msgs)) {
              $to = sanitize($_POST['recipient']);
              $subject = sanitize($_POST['subject']);
              $body = cleanOut($_POST['body']);
			  $numSent = 0;
			  $failedRecipients = array();
			  		  
              switch ($to) {
                  case "all":
                      require_once (BASEPATH . "lib/class_mailer.php");
                      $mailer = Mailer::sendMail();
                      $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100, 30));

                      $sql = "SELECT email, CONCAT(fname,' ',lname) as name FROM " . Users::uTable . " WHERE id != 1";
                      $userrow = Registry::get("Database")->fetch_all($sql);

                      $replacements = array();
                      if ($userrow) {
						  if (empty($_FILES['attachment']['name'])) {
							  $attachement = '';
						  } else {
							  move_uploaded_file($_FILES['attachment']['tmp_name'], UPLOADS . 'attachments/' . $_FILES['attachment']['name']);
							  $attachement = '<a href="' . SITEURL . '/uploads/attachments/' . $_FILES['attachment']['name'] . '">' . Core::$word->NL_ATTACH . '</a>';
						  }
                          foreach ($userrow as $cols) {
                              $replacements[$cols->email] = array(
                                  '[NAME]' => $cols->name,
								  '[ATTACHMENT]',
                                  '[SITE_NAME]' => Registry::get("Core")->site_name,
                                  '[URL]' => Registry::get("Core")->site_url);
                          }

                          $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
                          $mailer->registerPlugin($decorator);

                          $message = Swift_Message::newInstance()
									->setSubject($subject)
									->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
									->setBody($body, 'text/html');
						  
                          foreach ($userrow as $row) {
							  $message->setTo(array($row->email => $row->name));
							  $numSent++;
							  $mailer->send($message, $failedRecipients);
						  }
                          unset($row);

                      }
                      break;

                  case "newsletter":
                      require_once (BASEPATH . "lib/class_mailer.php");
                      $mailer = Mailer::sendMail();
                      $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100, 30));

                      $sql = "SELECT email, CONCAT(fname,' ',lname) as name FROM " . Users::uTable . " WHERE newsletter = '1' AND id != 1";
                      $userrow = Registry::get("Database")->fetch_all($sql);

                      $replacements = array();
                      if ($userrow) {
						  if (empty($_FILES['attachment']['name'])) {
							  $attachement = '';
						  } else {
							  move_uploaded_file($_FILES['attachment']['tmp_name'], UPLOADS . 'attachments/' . $_FILES['attachment']['name']);
							  $attachement = '<a href="' . SITEURL . '/uploads/attachments/' . $_FILES['attachment']['name'] . '">' . Core::$word->NL_ATTACH . '</a>';
						  }
                          foreach ($userrow as $cols) {
                              $replacements[$cols->email] = array(
                                  '[NAME]' => $cols->name,
								  '[ATTACHMENT]',
                                  '[SITE_NAME]' => Registry::get("Core")->site_name,
                                  '[URL]' => Registry::get("Core")->site_url);
                          }

                          $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
                          $mailer->registerPlugin($decorator);

                          $message = Swift_Message::newInstance()
									->setSubject($subject)
									->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
									->setBody($body, 'text/html');
									
						  if (!empty($_FILES['attachment']['name'])) {
							  move_uploaded_file($_FILES['attachment']['tmp_name'], UPLOADS . 'attachments/' . $_FILES['attachment']['name']);
							  $attachement = $_FILES['attachment']['name'];
						  }
						  
                          foreach ($userrow as $row) {
							  $message->setTo(array($row->email => $row->name));
							  $numSent++;
							  $mailer->send($message, $failedRecipients);
						  }
                          unset($row);

                      }
                      break;

                  case "free":
                      require_once (BASEPATH . "lib/class_mailer.php");
                      $mailer = Mailer::sendMail();
                      $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100));

                      $sql = "SELECT email,CONCAT(fname,' ',lname) as name FROM " . Users::uTable . " WHERE membership_id = 0 AND id != 1";
                      $userrow = Registry::get("Database")->fetch_all($sql);

                      $replacements = array();
                      if ($userrow) {
						  if (empty($_FILES['attachment']['name'])) {
							  $attachement = '';
						  } else {
							  move_uploaded_file($_FILES['attachment']['tmp_name'], UPLOADS . 'attachments/' . $_FILES['attachment']['name']);
							  $attachement = '<a href="' . SITEURL . '/uploads/attachments/' . $_FILES['attachment']['name'] . '">' . Core::$word->NL_ATTACH . '</a>';
						  }
                          foreach ($userrow as $cols) {
                              $replacements[$cols->email] = array(
                                  '[NAME]' => $cols->name,
								  '[ATTACHMENT]',
                                  '[SITE_NAME]' => Registry::get("Core")->site_name,
                                  '[URL]' => Registry::get("Core")->site_url);
                          }

                          $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
                          $mailer->registerPlugin($decorator);

                          $message = Swift_Message::newInstance()
									->setSubject($subject)
									->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
									->setBody($body, 'text/html');
						  
                          foreach ($userrow as $row) {
							  $message->setTo(array($row->email => $row->name));
							  $numSent++;
							  $mailer->send($message, $failedRecipients);
						  }
                          unset($row);

                      }
                      break;

                  case "paid":
                      require_once (BASEPATH . "lib/class_mailer.php");
                      $mailer = Mailer::sendMail();
                      $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100));

                      $sql = "SELECT email, CONCAT(fname,' ',lname) as name FROM " . Users::uTable . " WHERE membership_id <> 0 AND id != 1";
                      $userrow = Registry::get("Database")->fetch_all($sql);

                      $replacements = array();
                      if ($userrow) {
						  if (empty($_FILES['attachment']['name'])) {
							  $attachement = '';
						  } else {
							  move_uploaded_file($_FILES['attachment']['tmp_name'], UPLOADS . 'attachments/' . $_FILES['attachment']['name']);
							  $attachement = '<a href="' . SITEURL . '/uploads/attachments/' . $_FILES['attachment']['name'] . '">' . Core::$word->NL_ATTACH . '</a>';
						  }
                          foreach ($userrow as $cols) {
                              $replacements[$cols->email] = array(
                                  '[NAME]' => $cols->name,
								  '[ATTACHMENT]',
                                  '[SITE_NAME]' => Registry::get("Core")->site_name,
                                  '[URL]' => Registry::get("Core")->site_url);
                          }

                          $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
                          $mailer->registerPlugin($decorator);

                          $message = Swift_Message::newInstance()
									->setSubject($subject)
									->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
									->setBody($body, 'text/html');
						  
                          foreach ($userrow as $row) {
							  $message->setTo(array($row->email => $row->name));
							  $numSent++;
							  $mailer->send($message, $failedRecipients);
						  }
                      }
                      break;

                  default:
                      require_once (BASEPATH . "lib/class_mailer.php");
                      $mailer = Mailer::sendMail();

                      $row = Registry::get("Database")->first("SELECT email, CONCAT(fname,' ',lname) as name FROM " . Users::uTable . " WHERE email LIKE '%" . sanitize($to) . "%'");
                      if ($row) {
						  if (empty($_FILES['attachment']['name'])) {
							  $attachement = '';
						  } else {
							  move_uploaded_file($_FILES['attachment']['tmp_name'], UPLOADS . 'attachments/' . $_FILES['attachment']['name']);
							  $attachement = '<a href="' . SITEURL . '/uploads/attachments/' . $_FILES['attachment']['name'] . '">' . Core::$word->NL_ATTACH . '</a>';
						  }
                          $newbody = str_replace(array(
                              '[NAME]',
							  '[ATTACHMENT]',
                              '[SITE_NAME]',
                              '[URL]'), array(
                              $row->name,
							  $attachement,
                              Registry::get("Core")->site_name,
                              Registry::get("Core")->site_url), $body);

                          $message = Swift_Message::newInstance()
									->setSubject($subject)
								    ->setTo(array($to => $row->name))
									->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
									->setBody($newbody, 'text/html');
						  
						  $numSent++;
						  $mailer->send($message, $failedRecipients);
                      }
                      break;
              }

			  if ($numSent) {
				  $json['type'] = 'success';
				  $json['title'] = Core::$word->SUCCESS;
				  $json['message'] = Core::$word->NL_SENT;
			  } else {
				  $json['type'] = 'error';
				  $json['title'] = Core::$word->ERROR;
				  $res = '';
				  $res .= '<ul>';
				  foreach ($failedRecipients as $failed) {
					  $res .= '<li>' . $failed . '</li>';
				  }
				  $res .= '</ul>';
				  $json['message'] = Core::$word->NL_ALERT . $res;
	
				  unset($failed);
			  }
			  print json_encode($json);
			  
		  } else {
			  $json['type'] = 'error';
			  $json['title'] = Core::$word->SYSTEM_ERR;
			  $json['message'] = Filter::msgSingleStatus();
			  print json_encode($json);
		  }
	  }
  }