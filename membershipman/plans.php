<?php
  /**
   * Membersip Packages
   *
   */
  define("_VALID_PHP", true);
  require_once("init.php");
	  
  $listpackrow = $member->getMembershipListFrontEnd();
?>
<?php include("header.php");?>
<div id="wrap">
  <div class="wojo-grid">
    <div class="content">
      <?php if(!$user->logged_in):?>
      <h4><a href="register.php"><?php echo Core::$word->UA_REGPCKG;?></a> <?php echo Core::$word->UA_REGPCKG2;?></h4>
      <?php endif;?>
      <?php if($listpackrow):?>
      <div class="relative">
        <ul id="plans">
          <?php $color = array("468592","4a579b","814a9b","9c4a69","4b9c52","879b4a","9a804a","468592","4a579b","814a9b","9c4a69","4b9c52","879b4a","9a804a");?>
          <?php foreach ($listpackrow as $i => $prow):?>
          <li class="plan">
            <h2><?php echo $prow->title;?></h2>
            <p class="price" style="background:#<?php echo $color[$i];?>"><?php echo $core->formatMoney($prow->price);?> <span><?php echo $prow->days . ' ' .$member->getPeriod($prow->period);?></span></p>
            <p class="recurring"><?php echo Core::$word->RECURRING;?> <b><?php echo ($prow->recurring) ? Core::$word->YES : Core::$word->NO;?></b></p>
            <p class="desc"><?php echo cleanOut($prow->description)?></p>
          </li>
          <?php endforeach;?>
        </ul>
      </div>
      <?php endif;?>
    </div>
  </div>
</div>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function () {
	$('#plans').elasticColumns({
		innerMargin: 40,
		outerMargin: 0,
		columns: 2
	});
});
// ]]>
</script>
<?php include("footer.php");?>