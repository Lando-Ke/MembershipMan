<?php
  /**
   * Login Redirect Help
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
  <div class="active section"><?php echo Core::$word->N_HELP_LR;?></div>
</div>
<div class="wojo basic segment">
  <div class="wojo header"><span><?php echo Core::$word->HP_TITLE1;?></span>
    <p><?php echo Core::$word->HP_INFO;?></p>
  </div>
  <div class="wojo content"> <small class="wojo label push-left">1.</small>
    <p class="left-space"><?php echo Core::$word->HP_SUB3;?></p>
    <?php
  highlight_string('
  <?php
	if ($result)
		redirect_to("account.php");
  ?>');
?>
    <small class="wojo label push-left">2.</small>
    <p class="left-space"><?php echo Core::$word->HP_SUB4;?></p>
  </div>
</div>