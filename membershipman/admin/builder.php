<?php
  /**
   * Page Builder
   *
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php $memrow = $member->getMemberships();?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->N_HELP_PB;?></div>
</div>
<div class="wojo form basic segment">
  <div class="wojo header"><span><?php echo Core::$word->HP_TITLE4;?></span>
    <p><?php echo Core::$word->HP_INFO2. Core::$word->REQ1 . ' <i class="icon asterisk"></i> ' . Core::$word->REQ2;?></p>
  </div>
  <form id="wojo_form" name="wojo_form" method="post">
    <div class="wojo content">
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->HP_PNAME;?><i class="icon support" data-content="<?php echo Core::$word->HP_PNAME_T;?>"></i></label>
          <div class="wojo left labeled icon input">
            <input type="text" placeholder="<?php echo Core::$word->HP_PNAME;?>" name="pagename">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->HP_PADDHF;?><i class="icon support" data-content="<?php echo Core::$word->HP_PADDHF_T;?>"></i></label>
          <div class="inline-group">
            <label class="radio">
              <input name="header" type="radio" value="1" checked="checked" >
              <i></i>Yes</label>
            <label class="radio">
              <input type="radio" name="header" value="0" >
              <i></i>No</label>
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->MEMBERSHIP;?></label>
          <select name="membership_id[]" multiple="multiple">
            <?php if($memrow):?>
            <?php foreach ($memrow as $mlist):?>
            <option value="<?php echo $mlist->id;?>"><?php echo $mlist->title;?></option>
            <?php endforeach;?>
            <?php unset($mlist);?>
            <?php endif;?>
          </select>
        </div>
        <div class="field"> <?php echo Core::$word->HP_SUB13;?> </div>
      </div>
    </div>
    <div class="wojo footer">
      <button type="button" name="dosubmit" class="wojo button"><?php echo Core::$word->HP_PBUILD;?></button>
      <input name="processBuilder" type="hidden" value="1">
    </div>
  </form>
</div>