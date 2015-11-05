<?php
  /**
   * PayPal IPN
   *
   */
  define("_VALID_PHP", true);
  define("_PIPN", true);


  ini_set('log_errors', true);
  ini_set('error_log', dirname(__file__) . '/ipn_errors.log');

  if (isset($_POST['payment_status'])) {
      require_once ("../../init.php");
      require_once ("../../lib/class_pp.php");


      $demo = getValue("demo", "gateways", "name = 'paypal'");

      $listener = new IpnListener();
      $listener->use_live = $demo;
      $listener->use_ssl = true;
      $listener->use_curl = false;

      try {
          $listener->requirePostMethod();
          $ppver = $listener->processIpn();
      }
      catch (exception $e) {
          error_log($e->getMessage(), 3, "pp_errorlog.log");
          exit(0);
      }

      $payment_status = $_POST['payment_status'];
      $receiver_email = $_POST['receiver_email'];
      list($membership_id, $user_id) = explode("_", $_POST['item_number']);
      $mc_gross = $_POST['mc_gross'];
      $txn_id = $_POST['txn_id'];

      $getxn_id = $member->verifyTxnId($txn_id);
      $price = getValueById("price", Membership::mTable, intval($membership_id));
      $pp_email = getValue("extra", Membership::gTable, "name = 'paypal'");

	  $total = Core::getCart(intval($user_id));
	  $v1 = compareFloatNumbers($mc_gross, $total->totalprice, "=");

      if ($ppver) {
          if ($_POST['payment_status'] == 'Completed') {
              if ($receiver_email == $pp_email && $v1 == true && $getxn_id == true) {
                  $sql = "SELECT * FROM " . Membership::mTable . " WHERE id='" . (int)$membership_id . "'";
                  $row = $db->first($sql);

                  $username = getValueById("username", Users::uTable, intval($user_id));

                  $data = array(
                      'txn_id' => $txn_id,
                      'membership_id' => $row->id,
                      'user_id' => (int)$user_id,
					  'rate_amount' => $total->originalprice,
					  'tax' => $total->totaltax,
					  'coupon' => $total->coupon,
					  'total' => $total->totalprice,
                      'ip' => $_SERVER['REMOTE_ADDR'],
                      'date' => "NOW()",
                      'pp' => "PayPal",
                      'currency' => $_POST['mc_currency'],
                      'status' => 1);

                  $db->insert(Membership::pTable, $data);

                  $udata = array(
                      'membership_id' => $row->id,
                      'mem_expire' => $user->calculateDays($row->id),
                      'trial_used' => ($row->trial == 1) ? 1 : 0);

                  $db->update(Users::uTable, $udata, "id='" . (int)$user_id . "'");

                  /* == Notify Administrator == */
                  require_once (BASEPATH . "lib/class_mailer.php");
                  $row2 = Core::getRowById(Content::eTable, 5);

                  $body = str_replace(array(
                      '[USERNAME]',
                      '[ITEMNAME]',
                      '[PRICE]',
                      '[STATUS]',
                      '[PP]',
                      '[IP]'), array(
                      $username,
                      $row->title,
                      $core->formatMoney($total->totalprice),
                      "Completed",
                      "PayPal",
                      $_SERVER['REMOTE_ADDR']), $row2->body);

                  $newbody = cleanOut($body);

                  $mailer = Mailer::sendMail();
                  $message = Swift_Message::newInstance()
							->setSubject($row2->subject)
							->setTo(array($core->site_email => $core->site_name))
							->setFrom(array($core->site_email => $core->site_name))
							->setBody($newbody, 'text/html');

                  $mailer->send($message);


                  /* == Notify User == */
                  $row3 = Core::getRowById(Content::eTable, 15);
                  $uemail = getValueById("email", Users::uTable, intval($user_id));

                  $body2 = str_replace(array(
                      '[USERNAME]',
                      '[MNAME]',
                      '[VALID]'), array(
                      $username,
                      $row->title,
                      $udata['mem_expire']), $row3->body);

                  $newbody2 = cleanOut($body2);

                  $mailer2 = Mailer::sendMail();
                  $message2 = Swift_Message::newInstance()
							->setSubject($row3->subject)
							->setTo(array($uemail => $username))
							->setFrom(array($core->site_email => $core->site_name))
							->setBody($newbody2, 'text/html');

                  $mailer2->send($message2);
				  
				  $db->delete(Content::crTable, "uid = " . intval($user_id));
              }

          } else {
              /* == Failed Transaction= = */
              require_once (BASEPATH . "lib/class_mailer.php");
              $row2 = Core::getRowById(Content::eTable, 6);
              $itemname = getValueById("title", Membership::mTable, intval($membership_id));

              $body = str_replace(array(
                  '[USERNAME]',
                  '[ITEMNAME]',
                  '[PRICE]',
                  '[STATUS]',
                  '[PP]',
                  '[IP]'), array(
                  $username,
                  $itemname,
                  $core->formatMoney($total->totalprice),
                  "Failed",
                  "PayPal",
                  $_SERVER['REMOTE_ADDR']), $row2->body);

              $newbody = cleanOut($body);

              $mailer = Mailer::sendMail();
              $message = Swift_Message::newInstance()
						->setSubject($row2->subject)
						->setTo(array($core->site_email => $core->site_name))
						->setFrom(array($core->site_email => $core->site_name))
						->setBody($newbody, 'text/html');

              $mailer->send($message);

          }
      }
  }
?>