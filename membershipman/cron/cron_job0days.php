<?php
  /**
   * Cron Job Listing Expiry Zero Days Notice
   */
  define("_VALID_PHP", true);
  require_once("../init.php");
  
  $member->membershipCron(0);
?>