<?php
  /**
   * Discount Manager
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php switch(Filter::$action): case "edit": ?>
<?php $row = Core::getRowById(Content::dTable, Filter::$id);?>
<?php $memrow = $member->getMemberships();?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <a href="index.php?do=coupons" class="section"><?php echo Core::$word->N_DISC;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->DC_EDIT;?></div>
</div>
<div class="wojo form basic segment">
  <div class="wojo header"><span><?php echo Core::$word->DC_TITLE2;?></span><small><?php echo Core::$word->DC_SUBTITLE1 . ' [' . $row->title . ']';?></small>
    <p><?php echo Core::$word->DC_INFO1. Core::$word->REQ1 . ' <i class="icon asterisk"></i> ' . Core::$word->REQ2;?></p>
  </div>
  <form id="wojo_form" name="wojo_form" method="post">
    <div class="wojo content">
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->DC_TTITLE;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $row->title;?>" name="title">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->DC_CODE;?><i class="icon support" data-content="<?php echo Core::$word->DC_CODE_T;?>"></i></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $row->code;?>" name="code">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->DC_DISC;?><i class="icon support" data-content="<?php echo Core::$word->DC_DISC_T;?>"></i></label>
          <div class="wojo left labeled icon input">
            <input type="text" name="discount" value="<?php echo $row->discount;?>">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->DC_TYPE;?></label>
          <select name="type" data-cover="true">
            <option value="p"<?php if($row->type == "p") echo ' selected="selected"';?>><?php echo Core::$word->DC_TYPE_P;?></option>
            <option value="a"<?php if($row->type == "a") echo ' selected="selected"';?>><?php echo Core::$word->DC_TYPE_A;?></option>
          </select>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->MEMBERSHIP;?><i class="icon support" data-content="<?php echo Core::$word->DC_MEMBERSHIP_T;?>"></i></label>
          <select name="mid[]" multiple="multiple">
            <?php if($memrow):?>
            <?php $arr = explode(",", $row->mid);?>
            <?php foreach ($memrow as $mlist):?>
            <?php if(!$mlist->recurring and !$mlist->private):?>
            <?php $selected = (in_array($mlist->id, $arr)) ? " selected=\"selected\"" : "";?>
            <option value="<?php echo $mlist->id;?>"<?php echo $selected;?>><?php echo $mlist->title;?></option>
            <?php endif;?>
            <?php endforeach;?>
            <?php unset($mlist);?>
            <?php endif;?>
          </select>
        </div>
        <div class="field">
          <label><?php echo Core::$word->PUBLISHED;?></label>
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
    <div class="wojo footer">
      <button type="button" name="dosubmit" class="wojo button"><?php echo Core::$word->DC_UPDATE;?></button>
      <a href="index.php?do=coupons" class="wojo basic button"><?php echo Core::$word->CANCEL;?></a>
      <input name="processCoupon" type="hidden" value="1">
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
    </div>
  </form>
</div>
<?php break;?>
<?php case "add":?>
<?php $memrow = $member->getMemberships();?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <a href="index.php?do=coupons" class="section"><?php echo Core::$word->N_DISC;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->DC_ADD;?></div>
</div>
<div class="wojo form basic segment">
  <div class="wojo header"><span><?php echo Core::$word->DC_TITLE2;?></span><small><?php echo Core::$word->DC_SUBTITLE2;?></small>
    <p><?php echo Core::$word->DC_INFO3. Core::$word->REQ1 . ' <i class="icon asterisk"></i> ' . Core::$word->REQ2;?></p>
  </div>
  <form id="wojo_form" name="wojo_form" method="post">
    <div class="wojo content">
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->DC_TTITLE;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" placeholder="<?php echo Core::$word->DC_TTITLE;?>" name="title">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->DC_CODE;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" placeholder="<?php echo Core::$word->DC_CODE;?>" name="code">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->DC_DISC;?><i class="icon support" data-content="<?php echo Core::$word->DC_DISC_T;?>"></i></label>
          <div class="wojo left labeled icon input">
            <input type="text" name="discount" placeholder="<?php echo Core::$word->DC_DISC;?>">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->DC_TYPE;?></label>
          <select name="type" data-cover="true">
            <option value="p"><?php echo Core::$word->DC_TYPE_P;?></option>
            <option value="a"><?php echo Core::$word->DC_TYPE_A;?></option>
          </select>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->MEMBERSHIP;?><i class="icon support" data-content="<?php echo Core::$word->DC_MEMBERSHIP_T;?>"></i></label>
          <select name="mid[]" multiple="multiple">
            <?php if($memrow):?>
            <?php foreach ($memrow as $mlist):?>
            <?php if(!$mlist->recurring and !$mlist->private):?>
            <option value="<?php echo $mlist->id;?>"><?php echo $mlist->title;?></option>
            <?php endif;?>
            <?php endforeach;?>
            <?php unset($mlist);?>
            <?php endif;?>
          </select>
        </div>
        <div class="field">
          <label><?php echo Core::$word->PUBLISHED;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="active" type="radio" value="1" checked="checked">
              <i></i><?php echo Core::$word->YES;?></label>
            <label class="radio">
              <input name="active" type="radio" value="0" >
              <i></i><?php echo Core::$word->NO;?></label>
          </div>
        </div>
      </div>
    </div>
    <div class="wojo footer">
      <button type="button" name="dosubmit" class="wojo button"><?php echo Core::$word->DC_ADD;?></button>
      <a href="index.php?do=coupons" class="wojo basic button"><?php echo Core::$word->CANCEL;?></a>
      <input name="processCoupon" type="hidden" value="1">
    </div>
  </form>
</div>
<?php break;?>
<?php default: ?>
<?php $discrow = $content->getDiscounts();?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->N_DISC;?></div>
</div>
<div class="wojo basic segment">
  <div class="wojo header"><a href="index.php?do=coupons&amp;action=add" class="push-right wojo basic button"><i class="icon add"></i><?php echo Core::$word->DC_ADD;?></a> <span><?php echo Core::$word->DC_TITLE2;?></span>
    <p><?php echo Core::$word->DC_INFO2;?></p>
  </div>
</div>
<div class="wojo basic segment">
  <table class="wojo sortable table">
    <thead>
      <tr>
        <th data-sort="int">#</th>
        <th data-sort="string"><?php echo Core::$word->DC_TTITLE;?></th>
        <th data-sort="string"><?php echo Core::$word->DC_CODE;?></th>
        <th data-sort="int"><?php echo Core::$word->CREATED;?></th>
        <th class="disabled"><?php echo Core::$word->ACTIONS;?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(!$discrow):?>
      <tr>
        <td colspan="5"><?php echo Filter::msgSingleAlert(Core::$word->DC_NONDISC);?></td>
      </tr>
      <?php else:?>
      <?php foreach ($discrow as $row):?>
      <tr>
        <td><small class="wojo label"><?php echo $row->id;;?>.</small></td>
        <td><?php echo $row->title;?></td>
        <td><?php echo $row->code;?></td>
        <td data-sort-value="<?php echo strtotime($row->created);?>"><?php echo Filter::dodate("short_date", $row->created);?></td>
        <td><a href="index.php?do=coupons&amp;action=edit&amp;id=<?php echo $row->id;?>"><i class="circular inverted success icon pencil link"></i></a> <a class="delete" data-set='{"title": "<?php echo Core::$word->DELETE . ' ' . Core::$word->DC_COUPON;?>", "parent": "tr", "option": "deleteCoupon", "id": <?php echo $row->id;?>, "name": "<?php echo $row->title;?>"}'><i class="circular danger inverted trash icon link"></i></a></td>
      </tr>
      <?php endforeach;?>
      <?php unset($row);?>
      <?php endif;?>
    </tbody>
  </table>
</div>
<?php break;?>
<?php endswitch;?>