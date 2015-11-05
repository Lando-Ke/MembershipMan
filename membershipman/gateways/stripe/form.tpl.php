<?php
  /**
   * Stripe Form
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
	  $cart = Core::getCart();
?>
<?php if(!$row->recurring):?>
<form method="post" id="stripe_form">
  <div class="field">
    <label>Card Number</label>
    <label class="input">
      <input type="text" autocomplete="off" name="card-number" placeholder="Card Number">
    </label>
  </div>
  <div class="three fields">
    <div class="field">
      <label>CVC</label>
      <label class="input">
        <input type="text" autocomplete="off" name="card-cvc" placeholder="CVC">
      </label>
    </div>
    <div class="field">
      <label>Expiration Month</label>
      <label class="input">
        <input type="text" autocomplete="off" name="card-expiry-month" placeholder="MM">
      </label>
    </div>
    <div class="field">
      <label>Expiration Year</label>
      <label class="input">
        <input type="text" autocomplete="off" name="card-expiry-year" placeholder="YYYY">
      </label>
    </div>
  </div>
  <div class="clearfix">
    <button class="wojo button alt" id="dostripe" name="dostripe" type="button">Submit Payment</button>
  </div>
  <input type="hidden" name="amount" value="<?php echo $cart->totalprice;?>" />
  <input type="hidden" name="item_name" value="<?php echo $row->title;?>" />
  <input type="hidden" name="item_number" value="<?php echo $row->id;?>" />
  <input type="hidden" name="currency_code" value="<?php echo ($grows->extra2) ? $grows->extra2 : $core->currency;?>" />
  <input type="hidden" name="processStripePayment" value="1" />
</form>
<div id="smsgholder"></div>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function() {
    $('#dostripe').on('click', function() {
        $("#stripe_form").addClass('loading');
        var str = $("#stripe_form").serialize();
        $.ajax({
            type: "post",
            dataType: 'json',
            url: SITEURL + "/gateways/stripe/ipn.php",
            data: str,
            success: function(json) {
                $("#stripe_form").removeClass('loading');
                if (json.type == "success") {
					$('#smsgholder').html(json.message).fadeOut();
                    setTimeout(function() {
							window.location.href = SITEURL + '/account.php';
                        },
                        4000);
                } else {
                    $("#smsgholder").html(json.message);
                }
            }
        });
        return false;
    });
});
// ]]>
</script>
<?php endif;?>
