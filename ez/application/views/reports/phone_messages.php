
 <div class="loading" id="loading2" style="top: 0; margin: 0; float: left; left: 0; position:  fixed;display: none;">
  <center>
    <img src="<?php echo base_url()?>assets/img/loading.svg">
  </center>
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

.status{
  font-size: 15px;
  font-family: 'Roboto', sans-serif;
  font-weight: 500;
  color: #2c365d;
}
.dpr{
  font-size: 15px;
  font-family: 'Roboto', sans-serif;
  color: red;
}
.dpk{
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
.changeMonth, .changeYear, .changeDay{
  width: 90px!important;
}
.changeType{
  width: 100px!important;
}
</style>
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/datatables/style.css" type="text/css">
<div>
  <label for="day-select">Select a Date</label>
  <select class="changeDay" name="changeDay" id="day-select">
    <option value="">Day</option>
  </select>
  <select name="changeMonth" class="changeMonth" id="month-select">
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
  <select class="changeYear" name="changeYear" id="year-select">
    <option value="">Year</option>
  </select>
  <select name="changeType" class="changeType" id="type-select">
    <option value="">Date Type</option>
    <option value="Date_Payment">Due Date</option>
    <option value="Created_at">Send Date</option>
  </select>
</div>
<table id="messages" class="table table-bordered" style="width:100%; border-radius: 5px; ">
    <thead>
        <tr>
            <th>Name</th>
            <th>Contract Number</th>
            <th>Due Date</th>
            <th>Send Date</th>
            <th>Status</th>
            <th>Message</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
        <tr>
            <th>Name</th>
            <th>Contract Number</th>
            <th>Due Date</th>
            <th>Send Date</th>
            <th>Status</th>
            <th>Message</th>
        </tr>
    </tfoot>
</table>

<script>    
$(document).ready(function() {
  $('#messages').DataTable( {
    "aaSorting": [],
    "processing": true,
    "serverSide": true,
    "ajax": {
      url: '<?php echo base_url()?>' + 'message_list',
      type: 'POST',
      data: { month: selectedParam('month'), year: selectedParam('year'), day: selectedParam('day'), type:  selectedParam('type')}
    },
    "columnDefs": [
      {
      "targets": -3,
      "data": null,
      "render": function ( data, type, row, meta ) {
        return row[4].slice(0, 10)
      }},{
      "targets": -2,
      "data": null,
      "render": function ( data, type, row, meta ) {
        return '<div>' + sentMessage(row[3], row[4]) +'</div>'
      }},{
      "targets": -1,
      "data": null,
      "render": function ( data, type, row, meta ) {
        return '<div  style="cursor:pointer;" class="ccolor" data-toggle="modal" data-target="#general_modal" onclick="showMessage(' + row[5] +');">Link to Message</div>'
      }},
    ]
  } );
});

$(document).ready(function() {
  $('#year-select').val(selectedParam('year'));
  $('#month-select').val(selectedParam('month'));
  $('#type-select').val(selectedParam('type'));

  $('select.changeMonth').change(function(){
      var month = $(this).val();
      var year  =  $('select.changeYear').val();
      var day   =  $('select.changeDay').val();
      var type  =  $('select.changeType').val();
      reload(month, year, day, type);
  });

  $('select.changeYear').change(function(){
      var year  = $(this).val();
      var month =  $('select.changeMonth').val();
      var day   =  $('select.changeDay').val();
      var type  =  $('select.changeType').val();
      reload(month, year, day, type);
  });

  $('select.changeDay').change(function(){
      var year   =  $('select.changeYear').val();
      var month  =  $('select.changeMonth').val();
      var day    =  $(this).val();
      var type   =  $('select.changeType').val();
      reload(month, year, day, type);
  });

  $('select.changeType').change(function(){
      var year   =  $('select.changeYear').val();
      var month  =  $('select.changeMonth').val();
      var day    =  $('select.changeDay').val();
      var type   =  $(this).val();
      reload(month, year, day, type);
  });

  function reload(raw_month, raw_year, raw_day, raw_type){
      var month = (typeof raw_month !== "undefined") ? raw_month : '';
      var year  = (typeof raw_year !== "undefined") ? raw_year : '';
      var day   = (typeof raw_day !== "undefined") ? raw_day : '';
      var type  = (typeof raw_type !== "undefined") ? raw_type : '';
      document.location = '<?php echo base_url()?>' + 'phone_messages?month=' + month + '&year=' + year + '&day=' + day + '&type=' + type;
  }

  function get_month_days(){
  var raw_month =  $('select.changeMonth').val();
  var raw_year  =  $('select.changeYear').val();

  var month = (typeof raw_month !== "undefined") ? raw_month : Date.getMonth();
  var year  = (typeof raw_year !== "undefined") ? raw_year : Date.getFullYear();
  var days = new Date(year, month, 0).getDate();

  for (var i = 1; i <= days; i++){
    $('.changeDay').append($('<option />').val(i).html(i)); }
  }

  get_month_days();
  $('#day-select').val(selectedParam('day'));
});

year =  new Date().getFullYear();
for (var i = (year - 1); i <= (year + 5); i++){ $('.changeYear').append($('<option />').val(i).html(i)); }

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

function showMessage(contract_id) {
  $.ajax({
  data:    { id: contract_id },
  url:     "<?php echo site_url('mobil_message');?>",
  type:    "POST",
  dataType:"html",
  }).done(function(data) {
    $(".modal-body").html(data);
    $('#empModal').modal('show'); 
  });
} 

function sentMessage(sent_data, sent_date){
  var date = sent_date.slice(0, 10);
  var time = sent_date.slice(11, 20);

  if (sent_data == 1) return 'Message sent in ' + date + ' and time' + time;
  return 'The message was not sent, due to an error with phone number, date of attempted delivery ' + date + ' and time' + time
}
</script>