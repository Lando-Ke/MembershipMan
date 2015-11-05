<?php
  /**
   * Moneybookers Form
   *
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
	  $cart = Core::getCart();
?>
<form action="https://www.moneybookers.com/app/payment.pl" method="post" id="mb_form" name="mb_form">
  <input type="image" src="gateways/skrill/moneybookers_big.png" style="vertical-align:middle;border:0;width:180px;margin-right:10px" name="submit" title="Pay With Moneybookers" alt="" onclick="document.mb_form.submit();"/>
  <input type="hidden" name="pay_to_email" value="<?php echo $grows->extra;?>" />
  <input type="hidden" name="return_url" value="<?php echo SITEURL;?>/account.php" />
  <input type="hidden" name="cancel_url" value="<?php echo SITEURL;?>/account.php" />
  <input type="hidden" name="status_url" value="<?php echo SITEURL.'/gateways/'.$grows->dir;?>/ipn.php" />
  <input type="hidden" name="merchant_fields" value="session_id, item, custom" />
  <input type="hidden" name="item" value="<?php echo $row->title;?>" />
  <input type="hidden" name="session_id" value="<?php echo md5(time())?>" />
  <input type="hidden" name="custom" value="<?php echo $row->id . '_' . $user->uid;?>" />
  <?php if($row->recurring == 1):?>
  <input type="hidden" name="rec_amount" value="<?php echo $cart->totalprice;?>" />
  <input type="hidden" name="rec_period" value="<?php echo $member->getTotalDays($row->period, $row->days);?>" />
  <input type="hidden" name="rec_cycle" value="day" />
  <?php else: ?>
  <input type="hidden" name="amount" value="<?php echo $cart->totalprice;?>" />
  <?php endif; ?>
  <input type="hidden" name="currency" value="<?php echo ($grows->extra2) ? $grows->extra2 : $core->currency;?>" />
  <input type="hidden" name="detail1_description" value="<?php echo $row->title;?>" />
  <input type="hidden" name="detail1_text" value="<?php echo $row->description;?>" />
</form>
