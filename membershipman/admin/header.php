<?php
  /**
   * Header
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $core->site_name;?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script type="text/javascript">
var SITEURL = "<?php echo SITEURL; ?>";
var ADMINURL = "<?php echo ADMINURL; ?>";
</script>
<link href="<?php echo THEMEU . '/cache/' . Minify::cache(array('css/base.css','css/table.css','css/datepicker.css','css/editor.css','css/segment.css','css/button.css','css/form.css','css/input.css', 'css/divider.css', 'css/menu.css', 'css/dropdown.css', 'css/message.css', 'css/feed.css', 'css/image.css', 'css/breadcrumb.css', 'css/list.css','css/utility.css','css/icon.css', 'css/label.css' ,'css/style.css'),'css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../assets/js/jquery.js"></script>
<script type="text/javascript" src="../assets/js/jquery-ui.js"></script>
<script src="../assets/js/jquery.ui.touch-punch.js"></script>
<script src="../assets/js/global.js"></script>
<script type="text/javascript" src="../assets/js/editor.js"></script>
<script src="assets/js/master.js"></script>
</head>
<body>
<div id="wrapper">
  <div class="wojo-grid">
    <header>
      <div id="topnav" class="clearfix">
        <ul>
          <li><a href="index.php" class="logo"><?php echo ($core->logo) ? '<img src="'.SITEURL.'/uploads/'.$core->logo.'" alt="'.$core->site_name.'">': $core->site_name;?></a></li>
          <li class="separator right"><a href="logout.php"><i class="icon sign out"></i></a></li>
          <li class="separator right uinfo"><a href="index.php?do=users&amp;action=edit&amp;id=<?php echo $user->uid;?>"><img src="../uploads/<?php echo ($user->avatar) ? $user->avatar : 'blank.png';?>" alt="" class="avatar"> <?php echo Core::$word->HELLO;?>, <?php echo $user->username;?> <br />
            <?php echo Core::$word->UR_LASTLOGIN;?>: <?php echo strftime("%c", strtotime($user->last));?></a></li>
        </ul>
      </div>
      <nav class="clearfix">
        <ul>
          <li><a href="index.php"<?php if (!Filter::$do) echo ' class="active"';?>> <?php echo Core::$word->N_DASH;?></a></li>
          <li><a<?php if (Filter::$do == "templates" or Filter::$do == "news" or Filter::$do == "newsletter" or Filter::$do == "countries") echo ' class="active"';?>><?php echo Core::$word->N_CONTENT;?><i class="icon angle down"></i></a>
            <ul>
              <li><a href="index.php?do=templates"><?php echo Core::$word->N_EMAILS;?></a></li>
              <li><a href="index.php?do=countries"><?php echo Core::$word->N_COUNTRIES;?></a></li>
              <li><a href="index.php?do=language"><?php echo Core::$word->N_LANGM;?></a></li>
              <li><a href="index.php?do=coupons"><?php echo Core::$word->N_DISC;?></a></li>
              <li><a href="index.php?do=news"><?php echo Core::$word->N_NEWS;?></a></li>
              <li><a href="index.php?do=newsletter"><?php echo Core::$word->N_NEWSL;?></a></li>
              <li><a href="index.php?do=fields"><?php echo Core::$word->N_FIELDS;?></a></li>
            </ul>
          </li>
          <li><a<?php if (Filter::$do == "users" or Filter::$do == "ustats") echo ' class="active"';?>><?php echo Core::$word->N_USERS;?><i class="icon angle down"></i></a>
            <ul>
              <li><a href="index.php?do=users"><?php echo Core::$word->N_USERS;?></a></li>
              <li><a href="index.php?do=ustats"><?php echo Core::$word->N_USTATS;?></a></li>
            </ul>
          </li>
          <li><a<?php if (Filter::$do == "memberships" or Filter::$do == "gateways" or Filter::$do == "transactions") echo ' class="active"';?>><?php echo Core::$word->N_MEMS;?><i class="icon angle down"></i></a>
            <ul>
              <li><a href="index.php?do=memberships"><?php echo Core::$word->N_MEMSM;?></a></li>
              <li><a href="index.php?do=gateways"><?php echo Core::$word->N_GATE;?></a></li>
              <li><a href="index.php?do=transactions"><?php echo Core::$word->N_TXN;?></a></li>
            </ul>
          </li>
          <li><a<?php if (Filter::$do == "config" or Filter::$do == "maintenance" or Filter::$do == "backup") echo ' class="active"';?>><?php echo Core::$word->N_CONF;?><i class="icon angle down"></i></a>
            <ul>
              <li><a href="index.php?do=config"><?php echo Core::$word->N_SYSSONF;?></a></li>
              <li><a href="index.php?do=maintenance"><?php echo Core::$word->N_SYSMTNC;?></a></li>
              <li><a href="index.php?do=backup"><?php echo Core::$word->N_BACK;?></a></li>
            </ul>
          </li>
          <li><a<?php if (Filter::$do == "help-login" or Filter::$do == "help-redirect" or Filter::$do == "help-clogin" or Filter::$do == "help-member" or Filter::$do == "help-cron" or Filter::$do == "builder") echo ' class="active"';?>><?php echo Core::$word->N_HELP;?><i class="icon angle down"></i></a>
            <ul>
              <li><a href="index.php?do=help-login"><?php echo Core::$word->N_HELP_LP;?></a></li>
              <li><a href="index.php?do=help-redirect"><?php echo Core::$word->N_HELP_LR;?></a></li>
              <li><a href="index.php?do=help-clogin"><?php echo Core::$word->N_HELP_CL;?></a></li>
              <li><a href="index.php?do=help-member"><?php echo Core::$word->N_HELP_MP;?></a></li>
              <li><a href="index.php?do=help-cron"><?php echo Core::$word->N_HELP_CJ;?></a></li>
              <li><a href="index.php?do=builder"><?php echo Core::$word->N_HELP_PB;?></a></li>
            </ul>
          </li>
        </ul>
      </nav>
    </header>
  </div>