<?php
  /**
   * Language Manager
   *
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php $xmlel = simplexml_load_file(BASEPATH . Core::langdir . "/lang.xml");?>
<?php $sections = Core::getSections();?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->N_LANGM;?></div>
</div>
<div class="wojo basic form segment">
  <div class="wojo header"><span><?php echo Core::$word->LMG_TITLE;?></span>
    <p><?php echo Core::$word->LMG_INFO;?></p>
  </div>
  <div class="wojo content">
    <div class="two fields fitted">
      <div class="field">
        <div class="wojo icon input">
          <input id="filter" type="text" placeholder="<?php echo Core::$word->SEARCH;?>">
          <i class="search icon"></i> </div>
      </div>
      <div class="field">
        <select id="group" name="group">
          <option value="all"><?php echo Core::$word->LMG_RESET;?></option>
          <?php asort($sections);?>
          <?php foreach($sections as $row):?>
          <option value="<?php echo $row;?>"><?php echo $row;?></option>
          <?php endforeach;?>
        </select>
      </div>
    </div>
  </div>
</div>
<div class="wojo basic segment">
  <table class="wojo basic table" id="editable">
    <thead>
      <tr>
        <th class="one wide">#</th>
        <th class="four wide"><?php echo Core::$word->LMG_KEY;?></th>
        <th class="eleven wide"><?php echo Core::$word->LMG_VALUE;?></th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 1;?>
      <?php foreach ($xmlel as $pkey) :?>
      <tr>
        <td><small class="wojo label"><?php echo $i++;?>.</small></td>
        <td><?php echo $pkey['data'];?></td>
        <td data-editable="true" data-set='{"type": "phrase", "id": <?php echo $i++;?>,"key":"<?php echo $pkey['data'];?>", "path":"lang"}'><?php echo $pkey;?></td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
</div>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function () {
    /* == Filter == */
    $("#filter").on("keyup", function () {
        var filter = $(this).val(),
            count = 0;
        $("td[data-editable=true]").each(function () {
            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                $(this).parent().fadeOut();
            } else {
                $(this).parent().show();
                count++;
            }
        });
    });

    /* == Group Filter == */
    $('#group').change(function () {
        var sel = $(this).val();
		var type = $("#group option:selected").data('type');
        $("#langsegment").addClass('loading');
        $.ajax({
            type: "get",
            url: ADMINURL + "/controller.php",
            dataType: 'json',
            data: {
                'loadLangSection': 1,
				'section': sel
            },
            beforeSend: function () {},
            success: function (json) {
                if (json.status == "success") {
                    $("#editable tbody").html(json.message).fadeIn("slow");
					$('#editable').editableTableWidget();
                } else {
                    $.sticky(decodeURIComponent(json.message), {
                        type: "error",
                        title: json.title
                    });
                }
				$("#langsegment").removeClass('loading');
            }
        })
    });
});
// ]]>
</script> 