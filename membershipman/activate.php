<?php
  /**
   * Account Activation
   *
   *
   */
  define("_VALID_PHP", true);
  require_once("init.php");
  
  if ($user->logged_in)
      redirect_to("account.php");
?>
<?php include("header.php");?>
<div id="wrap">
  <div class="wojo-grid">
    <div class="columns">
      <div class="screen-60 tablet-90 phone-100 push-center">
        <div class="wojo form">
        <h4><?php echo Core::$word->UA_INFO5;?></h4>
        <form id="wojo_form" name="wojo_form" method="post">
          <div class="field">
            <input name="email" value="<?php if(get('email')) echo sanitize($_GET['email']);?>" placeholder="<?php echo Core::$word->CF_NAME;?>" type="text">
          </div>
          <div class="field">
            <input type="text" name="token" value="<?php if(get('token')) echo sanitize($_GET['token']);?>" placeholder="<?php echo Core::$word->UA_TOKEN;?>">
          </div>
          <div class="clearfix">
            <button data-url="/ajax/user.php" type="button" name="dosubmit" class="wojo button"><?php echo Core::$word->UA_ACTIVATE_ACC;?></button>
          </div>
          <input name="accActivate" type="hidden" value="1">
        </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include("footer.php");?>