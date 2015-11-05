<?php
  /**
   * Gateways
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php switch(Filter::$action): case "edit": ?>
<?php $row = Core::getRowById(Membership::gTable, Filter::$id);?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <a href="index.php?do=templates" class="section"><?php echo Core::$word->N_GATE;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->GW_EDIT;?></div>
</div>
<div class="wojo form basic segment">
  <div class="wojo header"><span><?php echo Core::$word->GW_TITLE2;?></span><small><?php echo Core::$word->GW_SUBTITLE1 . ' [' . $row->displayname . ']';?> <a class="viewtip"><i class="icon question"></i></a></small>
    <p><?php echo Core::$word->GW_INFO1. Core::$word->REQ1 . ' <i class="icon asterisk"></i> ' . Core::$word->REQ2;?></p>
  </div>
  <form id="wojo_form" name="wojo_form" method="post">
    <div class="wojo content">
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->GW_TTITLE;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $row->displayname;?>" name="displayname">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo $row->extra_txt;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $row->extra;?>" name="extra">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo $row->extra_txt2;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $row->extra2;?>" name="extra2">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo $row->extra_txt3;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $row->extra3;?>" name="extra3">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field fitted">
          <div class="two fields">
            <div class="field">
              <label><?php echo Core::$word->GW_LIVE;?><i class="icon support" data-content="<?php echo Core::$word->GW_LIVE_T;?>"></i></label>
              <div class="inline-group">
                <label class="radio">
                  <input name="demo" type="radio" value="1" <?php echo getChecked($row->demo, 1);?>>
                  <i></i><?php echo Core::$word->YES;?></label>
                <label class="radio">
                  <input name="demo" type="radio" value="0" <?php echo getChecked($row->demo, 0);?>>
                  <i></i><?php echo Core::$word->NO;?></label>
              </div>
            </div>
            <div class="field">
              <label><?php echo Core::$word->PUBLISHED;?><i class="icon support" data-content="<?php echo Core::$word->GW_PUBLISHED_T;?>"></i></label>
              <div class="inline-group">
                <label class="radio">
                  <input name="active" type="radio" value="1" <?php echo getChecked($row->active, 1);?>>
                  <i></i><?php echo Core::$word->YES;?></label>
                <label class="radio">
                  <input name="active" type="radio" value="0" <?php echo getChecked($row->active, 0);?>>
                  <i></i><?php echo Core::$word->NO;?></label>
              </div>
            </div>
          </div>
        </div>
        <div class="field disabled">
          <label>IPN URL</label>
          <input name="ipn" type="text" value="<?php echo SITEURL.'/gateways/'.$row->dir.'/ipn.php';?>" readonly>
        </div>
      </div>
    </div>
    <div class="wojo footer">
      <button type="button" name="dosubmit" class="wojo button"><?php echo Core::$word->GW_UPDATE;?></button>
      <input name="processGateway" type="hidden" value="1">
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
    </div>
  </form>
</div>
<div id="showhelp" style="display:none"><?php echo cleanOut($row->info);?></div>
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
	$('a.viewtip').on('click', function () {
		var text = $("#showhelp").html();
		new Messi(text, {
			title: "<?php echo $row->displayname;?>",
			modal: true,
		});
	});
});
// ]]>
</script>
<?php break;?>
<?php default: ?>
<?php $gaterow = $member->getGateways();?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->N_GATE;?></div>
</div>
<div class="wojo basic segment">
  <div class="wojo header"><span><?php echo Core::$word->GW_TITLE2;?></span>
    <p><?php echo Core::$word->GW_INFO2;?></p>
  </div>
</div>
<div class="wojo basic segment">
  <table class="wojo basic table">
    <thead>
      <tr>
        <th>#</th>
        <th>Gateway Name</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if(!$gaterow):?>
      <tr>
        <td colspan="3"><?php echo Filter::msgSingleAlert(Core::$word->GW_NOGWY);?></td>
      </tr>
      <?php else:?>
      <?php foreach ($gaterow as $row):?>
      <tr>
        <td><small class="wojo label"><?php echo $row->id;;?>.</small></td>
        <td><?php echo $row->displayname;?></td>
        <td><a href="index.php?do=gateways&amp;action=edit&amp;id=<?php echo $row->id;?>"><i class="circular inverted success icon pencil link"></i></a></td>
      </tr>
      <?php endforeach;?>
      <?php unset($row);?>
      <?php endif;?>
    </tbody>
  </table>
</div>
<?php break;?>
<?php endswitch;?>