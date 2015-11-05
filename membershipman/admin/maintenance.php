<?php
  /**
   * Maintenance
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->N_SYSMTNC;?></div>
</div>
<div class="wojo basic form segment">
  <div class="wojo header"><span><?php echo Core::$word->MT_TITLE;?></span>
    <p><?php echo Core::$word->MT_INFO;?></p>
  </div>
  <form id="wojo_form" name="wojo_form" method="post">
    <div class="wojo content">
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->MT_IUSERS;?></label>
          <select name="days" data-cover="true">
            <option value="3">3</option>
            <option value="7">7</option>
            <option value="14">14</option>
            <option value="30">30</option>
            <option value="60">60</option>
            <option value="100">100</option>
            <option value="180">180</option>
            <option value="365">365</option>
          </select>
          <p class="woho info"><?php echo Core::$word->MT_IUSERS_T;?></p>
        </div>
        <div class="field">
          <label><?php echo Core::$word->DELETE;?></label>
          <button type="button" data-type="inactive" name="inactive" class="wojo basic button"><?php echo Core::$word->MT_IUBTN;?></button>
        </div>
      </div>
      <div class="wojo fitted divider"></div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->MT_BUSERS;?></label>
          <p class="woho info"><?php echo str_replace("[TOTAL]", '<small class="wojo label">' . countEntries("users","active","b") . '</small>', Core::$word->MT_BUSERS_T);?></p>
        </div>
        <div class="field">
          <label><?php echo Core::$word->DELETE;?></label>
          <button type="button" data-type="banned" name="banned" class="wojo basic button"><?php echo Core::$word->MT_BUBTN;?></button>
        </div>
      </div>
      <div class="wojo fitted divider"></div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->MT_CART;?></label>
          <p class="woho info"><?php echo Core::$word->MT_CART_T;?></p>
        </div>
        <div class="field">
          <label><?php echo Core::$word->DELETE;?></label>
          <button type="button" data-type="cart" name="cart" class="wojo basic button"><?php echo Core::$word->MT_CRBTN;?></button>
        </div>
      </div>
    </div>
    <input name="processMaintenance" type="hidden" value="1">
  </form>
</div>
<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function () {
    /* == Master Form == */
		$('body').on('click', 'button[name=banned], button[name=inactive], button[name=cart]', function() {
		    var $parent = $(this).closest('.wojo.form');
		    function showResponse(json) {
				$($parent).removeClass("loading");
				$.sticky(decodeURIComponent(json.message), {
					autoclose: 12000,
					type: json.type,
					title: json.title
				});
		    }

		    function showLoader() {
		        $($parent).addClass("loading");
		    }
		    var options = {
		        target: null,
		        beforeSubmit: showLoader,
		        success: showResponse,
		        type: "post",
		        url: "controller.php",
		        dataType: 'json',
				data :{'do':$(this).data('type')}
		    };

		    $('#wojo_form').ajaxForm(options).submit();
		});
});
// ]]>
</script>