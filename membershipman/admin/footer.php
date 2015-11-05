<?php
  /**
   * Footer
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<!-- Start Footer-->
  <div class="wojo-grid">
    <footer> Copyright &copy;<?php echo date('Y').' '.$core->site_name;?><br />
      Wojoscripts.com &bull; Membership Manager Pro v<?php echo $core->version;?> </footer>
  </div>
</div>
<script src="<?php echo SITEURL;?>/assets/js/fullscreen.js"></script>
<!-- End Footer-->
<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function () {
    $.Master({
		weekstart: 0,
        lang: {
            button_text: "<?php echo Core::$word->BROWSE;?>",
            empty_text: "<?php echo Core::$word->NOFILE;?>",
            monthsFull: [<?php echo Core::monthList(false);?>],
            monthsShort: [<?php echo Core::monthList(false, false);?>],
			weeksFull : [<?php echo Core::weekList(false);?>],
			weeksShort : [<?php echo Core::weekList(false, false);?>],
			weeksMed: [ <?php echo Core::weekList(false, false);?>],
			today : "<?php echo Core::$word->AD_TODAY;?>",
			clear : "<?php echo Core::$word->CLEAR;?>",
			delBtn : "<?php echo Core::$word->DELETE_REC;?>",
            delMsg1: "<?php echo Core::$word->DELCONFIRM1;?>",
            delMsg2: "<?php echo Core::$word->DELCONFIRM2;?>",
            working: "<?php echo Core::$word->WORKING;?>"
        }
    });
});
// ]]>
</script>
</body></html>