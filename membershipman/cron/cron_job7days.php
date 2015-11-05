<?php
  /**
   * Cron Job Listing Expiry Seven Days Notice
   */
  define("_VALID_PHP", true);
  require_once("../init.php");
  
  $member->membershipCron(7);
?>