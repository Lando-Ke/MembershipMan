<?php
  /**
   * Core Class
   */

  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  class Core
  {

      const sTable = "settings";

      public $year = null;
      public $month = null;
      public $day = null;

      const langdir = "lang/";
	  public static $language;
	  public static $word = array();
	  public static $lang;
	  

      /**
       * Core::__construct()
       * 
       * @return
       */
      function __construct()
      {
		  self::getLanguage();
          $this->getSettings();
		  
          $this->year = (get('year')) ? get('year') : strftime('%Y');
          $this->month = (get('month')) ? get('month') : strftime('%m');
          $this->day = (get('day')) ? get('day') : strftime('%d');

          return mktime(0, 0, 0, $this->month, $this->day, $this->year);
      }


      /**
       * Core::getSettings()
       *
       * @return
       */
      private function getSettings()
      {
          $sql = "SELECT * FROM " . self::sTable;
          $row = Registry::get("Database")->first($sql);

          $this->site_name = $row->site_name;
          $this->site_url = $row->site_url;
		  $this->site_dir = $row->site_dir;
          $this->site_email = $row->site_email;
          $this->perpage = $row->perpage;
          $this->backup = $row->backup;
          $this->thumb_w = $row->thumb_w;
          $this->thumb_h = $row->thumb_h;
		  $this->short_date = $row->short_date;
		  $this->long_date = $row->long_date;
		  $this->logo = $row->logo;
          $this->reg_allowed = $row->reg_allowed;
          $this->user_limit = $row->user_limit;
          $this->reg_verify = $row->reg_verify;
          $this->notify_admin = $row->notify_admin;
          $this->auto_verify = $row->auto_verify;
          $this->currency = $row->currency;
          $this->cur_symbol = $row->cur_symbol;
		  $this->dsep = $row->dsep;
		  $this->tsep = $row->tsep;
		  $this->enable_tax = $row->enable_tax;
		  $this->inv_info = $row->inv_info;
		  $this->inv_note = $row->inv_note;
          $this->mailer = $row->mailer;
          $this->smtp_host = $row->smtp_host;
          $this->smtp_user = $row->smtp_user;
          $this->smtp_pass = $row->smtp_pass;
          $this->smtp_port = $row->smtp_port;
		  $this->is_ssl = $row->is_ssl;
		  $this->sendmail = $row->sendmail;
          $this->version = $row->version;

      }

      /**
       * Core::processConfig()
       * 
       * @return
       */
      public function processConfig()
      {

          Filter::checkPost('site_name', Core::$word->CG_SITENAME);
		  Filter::checkPost('site_url', Core::$word->CG_WEBURL);
		  Filter::checkPost('site_email', Core::$word->CG_WEBEMAIL);
		  Filter::checkPost('thumb_w', Core::$word->CG_IMG_W);
		  Filter::checkPost('thumb_h', Core::$word->CG_IMG_H);
		  Filter::checkPost('currency', Core::$word->CG_CURRENCY);

          switch($_POST['mailer']) {
			  case "SMTP" :
			  Filter::checkPost('smtp_host', Core::$word->CG_SMTP_HOST);
			  Filter::checkPost('smtp_user', Core::$word->CG_SMTP_USER);
			  Filter::checkPost('smtp_pass', Core::$word->CG_SMTP_PASS);
			  Filter::checkPost('smtp_port', Core::$word->CG_SMTP_PORT);
				  break;
			  
			  case "SMAIL" :
				  Filter::checkPost('sendmail', Core::$word->CG_SMAILPATH);
			  break;
		  }

          if (!empty($_FILES['logo']['name'])) {
              $file_info = getimagesize($_FILES['logo']['tmp_name']);
              if (empty($file_info))
				  Filter::checkPost('logo', Core::$word->CG_LOGO_R);
          }
		  
          if (empty(Filter::$msgs)) {
              $data = array(
                  'site_name' => sanitize($_POST['site_name']),
                  'site_url' => sanitize($_POST['site_url']),
				  'site_dir' => sanitize($_POST['site_dir']),
                  'site_email' => sanitize($_POST['site_email']),
                  'reg_allowed' => intval($_POST['reg_allowed']),
                  'user_limit' => intval($_POST['user_limit']),
                  'reg_verify' => intval($_POST['reg_verify']),
                  'notify_admin' => intval($_POST['notify_admin']),
                  'auto_verify' => intval($_POST['auto_verify']),
                  'perpage' => intval($_POST['perpage']),
                  'thumb_w' => intval($_POST['thumb_w']),
                  'thumb_h' => intval($_POST['thumb_h']),
				  'short_date' => sanitize($_POST['short_date']),
				  'long_date' => sanitize($_POST['long_date']),
                  'currency' => sanitize($_POST['currency']),
                  'cur_symbol' => sanitize($_POST['cur_symbol']),
				  'dsep' => sanitize($_POST['dsep']),
				  'tsep' => sanitize($_POST['tsep']),
				  'enable_tax' => intval($_POST['enable_tax']),
				  'inv_info' => ($_POST['inv_info']),
				  'inv_note' => ($_POST['inv_note']),
                  'mailer' => sanitize($_POST['mailer']),
				  'sendmail' => sanitize($_POST['sendmail']),
                  'smtp_host' => sanitize($_POST['smtp_host']),
                  'smtp_user' => sanitize($_POST['smtp_user']),
                  'smtp_pass' => sanitize($_POST['smtp_pass']),
                  'smtp_port' => intval($_POST['smtp_port']),
				  'is_ssl' => intval($_POST['is_ssl'])
				  );
				  
			  if (isset($_POST['dellogo']) and $_POST['dellogo'] == 1) {
				  $data['logo'] = "NULL";
			  } elseif (!empty($_FILES['logo']['name'])) {
				  if ($this->logo) {
					  @unlink(UPLOADS . $this->logo);
				  }
					  move_uploaded_file($_FILES['logo']['tmp_name'], UPLOADS.$_FILES['logo']['name']);

				  $data['logo'] = sanitize($_FILES['logo']['name']);
			  } else {
				$data['logo'] = $this->logo;
			  }
			  
              Registry::get("Database")->update(self::sTable, $data);
			  
              if (Registry::get("Database")->affected()) {
				  $json['type'] = 'success';
				  $json['title'] = Core::$word->SUCCESS;
				  $json['message'] = Core::$word->CG_UPDATED;
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
       * Core::get()
       * 
       * @return
       */
	  private static function getLanguage()
	  {

		  self::$word = self::setLanguage(BASEPATH . self::langdir . self::$lang. "lang.xml", self::$lang);
			  
		  return self::$word;
	  }
	  	
      /**
       * Core::set()
       * 
       * @return
       */
	  public static function setLanguage($lang, $abbr)
	  {
		  $xmlel = simplexml_load_file($lang);
		  $data = new stdClass();
		  foreach ($xmlel as $pkey) {
			  $key = (string )$pkey['data'];
			  $data->$key = (string )str_replace(array('\'', '"'), array("&apos;", "&quot;"), $pkey);
		  }
		  
		  return $data;
	  }

      /**
       * Core::getSections()
       * 
       * @return
       */
	  public static function getSections()
	  {
		  $xmlel = simplexml_load_file(BASEPATH . self::langdir . "/lang.xml");
		  $query = '/language/phrase[not(@section = preceding-sibling::phrase/@section)]/@section';
	
		  foreach ($xmlel->xpath($query) as $text) {
			  $sections[] = (string )$text;
		  }
	
		  return $sections;
	  }
	  
      /**
       * Core::monthList()
       * 
       * @return
       */ 	  
	  public static function monthList($list = true, $long = true, $selected = false)
	  {
		  $selected = is_null(get('month')) ? strftime('%m') : get('month');
	
		  if ($long) {
			  $arr = array(
				  '01' => self::$word->JAN,
				  '02' => self::$word->FEB,
				  '03' => self::$word->MAR,
				  '04' => self::$word->APR,
				  '05' => self::$word->MAY,
				  '06' => self::$word->JUN,
				  '07' => self::$word->JUL,
				  '08' => self::$word->AUG,
				  '09' => self::$word->SEP,
				  '10' => self::$word->OCT,
				  '11' => self::$word->NOV,
				  '12' => self::$word->DEC);
		  } else {
			  $arr = array(
				  '01' => self::$word->JA_,
				  '02' => self::$word->FE_,
				  '03' => self::$word->MA_,
				  '04' => self::$word->AP_,
				  '05' => self::$word->MY_,
				  '06' => self::$word->JU_,
				  '07' => self::$word->JL_,
				  '08' => self::$word->AU_,
				  '09' => self::$word->SE_,
				  '10' => self::$word->OC_,
				  '11' => self::$word->NO_,
				  '12' => self::$word->DE_);
		  }
		  $html = '';
		  if ($list) {
			  foreach ($arr as $key => $val) {
				  $html .= "<option value=\"$key\"";
				  $html .= ($key == $selected) ? ' selected="selected"' : '';
				  $html .= ">$val</option>\n";
			  }
		  } else {
			  $html .= '"' . implode('","', $arr) . '"';
		  }
		  unset($val);
		  return $html;
	  }

      /**
       * Core::weekList()
       * 
       * @return
       */ 	  
	  public static function weekList($list = true, $long = true, $selected = false)
	  {
		  if ($long) {
			  $arr = array(
				  '1' => self::$word->SUNDAY,
				  '2' => self::$word->MONDAY,
				  '3' => self::$word->TUESDAY,
				  '4' => self::$word->WEDNESDAY,
				  '5' => self::$word->THURSDAY,
				  '6' => self::$word->FRIDAY,
				  '7' => self::$word->SATURDAY);
		  } else {
			  $arr = array(
				  '1' => self::$word->SUN,
				  '2' => self::$word->MON,
				  '3' => self::$word->TUE,
				  '4' => self::$word->WED,
				  '5' => self::$word->THU,
				  '6' => self::$word->FRI,
				  '7' => self::$word->SAT);
		  }
	
		  $html = '';
		  if ($list) {
			  foreach ($arr as $key => $val) {
				  $html .= "<option value=\"$key\"";
				  $html .= ($key == $selected) ? ' selected="selected"' : '';
				  $html .= ">$val</option>\n";
			  }
		  } else {
			  $html .= '"' . implode('","', $arr) . '"';
		  }
	
		  unset($val);
		  return $html;
	  }
      /**
       * Core::yearlyStats()
       * 
       * @return
       */
      public function yearlyStats()
      {
          $sql = "SELECT *, YEAR(date) as year, MONTH(date) as month," 
		  . "\n COUNT(id) as total, SUM(rate_amount) as totalprice" 
		  . "\n FROM " . Membership::pTable 
		  . "\n WHERE YEAR(date) = '" . $this->year . "'" 
		  . "\n GROUP BY year DESC, month DESC ORDER by date";

          $row = Registry::get("Database")->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Core::getYearlySummary()
       * 
       * @return
       */
      public function getYearlySummary()
      {
          $sql = "SELECT YEAR(date) as year, MONTH(date) as month," 
		  . "\n COUNT(id) as total, SUM(rate_amount) as totalprice" 
		  . "\n FROM " . Membership::pTable 
		  . "\n WHERE YEAR(date) = '" . $this->year . "' GROUP BY year";

          $row = Registry::get("Database")->first($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Core::getShortDate()
       * 
       * @return
       */
      public static function getShortDate($selected = false)
	  {
	
		  $format = (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') ? "%#d" : "%e";
	
          $arr = array(
				 '%m-%d-%Y' => strftime('%m-%d-%Y') . ' (MM-DD-YYYY)',
				 $format . '-%m-%Y' => strftime($format . '-%m-%Y') . ' (D-MM-YYYY)',
				 '%m-' . $format . '-%y' => strftime('%m-' . $format . '-%y') . ' (MM-D-YY)',
				 $format . '-%m-%y' => strftime($format . '-%m-%y') . ' (D-MMM-YY)',
				 '%d %b %Y' => strftime('%d %b %Y')
		  );
		  
		  $shortdate = '';
		  foreach ($arr as $key => $val) {
              if ($key == $selected) {
                  $shortdate .= "<option selected=\"selected\" value=\"" . $key . "\">" . $val . "</option>\n";
              } else
                  $shortdate .= "<option value=\"" . $key . "\">" . $val . "</option>\n";
          }
          unset($val);
          return $shortdate;
      }


      /**
       * Core::getLongDate()
       * 
       * @return
       */
      public static function getLongDate($selected = false)
	  {
          $arr = array(
				'%B %d, %Y %I:%M %p' => strftime('%B %d, %Y %I:%M %p'),
				'%d %B %Y %I:%M %p' => strftime('%d %B %Y %I:%M %p'),
				'%B %d, %Y' => strftime('%B %d, %Y'),
				'%d %B, %Y' => strftime('%d %B, %Y'),
				'%A %d %B %Y' => strftime('%A %d %B %Y'),
				'%A %d %B %Y %H:%M' => strftime('%A %d %B %Y %H:%M'),
				'%a %d, %B' => strftime('%a %d, %B')
		  );
		  
		  $longdate = '';
		  foreach ($arr as $key => $val) {
              if ($key == $selected) {
                  $longdate .= "<option selected=\"selected\" value=\"" . $key . "\">" . utf8_encode($val) . "</option>\n";
              } else
                  $longdate .= "<option value=\"" . $key . "\">" . utf8_encode($val) . "</option>\n";
          }
          unset($val);
          return $longdate;
      }
	  
      /**
       * Core::formatMoney()
       * 
       * @param mixed $amount
       * @return
       */
      public function formatMoney($amount)
      {
		  return $this->cur_symbol . number_format($amount, 2, $this->dsep, $this->tsep) . ' ' . $this->currency;
      }
	  
      /**
       * Core::calculateTax()
       * 
	   * @param bool $uid
       * @return
       */
	  public static function calculateTax($uid = false)
	  {
		  if(Registry::get("Core")->enable_tax) {
			  if ($uid) {
				  $cnt = Registry::get("Database")->first("SELECT country FROM " . Users::uTable . " WHERE id = " . $uid);
				  $row = Registry::get("Database")->first("SELECT vat FROM " . Content::cTable . " WHERE abbr = '" . $cnt->country . "'");
			  } else {
				  $row = Registry::get("Database")->first("SELECT vat FROM " . Content::cTable . " WHERE abbr = '" . Registry::get("Users")->country . "'");
			  }
		
			  return ($row->vat / 100);
		  } else {
			  return 0.00;
		  }
	  }

      /**
       * Core::getCart()
       * 
	   * @param bool $uid
       * @return
       */
	  public static function getCart($uid = false)
	  {
		  $id = ($uid) ? intval($uid) : Registry::get("Users")->uid;
		  $row = Registry::get("Database")->first("SELECT * FROM " . Content::crTable . " WHERE uid = " . $id);
		  
		  return ($row) ? $row : 0; 
	  }
	  
	  /**
	   * Core::loopOptions()
	   * 
	   * @param mixed $array
	   * @return
	   */
	  public static function loopOptions($array, $key, $value,  $selected = false)
	  {
		  $html = '';
          if (is_array($array)) {
			  foreach ($array as $row) {
				  $html .= "<option value=\"" . $row->$key . "\"";
				  $html .= ($row->$key == $selected) ? ' selected="selected"' : '';
				  $html .= ">" . $row->$value . "</option>\n";
			  }
			  return $html;
          }
		  return false;
	  }

	  /**
	   * Core::_implode()
	   * 
	   * @param mixed $array
	   * @return
	   */
	  public static function _implode($array, $sep = ',')
	  {
          if (is_array($array)) {
			  $result = array();
			  foreach ($array as $row) {
				  if ($row != '') {
					  array_push($result, sanitize($row));
				  }
			  }
			  return implode($sep, $result);
          }
		  return false;
	  }

	  /**
	   * Core::sayHello()
	   * 
	   * @return
	   */
	  public static function sayHello()
	  {
		  $welcome = Core::$word->HELLO . ', ';
		  if (date("H") < 12) {
			  $welcome .= Core::$word->HI_M;
		  } else if (date('H') > 11 && date("H") < 18) {
			  $welcome .= Core::$word->HI_A;
		  } else if(date('H') > 17) {
			  $welcome .= Core::$word->HI_E;
		  }
		  
		  return $welcome;
	  }

	  /**
	   * Core::randomQuotes()
       * 
       * @param mixed $time
	   * @return
	   */
	  public static function randomQuotes($time)
	  {
		  // --> $time('m'); // Quote changes every month
		  // --> $time('h'); // Quote changes every hour
		  // --> $time('i'); // Quote changes every minute
		  
		  $quotes = file_get_contents(BASEPATH . "assets/quotes.txt");
		  $array = explode("%",$quotes);
		  
		  $time = intval(date($time));
		  $count = count($array);
		  $RandomIndexPos = ($time % $count);
		  
		  return $array[$RandomIndexPos];
	  }
	  
      /**
       * getRowById()
       * 
       * @param mixed $table
       * @param mixed $id
       * @param bool $and
       * @param bool $is_admin
       * @return
       */
      public static function getRowById($table, $id, $and = false, $is_admin = true)
      {
          $id = sanitize($id, 8, true);
          if ($and) {
              $sql = "SELECT * FROM " . (string )$table . " WHERE id = '" . Registry::get("Database")->escape((int)$id) . "' AND " . Registry::get("Database")->escape($and) . "";
          } else
              $sql = "SELECT * FROM " . (string )$table . " WHERE id = '" . Registry::get("Database")->escape((int)$id) . "'";

          $row = Registry::get("Database")->first($sql);

          if ($row) {
              return $row;
          } else {
              if ($is_admin)
                  Filter::error("You have selected an Invalid Id - #" . $id, "Core::getRowById()");
          }
      }
  }
?>