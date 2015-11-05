<?php
  /**
   * Index
   */
  define("_VALID_PHP", true);
  require_once("init.php");
  
  if (!$user->is_Admin())
      redirect_to("login.php");
?>
<?php include("header.php");?>
<!-- Start Content-->
<div class="wojo-grid">
  <?php (Filter::$do && file_exists(Filter::$do.".php")) ? include(Filter::$do.".php") : include("main.php");?>
</div>
<!-- End Content/-->
<?php include("footer.php");?>