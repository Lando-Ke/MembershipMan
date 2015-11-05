<?php
  /**
   * Backup
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php
  require_once(BASEPATH . "lib/class_dbtools.php");
  Registry::set('dbTools',new dbTools());
  $tools = Registry::get("dbTools");
  
  if (isset($_GET['backupok']) && $_GET['backupok'] == "1")
      Filter::msgOk(Core::$word->BK_BACKUP_OK,1,1);
	    
  if (isset($_GET['create']) && $_GET['create'] == "1")
      $tools->doBackup('',false);

  if (isset($_POST['backup_file']))
      $tools->doRestore($_POST['backup_file']);
	  
  $dir = BASEPATH . 'admin/backups/';
?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->N_BACK;?></div>
</div>
<div class="wojo basic segment">
  <div class="wojo header"><a href="index.php?do=backup&amp;create=1" class="push-right wojo basic button"><i class="icon add"></i><?php echo Core::$word->BK_CREATE;?></a><span><?php echo Core::$word->BK_TITLE;?></span>
    <p><?php echo Core::$word->BK_INFO;?></p>
  </div>
  <?php if (is_dir($dir)):?>
  <?php $getDir = dir($dir);?>
  <div class="wojo divided list">
    <?php while (false !== ($file = $getDir->read())):?>
    <?php if ($file != "." && $file != ".." && $file != "index.php"):?>
    <?php $latest =  ($file == $core->backup) ? " active" : "";?>
    <div class="item<?php echo $latest;?>"><i class="big icon hdd"></i>
      <div class="header"><?php echo getSize(filesize(BASEPATH . 'admin/backups/' . $file));?></div>
      <div class="push-right"> <a class="delete" data-set='{"title": "<?php echo Core::$word->DELETE;?>", "parent": ".item", "option": "deleteBackup", "id": 1, "name": "<?php echo $file;?>"}'><i class="circular danger inverted trash icon link"></i></a> <a href="<?php echo ADMINURL . '/backups/' . $file;?>" data-content="<?php echo Core::$word->DOWNLOAD;?>"><i class="circular success inverted download disk icon link"></i></a> <a class="restore" data-content="<?php echo Core::$word->BK_RESTORE_DB;?>" data-file="<?php echo $file;?>"><i class="circular warning inverted refresh icon link"></i></a> </div>
      <div class="content"><?php echo str_replace(".sql", "", $file);?></div>
    </div>
    <?php endif;?>
    <?php endwhile;?>
    <?php $getDir->close();?>
  </div>
  <?php endif;?>
</div>
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
    $('a.restore').on('click', function () {
        var parent = $(this).closest('div.item');
        var id = $(this).data('file')
        var title = id;
        var text = "<div class=\"messi-warning\"><p><i class=\"icon warn danger sign\"></i></p><p><?php echo Core::$word->BK_DORESTORE1;?><br><strong><?php echo Core::$word->BK_DORESTORE2;?></strong></p></div>";
        new Messi(text, {
            title: "<?php echo Core::$word->BK_RESTORE_DB1;?>",
            modal: true,
            closeButton: true,
            buttons: [{
                id: 0,
                label: "<?php echo Core::$word->BK_RESTORE_DB;?>",
                val: 'Y',
				class: 'basic negative'
            }],
            callback: function (val) {
                if (val === "Y") {
					$.ajax({
						type: 'post',
						dataType: 'json',
						url: "controller.php",
						data: 'restoreBackup=' + id,
						success: function (json) {
							parent.effect('highlight', 1500);
							$.sticky(decodeURIComponent(json.message), {
								type: json.type,
								title: json.title
							});
						}
					});
                }
            }
        })
    });
});
// ]]>
</script>