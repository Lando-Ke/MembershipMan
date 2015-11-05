<?php
  /**
   * Controller
   */
  define("_VALID_PHP", true);

  require_once("init.php");
  if (!$user->is_Admin())
    exit;
	
  $delete = (isset($_POST['delete']))  ? $_POST['delete'] : null;
?>
<?php
  switch ($delete):
	  /* == Delete User == */
	  case "deleteUser":
		if (Filter::$id == 1):
			$json['type'] = 'error';
			$json['title'] = Core::$word->ERROR;
			$json['message'] = Core::$word->UR_ADMIN_E;
		else:
			$res = $db->delete(Users::uTable, "id=" . Filter::$id);
			$title = sanitize($_POST['title']);
			if($res) :
				$json['type'] = 'success';
				$json['title'] = Core::$word->SUCCESS;
				$json['message'] =  str_replace("[NAME]", $title, Core::$word->UR_DELETED);
				else :
				$json['type'] = 'warning';
				$json['title'] = Core::$word->ALERT;
				$json['message'] = Core::$word->SYSTEM_PROCCESS;
			endif;
		endif;
			print json_encode($json);
	  break;
	
	  /* == Delete News == */
	  case "deleteNews":
		$res = $db->delete(Content::nTable, "id=" . Filter::$id);
		$title = sanitize($_POST['title']);
		if($res) :
			$json['type'] = 'success';
			$json['title'] = Core::$word->SUCCESS;
			$json['message'] =  str_replace("[NAME]", $title, Core::$word->NM_DELETED);
			else :
			$json['type'] = 'warning';
			$json['title'] = Core::$word->ALERT;
			$json['message'] = Core::$word->SYSTEM_PROCCESS;
		endif;
		print json_encode($json);
	  break;
	
	  /* == Delete Field == */
	  case "deleteField":
		$res = $db->delete(Content::fTable, "id=" . Filter::$id);
		$title = sanitize($_POST['title']);
		if($res) :
			$json['type'] = 'success';
			$json['title'] = Core::$word->SUCCESS;
			$json['message'] =  str_replace("[NAME]", $title, Core::$word->CF_DELETED);
			else :
			$json['type'] = 'warning';
			$json['title'] = Core::$word->ALERT;
			$json['message'] = Core::$word->SYSTEM_PROCCESS;
		endif;
		print json_encode($json);
	  break;
	
	  /* == Delete Country == */
	  case "deleteCountry":
		$res = $db->delete(Content::cTable, "id=" . Filter::$id);
		$title = sanitize($_POST['title']);
		if($res) :
			$json['type'] = 'success';
			$json['title'] = Core::$word->SUCCESS;
			$json['message'] =  str_replace("[NAME]", $title, Core::$word->CNT_DELOK);
			else :
			$json['type'] = 'warning';
			$json['title'] = Core::$word->ALERT;
			$json['message'] = Core::$word->SYSTEM_PROCCESS;
		endif;
		print json_encode($json);
	  break;
	
	  /* == Delete Membership == */
	  case "deleteMembership":
		$res = $db->delete(Membership::mTable, "id=" . Filter::$id);
		$title = sanitize($_POST['title']);
		if($res) :
			$json['type'] = 'success';
			$json['title'] = Core::$word->SUCCESS;
			$json['message'] =  str_replace("[NAME]", $title, Core::$word->MM_DELETED);
			else :
			$json['type'] = 'warning';
			$json['title'] = Core::$word->ALERT;
			$json['message'] = Core::$word->SYSTEM_PROCCESS;
		endif;
		print json_encode($json);
	  break;
	
	  /* == Delete Transaction == */
	  case "deleteTransaction":
		$res = $db->delete(Membership::pTable, "id=" . Filter::$id);
		$title = sanitize($_POST['title']);
		if($res) :
			$json['type'] = 'success';
			$json['title'] = Core::$word->SUCCESS;
			$json['message'] =  str_replace("[NAME]", $title, Core::$word->TX_DELETED);
			else :
			$json['type'] = 'warning';
			$json['title'] = Core::$word->ALERT;
			$json['message'] = Core::$word->SYSTEM_PROCCESS;
		endif;
		print json_encode($json);
	  break;

	  /* == Delete Coupon == */
	  case "deleteCoupon":
		$res = $db->delete(Content::dTable, "id=" . Filter::$id);
		$title = sanitize($_POST['title']);
		if($res) :
			$json['type'] = 'success';
			$json['title'] = Core::$word->SUCCESS;
			$json['message'] =  str_replace("[NAME]", $title, Core::$word->DC_DELETED);
			else :
			$json['type'] = 'warning';
			$json['title'] = Core::$word->ALERT;
			$json['message'] = Core::$word->SYSTEM_PROCCESS;
		endif;
		print json_encode($json);
	  break;
	  
	  /* == Delete Backup == */
	  case "deleteBackup":
		  $title = sanitize($_POST['title']);
		  $action = false;
	
		  if(file_exists(BASEPATH . 'admin/backups/' . $title)) :
			$action = unlink(BASEPATH . 'admin/backups/' . $title);
		  endif;
					  
		  if($action) :
			  $json['type'] = 'success';
			  $json['title'] = Core::$word->SUCCESS;
			  $json['message'] = str_replace("[NAME]", $title, Core::$word->BK_DELETE_OK);
		  else :
			  $json['type'] = 'warning';
			  $json['title'] = Core::$word->ALERT;
			  $json['message'] = Core::$word->SYSTEM_PROCCESS;
		  endif;
		  print json_encode($json);
	   break;
		 
  endswitch;
  
  /* == Proccess Configuration == */
  if (isset($_POST['processConfig'])):
      $core->processConfig();
  endif;

  /* == Proccess Newsletter == */
  if (isset($_POST['processNewsletter'])):
      $content->processNewsletter();
  endif;

  /* == Proccess Email Template == */
  if (isset($_POST['processEmailTemplate'])):
      $content->processEmailTemplate();
  endif;

  /* == Proccess News == */
  if (isset($_POST['processNews'])):
      $content->processNews();
  endif;

  /* == Proccess Field == */
  if (isset($_POST['processField'])):
      $content->processField();
  endif;

  /* == Proccess Country == */
  if (isset($_POST['processCountry'])):
      $content->processCountry();
  endif;
  
  /* == Proccess User == */
  if (isset($_POST['processUser'])):
      $user->processUser();
  endif;

  /* == Proccess Membership == */
  if (isset($_POST['processMembership'])):
      $member->processMembership();
  endif;

  /* == Proccess Discount == */
  if (isset($_POST['processCoupon'])):
      $content->processCoupon();
  endif;
  
  /* == Proccess Gateway == */
  if (isset($_POST['processGateway'])):
      $member->processGateway();
  endif;

  /* == Reorder Fields == */
  if (isset($_GET['sortfields'])):
      foreach ($_POST['node'] as $k => $v):
          $p = $k + 1;
          $data['sorting'] = intval($p);
          $db->update(Content::fTable, $data, "id=" . (int)$v);
      endforeach;
  endif;

  /* == Acctivate User == */
  if (isset($_POST['activateAccount'])):
      $user->activateAccount();
  endif;
  
  /* == User Search == */
  if (isset($_GET['doLiveSearch']) and $_GET['type'] == "usersearch"):
      $string = sanitize($_GET['value'], 15);

      if (strlen($string) > 3):
          $sql = "SELECT u.id, u.username, u.email, u.avatar, u.membership_id, u.created, CONCAT(u.fname,' ',u.lname) as name, m.title, m.id as mid" 
		  . "\n FROM " . Users::uTable . " as u"
		  . "\n LEFT JOIN " . Membership::mTable . " as m ON m.id = membership_id" 
		  . "\n WHERE MATCH (username) AGAINST ('" . $db->escape($string) . "*' IN BOOLEAN MODE)" 
		  . "\n ORDER BY username LIMIT 10";
		  $html = '';
          if ($result = $db->fetch_all($sql)):
			  $html .= '<div id="search-results" class="wojo small feed segment">';
              foreach ($result as $row):
			      $avatar = ($row->avatar) ? $row->avatar : 'blank.png';
				  $membership = (!$row->membership_id) ? '-/-' : '<a href="index.php?do=memberships&amp;action=edit&amp;id=' . $row->mid . '">' . $row->title . '</a>';
				  $link = 'index.php?do=users&amp;action=edit&amp;id=' . (int)$row->id;
				  $html .= '<div class="event">';
				  $html .= '<div class="label">';
				  $html .= '<img src="../uploads/' . $avatar . '" alt="">';
				  $html .= '</div>';
				  $html .= '<div class="content">';
				  $html .= '<div class="date">';
				  $html .= Filter::dodate('long_date', $row->created);
				  $html .= '</div>';
				  $html .= '<div class="summary">';
				  $html .= '<a href="' . $link . '">' . $row->name . '</a> (' . $row->username . ')';
				  $html .= '</div>';
				  $html .= '<div class="extra text">';
				  $html .= '<p><a href="index.php?do=newsletter&amp;emailid=' . urlencode($row->email). '">' . $row->email . '</a></p>';
				  $html .= '<p>' . Core::$word->MEMBERSHIP . ': ' . $membership . '</p>';
				  $html .= '</div>';
				  $html .= '</div>';
				  $html .= '</div>';
              endforeach;
			  $html .= '</div>';
			  print $html;
          endif;
      endif;
  endif;

  /* == Quick Edit== */
  if (isset($_POST['quickedit'])):
      $title = cleanOut($_POST['title']);
      $title = strip_tags($title);
      switch ($_POST['type']) {
          /* == Update Language Phrase== */
          case "phrase":
			  if (file_exists(BASEPATH . Core::langdir . "/lang.xml")):
				  $xmlel = simplexml_load_file(BASEPATH . Core::langdir . "/lang.xml");
				  $node = $xmlel->xpath("/language/phrase[@data = '" . $_POST['key'] . "']");
				  $node[0][0] = $title;
				  $xmlel->asXML(BASEPATH . Core::langdir . "/lang.xml");
			  endif;
          break;

          /* == Update Country Vat == */
          case "cntvat":
              if (empty($_POST['title'])):
                  print '0.000';
                  exit;
              endif;
              if ($_POST['key'] == "vat"):
                  $data['vat'] = sanitize($_POST['title']);
              endif;
				  $db->update(Content::cTable, $data, "id = " . Filter::$id);
          break;
      }

      print $title;
  endif;

  /* == Load Language Section == */
  if (isset($_GET['loadLangSection'])):
	  $xmlel = simplexml_load_file(BASEPATH . Core::langdir . "/lang.xml");
	  $i = 1;
	  $html = '';
	  if ($_GET['section'] == "all"):
		  foreach ($xmlel as $pkey):
			  $html .= '
			  <tr>
			    <td><small>' . $i++ . '.</small></td>
				<td>' . $pkey['data'] . '</td>
				<td data-editable="true" data-set=\'{"type": "phrase", "id": ' . $i++ . ',"key":"' . $pkey['data'] . '", "path":"lang"}\'>' . $pkey . '</td>
			  </tr>';
		  endforeach;
	  else:
		  $section = $xmlel->xpath('/language/phrase[@section="' . sanitize($_GET['section']) . '"]');
		  foreach ($section as $pkey):
			  $html .= '
			  <tr>
			    <td><small>' . $i++ . '.</small></td>
				<td>' . $pkey['data'] . '</td>
				<td data-editable="true" data-set=\'{"type": "phrase", "id": ' . $i++ . ',"key":"' . $pkey['data'] . '", "path":"lang"}\'>' . $pkey . '</td>
			  </tr>';
		  endforeach;
	  endif;
	  
	  $json['status']  = 'success';
	  $json['title']   = Core::$word->SUCCESS;
	  $json['message'] = $html;
	  print json_encode($json);
  endif;
  
  /* == Site Maintenance == */
  if (isset($_POST['processMaintenance'])):
      if ($_POST['do'] == "inactive"):
          $now = date('Y-m-d H:i:s');
          $diff = intval($_POST['days']);
          $expire = date("Y-m-d H:i:s", strtotime($now . -$diff . " days"));
          $db->delete(Users::uTable, "lastlogin < '" . $expire . "' AND active = 'y' AND userlevel !=9");

		  if ($db->affected()):
			  $json['type'] = 'success';
			  $json['title'] = Core::$word->SUCCESS;
			  $json['message'] = str_replace("[NUMBER]", $db->affected(), Core::$word->MT_DELINCT_OK);
		  else:
			  $json['type'] = 'warning';
			  $json['title'] = Core::$word->ALERT;
			  $json['message'] = Core::$word->SYSTEM_PROCCESS;
		  endif;
	      print json_encode($json);	
			
      elseif ($_POST['do'] == "banned"):
          $db->delete(Users::uTable, "active = 'b'");
		  
		  if ($db->affected()):
			  $json['type'] = 'success';
			  $json['title'] = Core::$word->SUCCESS;
			  $json['message'] = str_replace("[NUMBER]", $db->affected(), Core::$word->MT_DELBND_OK);
		  else:
			  $json['type'] = 'warning';
			  $json['title'] = Core::$word->ALERT;
			  $json['message'] = Core::$word->SYSTEM_PROCCESS;
		  endif;
	      print json_encode($json);	

      elseif ($_POST['do'] == "cart"):
          $db->delete(Content::crTable, "created < NOW() - INTERVAL 1 DAY");
		  
		  if ($db->affected()):
			  $json['type'] = 'success';
			  $json['title'] = Core::$word->SUCCESS;
			  $json['message'] = str_replace("[NUMBER]", $db->affected(), Core::$word->MT_DELCRT_OK);
		  else:
			  $json['type'] = 'warning';
			  $json['title'] = Core::$word->ALERT;
			  $json['message'] = Core::$word->SYSTEM_PROCCESS;
		  endif;
	      print json_encode($json);	
		  
      endif;
  endif;
				  
  /* == Transaction Search == */
  if (isset($_GET['doLiveSearch']) and $_GET['type'] == "transsearch"):
      $string = sanitize($_GET['value'], 25);

      if (strlen($string) > 5):
          $sql = "SELECT p.*, p.id as id, u.username, m.title, u.avatar, u.email, CONCAT(u.fname,' ',u.lname) as name, m.id as mid" 
		  . "\n FROM " . Membership::pTable . " as p" 
		  . "\n LEFT JOIN " . Users::uTable . " as u ON u.id = p.user_id" 
		  . "\n LEFT JOIN " . Membership::mTable . " as m ON m.id = p.membership_id" 
		  . "\n WHERE MATCH (txn_id) AGAINST ('" . $db->escape($string) . "*' IN BOOLEAN MODE)" 
		  . "\n ORDER BY username LIMIT 10";
		  $html = '';
          if ($result = $db->fetch_all($sql)):
			  $html .= '<div id="search-results" class="wojo small feed segment">';
              foreach ($result as $row):
			      $avatar = ($row->avatar) ? $row->avatar : 'blank.png';
				  $membership = '<a href="index.php?do=memberships&amp;action=edit&amp;id=' . $row->mid . '">' . $row->title . '</a>';
				  $link = 'index.php?do=users&amp;action=edit&amp;id=' . (int)$row->user_id;
				  $html .= '<div class="event">';
				  $html .= '<div class="label">';
				  $html .= '<img src="../uploads/' . $avatar . '" alt="">';
				  $html .= '</div>';
				  $html .= '<div class="content">';
				  $html .= '<div class="date">';
				  $html .= Filter::dodate('long_date', $row->date);
				  $html .= '</div>';
				  $html .= '<div class="summary">';
				  $html .= '<a href="' . $link . '">' . $row->name . '</a> (' . $row->username . ')';
				  $html .= '</div>';
				  $html .= '<div class="extra text">';
				  $html .= '<p><a href="index.php?do=newsletter&amp;emailid=' . urlencode($row->email). '">' . $row->email . '</a></p>';
				  $html .= '<p>' . Core::$word->MEMBERSHIP . ': ' . $membership . '</p>';
				  $html .= '<p>TXN: ' . $row->txn_id . '</p>';
				  $html .= '</div>';
				  $html .= '</div>';
				  $html .= '</div>';
              endforeach;
			  $html .= '</div>';
			  print $html;
          endif;
      endif;
  endif;
  
  /* == Export Transactions == */
  if (isset($_GET['exportTransactions'])) :
      $result = $member->getPayments(false, false, false);

      $type = "vnd.ms-excel";
      $date = date('m-d-Y H:i');
      $title = "Exported from the " . $core->site_name . " on $date";

      header("Pragma: public");
      header("Expires: 0");
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      header("Content-Type: application/force-download");
      header("Content-Type: application/octet-stream");
      header("Content-Type: application/download");
      header("Content-Type: application/$type");
      header("Content-Disposition: attachment;filename=temp_" . time() . ".xls");
      header("Content-Transfer-Encoding: binary ");

      echo ("$title\n");
      $sep = "\t";

      print '
	  <table width="100%" cellpadding="1" cellspacing="2" border="1">
	  <caption>' . $title . '</caption>
		<tr>
		  <td>TXN</td>
		  <td>' . Core::$word->MM_TTITLE . '</td>
		  <td>' . Core::$word->USERNAME . '</td>
		  <td>' . Core::$word->TX_AMOUNT . '</td>
		  <td>' . Core::$word->CREATED . '</td>
		  <td>' . Core::$word->TX_PP . '</td>
		  <td>IP</td>
		</tr>';
      foreach ($result as $v):
          print '<tr>
			  <td>' . $v->txn_id . '</td>
			  <td>' . $v->title . '</td>
			  <td>' . $v->username . '</td>
			  <td>' . $v->rate_amount . '</td>
			  <td>' . Filter::dodate("long_date", $v->date) . '</td>
			  <td>' . $v->pp . '</td>
			  <td>' . $v->ip . '</td>
			</tr>';
      endforeach;

      print '</table>';
      exit();
  endif;
  
  
  /* == Page Builder == */
  if (isset($_POST['processBuilder'])):
      Membership::processBuilder();
  endif;

  /* == Restore SQL Backup == */
  if (isset($_POST['restoreBackup'])):
	  require_once(BASEPATH . "lib/class_dbtools.php");
	  Registry::set('dbTools',new dbTools());
	  $tools = Registry::get("dbTools");
	  
	  if($tools->doRestore($_POST['restoreBackup'])) :
		  $json['type'] = 'success';
		  $json['title'] = Core::$word->SUCCESS;
		  $json['message'] = str_replace("[NAME]", $_POST['restoreBackup'], Core::$word->BK_RESTORE_OK);
		  else :
		  $json['type'] = 'warning';
		  $json['title'] = Core::$word->ALERT;
		  $json['message'] = Core::$word->SYSTEM_PROCCESS;
	  endif;
	  print json_encode($json);
  endif;

  /* == Account Map Stats == */
  if (isset($_GET['getAccCountries'])):
	 $data = $user->getAccountMapStats();
	 $json['country_name']= array();
	 $json['hits']= array();
      
	  if($data):
		  foreach($data as $row):
			  $json['country_name'][]= (string)$row->country_name;
			  $json['hits'][]= (int)$row->hits;
		  endforeach; 
	  endif;
      echo json_encode($json);
 endif;

  /* == Account Stats == */
  if (isset($_GET['getAccStats'])):
	
  $range = (isset($_GET['timerange'])) ? sanitize($_GET['timerange'], 6) : 'year';	  
  $data = array();
  $data['income'] = array();
  $data['xaxis'] = array();
  $data['regs']['label'] = Core::$word->REGISTRATIONS;
  $data['regs']['color'] = "#a3bdd8";

  
  switch ($range) {
	  case 'day':
	  $date = date('Y-m-d');
		  for ($i = 0; $i < 24; $i++) {
			  $query = $db->first("SELECT COUNT(*) AS total FROM " . Users::uTable 
			  . "\n WHERE DATE(created) = '" . $date . "'" 
			  . "\n AND HOUR(created) = '" . (int)$i . "'" 
			  . "\n GROUP BY HOUR(created) ORDER BY created ASC");
  
			  ($query) ? $data['regs']['data'][] = array($i, (int)$query->total) : $data['regs']['data'][] = array($i, 0);
			  $data['xaxis'][] = array($i, date('H', mktime($i, 0, 0, date('n'), date('j'), date('Y'))));
		  }
		  break;
	  case 'week':
		  $date_start = strtotime('-' . date('w') . ' days');
  
		  for ($i = 0; $i < 7; $i++) {
			  $date = date('Y-m-d', $date_start + ($i * 86400));
			  $query = $db->first("SELECT COUNT(*) AS total FROM " . Users::uTable
			  . "\n WHERE DATE(created) = '" . $date . "'"
			  . "\n GROUP BY DATE(created)");
  
			  ($query) ? $data['regs']['data'][] = array($i, (int)$query->total) : $data['regs']['data'][] = array($i, 0);
			  $data['xaxis'][] = array($i, date('D', strtotime($date)));
		  }
  
		  break;
	  default:
	  case 'month':
		  for ($i = 1; $i <= date('t'); $i++) {
			  $date = date('Y') . '-' . date('m') . '-' . $i;
			  $query = $db->first("SELECT COUNT(*) AS total FROM " . Users::uTable
			  . "\n WHERE (DATE(created) = '" . $date . "')"
			  . "\n GROUP BY DAY(created)");
  
			  ($query) ? $data['regs']['data'][] = array($i, (int)$query->total) : $data['regs']['data'][] = array($i, 0);
			  $data['xaxis'][] = array($i, date('j', strtotime($date)));
		  }
		  break;
	  case 'year':
		  for ($i = 1; $i <= 12; $i++) {
			  $query = $db->first("SELECT COUNT(*) AS total FROM " . Users::uTable
			  . "\n WHERE YEAR(created) = '" . date('Y') . "'"
			  . "\n AND MONTH(created) = '" . $i . "'"
			  . "\n GROUP BY MONTH(created)");
  
			  ($query) ? $data['regs']['data'][] = array($i, (int)$query->total) : $data['regs']['data'][] = array($i, 0);
			  $data['xaxis'][] = array($i, date('M', mktime(0, 0, 0, $i, 1, date('Y'))));
		  }
		  break;
	  case 'all':
		  for ($i = 1; $i <= 12; $i++) {
			  $query = $db->first("SELECT COUNT(*) AS total FROM " . Users::uTable
			  . "\n WHERE MONTH(created) = '" . $i . "'"
			  . "\n GROUP BY MONTH(created)");
  
			  ($query) ? $data['regs']['data'][] = array($i, (int)$query->total) : $data['regs']['data'][] = array($i, 0);
			  $data['xaxis'][] = array($i, date('M', mktime(0, 0, 0, $i, 1, date('Y'))));
		  }
		  break;
  }

   print json_encode($data);
  endif;
  
  /* == Latest Sales Stats == */
  if (isset($_GET['getSaleStats'])):
      if (intval($_GET['getSaleStats']) == 0 || empty($_GET['getSaleStats'])):
          die();
      endif;

      $range = (isset($_GET['timerange'])) ? sanitize($_GET['timerange']) : 'month';
      $data = array();
      $data['order'] = array();
      $data['xaxis'] = array();
      $data['order']['label'] = Core::$word->AD_REVENUE;
	  $data['order']['color'] = "#a3bdd8";

      switch ($range) {
          case 'day':
              $date = date('Y-m-d');
              for ($i = 0; $i < 24; $i++) {
                  $query = $db->first("SELECT COUNT(*) AS total FROM payments" 
				  . "\n WHERE DATE(date) = '" . $db->escape($date) . "'" 
				  . "\n AND HOUR(date) = '" . (int)$i . "'" 
				  . "\n GROUP BY HOUR(date) ORDER BY date ASC");

                  ($query) ? $data['order']['data'][] = array($i, (int)$query->total) : $data['order']['data'][] = array($i, 0);
                  $data['xaxis'][] = array($i, date('H', mktime($i, 0, 0, date('n'), date('j'), date('Y'))));
              }
              break;
          case 'week':
              $date_start = strtotime('-' . date('w') . ' days');

              for ($i = 0; $i < 7; $i++) {
                  $date = date('Y-m-d', $date_start + ($i * 86400));
                  $query = $db->first("SELECT COUNT(*) AS total FROM payments" 
				  . "\n WHERE DATE(date) = '" . $db->escape($date) . "'" 
				  . "\n GROUP BY DATE(date)");

                  ($query) ? $data['order']['data'][] = array($i, (int)$query->total) : $data['order']['data'][] = array($i, 0);
                  $data['xaxis'][] = array($i, date('D', strtotime($date)));
              }

              break;
          default:
          case 'month':
              for ($i = 1; $i <= date('t'); $i++) {
                  $date = date('Y') . '-' . date('m') . '-' . $i;
                  $query = $db->first("SELECT COUNT(*) AS total FROM payments" 
				  . "\n WHERE (DATE(date) = '" . $db->escape($date) . "')" 
				  . "\n GROUP BY DAY(date)");

                  ($query) ? $data['order']['data'][] = array($i, (int)$query->total) : $data['order']['data'][] = array($i, 0);
                  $data['xaxis'][] = array($i, date('j', strtotime($date)));
              }
              break;
          case 'year':
              for ($i = 1; $i <= 12; $i++) {
                  $query = $db->first("SELECT COUNT(*) AS total FROM payments" 
				  . "\n WHERE YEAR(date) = '" . date('Y') . "'" 
				  . "\n AND MONTH(date) = '" . $i . "'" 
				  . "\n GROUP BY MONTH(date)");

                  ($query) ? $data['order']['data'][] = array($i, (int)$query->total) : $data['order']['data'][] = array($i, 0);
                  $data['xaxis'][] = array($i, date('M', mktime(0, 0, 0, $i, 1, date('Y'))));
              }
              break;
      }

      print json_encode($data);
  endif;
?>