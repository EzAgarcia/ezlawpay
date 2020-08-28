<div class="loading" id="loading2" style="top: 0; margin: 0; float: left; left: 0; position:  fixed;display: none;">
  <center><img src="<?php echo base_url()?>assets/img/loading.svg"></center>
</div> 

<style type="text/css">
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
select {
  margin-left: 5px;
  width: 30%!important;
  border-radius: 5px;
}

.status {
  font-size: 15px;
  font-family: 'Roboto', sans-serif;
  font-weight: 500;
  color: #2c365d;
}

.dpr {
  font-size: 15px;
  font-family: 'Roboto', sans-serif;
  color: red;
}
.dpk {
    font-size: 15px;
    font-family: 'Roboto', sans-serif;
    color: green;
}

.ccolor{
  color: #17a2b8!important;
}

.mods{
  font-size: 15px!important;
}

.changeMonth, .changeYear {
  width: 80px!important;
}

.changeStatus {
  width: 80px!important;
}
.fa-dropdown-item {
  float: right;
  margin-top: -2.6rem;
  font-size: 1.2rem;
}
.warning-balance {
  font-size: .968rem;
  height: 3.5rem;
  color: gray;
}
.warning-balance:hover {
  font-size: .968rem;
  height: 3.5rem;
  color: gray;
}
</style>
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/datatables/style.css" type="text/css">
<div ></div>
<!-- <button type="button" class="btn btn-success" data-toggle="modal" data-target="#general_modal" onclick="add_contract()"><i class="btn btn-success"></i> New Contract</button> -->

<?php if ($_SESSION['ezlow']['profile'] != 3) { ?>
<input type="button" class="btn btn-success" onclick="location.href='<?php echo site_url('newview') ?>' " value="New Contract" name="boton" /> 
<?php } ?>
<div ></div>
<br>
<label for="month-select">Select a Date</label>
<select class="changeMonth" id="month-select">
    <option value="">Month</option>
    <option value="01">Jan</option>
    <option value="02">Feb</option>
    <option value="03">Mar</option>
    <option value="04">Apr</option>
    <option value="05">May</option>
    <option value="06">Jun</option>
    <option value="07">Jul</option>
    <option value="08">Aug</option>
    <option value="09">Sep</option>
    <option value="10">Oct</option>
    <option value="11">Nov</option>
    <option value="12">Dec</option>
</select>
<select class="changeYear" id="year-select">
    <option value="">Year</option>
</select>
<br>
<label for="status-select">Select</label>
<select id="status-select" class="changeStatus">
  <option value="">All</option>
  <option>Paid in full</option>
  <option>On hold</option>
  <option>Up to date</option>
  <option>Overdue</option>
  <option>Suspended</option>
  <option>Cancelled</option>
  <option>PI</option>
</select>
<br> <br>
 <table id="contracts" class="table table-bordered" style="width:100%; border-radius: 5px; ">
<thead>
    <tr>
      <th>Status</th>
      <th>Contract Number</th>
      <th>Client</th>
      <th>Date Sign</th>
      <th>Contract Amount</th>
      <th>Current Balance</th>
      <th>Receivable Amount</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  </tbody>
  <tfoot>
    <tr>
      <th>Status</th>
      <th>Contract Number</th>
      <th>Client</th>
      <th>Date Sign</th>
      <th>Contract Amount</th>
      <th>Current Balance</th>
      <th>Receivable Amount</th>
      <th></th>
    </tr>
  </tfoot>
</table>

<script>
$(document).ready(function() {
  var default_data =  current_data_date()
  $('#contracts').DataTable( {
    "aaSorting": [],
    "processing": true,
    "serverSide": true,
    "ajax": {
      url: '<?php echo base_url()?>' + 'contract_table_list',
      type: 'POST',
      data: default_data
    },
    "columnDefs": [ {
      "targets": 0,
      "data": null,
      "render": function ( data, type, row, meta ) {

        if ("<?php echo $_SESSION['ezlow']['profile']; ?>" != 3) {
            return '<div style="cursor: pointer" class="ccolor" data-toggle="modal" data-target="#general_modal" onclick="cambiaStatus(' + row[7] +');">' + row[0] +'</div>'
         }else{
            return '<div>' + row[0] +'</div>';
         }
        
      }},
      {
      "targets": 2,
      "data": null,
      "render": function ( data, type, row, meta ) {
        return '<div style="cursor: pointer" class="ccolor" data-toggle="modal" data-target="#general_modal" onclick="showContract(' + row[7] +');">' + row[2] +'</div>'
      }},
      {
      "targets": 3,
      "data": null,
      "render": function ( data, type, row, meta ) {
        return date_time_format(row[3])
      }},
      {
      "targets": -1,
      "data": null,
      "render": function ( data, type, row, meta ) {
        return edit_tools(row[7], row[8])
      }
    }]
  });
});

function date_time_format($date) {
  var d = $date.slice(0, 10).split('-');   
  return d[1] +'-'+ d[2] +'-'+ d[0];
}

function current_data_date(){
  var current_date = new Date();
  var year   = (selectedParam('year') === "undefined") || (selectedParam('year')  === "") ? '' : selectedParam('year');
  var month  = (selectedParam('month') === "undefined") || (selectedParam('month')  === "") ? '' : selectedParam('month');
  var status = (selectedParam('status') === "undefined") || (selectedParam('status')  === "") ? '' : selectedParam('status');
  var data = {};

  if(status != ''){ data['status'] = status }
  if(month != ''){ data['month'] = month }
  if(year != ''){ data['year'] = year }

  return data
}

$(document).ready(function() {
  $('#year-select').val(selectedParam('year'));
  $('#month-select').val(selectedParam('month'));
  $('#status-select').val(selectedParam('status'));

  $('select.changeMonth').change(function(){
    var month  = $(this).val();
    var year   =  $('select.changeYear').val();
    var status =  $('select.changeStatus').val();
    reload(month, year, status);
  });

  $('select.changeStatus').change(function(){
    var month  = $('select.changeMonth').val();
    var year   = $('select.changeYear').val();
    var status = $(this).val();
    reload(month, year, status);
  });

  $('select.changeYear').change(function(){
    var year   = $(this).val();
    var month  =  $('select.changeMonth').val();
    var status =  $('select.changeStatus').val();
    reload(month, year, status);
  });

  function reload(raw_month, raw_year, raw_status){
    var current_date = new Date();
    var current_year = current_date.getFullYear();
    var current_month = current_date.getMonth();

    var month  = (typeof raw_month  !== "undefined") || (raw_month  === "") ? raw_month : current_month;
    var year   = (typeof raw_year   !== "undefined") || (raw_year  === "") ? raw_year : current_year;
    var status = (typeof raw_status !== "undefined") || (raw_status  === "") ? raw_status : '';
    raw_url = '<?php echo base_url()?>' + 'contrac?month=' + month + '&year=' + year;

    status_url = status === ''  || status === null ? raw_url : raw_url + '&status=' + status;
    document.location =  status_url;
  }
});

year =  new Date().getFullYear();
var initial_contrat_year = 2016;
for (var i = initial_contrat_year; i <= (year); i++){ $('.changeYear').append($('<option />').val(i).html(i)); }

function selectedParam(param) {
  var uriParam = getUrlVars(param);
  if (Object.entries(uriParam).length === 0 && uriParam.constructor === Object) return  '';
  var urlParam = decodeURI(uriParam[param]);

  return urlParam
}

function getUrlVars() {
  var vars = {};
  var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
      vars[key] = value;
  });
  return vars;
}
 
function edit_tools(contract, balance_status) {
  var button            = '<div class="btn-group dropleft">';
  var button_style      = '<button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-list-ul" ></i></button>';
  var menu              = '<div class="dropdown-menu">';
  var edit              = '<a  href="' + '<?php echo base_url() ?>' + 'C_contracts/modificontract/'+contract+ '" class="dropdown-item mods">Edit</a>';
  var addnote              = '<a class="dropdown-item mods" data-toggle="modal" data-target="#general_modal" onclick="addnota('+contract+');">Add Note</a>';
  var update_amount     = '<a style="cursor: pointer" class="dropdown-item mods" onclick="actualizarin('+contract+')">Actualizar Montos</a>';

  var contractuk = '<a style="cursor: pointer" class="dropdown-item mods"  onclick="cambiars('+contract+');">Add to Contracts Uk</a>';

  var update_invoice     = '<a style="cursor: pointer" class="dropdown-item mods" onclick="actualizarinvoices('+contract+')">Actualizar Invoices</a>';
  var send_balance_link = '<a style="cursor: pointer" class="dropdown-item mods" data-toggle="modal" data-target="#general_modal" onclick="sendBalanceLink('+contract+');">Send Balance Link</a>';
  var reset_password    = '<!-- <a class="dropdown-item" onclick="reset('+contract+')">Reset Password</a>';
  var delete_contract   = '<a class="dropdown-item" onclick="elim('+contract+')">Delete</a> -->';
  var close_button      = '</div></div>';
  var warnnin_message   = 'Cannot be sent, the balance is not yet processed'
  var warning_balance   = '<div style="cursor: pointer" class="dropdown-item warning-balance class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title="'+ warnnin_message + '""><p>Send Balance Link<p><i class="fas fa-exclamation-circle fa-dropdown-item"></i><div>'
  var balance_message   = balance_status > 0 ? send_balance_link : warning_balance;


   if ("<?php echo $_SESSION['ezlow']['profile']; ?>" != 3) {
    return button + button_style + menu + edit + addnote + update_amount + update_invoice + contractuk + send_balance_link + reset_password + delete_contract + close_button;
   }else{
      return '';
   }
 
}

function add_contract() {
$.ajax({
  url: "<?php echo site_url('newcontrac');?>",
  type:"POST",
  dataType:"html",
}).done(function(data) {
    $(".modal-body").html(data);
  });
}

function showContract(ok){
  $.ajax({
    data: {ok: ok},
    url: "<?php echo site_url('showContract');?>",
    type:"POST",
    dataType:"html",
  }).done(function(data) {
    $(".modal-body").html(data);
  });
}  


function cambiaStatus(id){

  $.ajax({
    data: {id: id},
    url: "<?php echo site_url('cambiaestatus');?>",
    type:"POST",
    dataType:"html",
  }).done(function(data) {
    $(".modal-body").html(data);
  });
} 

function addnota(id){


  $.ajax({
    data: {id: id},
    url: "<?php echo site_url('C_contracts/addnota');?>",
    type:"POST",
    dataType:"html",
  }).done(function(data) {
    $(".modal-body").html(data);
  });
} 

function actualizarin(id){
  $.post( "<?php echo base_url()?>C_contracts/actualizarin",{id:id}, function( data ) {
    if (data !='SI'){
    }

    location.reload();
  });
}

function cambiars(id){

  $.ajax({
    data: {id: id},
    url: "<?php echo site_url('C_contracts/agregarcomouk');?>",
    type:"POST",
    success:function(response){

        Swal.fire({
              title: 'Done!',
              text:  'Added as Contract Uk!',
              icon:  'success'
            }).then((result) => {
                location.reload();
             })

    }

  })
}


function actualizarinvoices(id){
  $.post( "<?php echo base_url()?>C_contracts/billstts",{id:id}, function( data ) {

  });
}  



function sendBalanceLink(id){
  $.ajax({
    data: {id: id},
    url: "<?php echo base_url()?>message_balance_link/" + id,
    type:'GET',
    dataType:'html',
  }).done(function(data) {
    $(".modal-body").html(data);
    $('#empModal').modal('show'); 
  });
}   
</script>
