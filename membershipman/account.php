<?php
  /**
   * Account Profile
   */
  define("_VALID_PHP", true);
  require_once("init.php");
  
  if (!$user->logged_in)
      redirect_to("index.php");
	  
  $row = $user->getUserData();
  $mrow = $user->getUserMembership();
  $gatelist = $member->getGateways(true);
  $listpackrow = $member->getMembershipListFrontEnd();
  $datacountry = $content->getCountryList();
  $utransrow = $member->getUserTransactions();
?>
<?php include("header.php");?>
<div id="wrap" class="top-space">
  <div class="wojo-grid">
    <div class="columns">
      <div class="screen-80 tablet-90 phone-100 push-center">
        <div id="logtabs" class="wtabs">
          <ul class="wojo tabs">
            <li><a data-tab="#bmemb"><?php echo Core::$word->UA_SUBTITLE6;?></a></li>
            <li><a data-tab="#membership"><?php echo Core::$word->UA_SEL_MEMBERSHIP;?></a></li>
            <li><a data-tab="#account"><?php echo Core::$word->UA_SUBTITLE1;?></a></li>
          </ul>
          <div class="wojo form">
           <div id="bmemb" class="wojo tab data">
            <?php if($listpackrow):?>
            <div id="show-result"> </div>
            <?php $color = array("468592","4a579b","814a9b","9c4a69","4b9c52","879b4a","9a804a","468592","4a579b","814a9b","9c4a69","4b9c52","879b4a","9a804a");?>
            <ul id="plans" class="relative">
              <?php foreach ($listpackrow as $i => $prow):?>
              <li class="plan">
                <h2><?php echo $prow->title;?></h2>
                <p class="price alt" style="background:#<?php echo $color[$i];?>"><?php echo $core->formatMoney($prow->price);?> <span><?php echo $prow->days . ' ' .$member->getPeriod($prow->period);?></span></p>
                <p class="recurring"><?php echo Core::$word->RECURRING;?> <?php echo ($prow->recurring) ? Core::$word->YES : Core::$word->NO;?></p>
                <p class="desc"><?php echo cleanOut($prow->description);?></p>
                <p class="pbutton"><a class="add-cart" data-id="<?php echo $prow->id;?>" data-price="<?php echo $prow->price;?>"><?php echo ($prow->price <> 0) ? Core::$word->UA_BUY : Core::$word->UA_ACTIVATE;?></a></p>
              </li>
              <?php endforeach;?>
            </ul>
            <?php endif;?>
            </div>
            <div id="membership" class="wojo tab data">
              <h4><?php echo Core::$word->UA_SEL_MEMBERSHIP;?></h4>
              <table class="wojo basic table">
                <thead>
                  <tr>
                    <th class="nine wide"><?php echo Core::$word->UA_CUR_MEMBERSHIP;?></th>
                    <th class="seven wide"><?php echo Core::$word->UA_VALID_UNTIL;?></th>
                  </tr>
                </thead>
                <?php if($row->membership_id == 0) :?>
                <tr>
                  <td><?php echo Core::$word->UA_NO_MEMBERSHIP;?></td>
                  <td>--/--</td>
                </tr>
                <?php else:?>
                <tr class="positive">
                  <td><?php echo $mrow->title;?></td>
                  <td><?php echo Filter::dodate("long_date", $mrow->mem_expire);?></td>
                </tr>
                <?php endif;?>
                <?php if($utransrow):?>
                <tr>
                  <th><?php echo Core::$word->MEMBERSHIP;?></th>
                  <th><?php echo Core::$word->TRANSACTION;?></th>
                </tr>
                <?php foreach($utransrow as $trow):?>
                <tr>
                  <td><a href="<?php echo SITEURL;?>/ajax/controller.php?doInvoice&amp;id=<?php echo $trow->id;?>"><i class="icon pdf outline"></i> <?php echo $trow->title;?></a></td>
                  <td><?php echo Filter::dodate("long_date", $trow->date);?></td>
                </tr>
                <?php endforeach;?>
                <?php unset($trow);?>
                <?php endif;?>
              </table>
            </div>
            <div id="account" class="wojo tab data">
              <h4><?php echo Core::$word->UA_SUBTITLE1;?></h4>
              <form id="wojo_form" name="wojo_form" method="post">
                <div class="field">
                  <input name="username" type="text" disabled="disabled" value="<?php echo $row->username;?>">
                </div>
                <div class="field">
                  <input name="password" placeholder="<?php echo Core::$word->PASSWORD;?>" type="password">
                </div>
                <div class="field">
                  <input name="email" placeholder="<?php echo Core::$word->EMAIL;?>" type="text" value="<?php echo $row->email;?>">
                </div>
                <div class="field">
                  <input name="fname" placeholder="<?php echo Core::$word->UR_FNAME;?>" type="text" value="<?php echo $row->fname;?>">
                </div>
                <div class="field">
                  <input name="lname" placeholder="<?php echo Core::$word->UR_LNAME;?>" type="text" value="<?php echo $row->lname;?>">
                </div>
                <?php echo $content->rendertCustomFields('profile', $row->custom_fields, "two", false);?>
                <div class="two fields">
                  <div class="field">
                    <label class="input">
                      <input type="file" name="avatar" id="avatar" class="filefield">
                    </label>
                  </div>
                  <div class="field">
                    <div class="wojo avatar image">
                      <?php if($row->avatar):?>
                      <img src="<?php echo UPLOADURL;?><?php echo $row->avatar;?>" alt="<?php echo $user->username;?>">
                      <?php else:?>
                      <img src="<?php echo UPLOADURL;?>blank.png" alt="<?php echo $row->username;?>">
                      <?php endif;?>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <input type="text" placeholder="<?php echo Core::$word->UR_ADDRESS;?>" value="<?php echo $row->address;?>" name="address">
                </div>
                <div class="field">
                  <input type="text" placeholder="<?php echo Core::$word->UR_CITY;?>" value="<?php echo $row->city;?>" name="city">
                </div>
                <div class="two fields">
                  <div class="field">
                    <input type="text" placeholder="<?php echo Core::$word->UR_STATE;?>" value="<?php echo $row->state;?>" name="state">
                  </div>
                  <div class="field">
                    <input type="text" placeholder="<?php echo Core::$word->UR_ZIP;?>" value="<?php echo $row->zip;?>" name="zip">
                  </div>
                </div>
                <div class="field">
                  <select name="country">
                    <option value="">-- <?php echo Core::$word->CNT_SELECT;?> --</option>
                    <?php echo Core::loopOptions($datacountry, "abbr", "name", $row->country);?>
                  </select>
                </div>
                <div class="two fields">
                  <div class="field disabled">
                    <input name="lastlogin" title="<?php echo Core::$word->UR_LASTLOGIN;?>" type="text" disabled value="<?php echo (strtotime($row->lastlogin) === false) ? "-/-" : Filter::dodate("long_date", $row->lastlogin);?>" readonly>
                  </div>
                  <div class="field disabled">
                    <input name="lastip" title="<?php echo Core::$word->UR_LASTLOGIN_IP;?>" type="text" disabled value="<?php echo $row->lastip;?>" readonly>
                  </div>
                </div>
                <div class="two fields">
                  <div class="field disabled">
                    <input name="created" type="text" title="<?php echo Core::$word->UR_DATE_REGGED;?>" disabled value="<?php echo Filter::dodate("long_date", $row->created);?>" readonly>
                  </div>
                  <div class="field">
                    <label><?php echo Core::$word->UR_IS_NEWSLETTER;?></label>
                    <div class="inline-group">
                      <label class="radio">
                        <input type="radio" name="newsletter" value="1" <?php getChecked($row->newsletter, 1); ?>>
                        <i></i><?php echo Core::$word->YES;?></label>
                      <label class="radio">
                        <input type="radio" name="newsletter" value="0" <?php getChecked($row->newsletter, 0); ?>>
                        <i></i><?php echo Core::$word->NO;?></label>
                    </div>
                  </div>
                </div>
                <div class="clearfix content-center">
                  <button data-url="/ajax/controller.php" type="button" name="dosubmit" class="wojo button"><?php echo Core::$word->UA_UPDATE;?></button>
                </div>
                <input name="processUser" type="hidden" value="1">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function() {
    $('#plans').elasticColumns({
        innerMargin: 36,
        outerMargin: 0,
        columns: 2
    });
    $("body").on("click", "a.add-cart", function() {
        var id = $(this).data('id');
        price = $(this).data('price');
        $.ajax({
            type: "POST",
			dataType:'json',
            url: SITEURL + "/ajax/controller.php",
            data: {
                addtocart: 1,
                id: id,
                price: price
            },
            success: function(json) {
                $("#show-result").html(json.message);
				$('html, body').animate({
					scrollTop: $("#wrap").offset().top
				}, 1000);
            }
        });
        return false;
    });
    $("body").on("click", "input[name='gateway']", function() {
        var id = $(this).prop('value');
		var mid = $(this).data('gateway');
        $.ajax({
            type: "GET",
			dataType:'json',
            url: SITEURL + "/ajax/controller.php",
            data: {
                loadGateway: 1,
                id: id,
				mid: mid
            },
            success: function(json) {
				$("#gdata").html(json.message);
				$('html, body').animate({
					scrollTop: $("#gatedata").offset().top
				}, 500);
            }
        });
    });
    $("body").on("click", "#cinput", function() {
        var id = $(this).data('id');
        var $code = $("input[name=coupon]");
        if (!$code.val()) {
            $code.closest('div').addClass('error');
        } else {
            $.ajax({
                type: "get",
                dataType: 'json',
                url: SITEURL + "/ajax/controller.php",
                data: {
                    doCoupon: 1,
                    id: id,
                    code: $code.val()
                },
                success: function(json) {
                    if (json.type == "success") {
                        $code.closest('div').removeClass('error');
                        $(".totaltax").html(json.tax);
                        $(".totalamt").html(json.gtotal);
                        $(".disc").html(json.disc);
                        $(".disc").parent().addClass('error');
                    } else {
                        $code.closest('div').addClass('error');
                    }
                }

            });
        }
        return false;
    });
});
// ]]>
</script>
<?php include("footer.php");?>