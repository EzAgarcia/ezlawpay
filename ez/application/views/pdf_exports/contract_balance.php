<html>
  <head>
    <style>
      /** 
          Set the margins of the page to 0, so the footer and the header
          can be of the full height and width !
        **/
      @page {
        margin: 1.5cm 1.5cm;
      }

      /** Define now the real margins of every page in the PDF **/
      body {
        margin-top: 1.4cm;
        margin-left: 0px;
        margin-right: 0px;
        margin-bottom: 0px;
      }

      /** Define the header rules **/
      header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 2cm;

        /** Extra personal styles **/
        background-color: transparent;
        color: white;
        text-align: center;
        line-height: 1.5cm;
      }

      /** Define the footer rules **/
      footer {
        position: fixed; 
        bottom: 0cm; 
        left: 0cm; 
        right: 0cm;
        height: 2cm;

        /** Extra personal styles **/
        background-color: transparent;
        color: black;
        text-align: center;
        line-height: 1.5cm;
      }

      table {
      width: 100%;
      border-collapse: collapse;
      }
      .table-info{
        margin-top: 10px;
        width: 60%;
      }
      .row {
        margin-right: -15px;
        margin-left: -15px;
      }
      .text-center {
        text-align: center;
      }
      body {
        font-family: Helvetica, Arial, sans-serif;
        font-size: 11px;
        color: #333;
        background-color: #fff;
      }
      .th-total{
        background-color: #ffffff;
        color: black;
      }
      .th-header, .th-footer, .th-footer-total{
        background-color: #072457;
        color: white;
        text-align: center;
        height: 30px;
        font-size: 12px;
      }
      .th-header, .th-footer, .th-footer-total{
        background-color: #072457;
        color: white;
        font-weight: bold;
        text-align: center;
      }
      .th-footer-total {
        font-size: 16px;
        text-align: center;
      }
      td{
        text-align: center;
        font-size: 12px;
      }
      .td-bigger {
        text-align: center;
        font-weight: bold;
        font-size: 12px;
      }
      .box{
          display: -webkit-box;           
          display: -moz-box;         
          display: -ms-flexbox;      
          display: -webkit-flex;     
          display: flex;   
          width:   100%;
          height:  20px;
          padding-bottom: 20px;
          margin-top: 30px !important;
        }

      .box div {
        text-align:left;
        color:#000000;
        font-family: arial, sans-serif;
      }
      .left-box {
        width:   50%;
        float: left;
        display:inline-block;
      }
      .right-box {
        width:   50%;
        float: right;
        display:inline-block;
      }
      .row-title{
        text-align: left;
      }
      .row-info{
        text-align: right;
      }

      .logo{
        padding-bottom: 50px;
      }

      img {
        max-width: 40%;
        height: auto;
      }
      .logo-ez{
        max-width: 9%;
        height: auto;
        margin-top: -30px;
      }
      .powered{
        margin-top: 5px;
        margin-left: -70px;
      }
      .footer{
        margin-top: 35px;
        font-size: 12px;
        text-align: center;
      }
      .table-border {
        border-collapse: collapse;
      }
      .table-border, .th-border, .td-border {
        border: 1px solid black;
      }
      #imagencontainer {
        width:100%;
        height: 15%;
      }
      #leftcolumn {
        float:left;
        display:inline-block;
      }
      #contentwrapper {
        float:right;
        display:inline-block;
        margin-top: 17px;
      }
    </style>
</head>
<body>
<?php
$sum = array();
foreach($data['invoice'] as $amount){ array_push($sum, $amount->Pay_Amount); }
$subtotal = array_sum($sum);
$total = $data['contract']->Value - $subtotal;

function payment_method($type) {
  switch ($type) {
    case 1:
      return 'Cash';
    case 2:
      return 'Deposit';
    case 3:
      return 'Check';
    case 4:
      return 'Card';
    case 9:
      return 'Money Order';
    case 8:
      return 'Other';
    default:
      return 'No Found';
  }
}
?>

    <!-- Define header and footer blocks before your content -->
    <header>
    <div id="imagencontainer">
      <div id="leftcolumn" style="position; fixed; left: 10px; right: 10px; top: 10px;" class = "logo">
      <img src="<?php echo base_url()?>assets/img/Kostiv-bigger.png">
      </div>
      <div id="contentwrapper" style="position; fixed; left: 100px; right: 10px; top: 10px;" class = "logo">
      </div>
    </div>
    </header>

    <footer>
    <div class="footer">
      Kostiv & Associates
      3450 Wilshire Boulevard, Los Angeles, CA 90010,
      Telephone 213-309-9123
    </div>
    </footer>

    <!-- Wrap the content of your PDF inside a main tag -->
    <main>
    <div class="box">
      <div class = "left-box">
        <table class="table-info">
          <tbody>
              <tr class="client-info">
                <th class='row-title'>Contract Number:</th>
                <td class="row-info"><?php echo $data['contract']->Contract_N; ?></td>
              </tr>
            <tr class="client-info">
              <th class='row-title'>Name:</th>
              <td class="row-info"><?php echo $data['contract']->C_Name; ?></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class = "right-box">
        <table class="table-info">
          <tbody>
            <tr class="client-info">
              <th class='row-title'>Telephone:</th>
              <td class="row-info"><?php echo $data['contract']->Phone_Number; ?></td>
            </tr>
          </tbody>
        </table>
      </div>
      </div>

      <table class="table">
        <thead>
          <tr>
            <th scope="col" class="th-total"></th>
            <th scope="col" class="th-total"></th>
            <th scope="col" class="th-total"></th>
            <th scope="col" class="th-total"></th>
            <th scope="col" class="th-total"></th>
            <th scope="col" class="th-total">Contract Amount</th>
            <th scope="col" class="th-total"></th>
            <th scope="col" class="th-total"><?php echo '$ '.number_format($data['contract']->Value, 2, '.', ',') ?></th>
          </tr>
          <tr>
            <th scope="col" class="th-header">#</th>
            <th scope="col"  class="th-header">&nbsp;&nbsp;&nbsp;Date&nbsp;&nbsp;&nbsp;</th>
            <th scope="col" class="th-header">Payment Method</th>
            <th scope="col" class="th-header">Payment Description</th>
            <th scope="col" class="th-header">Transaction ID</th>
            <th class="th-header"></th>
            <th class="th-header"></th>
            <th class="th-header"></th>
          </tr>
        </thead>
        <?php $index = 1; ?>
        <?php foreach($data['invoice'] as $payment_data){ ?>
          <tbody>
            <tr>
              <th scope="row" class = "th-border"><?php echo  $index; ?></th>
              <td class = "td-bigger th-border"><?php echo  substr($payment_data->Date, 0, 10); ?></td>
              <td class = "th-border"><?php echo  payment_method($payment_data->Pay_Method); ?></td>
              <td class = "th-border"><?php echo  ($payment_data->Pay_Description); ?></td>
              <td class = "th-border"><?php echo  ($payment_data->Pay_Reference); ?></td>
              <td class = "th-border"></td>
              <td class = "td-bigger th-border"><?php echo  '$ '.number_format($payment_data->Pay_Amount, 2, '.', ','); ?></td>
              <td class = "th-border"></td>
            </tr>
          </tbody>
          <?php $index++; ?>
        <?php } ?>
          <tfoot>
          <tr>
            <th scope="col" class="th-footer"></th>
            <th scope="col" class="th-footer"></th>
            <th scope="col" class="th-footer"></th>
            <th scope="col" class="th-footer"></th>
            <th scope="col" class="th-footer"></th>
            <td scope="col" class="th-footer">Total Paid</td>
            <td scope="col" class="th-footer-total"><?php echo  '$ '.number_format($subtotal, 2, '.', ','); ?></td>
            <th scope="col" class="th-footer-total"></th>
          </tr>
          <tr>
            <th scope="col" class="th-footer"></th>
            <th scope="col" class="th-footer"></th>
            <th scope="col" class="th-footer"></th>
            <th scope="col" class="th-footer"></th>
            <th scope="col" class="th-footer"></th>
            <td scope="col" class="th-footer"></td>
            <td scope="col" class="th-footer">Balance</td>
            <th scope="col" class="th-footer-total"><?php echo '$ '.number_format($total, 2, '.', ','); ?></th>
          </tr>
        </tfoot>
      </table>
    </main>
  </body>
</html>
