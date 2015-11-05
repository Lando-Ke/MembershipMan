<?php
  /**
   * Login Help
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php switch(Filter::$action): case "edit": ?>
<?php $row = Core::getRowById(Content::fTable, Filter::$id);?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <a href="index.php?do=fields" class="section"><?php echo Core::$word->N_FIELDS;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->CF_EDIT;?></div>
</div>
<div class="wojo form basic segment">
  <div class="wojo header"><span><?php echo Core::$word->CF_TITLE2;?></span><small><?php echo Core::$word->CF_SUBTITLE1 . ' [' . $row->title . ']';?></small>
    <p><?php echo Core::$word->CF_INFO1. Core::$word->REQ1 . ' <i class="icon asterisk"></i> ' . Core::$word->REQ2;?></p>
  </div>
  <form id="wojo_form" name="wojo_form" method="post">
    <div class="wojo content">
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->CF_TTITLE;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $row->title;?>" name="title">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->CF_SECTION;?></label>
          <select name="type" data-cover="true">
            <?php echo Content::getFieldSection($row->type);?>
          </select>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->CF_TIP;?></label>
          <input type="text" value="<?php echo $row->tooltip;?>" name="tooltip">
        </div>
        <div class="field fitted">
          <div class="two fields">
            <div class="field">
              <label><?php echo Core::$word->CF_REQUIRED;?></label>
              <div class="inline-group">
                <label class="radio">
                  <input name="req" type="radio" value="1" <?php echo getChecked($row->req, 1);?>>
                  <i></i><?php echo Core::$word->YES;?></label>
                <label class="radio">
                  <input name="req" type="radio" value="0" <?php echo getChecked($row->req, 0);?>>
                  <i></i><?php echo Core::$word->NO;?></label>
              </div>
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
      </div>
    </div>
    <div class="wojo footer">
      <button type="button" name="dosubmit" class="wojo button"><?php echo Core::$word->CF_UPDATE;?></button>
      <a href="index.php?do=fields" class="wojo basic button"><?php echo Core::$word->CANCEL;?></a>
      <input name="processField" type="hidden" value="1">
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
    </div>
  </form>
</div>
<?php break;?>
<?php case"add": ?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <a href="index.php?do=fields" class="section"><?php echo Core::$word->N_FIELDS;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->CF_ADD;?></div>
</div>
<div class="wojo form basic segment">
  <div class="wojo header"><span><?php echo Core::$word->CF_TITLE2;?></span><small><?php echo Core::$word->CF_SUBTITLE2;?></small>
    <p><?php echo Core::$word->CF_INFO3. Core::$word->REQ1 . ' <i class="icon asterisk"></i> ' . Core::$word->REQ2;?></p>
  </div>
  <form id="wojo_form" name="wojo_form" method="post">
    <div class="wojo content">
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->CF_TTITLE;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" placeholder="<?php echo Core::$word->CF_TTITLE;?>" name="title">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->CF_SECTION;?></label>
          <select name="type" data-cover="true">
            <?php echo Content::getFieldSection();?>
          </select>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->CF_TIP;?></label>
          <input type="text" placeholder="<?php echo Core::$word->CF_TIP;?>" name="tooltip">
        </div>
        <div class="field filtted">
          <div class="two fields">
            <div class="field">
              <label><?php echo Core::$word->CF_REQUIRED;?></label>
              <div class="inline-group">
                <label class="radio">
                  <input name="req" type="radio" value="1" checked="checked">
                  <i></i><?php echo Core::$word->YES;?></label>
                <label class="radio">
                  <input name="req" type="radio" value="0">
                  <i></i><?php echo Core::$word->NO;?></label>
              </div>
            </div>
            <div class="field">
              <label><?php echo Core::$word->PUBLISHED;?></label>
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
        </div>
      </div>
    </div>
    <div class="wojo footer">
      <button type="button" name="dosubmit" class="wojo button"><?php echo Core::$word->CF_ADD;?></button>
      <a href="index.php?do=fields" class="wojo basic button"><?php echo Core::$word->CANCEL;?></a>
      <input name="processField" type="hidden" value="1">
    </div>
  </form>
</div>
<?php break;?>
<?php default: ?>
<?php $fields = $content->getCustomFields();?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->N_FIELDS;?></div>
</div>
<div class="wojo basic segment">
  <div class="wojo header"><a href="index.php?do=fields&amp;action=add" class="push-right wojo basic button"><i class="icon add"></i><?php echo Core::$word->CF_ADD;?></a> <span><?php echo Core::$word->CF_TITLE2;?></span></span>
    <p><?php echo Core::$word->CF_INFO2;?></p>
  </div>
</div>
<div class="wojo basic segment">
  <table class="wojo sortable table">
    <thead>
      <tr>
        <th class="disabled"><i class="icon reorder"></i></th>
        <th data-sort="string"><?php echo Core::$word->CF_TTITLE;?></th>
        <th data-sort="string"><?php echo Core::$word->CF_SECTION;?></th>
        <th data-sort="int"><?php echo Core::$word->CF_SECTION;?></th>
        <th class="disabled"><?php echo Core::$word->ACTIONS;?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(!$fields):?>
      <tr>
        <td colspan="5"><?php echo Filter::msgSingleAlert(Core::$word->CF_NOFIELDS);?></td>
      </tr>
      <?php else:?>
      <?php foreach ($fields as $row):?>
      <tr id="node-<?php echo $row->id;?>">
        <td class="id-handle"><i class="icon reorder"></i></td>
        <td><?php echo $row->title;?></td>
        <td><?php echo Content::fieldSection($row->type);?></td>
        <td><?php echo $row->sorting;?></td>
        <td><a href="index.php?do=fields&amp;action=edit&amp;id=<?php echo $row->id;?>"><i class="circular inverted success icon pencil link"></i></a> <a class="delete" data-set='{"title": "<?php echo Core::$word->DELETE . ' ' . Core::$word->CF_FIELD;?>", "parent": "tr", "option": "deleteField", "id": <?php echo $row->id;?>, "name": "<?php echo $row->title;?>"}'><i class="circular danger inverted trash icon link"></i></a></td>
      </tr>
      <?php endforeach;?>
      <?php unset($row);?>
      <?php endif;?>
    </tbody>
  </table>
</div>
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
    $(".wojo.table tbody").sortable({
        helper: 'clone',
        handle: '.id-handle',
        placeholder: 'placeholder',
        opacity: .6,
        update: function (event, ui) {
            serialized = $(".wojo.table tbody").sortable('serialize');
            $.ajax({
                type: "POST",
                url: "controller.php?sortfields",
                data: serialized,
                success: function (msg) {}
            });
        }
    });
});
// ]]>
</script>
<?php break;?>
<?php endswitch;?>