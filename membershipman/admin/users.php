<?php
  /**
   * Users
   *
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php switch(Filter::$action): case "edit": ?>
<?php $row = Core::getRowById(Users::uTable, Filter::$id);?>
<?php $memrow = $member->getMemberships();?>
<?php $datacountry = $content->getCountryList();?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <a href="index.php?do=users" class="section"><?php echo Core::$word->N_USERS;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->UR_TITLE1;?></div>
</div>
<div class="wojo form basic segment">
  <div class="wojo header"><span><?php echo Core::$word->UR_TITLE3;?></span><small><?php echo Core::$word->UR_SUBTITLE1 . ' [' . $row->username . ']';?></small>
    <p><?php echo Core::$word->UR_INFO1. Core::$word->REQ1 . ' <i class="icon asterisk"></i> ' . Core::$word->REQ2;?></p>
  </div>
  <form id="wojo_form" name="wojo_form" method="post">
    <div class="wojo content">
      <div class="two fields">
        <div class="field disabled">
          <label><?php echo Core::$word->USERNAME;?></label>
          <label class="input">
            <input type="text" value="<?php echo $row->username;?>" disabled="disabled" name="username">
          </label>
        </div>
        <div class="field">
          <label><?php echo Core::$word->EMAIL;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $row->email;?>" name="email">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->UR_FNAME;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $row->fname;?>" name="fname">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->UR_LNAME;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $row->lname;?>" name="lname">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->UR_AVATAR;?></label>
          <label class="input">
            <input type="file" name="avatar" id="avatar" class="filefield">
          </label>
        </div>
        <div class="field">
          <label><?php echo Core::$word->UR_AVATAR;?></label>
          <div class="wojo avatar image">
            <?php if($row->avatar):?>
            <img src="../uploads/<?php echo $row->avatar;?>" alt="<?php echo $user->username;?>">
            <?php else:?>
            <img src="../uploads/blank.png" alt="<?php echo $row->username;?>">
            <?php endif;?>
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->MEMBERSHIP;?><i class="icon support" data-content="<?php echo Core::$word->UR_NOMEMBERSHIP_T;?>"></i></label>
          <select name="membership_id">
            <option value="0">--- <?php echo Core::$word->UR_NOMEMBERSHIP;?> ---</option>
            <?php if($memrow):?>
            <?php foreach ($memrow as $mlist):?>
            <?php $selected = ($row->membership_id == $mlist->id) ? " selected=\"selected\"" : "";?>
            <option value="<?php echo $mlist->id;?>"<?php echo $selected;?>><?php echo $mlist->title;?></option>
            <?php endforeach;?>
            <?php unset($mlist);?>
            <?php endif;?>
          </select>
        </div>
        <div class="field">
          <label><?php echo Core::$word->PASSWORD;?><i class="icon support" data-content="<?php echo Core::$word->UR_PASS_T;?>"></i></label>
          <input type="text" name="password">
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->UR_ADDRESS;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $row->address;?>" name="address">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->UR_CITY;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" value="<?php echo $row->city;?>" name="city">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field fitted">
          <div class="two fields">
            <div class="field">
              <label><?php echo Core::$word->UR_STATE;?></label>
              <div class="wojo left labeled icon input">
                <input type="text" value="<?php echo $row->state;?>" name="state">
                <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
              </div>
            </div>
            <div class="field">
              <label><?php echo Core::$word->UR_ZIP;?></label>
              <div class="wojo left labeled icon input">
                <input type="text" value="<?php echo $row->zip;?>" name="zip">
                <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
              </div>
            </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->UR_COUNTRY;?></label>
          <select name="country">
            <option value="">-- <?php echo Core::$word->CNT_SELECT;?> --</option>
            <?php echo Core::loopOptions($datacountry, "abbr", "name", $row->country);?>
          </select>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->UR_STATUS;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="active" type="radio" value="y" <?php echo getChecked($row->active, "y");?>>
              <i></i><?php echo Core::$word->USER_A;?></label>
            <label class="radio">
              <input name="active" type="radio" value="n" <?php echo getChecked($row->active, "n");?>>
              <i></i><?php echo Core::$word->USER_I;?></label>
            <label class="radio">
              <input name="active" type="radio" value="b" <?php echo getChecked($row->active, "b");?>>
              <i></i><?php echo Core::$word->USER_B;?></label>
            <label class="radio">
              <input name="active" type="radio" value="t" <?php echo getChecked($row->active, "t");?>>
              <i></i><?php echo Core::$word->USER_P;?></label>
          </div>
        </div>
        <div class="field fitted">
          <div class="two fields">
            <div class="field">
              <label><?php echo Core::$word->UR_IS_NEWSLETTER;?></label>
              <div class="inline-group">
                <label class="radio">
                  <input name="newsletter" type="radio" value="1" <?php echo getChecked($row->newsletter, 1);?>>
                  <i></i><?php echo Core::$word->YES;?></label>
                <label class="radio">
                  <input name="newsletter" type="radio" value="0" <?php echo getChecked($row->newsletter, 0);?>>
                  <i></i><?php echo Core::$word->NO;?></label>
              </div>
            </div>
            <div class="field">
              <label><?php echo Core::$word->UR_LEVEL;?></label>
              <div class="inline-group">
                <label class="radio">
                  <input name="userlevel" type="radio" value="9" <?php echo getChecked($row->userlevel, 9);?>>
                  <i></i><?php echo Core::$word->UR_ADMIN;?></label>
                <label class="radio">
                  <input name="userlevel" type="radio" value="1" <?php echo getChecked($row->userlevel, 1);?>>
                  <i></i><?php echo Core::$word->USER;?></label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php echo $content->rendertCustomFields('profile', $row->custom_fields);?>
      <div class="wojo double fitted divider"></div>
      <div class="two fields">
        <div class="field disabled">
          <label><?php echo Core::$word->UR_LASTLOGIN;?></label>
          <label class="input">
            <input name="lastlogin" type="text" disabled value="<?php echo (strtotime($row->lastlogin) === false) ? "-/-" : Filter::dodate("long_date", $row->lastlogin);?>" readonly>
          </label>
        </div>
        <div class="field disabled">
          <label><?php echo Core::$word->UR_LASTLOGIN_IP;?></label>
          <label class="input">
            <input name="lastip" type="text" disabled value="<?php echo $row->lastip;?>" readonly>
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field disabled">
          <label><?php echo Core::$word->UR_DATE_REGGED;?></label>
          <label class="input">
            <input name="created" type="text" disabled value="<?php echo Filter::dodate("long_date", $row->created);?>" readonly>
          </label>
        </div>
        <div class="field">
          <label><?php echo Core::$word->UR_NOTIFY;?><i class="icon support" data-content="<?php echo Core::$word->UR_NOTIFY_T;?>"></i></label>
          <div class="inline-group">
            <label class="checkbox">
              <input name="notify" type="checkbox" value="1">
              <i></i><?php echo Core::$word->YES;?></label>
          </div>
        </div>
      </div>
      <div class="field">
        <label><?php echo Core::$word->UR_NOTES;?><i class="icon support" data-content="<?php echo Core::$word->UR_NOTES_T;?>"></i></label>
        <textarea name="notes"><?php echo $row->notes;?></textarea>
      </div>
    </div>
    <div class="wojo footer">
      <button type="button" name="dosubmit" class="wojo button"><?php echo Core::$word->UR_UPDATE;?></button>
      <a href="index.php?do=users" class="wojo basic button"><?php echo Core::$word->CANCEL;?></a>
      <input name="processUser" type="hidden" value="1">
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
      <input name="username" type="hidden" value="<?php echo $row->username;?>">
    </div>
  </form>
</div>
<?php break;?>
<?php case"add": ?>
<?php $memrow = $member->getMemberships();?>
<?php $datacountry = $content->getCountryList();?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <a href="index.php?do=users" class="section"><?php echo Core::$word->N_USERS;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->UR_TITLE2;?></div>
</div>
<div class="wojo form basic segment">
  <div class="wojo header"><span><?php echo Core::$word->UR_TITLE3;?></span><small><?php echo Core::$word->UR_SUBTITLE2;?></small>
    <p><?php echo Core::$word->UR_INFO1. Core::$word->REQ1 . ' <i class="icon asterisk"></i> ' . Core::$word->REQ2;?></p>
  </div>
  <form id="wojo_form" name="wojo_form" method="post">
    <div class="wojo content">
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->USERNAME;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" placeholder="<?php echo Core::$word->USERNAME;?>" name="username">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->EMAIL;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" placeholder="<?php echo Core::$word->EMAIL;?>" name="email">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->UR_FNAME;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" placeholder="<?php echo Core::$word->UR_FNAME;?>" name="fname">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->UR_LNAME;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" placeholder="<?php echo Core::$word->UR_LNAME;?>" name="lname">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->UR_AVATAR;?></label>
          <label class="input">
            <input type="file" name="avatar" id="avatar" class="filefield">
          </label>
        </div>
        <div class="field">
          <label><?php echo Core::$word->UR_AVATAR;?></label>
          <div class="wojo avatar image"> <img src="../uploads/blank.png" alt=""> </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->MEMBERSHIP;?><i class="icon support" data-content="<?php echo Core::$word->UR_NOMEMBERSHIP_T;?>"></i></label>
          <select name="membership_id">
            <option value="0">--- <?php echo Core::$word->UR_NOMEMBERSHIP;?> ---</option>
            <?php if($memrow):?>
            <?php foreach ($memrow as $mlist):?>
            <option value="<?php echo $mlist->id;?>"><?php echo $mlist->title;?></option>
            <?php endforeach;?>
            <?php unset($mlist);?>
            <?php endif;?>
          </select>
        </div>
        <div class="field">
          <label><?php echo Core::$word->PASSWORD;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" placeholder="<?php echo Core::$word->PASSWORD;?>" name="password">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->UR_ADDRESS;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" placeholder="<?php echo Core::$word->UR_ADDRESS;?>" name="address">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->UR_CITY;?></label>
          <div class="wojo left labeled icon input">
            <input type="text" placeholder="<?php echo Core::$word->UR_CITY;?>" name="city">
            <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field fitted">
          <div class="two fields">
            <div class="field">
              <label><?php echo Core::$word->UR_STATE;?></label>
              <div class="wojo left labeled icon input">
                <input type="text" placeholder="<?php echo Core::$word->UR_STATE;?>" name="state">
                <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
              </div>
            </div>
            <div class="field">
              <label><?php echo Core::$word->UR_ZIP;?></label>
              <div class="wojo left labeled icon input">
                <input type="text" placeholder="<?php echo Core::$word->UR_ZIP;?>" name="zip">
                <div class="wojo corner label"> <i class="icon asterisk"></i> </div>
              </div>
            </div>
          </div>
        </div>
        <div class="field">
          <label><?php echo Core::$word->UR_COUNTRY;?></label>
          <select name="country">
            <option value="">-- <?php echo Core::$word->CNT_SELECT;?> --</option>
            <?php echo Core::loopOptions($datacountry, "abbr", "name", false);?>
          </select>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Core::$word->UR_STATUS;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="active" type="radio" value="y" checked="checked">
              <i></i><?php echo Core::$word->USER_A;?></label>
            <label class="radio">
              <input name="active" type="radio" value="n">
              <i></i><?php echo Core::$word->USER_I;?></label>
            <label class="radio">
              <input name="active" type="radio" value="b">
              <i></i><?php echo Core::$word->USER_B;?></label>
            <label class="radio">
              <input name="active" type="radio" value="t">
              <i></i><?php echo Core::$word->USER_P;?></label>
          </div>
        </div>
        <div class="field fitted">
          <div class="two fields">
            <div class="field">
              <label><?php echo Core::$word->UR_IS_NEWSLETTER;?></label>
              <div class="inline-group">
                <label class="radio">
                  <input name="newsletter" type="radio" value="1" checked="checked">
                  <i></i><?php echo Core::$word->YES;?></label>
                <label class="radio">
                  <input name="newsletter" type="radio" value="0">
                  <i></i><?php echo Core::$word->NO;?></label>
              </div>
            </div>
            <div class="field">
              <label><?php echo Core::$word->UR_LEVEL;?></label>
              <div class="inline-group">
                <label class="radio"> <input name="userlevel" type="radio" value="9">
                  <i></i><?php echo Core::$word->UR_ADMIN;?></label>
                <label class="radio">
                  <input name="userlevel" type="radio" value="1" checked="checked">
                  <i></i><?php echo Core::$word->USER;?></label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php echo $content->rendertCustomFields('register', false);?>
      <div class="wojo double fitted divider"></div>
      <div class="field">
        <label><?php echo Core::$word->UR_NOTIFY;?><i class="icon support" data-content="<?php echo Core::$word->UR_NOTIFY_T;?>"></i></label>
        <div class="inline-group">
          <label class="checkbox">
            <input name="notify" type="checkbox" value="1">
            <i></i><?php echo Core::$word->YES;?></label>
        </div>
      </div>
      <div class="field">
        <label><?php echo Core::$word->UR_NOTES;?><i class="icon support" data-content="<?php echo Core::$word->UR_NOTES_T;?>"></i></label>
        <textarea placeholder="<?php echo Core::$word->UR_NOTES;?>" name="notes"></textarea>
      </div>
    </div>
    <div class="wojo footer">
      <button type="button" name="dosubmit" class="wojo button"><?php echo Core::$word->UR_ADD;?></button>
      <a href="index.php?do=users" class="wojo basic button"><?php echo Core::$word->CANCEL;?></a>
      <input name="processUser" type="hidden" value="1">
    </div>
  </form>
</div>
<?php break;?>
<?php case"grid": ?>
<?php $userrow = $user->getUsers();?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->N_USERS;?></div>
</div>
<div class="wojo form basic segment">
  <div class="wojo header"> <a href="index.php?do=users&amp;action=add" class="push-right wojo basic button"><i class="icon add"></i><?php echo Core::$word->UR_ADD;?></a> <span><?php echo Core::$word->UR_TITLE3;?></span>
    <p><?php echo str_replace("[ICON]", "<i class=\"icon adjust\"></i>", Core::$word->UR_INFO3);?></p>
  </div>
  <div class="wojo content">
    <form method="post" id="admin_form" name="wojo_form">
      <div class="three fields">
        <div class="field">
          <div class="wojo input"> <i class="icon-prepend icon calendar"></i>
            <input name="fromdate" type="text" id="fromdate" placeholder="<?php echo Core::$word->FROM;?>" readonly data-link-field="true" data-date-format="dd, MM yyyy" data-link-format="yyyy-mm-dd">
          </div>
        </div>
        <div class="field">
          <div class="wojo action input"> <i class="icon-prepend icon calendar"></i>
            <input name="enddate" type="text" id="enddate" placeholder="<?php echo Core::$word->TO;?>" readonly data-date-autoclose="true" data-min-view="2" data-start-view="2" data-date-today-btn="true" data-link-field="true" data-date-format="dd, MM yyyy" data-link-format="yyyy-mm-dd">
            <a id="doDates" class="wojo button"><?php echo Core::$word->FIND;?></a> </div>
        </div>
        <div class="field"> <?php echo $pager->items_per_page();?></div>
      </div>
    </form>
    <div class="three fields">
      <div class="field">
        <div class="wojo icon input">
          <input type="text" name="clientsearch" placeholder="<?php echo Core::$word->SEARCH;?>" id="searchfield">
          <i class="search icon"></i>
          <div id="suggestions"></div>
        </div>
      </div>
      <div class="field content-center"> <a><i class="circular inverted black icon grid layout dimmed link"></i></a> <a href="index.php?do=users"><i class="circular inverted black icon list layout link"></i> </a></div>
      <div class="field"> <?php echo $pager->jump_menu();?> </div>
    </div>
  </div>
  <div class="content-center wojo footer"><?php echo alphaBits("index.php?do=users&amp;action=grid", "letter", "wojo small pagination menu");?></div>
</div>
<?php if(!$userrow):?>
<?php echo Filter::msgSingleAlert(Core::$word->UR_NOUSER);?>
<?php else:?>
<div class="three columns small-gutters">
  <?php foreach ($userrow as $row):?>
  <div class="row">
    <div class="wojo basic segment">
      <div class="wojo header"><img src="../uploads/<?php echo ($row->avatar) ? $row->avatar : "blank.png";?>" alt="" class="wojo circular small image">
        <div class="item"><a href="index.php?do=users&amp;action=edit&amp;id=<?php echo $row->id;?>"><?php echo $row->name;?> </a></div>
        <?php echo Core::$word->UR_LASTLOGIN;?>: <?php echo (strtotime($row->lastlogin) === false) ? "never" : Filter::dodate("long_date", $row->lastlogin);?> </div>
      <div class="wojo project list">
        <div class="content">
          <div class="header"><?php echo Core::$word->USERNAME;?>:</div>
          <div class="data"><?php echo $row->username;?></div>
        </div>
        <div class="content">
          <div class="header"><?php echo Core::$word->EMAIL;?>:</div>
          <div class="data"><a href="index.php?do=newsletter&amp;emailid=<?php echo urlencode($row->email);?>"><?php echo $row->email;?></a></div>
        </div>
        <div class="content">
          <div class="header"><?php echo Core::$word->MEMBERSHIP;?>:</div>
          <div class="data">
            <?php if(!$row->membership_id):?>
            --/--
            <?php else:?>
            <a href="index.php?do=memberships&amp;action=edit&amp;id=<?php echo $row->mid;?>"><?php echo $row->title;?></a>
            <?php endif;?>
          </div>
        </div>
        <div class="content">
          <div class="header"><?php echo Core::$word->UR_ADDRESS;?>:</div>
          <div class="data"><?php echo $row->address;?></div>
        </div>
        <div class="content">
          <div class="header"><?php echo Core::$word->UR_CITY;?>:</div>
          <div class="data"><?php echo $row->city;?></div>
        </div>
        <div class="content">
          <div class="header"><?php echo Core::$word->UR_COUNTRY;?>:</div>
          <div class="data"><?php echo $row->cname;?></div>
        </div>
        <div class="content">
          <div class="header"><?php echo Core::$word->UR_ZIP;?>:</div>
          <div class="data"><?php echo $row->zip;?></div>
        </div>
        <div class="content">
          <div class="header"><?php echo Core::$word->UR_STATUS;?>:</div>
          <div class="data"><?php echo userStatus($row->active, $row->id);?></div>
        </div>
        <div class="content actions">
          <div class="header"><?php echo Core::$word->ACTIONS;?>:</div>
          <div class="data"><a href="index.php?do=users&amp;action=edit&amp;id=<?php echo $row->id;?>"><i class="circular inverted success icon pencil link"></i></a> <a class="delete" data-set='{"title": "<?php echo Core::$word->DELETE . ' ' . Core::$word->USER;?>", "parent": ".row", "option": "deleteUser", "id": <?php echo $row->id;?>, "name": "<?php echo $row->username;?>"}'><i class="circular danger inverted remove icon link"></i></a></div>
        </div>
      </div>
    </div>
  </div>
  <?php endforeach;?>
</div>
<?php endif;?>
<div class="wojo tabular info segment">
  <div class="wojo cell"> <span class="wojo small basic button"><?php echo Core::$word->PAG_TOTAL.': '.$pager->items_total;?> / <?php echo Core::$word->PAG_CURPAGE.': '.$pager->current_page.' '.Core::$word->PAG_OF.' '.$pager->num_pages;?></span> </div>
  <div class="wojo cell right"> <?php echo $pager->display_pages();?> </div>
</div>
<?php break;?>
<?php default:?>
<?php $userrow = $user->getUsers();?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->N_USERS;?></div>
</div>
<div class="wojo form basic segment">
  <div class="wojo header"> <a href="index.php?do=users&amp;action=add" class="push-right wojo basic button"><i class="icon add"></i><?php echo Core::$word->UR_ADD;?></a> <span><?php echo Core::$word->UR_TITLE3;?></span>
    <p><?php echo str_replace("[ICON]", "<i class=\"icon adjust\"></i>", Core::$word->UR_INFO3);?></p>
  </div>
  <div class="wojo content">
    <form method="post" id="admin_form" name="wojo_form">
      <div class="three fields">
        <div class="field">
          <div class="wojo input"> <i class="icon-prepend icon calendar"></i>
            <input name="fromdate" type="text" id="fromdate" placeholder="<?php echo Core::$word->FROM;?>" readonly data-link-field="true" data-date-format="dd, MM yyyy" data-link-format="yyyy-mm-dd">
          </div>
        </div>
        <div class="field">
          <div class="wojo action input"> <i class="icon-prepend icon calendar"></i>
            <input name="enddate" type="text" id="enddate" placeholder="<?php echo Core::$word->TO;?>" readonly data-date-autoclose="true" data-min-view="2" data-start-view="2" data-date-today-btn="true" data-link-field="true" data-date-format="dd, MM yyyy" data-link-format="yyyy-mm-dd">
            <a id="doDates" class="wojo button"><?php echo Core::$word->FIND;?></a> </div>
        </div>
        <div class="field"> <?php echo $pager->items_per_page();?></div>
      </div>
    </form>
    <div class="three fields">
      <div class="field">
        <div class="wojo icon input">
          <input type="text" name="usersearch" placeholder="<?php echo Core::$word->SEARCH;?>" id="searchfield">
          <i class="search icon"></i>
          <div id="suggestions"></div>
        </div>
      </div>
      <div class="field content-center"> <a href="index.php?do=users&amp;action=grid"><i class="circular inverted black icon grid layout link"></i></a> <a><i class="circular inverted dimmed black icon list layout link"></i> </a></div>
      <div class="field"> <?php echo $pager->jump_menu();?> </div>
    </div>
  </div>
  <div class="content-center wojo footer"><?php echo alphaBits("index.php?do=users", "letter", "wojo small pagination menu");?></div>
</div>
<div class="wojo basic segment">
  <table class="wojo sortable table">
    <thead>
      <tr>
        <th data-sort="int">#</th>
        <th data-sort="string"><?php echo Core::$word->USERNAME;?></th>
        <th data-sort="string"><?php echo Core::$word->FULLNAME;?></th>
        <th data-sort="string"><?php echo Core::$word->UR_STATUS;?></th>
        <th data-sort="string"><?php echo Core::$word->MEMBERSHIP;?></th>
        <th data-sort="int"><?php echo Core::$word->EXPIRE;?></th>
        <th class="disabled"><?php echo Core::$word->ACTIONS;?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(!$userrow):?>
      <tr>
        <td colspan="7"><?php echo Filter::msgSingleAlert(Core::$word->UR_NOUSER);?></td>
      </tr>
      <?php else:?>
      <?php foreach ($userrow as $row):?>
      <tr>
        <td><small class="wojo label"><?php echo $row->id;;?>.</small></td>
        <td><a href="index.php?do=newsletter&amp;emailid=<?php echo urlencode($row->email);?>"><?php echo $row->username;?></a></td>
        <td><?php echo $row->name;?></td>
        <td><?php echo userStatus($row->active, $row->id);?></td>
        <td><?php if(!$row->membership_id):?>
          --/--
          <?php else:?>
          <a href="index.php?do=memberships&amp;action=edit&amp;id=<?php echo $row->mid;?>"><?php echo $row->title;?></a>
          <?php endif;?></td>
        <td data-sort-value="<?php echo strtotime($row->created);?>"><?php echo $row->mem_expire;?></td>
        <td><a href="index.php?do=users&amp;action=edit&amp;id=<?php echo $row->id;?>"><i class="circular inverted success icon pencil link"></i></a>
          <?php if($row->id == 1):?>
          <a><i class="circular black inverted lock icon link"></i></a>
          <?php else:?>
          <a class="delete" data-set='{"title": "<?php echo Core::$word->DELETE . ' ' . Core::$word->USER;?>", "parent": "tr", "option": "deleteUser", "id": <?php echo $row->id;?>, "name": "<?php echo $row->username;?>"}'><i class="circular danger inverted trash icon link"></i></a>
          <?php endif;?></td>
      </tr>
      <?php endforeach;?>
      <?php unset($row);?>
      <?php endif;?>
    </tbody>
  </table>
  <div class="wojo tabular info segment bottom attached">
    <div class="wojo cell"> <span class="wojo small basic button"><?php echo Core::$word->PAG_TOTAL.': '.$pager->items_total;?> / <?php echo Core::$word->PAG_CURPAGE.': '.$pager->current_page.' '.Core::$word->PAG_OF.' '.$pager->num_pages;?></span> </div>
    <div class="wojo cell right"> <?php echo $pager->display_pages();?> </div>
  </div>
</div>
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function() {
    $('a.activate').on('click', function() {
        var uid = $(this).data('id')
        var text = "<div class=\"messi-warning\"><p><i class=\"icon warn danger sign\"></i></p><p><?php echo Core::$word->UA_AC_ACC;?><br><strong><?php echo Core::$word->UA_AC_ACC2;?></strong></p></div>";
        new Messi(text, {
            title: "<?php echo Core::$word->UA_TITLE5;?>",
            modal: true,
            closeButton: true,
            buttons: [{
                id: 0,
                label: "<?php echo Core::$word->UA_ACTIVATE_ACC;?>",
                val: 'Y'
            }],
            callback: function(val) {
                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: "controller.php",
                    data: {
                        activateAccount: 1,
                        id: uid,
                    },
                    success: function(json) {
                        $.sticky(decodeURIComponent(json.message), {
                            type: json.type,
                            title: json.title
                        });
                    }
                });
            }
        });
    });
});
// ]]>
</script>
<?php break;?>
<?php endswitch;?>