<?php
  /**
   * Send Mail
   *
   */
  define("_VALID_PHP", true);
  require_once("../init.php");
?>
<?php
  $post = (!empty($_POST)) ? true : false;

  if ($post) {
      Filter::checkPost("name", Core::$word->CF_NAME);
      Filter::checkPost("email", Core::$word->CF_EMAIL);

      if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $_POST['email']))
          Filter::$msgs['email'] = Core::$word->CF_EMAIL_ERR;

      Filter::checkPost("message", Core::$word->CF_MSG);
      Filter::checkPost("captcha", Core::$word->CF_TOTAL);

      if ($_SESSION['captchacode'] != $_POST['captcha'])
          Filter::$msgs['captcha'] = Core::$word->CF_TOTAL_ERR;


      if (empty(Filter::$msgs)) {
          $sender_email = sanitize($_POST['email']);
          $name = sanitize($_POST['name']);
          $message = strip_tags($_POST['message']);
          $mailsubject = sanitize($_POST['subject']);
          $ip = sanitize($_SERVER['REMOTE_ADDR']);

          require_once (BASEPATH . "lib/class_mailer.php");
          $mailer = Mailer::sendMail();

          $row = Registry::get("Core")->getRowById(Content::eTable, 10);

          $body = str_replace(array(
              '[MESSAGE]',
              '[SENDER]',
              '[NAME]',
              '[MAILSUBJECT]',
              '[IP]',
              '[SITE_NAME]',
              '[URL]'), array(
              $message,
              $sender_email,
              $name,
              $mailsubject,
              $ip,
              $core->site_name,
              SITEURL), $row->body);

          $msg = Swift_Message::newInstance()
				  ->setSubject($row->subject)
				  ->setTo(array($core->site_email => $core->site_name))
				  ->setFrom(array($sender_email => $name))
				  ->setBody(cleanOut($body), 'text/html');

          if ($mailer->send($msg)) {
              $json['type'] = 'success';
              $json['title'] = Core::$word->SUCCESS;
              $json['message'] = Core::$word->CF_OK;
              print json_encode($json);

          } else {
              $json['type'] = 'error';
              $json['title'] = Core::$word->ERROR;
              $json['message'] = Core::$word->CF_ERROR;
              print json_encode($json);
          }

      } else {
          $json['type'] = 'error';
          $json['title'] = Core::$word->SYSTEM_ERR;
          $json['message'] = Filter::msgSingleStatus();
          print json_encode($json);
      }

  }