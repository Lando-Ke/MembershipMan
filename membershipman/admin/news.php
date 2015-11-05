<?php
  /**
   * News Manager
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php switch(Filter::$action): case "edit": ?>
<?php $row = Core::getRowById(Content::nTable, Filter::$id);?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <a href="index.php?do=news" class="section"><?php echo Core::$word->N_NEWS;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->NM_EDIT;?></div>
</div>
<div class="wojo form basic segment">
  <div class="wojo header"><span><?php echo Core::$word->NM_TITLE2;?></span><small><?php echo Core::$word->NM_SUBTITLE1 . ' [' . $row->title . ']';?></small>
    <p><?php echo Core::$word->NM_INFO1. Core::$word->REQ1 . ' <i class="icon asterisk"></i> ' . Core::$word->REQ2;?></p>
  </div>
  <form id="wojo_form" name="wojo_form" method="post">
    <div class="wojo content">
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->NM_TTITLE;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $row->title;?>" name="title">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->NM_AUTHOR;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $row->author;?>" name="author">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->CREATED;?></label>
          <label class="input"><i class="icon-append icon calendar"></i>
            <input data-datepicker="true" data-min-view="2" data-start-view="2" data-date="<?php echo $row->created;?>" type="text" value="<?php echo Filter::dodate("short_date", $row->created);?>" name="created">
          </label>
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
      <div class="field">
        <label><?php echo Core::$word->NM_CONTENT;?></label>
        <textarea name="body" class="altpost"><?php echo $row->body;?></textarea>
      </div>
    </div>
    <div class="wojo footer">
      <button type="button" name="dosubmit" class="wojo button"><?php echo Core::$word->NM_UPDATE;?></button>
      <a href="index.php?do=news" class="wojo basic button"><?php echo Core::$word->CANCEL;?></a>
      <input name="processNews" type="hidden" value="1">
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
    </div>
  </form>
</div>
<?php break;?>
<?php case "add":?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <a href="index.php?do=news" class="section"><?php echo Core::$word->N_NEWS;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->NM_ADD;?></div>
</div>
<div class="wojo form basic segment">
  <div class="wojo header"><span><?php echo Core::$word->NM_TITLE2;?></span><small><?php echo Core::$word->NM_SUBTITLE2;?></small>
    <p><?php echo Core::$word->NM_INFO3. Core::$word->REQ1 . ' <i class="icon asterisk"></i> ' . Core::$word->REQ2;?></p>
  </div>
  <form id="wojo_form" name="wojo_form" method="post">
    <div class="wojo content">
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->NM_TTITLE;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" placeholder="<?php echo Core::$word->NM_TTITLE;?>" name="title">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->NM_AUTHOR;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" placeholder="<?php echo Core::$word->NM_AUTHOR;?>" name="author" value="<?php echo $user->username;?>">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->CREATED;?></label>
          <label class="input"><i class="icon-append icon calendar"></i>
            <input data-datepicker="true" data-min-view="2" data-start-view="2" data-date="<?php echo date('Y-m-d');?>" type="text" value="<?php echo Filter::dodate("short_date", date('Y-m-d'));?>" name="created">
          </label>
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
      <div class="field">
        <label><?php echo Core::$word->NM_CONTENT;?></label>
        <textarea placeholder="<?php echo Core::$word->NM_CONTENT;?>" name="body" class="altpost"></textarea>
      </div>
    </div>
    <div class="wojo footer">
      <button type="button" name="dosubmit" class="wojo button"><?php echo Core::$word->NM_ADD;?></button>
      <a href="index.php?do=news" class="wojo basic button"><?php echo Core::$word->CANCEL;?></a>
      <input name="processNews" type="hidden" value="1">
    </div>
  </form>
</div>
<?php break;?>
<?php default: ?>
<?php $newsrow = $content->getNews();?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->N_NEWS;?></div>
</div>
<div class="wojo basic segment">
  <div class="wojo header"><a href="index.php?do=news&amp;action=add" class="push-right wojo basic button"><i class="icon add"></i><?php echo Core::$word->NM_ADD;?></a> <span><?php echo Core::$word->NM_TITLE2;?></span>
    <p><?php echo Core::$word->NM_INFO2;?></p>
  </div>
</div>
<div class="wojo basic segment">
  <table class="wojo sortable table">
    <thead>
      <tr>
        <th data-sort="int">#</th>
        <th data-sort="string"><?php echo Core::$word->NM_TTITLE;?></th>
        <th data-sort="int"><?php echo Core::$word->CREATED;?></th>
        <th class="disabled"><?php echo Core::$word->ACTIONS;?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(!$newsrow):?>
      <tr>
        <td colspan="4"><?php echo Filter::msgSingleAlert(Core::$word->NM_NONEWS);?></td>
      </tr>
      <?php else:?>
      <?php foreach ($newsrow as $row):?>
      <tr>
        <td><small class="wojo label"><?php echo $row->id;;?>.</small></td>
        <td><?php echo $row->title;?></td>
        <td data-sort-value="<?php echo strtotime($row->created);?>"><?php echo Filter::dodate("short_date", $row->created);?></td>
        <td><a href="index.php?do=news&amp;action=edit&amp;id=<?php echo $row->id;?>"><i class="circular inverted success icon pencil link"></i></a> <a class="delete" data-set='{"title": "<?php echo Core::$word->DELETE . ' ' . Core::$word->NM_NEWS;?>", "parent": "tr", "option": "deleteNews", "id": <?php echo $row->id;?>, "name": "<?php echo $row->title;?>"}'><i class="circular danger inverted trash icon link"></i></a></td>
      </tr>
      <?php endforeach;?>
      <?php unset($row);?>
      <?php endif;?>
    </tbody>
  </table>
</div>
<?php break;?>
<?php endswitch;?>