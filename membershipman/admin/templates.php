<?php
  /**
   * Email Templates
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php switch(Filter::$action): case "edit": ?>
<?php $row = Core::getRowById(Content::eTable, Filter::$id);?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <a href="index.php?do=templates" class="section"><?php echo Core::$word->N_EMAILS;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->ET_EDIT;?></div>
</div>
<div class="wojo form basic segment">
  <div class="wojo header"><span><?php echo Core::$word->ET_TITLE2;?></span><small><?php echo Core::$word->ET_SUBTITLE1 . ' [' . $row->name . ']';?></small>
    <p><?php echo Core::$word->ET_INFO1. Core::$word->REQ1 . ' <i class="icon asterisk"></i> ' . Core::$word->REQ2;?></p>
  </div>
  <form id="wojo_form" name="wojo_form" method="post">
    <div class="wojo content">
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->ET_TTITLE;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $row->name;?>" name="name">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->ET_SUBJECT;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $row->subject;?>" name="subject">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
      </div>
      <div class="field">
        <label><?php echo Core::$word->ET_TPL_DESC;?></label>
        <input type="text" value="<?php echo $row->help;?>" name="help">
      </div>
      <div class="field">
        <label><?php echo Core::$word->ET_BODY;?></label>
        <textarea name="body" class="bodypost"><?php echo $row->body;?></textarea>
        <p class="wojo error"><?php echo Core::$word->ET_VAR_T;?></p>
      </div>
    </div>
    <div class="wojo footer">
      <button type="button" name="dosubmit" class="wojo button"><?php echo Core::$word->ET_UPDATE;?></button>
      <a href="index.php?do=templates" class="wojo basic button"><?php echo Core::$word->CANCEL;?></a>
      <input name="processEmailTemplate" type="hidden" value="1">
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
    </div>
  </form>
</div>
<?php break;?>
<?php default: ?>
<?php $temprow = $content->getEmailTemplates();?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->N_EMAILS;?></div>
</div>
<div class="wojo basic segment">
  <div class="wojo header"><span><?php echo Core::$word->ET_TITLE2;?></span>
    <p><?php echo Core::$word->ET_INFO2;?></p>
  </div>
</div>
<div class="wojo basic segment">
  <table class="wojo sortable table">
    <thead>
      <tr>
        <th data-sort="int">#</th>
        <th data-sort="string"><?php echo Core::$word->ET_TTITLE;?></th>
        <th data-sort="string"><?php echo Core::$word->ET_TPL_DESC;?></th>
        <th class="disabled"><?php echo Core::$word->ACTIONS;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($temprow as $row):?>
      <tr>
        <td><small class="wojo label"><?php echo $row->id;;?>.</small></td>
        <td><?php echo $row->name;?></td>
        <td><?php echo $row->help;?></td>
        <td><a href="index.php?do=templates&amp;action=edit&amp;id=<?php echo $row->id;?>"><i class="circular inverted success icon pencil link"></i></a></td>
      </tr>
      <?php endforeach;?>
      <?php unset($row);?>
    </tbody>
  </table>
</div>
<?php break;?>
<?php endswitch;?>