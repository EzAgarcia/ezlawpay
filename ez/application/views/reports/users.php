<style type="text/css">
  .especial a{
    color: #000 !important;
    font-size: 13px;
  }
  .especial a i{
    margin-right: 10px
  }
  table {
    table-layout:fixed;
    font-size: 13.5px;
    font-family: 'Roboto', sans-serif;
    font-weight: 400;
    }
    table td {
      word-wrap: break-word;
      max-width: 400px;
      padding: 15px;
      text-align: center;
    }
    th{
      padding: 15px;
      text-align: center;
    }

    tr{
      padding: 15px;
      border-radius: 100px!important;
    }

    .odd {
      background-color: #f9f9f9!important;
    }

    .span{
      color: #fff;
      padding: 10px 25px;
      font-size: 11px;
    }
</style> 
<?php 
  $teamSalesToday     = $transactions['day'];
  $teamSalesThisweek  = $transactions['week'];
  $teamSalesThisMonth = $transactions['month'];
  $teamSalesThisYear  = $transactions['year'];
  $panels = [
    'week' => [
      'class'   => 'tab-pane fade',
      'id_name' => 'week',
      'data'    => $teamSalesThisweek
    ],
    'month' => [
      'class'   => 'tab-pane fade',
      'id_name' => 'month',
      'data'    => $teamSalesThisMonth
    ],
    'year' => [
      'class'   => 'tab-pane',
      'id_name' => 'year',
      'data'    => $teamSalesThisYear
    ],
 ];
?>
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/datatables/style.css" type="text/css">
<ul class="nav nav-tabs especial" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="pills-today-tab" data-toggle="pill" href="#pills-today" role="tab" aria-controls="pills-today" aria-selected="true">Today</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pills-week-tab" data-toggle="pill" href="#pills-week" role="tab" aria-controls="pills-week" aria-selected="false">This Week</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pills-month-tab" data-toggle="pill" href="#pills-month" role="tab" aria-controls="pills-month" aria-selected="false">This Month</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pills-year-tab" data-toggle="pill" href="#pills-year" role="tab" aria-controls="pills-year" aria-selected="false">This Year</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
<div class="tab-pane fade show active" id="pills-today" role="tabpanel" aria-labelledby="pills-today-tab">
    <div class="card" style="border: none">
      <div class="card-body">
        <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
          <thead>
            <tr>
              <th>Type</th>
              <th>Total Collected</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($teamSalesToday as $type => $totals) { ?>
              <?php foreach ($totals as $total) { ?>
                <tr>
                  <td><?php print($type); ?></td>
                  <td><?php print('$'.number_format($total->amount).'.00'); ?></td>
                </tr>
            <?php }} ?>
          </tbody>
          <tfoot>
              <tr>
                <th></th>
                <th></th>
              </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
  <?php foreach ($panels as $key => $data) { ?>
    <div class=<?php print($data['class']); ?> id="pills-<?php print($key); ?>" role="tabpanel" aria-labelledby="pills-<?php print_r($key); ?>-tab">
      <div class="card" style="border: none">
        <div class="card-body">
          <table id=<?php print($data['id_name']); ?> class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
            <thead>
              <tr>
                <th>Type</th>
                <th>Total Collected</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($data['data'] as $type => $totals) { ?>
                <?php foreach ($totals as $total) { ?>
                  <tr>
                    <td><?php print($type); ?></td>
                    <td><?php print('$'.number_format($total->amount).'.00'); ?></td>
                  </tr>
              <?php }} ?>
            </tbody>
            <tfoot>
                <tr>
                  <th></th>
                  <th></th>
                </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  <?php } ?>
</div>
<script type="text/javascript">
$(document).ready(function() {
  var tables = ['#example', '#week', '#month', '#year'];
  tables.forEach(createTables)
} );

function createTables(table_name) {
  $(table_name).DataTable({
    "footerCallback": function ( row, data, start, end, display ) {
      var api = this.api(), data;
      var intVal = function (i) { return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0; };
      var total = api.column(1).data().reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );
      
      $(api.column(0).footer() ).html('Total');
      $(api.column(1).footer() ).html(moneyFormat(total));
    },
  })
}

function moneyFormat(amount) {
  return amount.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
}
</script>