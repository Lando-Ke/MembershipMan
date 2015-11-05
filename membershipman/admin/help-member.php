<?php
  /**
   * Membership Help
   *
   * @package Membership Manager Pro
   * @author wojoscripts.com
   * @copyright 2010
   * @version $Id: help-member.php, v2.00 2011-07-10 10:12:05 gewa Exp $
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->N_HELP_MP;?></div>
</div>
<div class="wojo basic segment">
  <div class="wojo header"><span><?php echo Core::$word->HP_TITLE2;?></span>
    <p><?php echo Core::$word->HP_INFO;?></p>
  </div>
  <div class="wojo content"> <small class="wojo label push-left">1.</small>
    <p class="left-space"><?php echo Core::$word->HP_SUB5;?></p>
    <?php
  highlight_string('
  <?php
	define("_VALID_PHP", true);
	require_once("init.php");
  ?>');
?>
    <small class="wojo label push-left">2.</small>
    <p class="left-space"><?php echo Core::$word->HP_SUB6;?></p>
    <?php
  highlight_string('
  <?php
	define("_VALID_PHP", true);
	require_once("init.php");
	
	if (!$user->checkMembership("3,4"))
		redirect_to("login.php");
  ?>');
?>
    <p><?php echo Core::$word->HP_SUB7;?></p>
    <br>
    <div class="clearfix"><small class="wojo label push-left">3.</small>
      <p class="left-space"><?php echo Core::$word->HP_SUB8;?></p>
    </div>
    <br>
    <div class="clearfix"><small class="wojo label push-left">4.</small>
      <p class="left-space"><?php echo Core::$word->HP_SUB9;?></p>
    </div>
    <?php
  highlight_string('
  <?php
	define("_VALID_PHP", true);
	require_once("init.php");
  ?>
	<?php if (!$user->checkMembership("3,4")) : ?>
	
		Your custom error message goes here, such as Sorry you do not have valid membership!!!
	   
	<?php else: ?>
	
		In this section here you would place your content that users with valid membership will be able to see.
		
	<?php endif;?>
  ');
?>
    <p><?php echo Core::$word->HP_SUB10;?></p>
    <p><?php echo Core::$word->HP_SUB11;?></p>
  </div>
</div>