<?php
  /**
   * Memberships
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
?>
<?php switch(Filter::$action): case "edit": ?>
<?php $row = Core::getRowById(Membership::mTable, Filter::$id);?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <a href="index.php?do=templates" class="section"><?php echo Core::$word->N_MEMS;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->MM_EDIT;?></div>
</div>
<div class="wojo form basic segment">
  <div class="wojo header"><span><?php echo Core::$word->MM_TITLE2;?></span><small><?php echo Core::$word->MM_SUBTITLE1 . ' [' . $row->title . ']';?></small>
    <p><?php echo Core::$word->MM_INFO1. Core::$word->REQ1 . ' <i class="icon asterisk"></i> ' . Core::$word->REQ2;?></p>
  </div>
  <form id="wojo_form" name="wojo_form" method="post">
    <div class="wojo content">
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->MM_TTITLE;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $row->title;?>" name="title">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->PRICE;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $row->price;?>" name="price">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->MM_PERIOD;?><i class="icon support" data-content="<?php echo Core::$word->MM_PERIOD_T;?>"></i></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $row->days;?>" name="days">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->MM_PERIOD;?></label>
          <select name="period" data-cover="true">
            <?php echo $member->getMembershipPeriod($row->period);?>
          </select>
        </div>
      </div>
      <div class="four fields">
        <div class="field">
          <label><?php echo Core::$word->MM_TRIAL;?><i class="icon support" data-content="<?php echo Core::$word->MM_TRIAL_T;?>"></i></label>
          <div class="inline-group">
            <label class="radio">
              <input name="trial" type="radio" value="1" <?php echo getChecked($row->trial, 1);?>>
              <i></i><?php echo Core::$word->YES;?></label>
            <label class="radio">
              <input name="trial" type="radio" value="0" <?php echo getChecked($row->trial, 0);?>>
              <i></i><?php echo Core::$word->NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->MM_RECURRING;?><i class="icon support" data-content="<?php echo Core::$word->MM_RECURRING_T;?>"></i></label>
          <div class="inline-group">
            <label class="radio">
              <input name="recurring" type="radio" value="1" <?php echo getChecked($row->recurring, 1);?>>
              <i></i><?php echo Core::$word->YES;?></label>
            <label class="radio">
              <input name="recurring" type="radio" value="0" <?php echo getChecked($row->recurring, 0);?>>
              <i></i><?php echo Core::$word->NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->MM_PRIVATE;?><i class="icon support" data-content="<?php echo Core::$word->MM_PRIVATE_T;?>"></i></label>
          <div class="inline-group">
            <label class="radio">
              <input name="private" type="radio" value="1" <?php echo getChecked($row->private, 1);?>>
              <i></i><?php echo Core::$word->YES;?></label>
            <label class="radio">
              <input name="private" type="radio" value="0" <?php echo getChecked($row->private, 0);?>>
              <i></i><?php echo Core::$word->NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->PUBLISHED;?><i class="icon support" data-content="<?php echo Core::$word->MM_PUBLISHED_T;?>"></i></label>
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
      <div class="field">
        <label><?php echo Core::$word->MM_DESC;?></label>
        <textarea name="description"><?php echo $row->description;?></textarea>
      </div>
    </div>
    <div class="wojo footer">
      <button type="button" name="dosubmit" class="wojo button"><?php echo Core::$word->MM_UPDATE;?></button>
      <a href="index.php?do=memberships" class="wojo basic button"><?php echo Core::$word->CANCEL;?></a>
      <input name="processMembership" type="hidden" value="1">
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
    </div>
  </form>
</div>
<?php break;?>
<?php case"add": ?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <a href="index.php?do=memberships" class="section"><?php echo Core::$word->MM_EDIT;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->MM_ADD;?></div>
</div>
<div class="wojo form basic segment">
  <div class="wojo header"><span><?php echo Core::$word->MM_TITLE2;?></span><small><?php echo Core::$word->MM_SUBTITLE2;?></small>
    <p><?php echo Core::$word->MM_INFO3. Core::$word->REQ1 . ' <i class="icon asterisk"></i> ' . Core::$word->REQ2;?></p>
  </div>
  <form id="wojo_form" name="wojo_form" method="post">
    <div class="wojo content">
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->MM_TTITLE;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" placeholder="<?php echo Core::$word->MM_TTITLE;?>" name="title">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->PRICE;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" placeholder="<?php echo Core::$word->PRICE;?>" name="price">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->MM_PERIOD;?><i class="icon support" data-content="<?php echo Core::$word->MM_PERIOD_T;?>"></i></label>
          <div class="wojo left labeled icon input">
            <input type="text" placeholder="<?php echo Core::$word->MM_PERIOD;?>" name="days">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->MM_PERIOD;?></label>
          <select name="period" data-cover="true">
            <?php echo $member->getMembershipPeriod();?>
          </select>
        </div>
      </div>
      <div class="four fields">
        <div class="field">
          <label><?php echo Core::$word->MM_TRIAL;?><i class="icon support" data-content="<?php echo Core::$word->MM_TRIAL_T;?>"></i></label>
          <div class="inline-group">
            <label class="radio">
              <input name="trial" type="radio" value="1">
              <i></i><?php echo Core::$word->YES;?></label>
            <label class="radio">
              <input name="trial" type="radio" value="0" checked="checked">
              <i></i><?php echo Core::$word->NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->MM_RECURRING;?><i class="icon support" data-content="<?php echo Core::$word->MM_RECURRING_T;?>"></i></label>
          <div class="inline-group">
            <label class="radio">
              <input name="recurring" type="radio" value="1">
              <i></i><?php echo Core::$word->YES;?></label>
            <label class="radio">
              <input name="recurring" type="radio" value="0" checked="checked">
              <i></i><?php echo Core::$word->NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->MM_PRIVATE;?><i class="icon support" data-content="<?php echo Core::$word->MM_PRIVATE_T;?>"></i></label>
          <div class="inline-group">
            <label class="radio">
              <input name="private" type="radio" value="1">
              <i></i><?php echo Core::$word->YES;?></label>
            <label class="radio">
              <input name="private" type="radio" value="0" checked="checked">
              <i></i><?php echo Core::$word->NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->PUBLISHED;?><i class="icon support" data-content="<?php echo Core::$word->MM_PUBLISHED_T;?>"></i></label>
          <div class="inline-group">
            <label class="radio">
              <input name="active" type="radio" value="1" checked="checked">
              <i></i><?php echo Core::$word->YES;?></label>
            <label class="radio">
              <input name="active" type="radio" value="0">
              <i></i><?php echo Core::$word->NO;?></label>
          </div>
        </div>
      </div>
      <div class="field">
        <label><?php echo Core::$word->MM_DESC;?></label>
        <textarea name="description" placehoder="<?php echo Core::$word->MM_DESC;?>"></textarea>
      </div>
    </div>
    <div class="wojo footer">
      <button type="button" name="dosubmit" class="wojo button"><?php echo Core::$word->MM_ADD;?></button>
      <a href="index.php?do=memberships" class="wojo basic button"><?php echo Core::$word->CANCEL;?></a>
      <input name="processMembership" type="hidden" value="1">
    </div>
  </form>
</div>
<?php break;?>
<?php default: ?>
<?php $memrow = $member->getMemberships();?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->N_MEMS;?></div>
</div>
<div class="wojo basic segment">
  <div class="wojo header"><a href="index.php?do=memberships&amp;action=add" class="push-right wojo basic button"><i class="icon add"></i><?php echo Core::$word->MM_ADD;?></a> <span><?php echo Core::$word->MM_TITLE2;?></span>
    <p><?php echo Core::$word->MM_INFO2;?></p>
  </div>
</div>
<div class="wojo basic segment">
  <table class="wojo sortable table">
    <thead>
      <tr>
        <th data-sort="int">#</th>
        <th data-sort="string"><?php echo Core::$word->MM_TTITLE;?></th>
        <th data-sort="int"><?php echo Core::$word->PRICE;?></th>
        <th data-sort="string"><?php echo Core::$word->MM_DESC;?></th>
        <th data-sort="int"><?php echo Core::$word->EXPIRE;?></th>
        <th data-sort="int"><?php echo Core::$word->PUBLISHED;?></th>
        <th class="disabled"><?php echo Core::$word->ACTIONS;?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(!$memrow):?>
      <tr>
        <td colspan="7"><?php echo Filter::msgSingleAlert(Core::$word->MM_NOMEM);?></td>
      </tr>
      <?php else:?>
      <?php foreach ($memrow as $row):?>
      <tr>
        <td><small class="wojo label"><?php echo $row->id;?>.</small></td>
        <td><?php echo $row->title;?></td>
        <td><?php echo $core->formatMoney($row->price);?></td>
        <td><?php echo $row->description;?></td>
        <td><?php echo $row->days . ' ' . $member->getPeriod($row->period);?></td>
        <td><?php if($row->active):?>
          <i class="circular inverted info icon check"></i>
          <?php else:?>
          <i class="circular inverted info icon time"></i>
          <?php endif;?></td>
        <td><a href="index.php?do=memberships&amp;action=edit&amp;id=<?php echo $row->id;?>"><i class="circular inverted success icon pencil link"></i></a> <a class="delete" data-set='{"title": "<?php echo Core::$word->DELETE . ' ' . Core::$word->MM_MEM;?>", "parent": "tr", "option": "deleteMembership", "id": <?php echo $row->id;?>, "name": "<?php echo $row->title;?>"}'><i class="circular danger inverted trash icon link"></i></a></td>
      </tr>
      <?php endforeach;?>
      <?php unset($row);?>
      <?php endif;?>
    </tbody>
  </table>
</div>
<?php break;?>
<?php endswitch;?>