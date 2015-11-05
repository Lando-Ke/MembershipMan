<?php
  /**
   * Country Manager
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php switch(Filter::$action): case "edit": ?>
<?php $row = Core::getRowById(Content::cTable, Filter::$id);?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <a href="index.php?do=countries" class="section"><?php echo Core::$word->N_COUNTRIES;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->CNT_EDIT;?></div>
</div>
<div class="wojo form basic segment">
  <div class="wojo header"><span><?php echo Core::$word->CNT_TITLE2;?></span><small><?php echo Core::$word->CNT_EDIT . ' [' . $row->name . ']';?></small>
    <p><?php echo Core::$word->CNT_INFO1. Core::$word->REQ1 . ' <i class="icon asterisk"></i> ' . Core::$word->REQ2;?></p>
  </div>
  <form id="wojo_form" name="wojo_form" method="post">
    <div class="wojo content">
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->CNT_TITLE;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $row->name;?>" name="name">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->CNT_ABBR;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $row->abbr;?>" name="abbr">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
      </div>
      <div class="four fields">
        <div class="field">
          <label><?php echo Core::$word->VAT;?></label>
          <label class="input"><span class="icon-append"><b>%</b></span>
            <input type="text" value="<?php echo $row->vat;?>" name="vat">
          </label>
        </div>
        <div class="field">
          <label><?php echo Core::$word->SORTING;?></label>
          <label class="input">
            <input type="text" value="<?php echo $row->sorting;?>" name="sorting">
          </label>
        </div>
        <div class="field">
          <label><?php echo Core::$word->PUBLISHED;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="active" type="radio" value="1" <?php getChecked($row->active, 1);?>>
              <i></i><?php echo Core::$word->ACTIVE;?></label>
            <label class="radio">
              <input name="active" type="radio" value="0" <?php getChecked($row->active, 0);?>>
              <i></i><?php echo Core::$word->INACTIVE;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->DEFAULT;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="home" type="radio" value="1" <?php getChecked($row->home, 1);?>>
              <i></i><?php echo Core::$word->YES;?></label>
            <label class="radio">
              <input name="home" type="radio" value="0" <?php getChecked($row->home, 0);?>>
              <i></i><?php echo Core::$word->NO;?></label>
          </div>
        </div>
      </div>
    </div>
    <div class="wojo footer">
      <button type="button" name="dosubmit" class="wojo button"><?php echo Core::$word->CNT_UPDATE;?></button>
      <a href="index.php?do=countries" class="wojo basic button"><?php echo Core::$word->CANCEL;?></a>
      <input name="processCountry" type="hidden" value="1">
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
    </div>
  </form>
</div>
<?php break;?>
<?php default: ?>
<?php $countries = $content->getCountryList();?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->N_COUNTRIES;?></div>
</div>
<div class="wojo basic segment">
  <div class="wojo header"><span><?php echo Core::$word->CNT_TITLE2;?></span>
    <p><?php echo Core::$word->CNT_INFO2;?></p>
  </div>
</div>
<div class="wojo basic segment">
  <table class="wojo sortable table" id="editable">
    <thead>
      <tr>
        <th data-sort="string"><?php echo Core::$word->CNT_TITLE;?></th>
        <th data-sort="string"><?php echo Core::$word->CNT_ABBR;?></th>
        <th data-sort="int"><?php echo Core::$word->DEFAULT;?></th>
        <th data-sort="int"><?php echo Core::$word->PUBLISHED;?></th>
        <th data-sort="int"><?php echo Core::$word->SORTING;?></th>
        <th data-sort="int"><?php echo Core::$word->VAT;?></th>
        <th class="disabled"><?php echo Core::$word->ACTIONS;?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(!$countries):?>
      <tr>
        <td colspan="7"><?php echo Filter::msgSingleAlert(Core::$word->CNT_NOCOUNTRY);?></td>
      </tr>
      <?php else:?>
      <?php foreach ($countries as $row):?>
      <tr>
        <td><?php echo $row->name;?></td>
        <td><small class="wojo label"><?php echo $row->abbr;;?></small></td>
        <td data-sort-value="<?php echo $row->home;?>"><?php echo isActive($row->home);?></td>
        <td data-sort-value="<?php echo $row->active;?>"><?php echo isActive($row->active);?></td>
        <td><?php echo $row->sorting;?></td>
        <td data-editable="true" data-set='{"type": "cntvat", "id": <?php echo $row->id;?>,"key":"vat", "path":""}'><?php echo $row->vat;?></td>
        <td><a href="index.php?do=countries&amp;action=edit&amp;id=<?php echo $row->id;?>"><i class="circular inverted success icon pencil link"></i></a> <a class="delete" data-set='{"title": "<?php echo Core::$word->DELETE . ' ' . Core::$word->UR_COUNTRY;?>", "parent": "tr", "option": "deleteCountry", "id": <?php echo $row->id;?>, "name": "<?php echo $row->name;?>"}'><i class="circular danger inverted trash icon link"></i></a></td>
      </tr>
      <?php endforeach;?>
      <?php unset($row);?>
      <?php endif;?>
    </tbody>
  </table>
</div>
<?php break;?>
<?php endswitch;?>