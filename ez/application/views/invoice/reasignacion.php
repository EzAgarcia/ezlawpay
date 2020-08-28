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


<table id="tabla" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                
                <th>Client</th>
                <th>Contract Number</th>
                <th>Sign Date</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
          <?php foreach ($contratos as $key) { ?>
            <tr>
               
                <td><div style="cursor: pointer" class="ccolor" data-toggle="modal" data-target="#general_modal" onclick="showContract('<?php echo $key->ID; ?>');"><?php echo $key->C_Name; ?></div></td>
                <td><?php echo $key->Contract_N; ?></td>
                <td><?php echo $key->Sign_Date; ?></td>
                <td><?php echo $key->Balance_Amount ; ?></td>
            </tr>
          <?php } ?>
        </tbody>
        <tfoot>
            <tr>
               
                <th>Client</th>
                <th>Contract Number</th>
                <th>Sign Date</th>
                <th>Balance</th>
            </tr>
        </tfoot>
    </table>

<script>
  $(document).ready(function() {
    $('#tabla').DataTable();
} );

  function showContract(ok){
  $.ajax({
    data: {ok: ok},
    url: "<?php echo site_url('C_contracts/showContractmd');?>",
    type:"POST",
    dataType:"html",
  }).done(function(data) {
    $(".modal-body").html(data);
  });
} 


$("#general_modal").on('hidden.bs.modal', function () {
            location.reload();
    });

</script>