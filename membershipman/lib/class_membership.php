<?php
  /**
   * Membership Class
   */

  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  class Membership
  {
      const mTable = "memberships";
      const pTable = "payments";
      const gTable = "gateways";
      private static $db;


      /**
       * Membership::__construct()
       * 
       * @return
       */
      public function __construct()
      {
          self::$db = Registry::get("Database");

      }

      /**
       * Membership::getMemberships()
       * 
       * @return
       */
      public function getMemberships()
      {
          $sql = "SELECT * FROM " . self::mTable . " ORDER BY price";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Membership::getMembershipListFrontEnd()
       * 
       * @return
       */
      public function getMembershipListFrontEnd()
      {

		  $sql = "SELECT *, "
		  . "\n (SELECT COUNT(" . Users::uTable . ".membership_id) FROM " . Users::uTable . " WHERE " . Users::uTable . ".membership_id = " . self::mTable . ".id) as totalmems"
		  . "\n FROM " . self::mTable
		  . "\n WHERE private = 0"
		  . "\n AND active = 1"
		  . "\n ORDER BY price";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Membership::processMembership()
       * 
       * @return
       */
      public function processMembership()
      {
		  Filter::checkPost('title', Core::$word->MM_TTITLE);
		  Filter::checkPost('price', Core::$word->PRICE);
		  Filter::checkPost('days', Core::$word->MM_PERIOD);
          if (!is_numeric($_POST['days']))
              Filter::$msgs['days'] = Core::$word->MM_ERR;

          if (empty(Filter::$msgs)) {
              $data = array(
                  'title' => sanitize($_POST['title']),
                  'price' => floatval($_POST['price']),
                  'days' => intval($_POST['days']),
                  'period' => sanitize($_POST['period']),
                  'trial' => intval($_POST['trial']),
                  'recurring' => intval($_POST['recurring']),
                  'private' => intval($_POST['private']),
                  'description' => sanitize($_POST['description']),
                  'active' => intval($_POST['active']));

              if ($data['trial'] == 1) {
                  $trial['trial'] = "DEFAULT(trial)";
                  self::$db->update(self::mTable, $trial);
              }

              (Filter::$id) ? self::$db->update(self::mTable, $data, "id=" . Filter::$id) : self::$db->insert(self::mTable, $data);
              $message = (Filter::$id) ? Core::$word->MM_UPDATED : Core::$word->MM_ADDED;

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
       * Membership::getUserTransactions()
       * 
       * @return
       */
      public function getUserTransactions()
      {

		  $sql = "SELECT p.*, m.title"
		  . "\n FROM " . self::pTable . " as p"
		  . "\n LEFT JOIN " . self::mTable . " as m on m.id = p.membership_id"
		  . "\n WHERE status = 1"
		  . "\n AND p.user_id = " . Registry::get("Users")->uid
		  . "\n ORDER BY date DESC";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Membership::getUserInvoice()
       * 
       * @return
       */
      public function getUserInvoice($id)
      {

		  $sql = "SELECT p.*, m.title, m.description, DATE_FORMAT(p.date,'%Y%m%d') as invid"
		  . "\n FROM " . self::pTable . " as p"
		  . "\n LEFT JOIN " . self::mTable . " as m on m.id = p.membership_id"
		  . "\n WHERE p.id = " . $id
		  . "\n AND p.user_id = " . Registry::get("Users")->uid
		  . "\n AND p.status = 1"
		  . "\n ORDER BY date DESC";
          $row = self::$db->first($sql);

          return ($row) ? $row : 0;
      }
	  
      /**
       * Membership::getMembershipPeriod()
       * 
       * @param bool $sel
       * @return
       */
      public function getMembershipPeriod($sel = false)
      {
          $arr = array(
              'D' => Core::$word->DAYS,
              'W' => Core::$word->WEEKS,
              'M' => Core::$word->MONTHS,
              'Y' => Core::$word->YEARS
			  );

          $data = '';
          foreach ($arr as $key => $val) {
              if ($key == $sel) {
                  $data .= "<option selected=\"selected\" value=\"" . $key . "\">" . $val . "</option>\n";
              } else
                  $data .= "<option value=\"" . $key . "\">" . $val . "</option>\n";
          }
          unset($val);
          return $data;
      }

      /**
       * Membership::getPeriod()
       * 
       * @param bool $value
       * @return
       */
      public function getPeriod($value)
      {
          switch ($value) {
              case "D":
                  return Core::$word->DAYS;
                  break;
              case "W":
                  return Core::$word->WEEKS;
                  break;
              case "M":
                  return Core::$word->MONTHS;
                  break;
              case "Y":
                  return Core::$word->YEARS;
                  break;
          }

      }
			  
      /**
       * Membership::calculateDays()
       * 
       * @return
       */
      public function calculateDays($period, $days)
      {
          global $db;

          $now = date('Y-m-d H:i:s');
          switch ($period) {
              case "D":
                  $diff = $days;
                  break;
              case "W":
                  $diff = $days * 7;
                  break;
              case "M":
                  $diff = $days * 30;
                  break;
              case "Y":
                  $diff = $days * 365;
                  break;
          }
          return date("d M Y", strtotime($now . + $diff . " days"));
      }

      /**
       * Membership::getTotalDays()
       * Used for MoneyBookers
       * @return
       */
      public function getTotalDays($period, $days)
      {
          switch ($period) {
              case "D":
                  $diff = $days;
                  break;
              case "W":
                  $diff = $days * 7;
                  break;
              case "M":
                  $diff = $days * 30;
                  break;
              case "Y":
                  $diff = $days * 365;
                  break;
          }
          return $diff;
      }
	  
      /**
       * Membership::getPayments()
       * 
       * @param bool $from
       * @return
       */
      public function getPayments($from = false)
      {

          if (isset($_GET['letter']) and (isset($_POST['fromdate_submit']) && $_POST['fromdate_submit'] <> "" || isset($from) && $from != '')) {
              $enddate = date("Y-m-d");
              $letter = sanitize($_GET['letter'], 2);
              $fromdate = (empty($from)) ? sanitize($_POST['fromdate_submit']) : $from;
              if (isset($_POST['enddate_submit']) && $_POST['enddate_submit'] <> "") {
                  $enddate = sanitize($_POST['enddate_submit']);
              }
              $q = ("SELECT u.username, COUNT(*) FROM " . self::pTable . " as p LEFT JOIN " . Users::uTable . " as u ON u.id = p.user_id WHERE date BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59' AND username REGEXP '^" . $letter . "'");
              $and = "WHERE date BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59' AND username REGEXP '^" . $letter . "'";

          } elseif (isset($_POST['fromdate_submit']) && $_POST['fromdate_submit'] <> "" || isset($from) && $from != '') {
              $enddate = date("Y-m-d");
              $fromdate = (empty($from)) ? sanitize($_POST['fromdate_submit']) : $from;
              if (isset($_POST['enddate_submit']) && $_POST['enddate_submit'] <> "") {
                  $enddate = sanitize($_POST['enddate_submit']);
              }
              $q = ("SELECT COUNT(*) FROM " . self::pTable . " WHERE date BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'");
              $and = "WHERE date BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'";

          } elseif (isset($_GET['letter'])) {
              $letter = sanitize($_GET['letter'], 2);
              $and = "WHERE username REGEXP '^" . $letter . "'";
              $q = ("SELECT u.username, COUNT(*) FROM " . self::pTable . " as p LEFT JOIN " . Users::uTable . " as u ON u.id = p.user_id WHERE username REGEXP '^" . $letter . "' LIMIT 1");
          } else {
              $q = ("SELECT COUNT(*) FROM " . self::pTable);
              $and = null;
          }

          $record = self::$db->query($q);
          $total = self::$db->fetchrow($record);
          $counter = $total[0];

          $pager = Paginator::instance();
          $pager->items_total = $counter;
          $pager->default_ipp = Registry::get("Core")->perpage;
          $pager->paginate();
		  
          $sql = "SELECT p.*, p.id as id, p.date as created, u.username, m.title" 
		  . "\n FROM " . self::pTable . " as p" 
		  . "\n LEFT JOIN " . Users::uTable . " as u ON u.id = p.user_id" 
		  . "\n LEFT JOIN " . self::mTable . " as m ON m.id = p.membership_id" 
		  . "\n $and"
		  . "\n ORDER BY created DESC" . $pager->limit;

          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Membership::getPaymentFilter()
       * 
       * @return
       */
      public static function getPaymentFilter()
      {
          $arr = array(
              'user_id-ASC' => 'Username &uarr;',
              'user_id-DESC' => 'Username &darr;',
              'rate_amount-ASC' => 'Amount &uarr;',
              'rate_amount-DESC' => 'Amount &darr;',
              'pp-ASC' => 'Processor &uarr;',
              'pp-DESC' => 'Processor &darr;',
              'date-ASC' => 'Payment Date &uarr;',
              'date-DESC' => 'Payment Date &darr;',
              );

          $filter = '';
          foreach ($arr as $key => $val) {
              if ($key == get('sort')) {
                  $filter .= "<option selected=\"selected\" value=\"$key\">$val</option>\n";
              } else
                  $filter .= "<option value=\"$key\">$val</option>\n";
          }
          unset($val);
          return $filter;
      }

      /**
       * Membership::monthlyStats()
       * 
       * @return
       */
      public function monthlyStats()
      {
          global $db, $core;

          $sql = "SELECT id, COUNT(id) as total, SUM(rate_amount) as totalprice" 
		  . "\n FROM " . self::pTable . "\n WHERE status = '1'" 
		  . "\n AND date > '" . $core->year . "-" . $core->month . "-01'" 
		  . "\n AND date < '" . $core->year . "-" . $core->month . "-31 23:59:59'";

          $row = self::$db->first($sql);

          return ($row->total > 0) ? $row : false;
      }

      /**
       * Membership::yearlyStats()
       * 
       * @return
       */
      public function yearlyStats()
      {
          global $db, $core;

          $sql = "SELECT *, YEAR(date) as year, MONTH(date) as month," 
		  . "\n COUNT(id) as total, SUM(rate_amount) as totalprice" 
		  . "\n FROM " . self::pTable 
		  . "\n WHERE status = 1" 
		  . "\n AND YEAR(date) = " . $core->year
		  . "\n GROUP BY year DESC ,month DESC ORDER by date";

          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Membership::getYearlySummary()
       * 
       * @return
       */
      public function getYearlySummary()
      {
          global $db, $core;

          $sql = "SELECT YEAR(date) as year, MONTH(date) as month," 
		  . "\n COUNT(id) as total, SUM(rate_amount) as totalprice" 
		  . "\n FROM " . self::pTable 
		  . "\n WHERE status = 1" 
		  . "\n AND YEAR(date) = " . $core->year;

          $row = self::$db->first($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Membership::totalIncome()
       * 
       * @return
       */
      public function totalIncome()
      {
          $sql = "SELECT SUM(rate_amount) as totalsale" 
		  . "\n FROM " . self::pTable 
		  . "\n WHERE status = 1";
          $row = self::$db->first($sql);

          $total_income = $core->formatMoney($row->totalsale);

          return $total_income;
      }

      /**
       * Membership::membershipCron()
       * 
       * @param mixed $days
       * @return
       */
      function membershipCron($days)
      {

          $sql = "SELECT u.id, CONCAT(u.fname,' ',u.lname) as name, u.email, u.membership_id, u.trial_used, m.title, m.days," 
		  . "\n DATE_FORMAT(u.mem_expire, '%d %b %Y') as edate" 
		  . "\n FROM " . Users::uTable . " as u" 
		  . "\n LEFT JOIN " . self::mTable . " AS m ON m.id = u.membership_id" 
		  . "\n WHERE u.active = 'y' AND u.membership_id !=0" 
		  . "\n AND TO_DAYS(u.mem_expire) - TO_DAYS(NOW()) = '" . (int)$days . "'";

          $listrow = $db->fetch_all($sql);
          require_once (BASEPATH . "lib/class_mailer.php");

          if ($listrow) {
              switch ($days) {
                  case 7:
                      $mailer = Mailer::sendMail();
                      $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100, 30));

					  $trow = Registry::get("Core")->getRowById(Content::eTable, 8);
                      $body = cleanOut($trow->body);

                      $replacements = array();
                      foreach ($listrow as $cols) {
                          $replacements[$cols->email] = array(
                              '[NAME]' => $cols->name,
                              '[SITE_NAME]' => Registry::get("Core")->site_name,
                              '[URL]' => Registry::get("Core")->site_url);
                      }

                      $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
                      $mailer->registerPlugin($decorator);

                      $message = Swift_Message::newInstance()
								->setSubject($trow->subject)
								->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
								->setBody($body, 'text/html');

                      foreach ($listrow as $row) {
						  $message->setTo(array($row->email => $row->name));
						  $mailer->send($message);
					  }
                      unset($row);
                      break;

                  case 0:
                      $mailer = Mailer::sendMail();
                      $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100, 30));

					  $trow = Registry::get("Core")->getRowById(Content::eTable, 9);
                      $body = cleanOut($trow->body);

                      $replacements = array();
                      foreach ($listrow as $cols) {
                          $replacements[$cols->email] = array(
                              '[NAME]' => $cols->name,
                              '[SITE_NAME]' => Registry::get("Core")->site_name,
                              '[URL]' => Registry::get("Core")->site_url);
                      }

                      $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
                      $mailer->registerPlugin($decorator);

                      $message = Swift_Message::newInstance()
								->setSubject($trow->subject)
								->setFrom(array($core->site_email => $core->site_name))
								->setBody($body, 'text/html');

                      foreach ($listrow as $row) {
                          $message->setTo(array($row->email => $row->name));
                          $data = array('membership_id' => 0, 'mem_expire' => "0000-00-00 00:00:00");
                          self::$db->update(Users::uTable, $data, "id = " . $row->id);
						  $mailer->send($message);
                      }
                      unset($row);

                      break;
              }
          }
      }

      /**
       * Membership::getGateways()
       * 
       * @return
       */
      public function getGateways($active = false)
      {

          $where = ($active) ? "WHERE active = 1" : null;
          $sql = "SELECT * FROM " . self::gTable 
		  . "\n " . $where 
		  . "\n ORDER BY name";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }


      /**
       * Membership::processGateway()
       * 
       * @return
       */
      public function processGateway()
      {

		  Filter::checkPost('displayname', Core::$word->GW_TTITLE);

          if (empty(Filter::$msgs)) {
              $data = array(
                  'displayname' => sanitize($_POST['displayname']),
                  'extra' => sanitize($_POST['extra']),
                  'extra2' => sanitize($_POST['extra2']),
                  'extra3' => sanitize($_POST['extra3']),
                  'demo' => intval($_POST['demo']),
                  'active' => intval($_POST['active']));

              self::$db->update(self::gTable, $data, "id=" . Filter::$id);
			  
              if (self::$db->affected()) {
				  $json['type'] = 'success';
				  $json['title'] = Core::$word->SUCCESS;
				  $json['message'] = Core::$word->GW_UPDATED;
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
       * Membership::processBuilder()
       * 
       * @return
       */
      public static function processBuilder()
      {

		  Filter::checkPost('pagename', Core::$word->HP_PNAME);
		  Filter::checkPost('membership_id', Core::$word->MEMBERSHIP);

          if (empty(Filter::$msgs)) {
              $pagename = sanitize($_POST['pagename']);
              $pagename = preg_replace("/&([a-zA-Z])(uml|acute|grave|circ|tilde|ring),/", "", $pagename);
              $pagename = preg_replace("/[^a-zA-Z0-9_.-]/", "", $pagename);
              $pagename = str_replace(array('---', '--'), '-', $pagename);
              $pagename = str_replace(array('..', '.'), '', $pagename);

              $header = intval($_POST['header']);

              $mids = $_POST['membership_id'];
              $total = count($mids);
              $i = 1;
              if (is_array($mids)) {
                  $midata = '';
                  foreach ($mids as $mid) {
                      if ($i == $total) {
                          $midata .= $mid;
                      } else
                          $midata .= $mid . ",";
                      $i++;
                  }
              }
              $mem_id = $midata;

              $data = "<?php \n" 
			  . "\t/** \n" 
			  . "\t* " . $pagename . "\n" 
			  . "\t*" . " \n" 
			  . "\t* @package Membership Manager Pro\n" 
			  . "\t* @author wojoscripts.com\n" 
			  . "\t* @copyright 2015\n" 
			  . "\t* @version Id: " . $pagename . ".php, v3.0 " . date('Y-m-d H:i:s') . " gewa Exp $\n" 
			  . "\t*/\n" 
			  . " \n" 
			  . "\t define(\"_VALID_PHP\", true); \n" 
			  . "\t require_once(\"init.php\");\n" 
			  . " \n" . "?>";

              if ($header == 1) {
                  $data .= "" . " \n" 
				  . " \n" . " <?php include(\"header.php\");?> \n" 
				  . " \n" . " \n";
              }

              $data .= "" 
			  . "\t <?php if(Registry::get(\"Users\")->checkMembership('$mem_id')): ?>\n" 
			  . " \n" 
			  . "\t <h1>User has valid membership, you can display your protected content here</h1>.\n" 
			  . " \n" . "\t <?php else: ?>\n" 
			  . " \n" . "\t <h1>User membership is't not valid. Show your custom error message here</h1>\n" 
			  . " \n" . "\t <?php endif; ?>\n" 
			  . "";

              if ($header == 1) {
                  $data .= "" . " \n" 
				  . " \n" . " <?php include(\"footer.php\");?> \n" 
				  . " \n" 
				  . " \n";
              }

              $pagefile = UPLOADS . $pagename . '.php';
              if (is_writable(UPLOADS)) {
                  $handle = fopen($pagefile, 'w');
                  fwrite($handle, $data);
                  fclose($handle);
				  
				  $json['type'] = 'success';
				  $json['title'] = Core::$word->SUCCESS;
				  $json['message'] = str_replace("[NAME]", $pagename, Core::$word->HP_PBUILD_OK);
				  print json_encode($json);
              } else {
				  $json['type'] = 'error';
				  $json['title'] = Core::$word->ERROR;
				  $json['message'] = str_replace("[NAME]", $pagename, Core::$word->HP_PBUILD_ER);
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
       * Membership::verifyTxnId()
       * 
       * @param mixed $txn_id
       * @return
       */
      public function verifyTxnId($txn_id)
      {

          $sql = self::$db->query("SELECT id" 
		  . "\n FROM " . self::pTable
		  . "\n WHERE txn_id = '" . sanitize($txn_id) . "'" 
		  . "\n LIMIT 1");

          if (self::$db->numrows($sql) > 0)
              return false;
          else
              return true;
      }
  }
?>