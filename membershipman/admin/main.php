<?php
  /**
   * Main
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php $reports = $core->yearlyStats();?>
<?php $row = $core->getYearlySummary();?>
<div class="wojo breadcrumb">
  <div class="active section"><i class="icon home"></i> <?php echo Core::$word->N_DASH;?></div>
</div>
<div class="wojo form basic segment">
  <div class="wojo header">
    <div class="wojo right pointing dropdown push-right" data-select-range="true"> <i class="rounded inverted black reorder link icon"></i>
      <div class="menu">
        <div class="item" data-value="day"><?php echo Core::$word->TODAY;?></div>
        <div class="item" data-value="week"><?php echo Core::$word->THIS_WEEK;?></div>
        <div class="item" data-value="month"><?php echo Core::$word->THIS_MONTH;?></div>
        <div class="item" data-value="year"><?php echo Core::$word->THIS_YEAR;?></div>
      </div>
    </div>
    <span><?php echo Core::$word->AD_TITLE;?></span>
    <p><?php echo Core::$word->AD_INFO;?></p>
  </div>
  <div class="wojo content">
    <div class="columns small-gutters">
      <div class="screen-25 tablet-50 phone-100">
        <div class="wojo tertiary segment">
          <div class="columns">
            <div class="screen-30"><i class="circular big inverted success users icon"></i> </div>
            <div class="screen-70">
              <div class="wojo caps"><?php echo Core::$word->AD_RUSER;?></div>
              <div class="wojo big font success label"><?php echo countEntries(Users::uTable);?></div>
            </div>
          </div>
        </div>
      </div>
      <div class="screen-25 tablet-50 phone-100">
        <div class="wojo tertiary segment">
          <div class="columns">
            <div class="screen-30"><i class="circular big inverted info user icon"></i> </div>
            <div class="screen-70">
              <div class="wojo caps"><?php echo Core::$word->AD_AUSER;?></div>
              <div class="wojo big font info label"><?php echo countEntries(Users::uTable, "active", "y");?></div>
            </div>
          </div>
        </div>
      </div>
      <div class="screen-25 tablet-50 phone-100">
        <div class="wojo tertiary segment">
          <div class="columns">
            <div class="screen-30"><i class="circular big inverted danger send icon"></i> </div>
            <div class="screen-70">
              <div class="wojo caps"><?php echo Core::$word->AD_PUSER;?></div>
              <div class="wojo big font negative label"><?php echo countEntries(Users::uTable, "active", "t");?></div>
            </div>
          </div>
        </div>
      </div>
      <div class="screen-25 tablet-50 phone-100">
        <div class="wojo tertiary segment">
          <div class="columns">
            <div class="screen-30"><i class="circular big inverted warning ticket icon"></i> </div>
            <div class="screen-70">
              <div class="wojo caps"><?php echo Core::$word->AD_AMEM;?></div>
              <div class="wojo big font warning label"><?php echo countEntries(Users::uTable, "membership_id", "<>0");?></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Start Chart -->
    <div id="chart" style="height:400px"></div>
    <!-- End Chart /-->
    <div class="wojo divider"></div>
    <!-- Start Revenue List-->
    <table class="wojo basic table">
      <thead>
        <tr>
          <th><?php echo Core::$word->AD_MY;?></th>
          <th>#<?php echo Core::$word->AD_TRX;?></th>
          <th><?php echo Core::$word->AD_TINCOME;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$reports):?>
        <tr>
          <td colspan="3"><?php echo Filter::msgSingleAlert(Core::$word->TX_NOTRANS);?></td>
        </tr>
        <?php else:?>
        <?php foreach($reports as $report):?>
        <tr>
          <td><?php echo date("F", mktime(0, 0, 0, $report->month, 10)) . ' / '.$core->year;?></td>
          <td><small class="wojo info label"><?php echo $report->total;?></small></td>
          <td><?php echo $core->formatMoney($report->totalprice);?></td>
        </tr>
        <?php endforeach ?>
        <tr class="positive">
          <td><?php echo Core::$word->AD_TYEAR;?></td>
          <td><small class="wojo label"><?php echo $row->total;?></small></td>
          <td><?php echo $core->formatMoney($row->totalprice);?></td>
        </tr>
        <?php unset($report);?>
        <?php endif;?>
      </tbody>
    </table>
    <!-- End Revenue List--> 
  </div>
</div>
<script type="text/javascript" src="<?php echo SITEURL;?>/assets/js/jquery.flot.min.js"></script> 
<script type="text/javascript" src="<?php echo SITEURL;?>/assets/js/jquery.flot.resize.min.js"></script> 
<script type="text/javascript" src="<?php echo SITEURL;?>/assets/js/excanvas.min.js"></script> 
<script type="text/javascript" src="<?php echo SITEURL;?>/assets/js/jquery.flot.spline.js"></script> 
<script type="text/javascript">
// <![CDATA[
  function getChart(range) {
      $.ajax({
          type: 'GET',
          url: "controller.php?getSaleStats=1&timerange=" + range,
          dataType: 'json',
          async: false,
      }).done(function(json) {
          var option = {
              series: {
                  lines: {
                      show: false
                  },
                  splines: {
                      show: true,
                      tension: 0.4,
                      lineWidth: 1,
                      fill: 0.3
                  },
                  shadowSize: 0
              },
              points: {
                  show: true,
              },
              grid: {
                  hoverable: true,
                  clickable: true,
                  borderColor: "#a3bdd8",
                  borderWidth: 1,
                  labelMargin: 10,
                  backgroundColor: '#fff'
              },
              yaxis: {
                  color: "#a3bdd8",
                  font: {
                      color: "#3e4e5d"
                  }
              },
              xaxis: {
                  color: "#a3bdd8",
                  ticks: json.xaxis,
                  font: {
                      color: "#3e4e5d"
                  }
              },
              legend: {
                  backgroundColor: "#fff",
                  labelBoxBorderColor: "",
                  backgroundOpacity: .75,
                  noColumns: 1,
              }
          }

          $.plot($('#chart'), [json.order], option);
      });

  }
  getChart('year');
  $("[data-select-range]").on('click', '.item', function() {
      v = $(this).data('value');
      getChart(v)
  });
// ]]>
</script> 