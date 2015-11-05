<?php
  /**
   * Index
   *
   */
  define("_VALID_PHP", true);
  require_once("init.php");
  
  if ($user->logged_in)
      redirect_to(SITEURL . "/account.php");
	  
  if (isset($_POST['doLogin']))
      : $result = $user->login($_POST['username'], $_POST['password']);
  
  /* Login Successful */
  if ($result)
      : redirect_to("account.php");
  endif;
  endif;
?>
<?php include("header.php");?>
<div id="wrap">
  <div class="wojo-grid">
    <div class="columns">
      <div class="screen-60 tablet-90 phone-100 push-center">
        <div class="wojo form">
          <div id="loginform">
            <h4><?php echo Core::$word->UA_SUBTITLE2;?></h4>
            <form method="post" id="login_form" name="login_form">
              <div class="field">
                <input name="username" placeholder="<?php echo Core::$word->UA_TITLE2;?>" type="text">
              </div>
              <div class="field">
                <input name="password" placeholder="<?php echo Core::$word->PASSWORD;?>" type="password">
              </div>
              <div class="clearfix"> <a id="passreset" class="push-right"><?php echo Core::$word->UA_TITLE3;?></a>
                <button name="submit" type="submit" class="wojo button"><?php echo Core::$word->UA_LOGINNOW;?></button>
              </div>
              <input name="doLogin" type="hidden" value="1">
            </form>
            <?php print Filter::$showMsg;?> 
          </div>
          <div id="passform" style="display:none">
            <h4><?php echo Core::$word->UA_SUBTITLE3;?></h4>
            <form id="wojo_form" name="wojo_form" method="post">
              <div class="field">
                <input name="uname" placeholder="<?php echo Core::$word->USERNAME;?>" type="text">
              </div>
              <div class="field">
                <input name="email" placeholder="<?php echo Core::$word->UR_EMAIL;?>" type="text">
              </div>
              <div class="field">
                <label class="input"><img src="<?php echo SITEURL;?>/lib/captcha.php" alt="" class="captcha-append" />
                  <input name="captcha" placeholder="<?php echo Core::$word->UA_PASS_RTOTAL;?>" type="text">
                </label>
              </div>
              <div class="clearfix"> <a id="backto" class="push-right"><?php echo Core::$word->UA_BLOGIN;?></a>
                <button data-url="/ajax/user.php" type="button" name="dosubmit" class="wojo button"><?php echo Core::$word->UA_PASS_RSUBMIT;?></button>
              </div>
              <input name="passReset" type="hidden" value="1">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function () {
    $('#backto').click(function () {
        $("#passform").slideUp("slow");
        $("#loginform").slideDown("slow");
    });
    $('#passreset').click(function () {
        $("#loginform").slideUp("slow");
        $("#passform").slideDown("slow");
    });
});
// ]]>
</script>
<?php include("footer.php");?>