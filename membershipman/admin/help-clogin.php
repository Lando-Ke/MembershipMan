<?php
  /**
   * Custom Login Form Help
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
  <div class="active section"><?php echo Core::$word->N_HELP_CL;?></div>
</div>
<div class="wojo basic segment">
  <div class="wojo header"><span><?php echo Core::$word->HP_TITLE5;?></span>
    <p><?php echo Core::$word->HP_INFO;?></p>
  </div>
  <div class="wojo content"> <small class="wojo label push-left">1.</small> <p class="left-space"><?php echo Core::$word->HP_SUB14;?></p>
<?php
  highlight_string('
  <?php
	define("_VALID_PHP", true);
	require_once("init.php");
  ?>');
?>
    <small class="wojo label push-left">2.</small> <p class="left-space"><?php echo Core::$word->HP_SUB15;?></p>
<?php
  highlight_string('
  <?php
	define("_VALID_PHP", true);
	require_once("init.php");
	
	if ($user->logged_in)
		redirect_to(SITEURL . "/account.php");
		
	if (isset($_POST["doLogin"])) : 
	    $result = $user->login($_POST["username"], $_POST["password"]);
	
	/* Login Successful */
	if ($result) : 
	    redirect_to(SITEURL . "/account.php");
	endif;
	endif;
  ?>');
?>
    <small class="wojo label push-left">3.</small> <p class="left-space"><?php echo Core::$word->HP_SUB16;?></p> 
<?php
  highlight_string('
	<form method="post" id="login_form" name="login_form">
	  <div class="field">
		<input name="username" placeholder="Username" type="text">
	  </div>
	  <div class="field">
		<input name="password" placeholder="Password" type="password">
	  </div>
	  <div class="clearfix">
		<button name="submit" type="submit" class="wojo button">Login</button>
	  </div>
	  <input name="doLogin" type="hidden" value="1">
	</form>
	<?php print Filter::$showMsg;?> 
  ');
?>
    <small class="wojo label push-left">4.</small> <p class="left-space"><?php echo Core::$word->HP_SUB17;?></p> 
    </div>
</div>