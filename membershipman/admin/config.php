<?php
  /**
   * Configuratio
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->N_CONF;?></div>
</div>
<div class="wojo form basic segment">
  <div class="wojo header"><span><?php echo Core::$word->N_SYSSONF;?></span>
    <p><?php echo Core::$word->CG_INFO1. Core::$word->REQ1 . ' <i class="icon asterisk"></i> ' . Core::$word->REQ2;?></p>
  </div>
  <form id="wojo_form" name="wojo_form" method="post">
    <div class="wojo content">
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->CG_SITENAME;?><i class="icon support" data-content="<?php echo Core::$word->CG_SITENAME_T;?>"></i></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $core->site_name;?>" name="site_name">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->CG_WEBEMAIL;?><i class="icon support" data-content="<?php echo Core::$word->CG_WEBEMAIL_T;?>"></i></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $core->site_email;?>" name="site_email">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->CG_WEBURL;?><i class="icon support" data-content="<?php echo Core::$word->CG_WEBURL_T;?>"></i></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $core->site_url;?>" name="site_url">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->CG_DIR;?><i class="icon support" data-content="<?php echo Core::$word->CG_DIR_T;?>"></i></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $core->site_dir;?>" name="site_dir">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->CG_LOGO;?></label>
          <label class="input">
            <input type="file" name="logo" id="logo" class="filefield">
          </label>
        </div>
        <div class="field">
          <label><?php echo Core::$word->CG_LOGO_DEL;?><i class="icon support" data-content="<?php echo Core::$word->CG_LOGO_T;?>"></i></label>
          <div class="inline-group">
            <label class="checkbox">
              <input name="dellogo" type="checkbox" value="1">
              <i></i><?php echo Core::$word->YES;?></label>
          </div>
        </div>
      </div>
      <div class="three fields">
        <div class="field">
          <label><?php echo Core::$word->CG_PERPAGE;?><i class="icon support" data-content="<?php echo Core::$word->CG_PERPAGE_T;?>"></i></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $core->perpage;?>" name="perpage">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->CG_IMG_W;?><i class="icon support" data-content="<?php echo Core::$word->CG_IMG_T;?>"></i></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $core->thumb_w;?>" name="thumb_w">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->CG_IMG_H;?><i class="icon support" data-content="<?php echo Core::$word->CG_IMG_T;?>"></i></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $core->thumb_h;?>" name="thumb_h">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
      </div>
      <div class="wojo fitted divider"></div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->CG_SHORTDATE;?></label>
          <select name="short_date">
            <?php echo Core::getShortDate($core->short_date);?>
          </select>
        </div>
        <div class="field">
          <label><?php echo Core::$word->CG_LONGDATE;?></label>
          <select name="long_date">
            <?php echo Core::getLongDate($core->long_date);?>
          </select>
        </div>
      </div>
      <div class="four fields">
        <div class="field">
          <label><?php echo Core::$word->CG_REGVERIFY;?><i class="icon support" data-content="<?php echo Core::$word->CG_REGVERIFY_T;?>"></i></label>
          <div class="inline-group">
            <label class="radio">
              <input name="reg_verify" type="radio" value="1" <?php echo getChecked($core->reg_verify, 1);?>>
              <i></i><?php echo Core::$word->YES;?></label>
            <label class="radio">
              <input name="reg_verify" type="radio" value="0" <?php echo getChecked($core->reg_verify, 0);?>>
              <i></i><?php echo Core::$word->NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->CG_AUTOVERIFY;?><i class="icon support" data-content="<?php echo Core::$word->CG_AUTOVERIFY_T;?>"></i></label>
          <div class="inline-group">
            <label class="radio">
              <input name="auto_verify" type="radio" value="1" <?php echo getChecked($core->auto_verify, 1);?>>
              <i></i><?php echo Core::$word->YES;?></label>
            <label class="radio">
              <input name="auto_verify" type="radio" value="0" <?php echo getChecked($core->auto_verify, 0);?>>
              <i></i><?php echo Core::$word->NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->CG_REGALOWED;?><i class="icon support" data-content="<?php echo Core::$word->CG_REGALOWED_T;?>"></i></label>
          <div class="inline-group">
            <label class="radio">
              <input name="reg_allowed" type="radio" value="1" <?php echo getChecked($core->reg_allowed, 1);?>>
              <i></i><?php echo Core::$word->YES;?></label>
            <label class="radio">
              <input name="reg_allowed" type="radio" value="0" <?php echo getChecked($core->reg_allowed, 0);?>>
              <i></i><?php echo Core::$word->NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->CG_NOTIFY_ADMIN;?><i class="icon support" data-content="<?php echo Core::$word->CG_NOTIFY_ADMIN_T;?>"></i></label>
          <div class="inline-group">
            <label class="radio">
              <input name="notify_admin" type="radio" value="1" <?php echo getChecked($core->notify_admin, 1);?>>
              <i></i><?php echo Core::$word->YES;?></label>
            <label class="radio">
              <input name="notify_admin" type="radio" value="0" <?php echo getChecked($core->notify_admin, 0);?>>
              <i></i><?php echo Core::$word->NO;?></label>
          </div>
        </div>
      </div>
      <div class="wojo fitted divider"></div>
      <div class="four fields">
        <div class="field">
          <label><?php echo Core::$word->CG_USERLIMIT;?><i class="icon support" data-content="<?php echo Core::$word->CG_USERLIMIT_T;?>"></i></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $core->user_limit;?>" name="user_limit">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field"></div>
        <div class="field">
          <label><?php echo Core::$word->CG_ETAX;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="enable_tax" type="radio" value="1" <?php echo getChecked($core->enable_tax, 1);?>>
              <i></i><?php echo Core::$word->YES;?></label>
            <label class="radio">
              <input name="enable_tax" type="radio" value="0" <?php echo getChecked($core->enable_tax, 0);?>>
              <i></i><?php echo Core::$word->NO;?></label>
          </div>
        </div>
        <div class="field"></div>
      </div>
      <div class="four fields">
        <div class="field">
          <label><?php echo Core::$word->CG_CURRENCY;?><i class="icon support" data-content="<?php echo Core::$word->CG_CURRENCY_T;?>"></i></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $core->currency;?>" name="currency">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->CG_CUR_SYMBOL;?><i class="icon support" data-content="<?php echo Core::$word->CG_CUR_SYMBOL_T;?>"></i></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $core->cur_symbol;?>" name="cur_symbol">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->CG_CUR_TSEP;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $core->tsep;?>" name="tsep">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->CG_CUR_DSEP;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $core->dsep;?>" name="dsep">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
      </div>
      <div class="wojo fitted divider"></div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->CG_INVDATA;?><i class="icon support" data-content="<?php echo Core::$word->CG_INVDATA_T;?>"></i></label>
          <textarea class="altpost" name="inv_info"><?php echo $core->inv_info;?></textarea>
        </div>
        <div class="field">
          <label><?php echo Core::$word->CG_INVNOTE;?><i class="icon support" data-content="<?php echo Core::$word->CG_INVNOTE_T;?>"></i></label>
          <textarea class="altpost" name="inv_note"><?php echo $core->inv_note;?></textarea>
        </div>
      </div>
      <div class="wojo fitted divider"></div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->CG_MAILER;?><i class="icon support" data-content="<?php echo Core::$word->CG_MAILER_T;?>"></i></label>
          <select name="mailer" id="mailerchange" data-cover="true">
            <option value="PHP" <?php if ($core->mailer == "PHP") echo "selected=\"selected\"";?>>PHP Mailer</option>
            <option value="SMAIL" <?php if ($core->mailer == "SMAIL") echo "selected=\"selected\"";?>>Sendmail</option>
            <option value="SMTP" <?php if ($core->mailer == "SMTP") echo "selected=\"selected\"";?>>SMTP Mailer</option>
          </select>
        </div>
        <div class="field showsmail">
          <label><?php echo Core::$word->CG_SMAILPATH;?><i class="icon support" data-content="<?php echo Core::$word->CG_SMAILPATH_T;?>"></i></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $core->sendmail;?>" name="sendmail">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
      </div>
      <div class="showsmtp">
        <div class="wojo thin attached divider"></div>
        <div class="two fields">
          <div class="field">
            <label><?php echo Core::$word->CG_SMTP_HOST;?><i class="icon support" data-content="<?php echo Core::$word->CG_SMTP_HOST_T;?>"></i></label>
            <div class="wojo left labeled icon input">
              <input name="smtp_host" value="<?php echo $core->smtp_host;?>" placeholder="<?php echo Core::$word->CG_SMTP_HOST;?>" type="text">
              <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
            </div>
          </div>
          <div class="field">
            <label><?php echo Core::$word->CG_SMTP_USER;?></label>
            <div class="wojo left labeled icon input">
              <input name="smtp_user" value="<?php echo $core->smtp_user;?>" placeholder="<?php echo Core::$word->CG_SMTP_USER;?>" type="text">
              <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
            </div>
          </div>
        </div>
        <div class="three fields">
          <div class="field">
            <label><?php echo Core::$word->CG_SMTP_PASS;?></label>
            <div class="wojo left labeled icon input">
              <input name="smtp_pass" value="<?php echo $core->smtp_pass;?>" placeholder="<?php echo Core::$word->CG_SMTP_PASS;?>" type="text">
              <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
            </div>
          </div>
          <div class="field">
            <label><?php echo Core::$word->CG_SMTP_PORT;?><i class="icon support" data-content="<?php echo Core::$word->CG_SMTP_PORT_T;?>"></i></label>
            <div class="wojo left labeled icon input">
              <input name="smtp_port" value="<?php echo $core->smtp_port;?>" placeholder="<?php echo Core::$word->CG_SMTP_PORT;?>" type="text">
              <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
            </div>
          </div>
          <div class="field">
            <label><?php echo Core::$word->CG_SMTP_SSL;?><i class="icon support" data-content="<?php echo Core::$word->CG_SMTP_SSL_T;?>"></i></label>
            <div class="inline-group">
              <label class="radio">
                <input name="is_ssl" type="radio" value="1" <?php getChecked($core->is_ssl, 1); ?>>
                <i></i><?php echo Core::$word->YES;?></label>
              <label class="radio">
                <input name="is_ssl" type="radio" value="0" <?php getChecked($core->is_ssl, 0); ?>>
                <i></i> <?php echo Core::$word->NO;?> </label>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="wojo footer">
      <button type="button" name="dosubmit" class="wojo button"><?php echo Core::$word->CG_UPDATE;?></button>
      <input name="processConfig" type="hidden" value="1">
    </div>
  </form>
</div>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function () {
	var res2 = '<?php echo $core->mailer;?>';
		(res2 == "SMTP" ) ? $('.showsmtp').show() : $('.showsmtp').hide();
    $('#mailerchange').change(function () {
		var res = $("#mailerchange option:selected").val();
		(res == "SMTP" ) ? $('.showsmtp').show() : $('.showsmtp').hide();
	});

     (res2 == "SMAIL") ? $('.showsmail').show() : $('.showsmail').hide();
     $('#mailerchange').change(function () {
         var res = $("#mailerchange option:selected").val();
         (res == "SMAIL") ? $('.showsmail').show() : $('.showsmail').hide();
     });
});
// ]]>
</script>