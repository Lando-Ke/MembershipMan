<?php
  /**
   * PayFast Form
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
	  $cart = Core::getCart();
?>
<?php if(!$row->recurring):?>
<?php $url = ($grows->demo) ? 'www.payfast.co.za' : 'sandbox.payfast.co.za';?>
  <form action="https://<?php echo $url;?>/eng/process" class="xform" method="post" id="pf_form" name="pf_form">
    <input type="image" src="<?php echo SITEURL.'/gateways/payfast/payfast_big.png';?>" name="submit" title="Pay With PayFast" alt="" onclick="document.pf_form.submit();"/>
	<?php
      $html = '';
      $string = '';
	  list($fname, $lname) = explode(" ", $user->name);
      
      $array = array(
          'merchant_id' => $grows->extra,
          'merchant_key' => $grows->extra2,
          'return_url' => SITEURL . "/account.php",
          'cancel_url' => SITEURL . "/account.php",
          'notify_url' => SITEURL . '/gateways/' . $grows->dir . '/ipn.php',
		  'name_first' => $fname,
		  'name_last' => $lname,
          'email_address' => $user->email,
          'm_payment_id' => $row->id,
          'amount' => $cart->totalprice,
          'item_name' => $row->title,
          'item_description' => $row->description,
          'custom_int1' => $user->uid,
          );
    
      foreach ($array as $k => $v) {
          $html .= '<input type="hidden" name="' . $k . '" value="' . $v . '" />';
          $string .= $k . '=' . urlencode($v) . '&';
      }
      $string = substr($string, 0, -1);
      $sig = md5($string);
      $html .= '<input type="hidden" name="signature" value="' . $sig . '" />';
    
      print $html;
    ?>
  </form>
<?php endif;?>