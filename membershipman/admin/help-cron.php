<?php
  /**
   * Cron Job Help
   *
   * @package Membership Manager Pro
   * @author wojoscripts.com
   * @copyright 2015
   * @version $Id: help-redirect.php, v3.00 2015-03-10 10:12:05 gewa Exp $
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->N_HELP_CJ;?></div>
</div>
<div class="wojo basic segment">
  <div class="wojo header"><span><?php echo Core::$word->HP_TITLE3;?></span>
    <p><?php echo Core::$word->HP_INFO;?></p>
  </div>
  <div class="wojo content">
    <p><?php echo Core::$word->HP_SUB12;?></p>
    <br>
    <p>By default there are two files inside /cron/ directory <strong>cron_job0days.php</strong> and <strong>cron_job7days.php</strong><br />
      <strong>cron_job0days.php</strong> will automatically send emails to all users whose membership had expired at the present day, while <strong>cron_job7days.php</strong> will send emails to all users whose membership is about to expire within 7 days.</p>
    <div class="pagetip"> <strong>1</strong>. Each hosting company might have different way of setting cron jobs. Here will give you few examples: <br />
      <ul>
        <li><strong> For CPanel - </strong> http://www.siteground.com/tutorials/cpanel/cron_jobs.htm</li>
        <li><strong>For Plesk Pnel -</strong> http://www.hosting.com/support/plesk/crontab</li>
      </ul>
    </div>
    <p><strong>2</strong>. If your hosting panel it's not covered here you can always ask your hosting provider.</p>
    <p> <strong>3.</strong> <strong>cron_job0days.php</strong> and <strong>cron_job7days.php</strong> files should be set up to run every day at midnight</p>
    <p><strong>4.</strong> <em>Don't forget to modify template files for sending reminders. <a href="index.php?do=templates&amp;action=edit&amp;id=8">Membership Expire 7 days</a> and <a href="index.php?do=templates&amp;action=edit&amp;id=9">Membership Expired Today</a></em> </p>
  </div>
</div>