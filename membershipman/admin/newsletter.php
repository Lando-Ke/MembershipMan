<?php
  /**
   * Newsletter
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php $row = (isset(Filter::$get['emailid'])) ? Core::getRowById(Content::eTable, 12) : Core::getRowById(Content::eTable, 4);?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->N_NEWSL;?></div>
</div>
<div class="wojo form basic segment">
  <div class="wojo header"><span><?php echo Core::$word->NL_TTITLE;?></span>
    <p><?php echo Core::$word->NL_INFO1. Core::$word->REQ1 . ' <i class="icon asterisk"></i> ' . Core::$word->REQ2;?></p>
  </div>
  <form id="wojo_form" name="wojo_form" method="post">
    <div class="wojo content">
      <div class="two fields">
        <div class="field disabled">
          <label><?php echo Core::$word->NL_FROM;?></label>
          <label class="input">
            <input type="text" value="<?php echo $core->site_email;?>" disabled="disabled" name="site_email">
          </label>
        </div>
        <div class="field">
          <label><?php echo Core::$word->NL_RCPT;?></label>
          <?php if(isset(Filter::$get['emailid'])):?>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo sanitize(Filter::$get['emailid']);?>" name="recipient">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
          <?php else:?>
          <select name="recipient" data-cover="true">
            <option value="all"><?php echo Core::$word->NL_UALL;?></option>
            <option value="free"><?php echo Core::$word->NL_UAREG;?></option>
            <option value="paid"><?php echo Core::$word->NL_UPAID;?></option>
            <option value="newsletter"><?php echo Core::$word->NL_UNLS;?></option>
          </select>
          <?php endif;?>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->NL_SUBJECT;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $row->subject;?>" name="subject">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->NL_ATTACH;?></label>
          <label class="input">
            <input type="file" name="attachment" id="attachment" class="filefield">
          </label>
        </div>
      </div>
      <div class="field">
        <label><?php echo Core::$word->NL_BODY;?></label>
        <textarea name="body" class="bodypost"><?php echo $row->body;?></textarea>
        <p class="wojo error"><?php echo Core::$word->ET_VAR_T;?></p>
      </div>
    </div>
    <div class="wojo footer">
      <button type="button" name="dosubmit" class="wojo button"><?php echo Core::$word->NL_SEND;?></button>
      <input name="processNewsletter" type="hidden" value="1">
    </div>
  </form>
</div>