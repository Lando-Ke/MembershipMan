<?php

  /**
   * PayFast IPN
   */
  define("_VALID_PHP", true);
  define("_PIPN", true);

  ini_set('log_errors', true);
  ini_set('error_log', dirname(__file__) . '/ipn_errors.log');

  include_once dirname(__file__) . '/pf.inc.php';

  if (isset($_POST['payment_status'])) {
      require_once ("../../init.php");

      $pf = Core::getRow(Content::gwTable, "name", "payfast");
      $pfHost = ($pf->live) ? 'https://www.payfast.co.za' : 'https://sandbox.payfast.co.za';
	  $error = false;


      pflog('ITN received from payfast.co.za');


      if (!pfValidIP($_SERVER['REMOTE_ADDR'])) {
          pflog('REMOTE_IP mismatch: ');
		  $error = true;
          return false;
      }

      $data = pfGetData();

      pflog('POST received from payfast.co.za: ' . print_r($data, true));

      if ($data === false) {
          pflog('POST is empty: ' . print_r($data, true));
		  $error = true;
          return false;
      }

      if (!pfValidSignature($data, $pf->extra3)) {
          pflog('Signature mismatch on POST');
		  $error = true;
          return false;
      }

      pflog('Signature OK');


      $itnPostData = array();
      $itnPostDataValuePairs = array();

      foreach ($_POST as $key => $value) {
          if ($key == 'signature')
              continue;

          $value = urlencode(stripslashes($value));
          $value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i', '${1}%0D%0A${3}', $value);

          $itnPostDataValuePairs[] = "$key=$value";
      }

      $itnVerifyRequest = implode('&', $itnPostDataValuePairs);

      if (!pfValidData($pfHost, $itnVerifyRequest, "$pfHost/eng/query/validate")) {
          pflog("ITN mismatch for $itnVerifyRequest\n");
          pflog('ITN not OK');
		  $error = true;
          return false;
      }

      pflog('ITN OK');
      pflog("ITN verified for $itnVerifyRequest\n");

      if ($error == false and $_POST['payment_status'] == "COMPLETE") {
	
		  $user_id = intval($_POST['custom_int1']);
		  $mc_gross = $_POST['amount_gross'];
		  $membership_id = $_POST['m_payment_id'];
		  $txn_id = $_POST['pf_payment_id'];
	
		  $total = Core::getCart($user_id);
		  $v1 = compareFloatNumbers($mc_gross, $total->totalprice, "=");
		  
		  if ($v1 == true) {
                  $row = $db->first("SELECT * FROM " . Membership::mTable . " WHERE id=" . (int)$membership_id);
                  $username = getValueById("username", Users::uTable, (int)$user_id);

                  $data = array(
                      'txn_id' => $txn_id,
                      'membership_id' => $row->id,
                      'user_id' => (int)$user_id,
					  'rate_amount' => $total->originalprice,
					  'tax' => $total->totaltax,
					  'coupon' => $total->coupon,
					  'total' => $total->totalprice,
                      'ip' => $_SERVER['REMOTE_ADDR'],
                      'created' => "NOW()",
                      'pp' => "PayFast",
                      'currency' => "ZAR",
                      'status' => 1);

                  $db->insert(Membership::pTable, $data);

                  $udata = array(
                      'membership_id' => $row->id,
                      'mem_expire' => $user->calculateDays($row->id),
                      'trial_used' => ($row->trial == 1) ? 1 : 0,
                      'memused' => 1);

                  $db->update(Users::uTable, $udata, "id=" . (int)$user_id); 
				  
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
                      $core->formatMoney($mc_gross),
                      "Completed",
                      "PayPal",
                      $_SERVER['REMOTE_ADDR']), $row2->body
					  );

                  $newbody = cleanOut($body);

                  $mailer = Mailer::sendMail();
                  $message = Swift_Message::newInstance()
							->setSubject($row2->subject)
							->setTo(array($core->site_email => $core->site_name))
							->setFrom(array($core->site_email => $core->site_name))
							->setBody($newbody, 'text/html');

                  $mailer->send($message);
				  pflog("Email Notification sent successfuly");
		  }

      }

  }

?>