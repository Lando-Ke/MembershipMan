<?php
  /**
   * Transactions
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php $transrow = $member->getPayments();?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->N_TXN;?></div>
</div>
<div class="wojo form basic segment">
  <div class="wojo header"> <a href="controller.php?exportTransactions" class="push-right wojo basic button"><i class="icon table"></i><?php echo Core::$word->TX_EXPORT;?></a> <span><?php echo Core::$word->TX_TITLE;?></span>
    <p><?php echo Core::$word->TX_INFO1;?></p>
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
          <input type="text" name="transsearch" placeholder="<?php echo Core::$word->SEARCH;?>" id="searchfield">
          <i class="search icon"></i>
          <div id="suggestions"></div>
        </div>
      </div>
      <div class="field"></div>
      <div class="field"> <?php echo $pager->jump_menu();?> </div>
    </div>
  </div>
  <div class="content-center wojo footer"><?php echo alphaBits("index.php?do=transactions", "letter", "wojo small pagination menu");?></div>
</div>
<div class="wojo basic segment">
  <table class="wojo sortable table">
    <thead>
      <tr>
        <th data-sort="int">#</th>
        <th data-sort="string"><?php echo Core::$word->MM_TTITLE;?></th>
        <th data-sort="string"><?php echo Core::$word->USERNAME;?></th>
        <th data-sort="int"><?php echo Core::$word->TX_AMOUNT;?></th>
        <th data-sort="int"><?php echo Core::$word->CREATED;?></th>
        <th data-sort="string"><?php echo Core::$word->TX_PP;?></th>
        <th class="disabled"><?php echo Core::$word->ACTIONS;?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(!$transrow):?>
      <tr>
        <td colspan="7"><?php echo Filter::msgSingleAlert(Core::$word->TX_NOTRANS);?></td>
      </tr>
      <?php else:?>
      <?php foreach ($transrow as $row):?>
      <tr>
        <td><small class="wojo label"><?php echo $row->id;;?>.</small></td>
        <td><?php echo $row->title;?></td>
        <td><a href="index.php?do=users&amp;action=edit&amp;id=<?php echo $row->user_id;?>"><?php echo $row->username;?></a></td>
        <td><?php echo $core->formatMoney($row->rate_amount);?></td>
        <td data-sort-value="<?php echo strtotime($row->created);?>"><?php echo Filter::dodate("short_date", $row->created);?></td>
        <td><?php echo $row->pp;?></td>
        <td><?php if($row->status == 1):?>
          <i class="circular inverted black icon check"></i>
          <?php else:?>
          <i class="circular inverted black icon time"></i>
          <?php endif;?>
          <a class="delete" data-set='{"title": "<?php echo Core::$word->DELETE . ' ' . Core::$word->TRANSACTION;?>", "parent": "tr", "option": "deleteTransaction", "id": <?php echo $row->id;?>, "name": "<?php echo $row->created;?>"}'><i class="circular danger inverted trash icon link"></i></a></td>
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