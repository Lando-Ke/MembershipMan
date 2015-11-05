<?php
  /**
   * User Statistics
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<div class="wojo breadcrumb"> <i class="icon home"></i> <a href="index.php" class="section"><?php echo Core::$word->N_DASH;?></a>
  <div class="divider"></div>
  <a href="index.php?do=users" class="section"><?php echo Core::$word->N_USERS;?></a>
  <div class="divider"></div>
  <div class="active section"><?php echo Core::$word->UR_TITLE4;?></div>
</div>
<div class="wojo basic segment">
  <div class="wojo header">
    <div class="wojo right pointing dropdown push-right" data-select-range="true"> <i class="rounded inverted black reorder link icon"></i>
      <div class="menu">
        <div class="item" data-value="all"><?php echo Core::$word->THIS_ALL;?></div>
        <div class="item" data-value="day"><?php echo Core::$word->TODAY;?></div>
        <div class="item" data-value="week"><?php echo Core::$word->THIS_WEEK;?></div>
        <div class="item" data-value="month"><?php echo Core::$word->THIS_MONTH;?></div>
        <div class="item" data-value="year"><?php echo Core::$word->THIS_YEAR;?></div>
      </div>
    </div>
    <span><?php echo Core::$word->UR_TITLE4;?></span>
    <p><?php echo Core::$word->UR_INFO4;?></p>
  </div>
  <div class="wojo content">
    <div id="chart" style="height:600px;overflow:hidden"></div>
  </div>
  <div class="wojo header"><span><?php echo Core::$word->UR_MAP_OVERLAY;?></span></div>
  <div class="wojo content">
    <div id="map">wait...</div>
  </div>
</div>
<script type='text/javascript' src="<?php echo $protocol;?>://www.google.com/jsapi"></script> 
<script type="text/javascript" src="<?php echo SITEURL;?>/assets/js/jquery.flot.min.js"></script> 
<script type="text/javascript" src="<?php echo SITEURL;?>/assets/js/jquery.flot.resize.min.js"></script> 
<script type="text/javascript" src="<?php echo SITEURL;?>/assets/js/excanvas.min.js"></script> 
<script type="text/javascript" src="<?php echo SITEURL;?>/assets/js/jquery.flot.spline.js"></script> 
<script type='text/javascript'>
  google.load('visualization', '1', {
      'packages': ['geochart']
  });
  google.setOnLoadCallback(drawRegionsMap);

  function drawRegionsMap() {
      $.ajax({
          url: ADMINURL + "/controller.php?getAccCountries",
          dataType: "json"
      }).done(function(result) {
          var data = new google.visualization.DataTable();
          data.addColumn('string', '<?php echo Core::$word->UR_COUNTRY;?>');
          data.addColumn('number', '<?php echo Core::$word->POPULARITY;?>');
          for (i = 0; i < result.country_name.length; i++)
              data.addRow([result.country_name[i], result.hits[i]]);

          var chart = new google.visualization.GeoChart(
              document.getElementById('map'));
          chart.draw(data, options);
          var geochart = new google.visualization.GeoChart(
              document.getElementById('map'));
          var options = {
              width: "auto",
              height: 600,
			  backgroundColor:"transparent",
              colorAxis: {
                  colors: ['#a3bdd8', '#4d76a4']
              } // Map Colors 
          };
          geochart.draw(data, options);
      });
  };

  function getRegistration(range) {
      $.ajax({
          type: 'GET',
          url: "controller.php?getAccStats=1&timerange=" + range,
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

          $.plot($('#chart'), [json.regs], option);
      });

  }
  getRegistration('all');
  $("[data-select-range]").on('click', '.item', function() {
      v = $(this).data('value');
      getRegistration(v)
  });
</script> 