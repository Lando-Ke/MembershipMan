<?php
  /**
   * Contact Form
   */
  define("_VALID_PHP", true);
  require_once("init.php");
?>
<?php include("header.php");?>
<div id="wrap">
  <div class="wojo-grid">
    <div class="columns">
      <div class="screen-60 tablet-90 phone-100 push-center">
        <div class="wojo form">
          <h4><?php echo Core::$word->CF_INFO;?></h4>
          <form id="wojo_form" name="wojo_form" method="post">
            <div class="field">
              <input name="name" value="<?php if ($user->logged_in) echo $user->name;?>" placeholder="<?php echo Core::$word->CF_NAME;?>" type="text">
            </div>
            <div class="field">
              <input type="text" name="email" value="<?php if ($user->logged_in) echo $user->email;?>" placeholder="<?php echo Core::$word->CF_EMAIL;?>">
            </div>
            <div class="field">
              <select name="subject" data-cover="true">
                <option value=""><?php echo Core::$word->CF_SUBJECT_1;?></option>
                <option value="<?php echo Core::$word->CF_SUBJECT_2;?>"><?php echo Core::$word->CF_SUBJECT_2;?></option>
                <option value="<?php echo Core::$word->CF_SUBJECT_3;?>"><?php echo Core::$word->CF_SUBJECT_3;?></option>
                <option value="<?php echo Core::$word->CF_SUBJECT_4;?>"><?php echo Core::$word->CF_SUBJECT_4;?></option>
                <option value="<?php echo Core::$word->CF_SUBJECT_5;?>"><?php echo Core::$word->CF_SUBJECT_5;?></option>
                <option value="<?php echo Core::$word->CF_SUBJECT_6;?>"><?php echo Core::$word->CF_SUBJECT_6;?></option>
                <option value="<?php echo Core::$word->CF_SUBJECT_7;?>"><?php echo Core::$word->CF_SUBJECT_7;?></option>
              </select>
            </div>
            <div class="field">
              <textarea name="message" placeholder="<?php echo Core::$word->CF_MSG;?>"></textarea>
            </div>
            <div class="field">
              <label class="input"><img src="<?php echo SITEURL;?>/lib/captcha.php" alt="" class="captcha-append" />
                <input name="captcha" placeholder="<?php echo Core::$word->UA_PASS_RTOTAL;?>" type="text">
              </label>
            </div>
            <div class="clearfix content-center">
              <button data-url="/ajax/sendmail.php" type="button" name="dosubmit" class="wojo button"><?php echo Core::$word->CF_SEND;?></button>
            </div>
            <input name="processContact" type="hidden" value="1">
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include("footer.php");?>