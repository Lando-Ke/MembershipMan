<?php
  /**
   * Login
   */
  
  define("_VALID_PHP", true);
  require_once("../init.php");
?>
<?php
  if ($user->is_Admin())
      redirect_to("index.php");
	  
  if (isset($_POST['submit']))
      : $result = $user->login($_POST['username'], $_POST['password']);
  //Login successful 
  if ($result)
      : redirect_to("index.php");
  endif;
  endif;

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $core->site_name;?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="assets/css/login.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../assets/js/jquery.js"></script>
</head>
<body>
<div id="wrapper">
  <div id="content">
    <h1>Admin Panel<span><?php echo $core->site_name;?></span></h1>
    <form id="admin_form" name="admin_form" method="post" action="#">
      <div class="row">
        <input placeholder="Username"  type="text" name="username">
      </div>
      <div class="row">
        <input placeholder="**********" type="password" name="password">
      </div>
      <div id="footer" class="clearfix"> <span>Copyright &copy;<?php echo date('Y').' '.$core->site_name;?></span>
        <button name="submit">Login</button>
      </div>
    </form>
  </div>
  <div id="message-box"><?php print Filter::$showMsg;?></div>
</div>
</body>
</html>