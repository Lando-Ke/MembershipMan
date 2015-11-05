<?php
  /**
   * User Register
   *
   * @package Membership Manager Pro
   * @author wojoscripts.com
   * @copyright 2015
   * @version $Id: register.php, v4.00 2015-04-10 10:12:05 gewa Exp $
   */
  define("_VALID_PHP", true);
  require_once("init.php");

  if ($user->logged_in)
      redirect_to("account.php");
	  
   $numusers = countEntries("users");
   $datacountry = $content->getCountryList();
?>
<?php include("header.php");?>
<div id="wrap">
  <div class="wojo-grid">
    <div class="columns">
      <div class="screen-60 tablet-90 phone-100 push-center">
        <div class="wojo form">
          <?php if(!$core->reg_allowed):?>
          <?php echo Filter::msgSingleAlert(Core::$word->UA_NOMORE_REG);?>
          <?php elseif($core->user_limit !=0 and $core->user_limit == countEntries(Users::uTable)):?>
          <?php echo Filter::msgSingleAlert(Core::$word->UA_MAX_LIMIT);?>
          <?php else:?>
          <h4><?php echo Core::$word->UA_INFO4;?></h4>
          <form id="wojo_form" name="wojo_form" method="post">
            <div class="field">
              <input name="username" placeholder="<?php echo Core::$word->USERNAME;?>" type="text">
            </div>
            <div class="field">
              <input name="pass" placeholder="<?php echo Core::$word->PASSWORD;?>" type="password">
            </div>
            <div class="field">
              <input name="pass2" placeholder="<?php echo Core::$word->UA_PASSWORD2;?>" type="password">
            </div>
            <div class="field">
              <input name="email" placeholder="<?php echo Core::$word->UR_EMAIL;?>" type="text">
            </div>
            <div class="field">
              <input name="fname" placeholder="<?php echo Core::$word->UR_FNAME;?>" type="text">
            </div>
            <div class="field">
              <input name="lname" placeholder="<?php echo Core::$word->UR_LNAME;?>" type="text">
            </div>
            <?php echo $content->rendertCustomFields('register', false, "two", false);?>
            <div class="field">
              <input type="text" data-geo="name" placeholder="<?php echo Core::$word->UR_ADDRESS;?>" name="address">
            </div>
            <div class="field">
              <input type="text" data-geo="locality" placeholder="<?php echo Core::$word->UR_CITY;?>" name="city">
            </div>
            <div class="two fields">
              <div class="field">
                <input type="text" data-geo="administrative_area_level_1" placeholder="<?php echo Core::$word->UR_STATE;?>" name="state">
              </div>
              <div class="field">
                <input type="text" data-geo="postal_code" placeholder="<?php echo Core::$word->UR_ZIP;?>" name="zip">
              </div>
            </div>
            <div class="field">
              <select name="country">
                <option value="">-- <?php echo Core::$word->CNT_SELECT;?> --</option>
                <?php echo Core::loopOptions($datacountry, "abbr", "name", false);?>
              </select>
            </div>
            <div class="field">
              <label class="input"><img src="<?php echo SITEURL;?>/lib/captcha.php" alt="" class="captcha-append">
                <input type="text" placeholder="<?php echo Core::$word->UA_REG_RTOTAL;?>" name="captcha">
              </label>
            </div>
            <div class="clearfix content-center">
              <button data-url="/ajax/user.php" type="button" name="dosubmit" class="wojo secondary button"><?php echo Core::$word->UA_REG_ACC;?></button>
            </div>
            <input name="doRegister" type="hidden" value="1">
            <input data-geo="country" name="tmpcountry" type="hidden" value="">
          </form>
          <?php endif;?>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo $protocol;?>://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script> 
<script type="text/javascript" src="<?php echo SITEURL;?>/assets/js/geocomplete.js"></script> 
<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function() {
    $("input[name=address]").geocomplete({
        details: "form",
        detailsAttribute: "data-geo",
        types: ["geocode", "establishment"]
    }).on("geocode:result", function(e, result) {
        var country = $("input[name=tmpcountry]").val()
        $('select[name=country] option:contains("' + country + '")').prop("selected", "selected")
        $('select[name=country]').selecter("update");
    });
});
// ]]>
</script>
<?php include("footer.php");?>