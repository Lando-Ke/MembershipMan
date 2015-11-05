<?php
  /**
   * Header
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
	  $news = $content->renderNews();
?>
<!DOCTYPE html>

<head>
<meta charset="utf-8">
<title><?php echo $core->site_name;?></title>
<script type="text/javascript">
var SITEURL = "<?php echo SITEURL; ?>";
var ADMINURL = "<?php echo ADMINURL; ?>";
</script>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="<?php echo $protocol;?>://fonts.googleapis.com/css?family=Open+Sans:300,700" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="theme/css/base.css" type="text/css" />
<link rel="stylesheet" href="theme/css/form.css" type="text/css" />
<link rel="stylesheet" href="theme/css/message.css" type="text/css" />
<link rel="stylesheet" href="theme/css/icon.css" type="text/css" />
<link rel="stylesheet" href="theme/css/table.css" type="text/css" />
<link rel="stylesheet" href="theme/css/style.css" type="text/css" />
<script type="text/javascript" src="assets/js/jquery.js"></script>
<script type="text/javascript" src="assets/js/jquery-ui.js"></script>
<script src="assets/js/global.js"></script>
<script src="theme/js/master.js"></script>
<script src="assets/js/jquery.ui.touch-punch.js"></script>
</head>
<body>
<div class="wojo-grid">
  <header>
    <div class="columns">
      <div class="screen-30 tablet-40 phone-100">
        <div id="logo"> <a href="index.php"><?php echo ($core->logo) ? '<img src="' . SITEURL . '/uploads/' . $core->logo . '" alt="' . $core->site_name . '" class="logo"/>': $core->site_name;?></a> </div>
      </div>
      <div class="screen-70 tablet-60 phone-100">
        <nav> <a href="index.php"><?php echo Core::$word->HOME;?></a> // <a href="contact.php"><?php echo Core::$word->CF_CONTACT;?></a> //
          <?php if($user->logged_in):?>
          <a href="logout.php"><?php echo Core::$word->N_LOGOUT;?></a> //
          <?php endif;?>
          <?php if(!$user->logged_in):?>
          <a href="plans.php"><?php echo Core::$word->MM_PACK;?></a> //
          <?php endif;?>
          <?php if($user->is_Admin()):?>
          <a href="admin/index.php"> Admin Panel</a> //
          <?php endif;?>
          <?php if(!$user->logged_in):?>
          <a href="register.php"><?php echo Core::$word->UA_REGISTER;?></a>
          <?php endif;?>
        </nav>
      </div>
    </div>
  </header>
  <?php if($news and !$user->logged_in):?>
  <div class="columns">
    <div class="screen-60 tablet-90 phone-100 push-center">
      <div id="news"><?php echo Filter::dodate("short_date", $news->created).' <strong>'.$news->title.'</strong>';?> <?php echo cleanOut($news->body);?> </div>
    </div>
  </div>
  <?php endif;?>
</div>