<?php
  /**
   * Pdf Form
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php if($row):?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo Core::$word->INVOICE;?></title>
<style type="text/css">
body {
  background-color: #fff;
  color: #333;
  font-family: DejaVu Serif, Helvetica, Times-Roman;
  font-size: 1em;
  margin: 0;
  padding: 0
}
table {
  font-size: 75%;
  width: 100%;
  border-collapse: separate;
  border-spacing: 2px
}
th,
td {
  position: relative;
  text-align: left;
  border-radius: .25em;
  border-style: solid;
  border-width: 1px;
  padding: .5em
}
th {
  background: #EEE;
  border-color: #BBB
}
td {
  border-color: #DDD
}
h1 {
  font: bold 100% sans-serif;
  letter-spacing: .5em;
  text-align: center;
  text-transform: uppercase
}
table.inventory {
  clear: both;
  width: 100%
}
table.inventory th,
table.payments th {
  font-weight: 700;
  text-align: center
}
table.inventory td:nth-child(1) {
  width: 52%
}
table.payments {
  padding-top: 20px
}
table.balance th,
table.balance td {
  width: 50%
}
.green {
  background-color: #D5EEBE;
  color: #689340
}
.blue {
  background-color: #D0EBFB;
  color: #4995B1
}
.red {
  background-color: #FAD0D0;
  color: #AF4C4C
}
.yellow {
  background-color: #FFC;
  color: #BBB840
}
#aside {
  padding-top: 30px;
  font-size: 65%
}
small {
  font-size: 75%;
  line-height: 1.5em
}
table.inventory td.right {
  text-align: right;
  width: 12%
}
table.payments td.right,
table.balance td {
  text-align: right
}
#footer {
  position: fixed;
  bottom: 0px;
  left: 0px;
  right: 0px;
  height: 100px;
  text-align: center;
  border-top: 2px solid #eee;
  font-size: 85%;
  padding-top: 5px
}
</style>
</head>
<body>
<table border="0">
  <tr>
    <td style="width: 60%;" valign="top"><?php if (Registry::get("Core")->logo):?>
      <img alt="" src="<?php echo UPLOADS . Registry::get("Core")->logo;?>">
      <?php else:?>
      <?php echo Registry::get("Core")->site_name;?>
      <?php endif;?></td>
    <td valign="top" style="width:40%;text-align: right"><h4 style="margin:0px;padding:0px;font-size: 12px;">Invoice: #<?php echo $row->invid;?></h4>
      <h4 style="margin:0px;padding:0px;font-size: 12px;"><?php echo Filter::dodate("short_date", $row->date);?></h4></td>
  </tr>
</table>
<div style="background-color:#ddd;height:1px">&nbsp;</div>
<table style="padding-top:25px">
  <tr>
    <td valign="top" style="width:60%">Payment To</td>
    <td colspan="2" valign="top" style="width:40%">Bill To</td>
  </tr>
  <tr>
    <td valign="top" style="width:60%"><p><?php echo cleanOut(Registry::get("Core")->inv_info);?></p></td>
    <td colspan="2" valign="top" style="width:40%"><p><?php echo $usr->fname;?> <?php echo $usr->lname;?><br />
        <?php echo $usr->address;?><br />
        <?php echo $usr->city.', '.$usr->state.' '.$usr->zip;?><br />
        <?php echo $usr->country;?></p></td>
  </tr>
  <tr>
    <td valign="top" style="width:60%"><br /></td>
    <td valign="top" style="width:20%">Amount Due:<br />
      Due Date:</td>
    <td valign="top" style="width:20%"><?php echo Registry::get("Core")->formatMoney($row->total);?><br />
      <?php echo Filter::dodate("short_date", $row->date);?></td>
  </tr>
</table>
<div style="height:20px"></div>
<table class="inventory">
  <thead>
    <tr>
      <th><span>Invoice Items</span></th>
      <th><span>Total</span></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><span><?php echo $row->title;?> <small>(<?php echo $row->description;?>)</small></span></td>
      <td class="right"><span><?php echo $row->rate_amount;?></span></td>
    </tr>
    <tr>
      <td align="right">Discount/Coupon:</td>
      <td align="right">- <?php echo number_format($row->coupon, 2);?></td>
    </tr>
  </tbody>
</table>
<table class="balance">
  <tr>
    <th><span>Subtotal</span></th>
    <td><span><?php echo number_format($row->total - $row->coupon - $row->tax, 2);?></span></td>
  </tr>
  <tr>
    <th><span>Taxes</span></th>
    <td><span><?php echo $row->tax;?></span></td>
  </tr>
  <tr>
    <th><span>Grand Total</span></th>
    <td><span><?php echo $row->total;?> <?php echo $row->currency;?></span></td>
  </tr>
  <tr>
    <th>Status</th>
    <td class="green">Paid</td>
  </tr>
</table>
<div id="footer">
  <h1><span>Additional Notes</span></h1>
  <div>
    <p><small class="extra"><?php echo cleanOut(Registry::get("Core")->inv_note);?></small></p>
  </div>
</div>
</body>
</html>
<?php else:?>
<?php die('<h1 style="text-align:center">You have selected invalid invoice</h1>');?>
<?php endif;?>