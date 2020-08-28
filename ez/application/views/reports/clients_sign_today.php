<style type="text/css">
    i:hover{
        cursor: pointer;
        color: #4d5a89;
    }
    i{
        margin-left: 5px;
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
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/datatables/style.css" type="text/css">
<h5 class="card-title">Contract Signed This Week</h5>
<table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
   <thead>
            <tr>
                <th>Status</th>
                <th>Contract Number</th>
                <th>Client</th>
                <th>Date Sign</th>
                <th>Contract Amount</th>
                <th>Current Balance</th>
                <th>Receivable Amount</th>
               
            </tr>
        </thead>
        <tbody>

              <?php foreach ($today as $key) { 
                // $val = $this->M_contracts->pagosum($key->ID);
                  $val = 0;
                ?>
                <tr>

                  
                   <td><?php echo $key->Status; ?></td>
                  <td><?php echo $key->Contract_N; ?></td>
                  <td style="white-space: normal;"><?php echo $key->C_Name; ?></span></td>
                  <td><?php echo date("m-d-Y", strtotime($key->Sign_Date)); ?></td>
                  <td><?php echo $key->Value; ?></td>
                  <!-- <?php if (!empty($val[0]->suma)) { ?>
                      <td><?php echo ($key->Value) - ($val[0]->suma);?></td>
                  <?php }else{  ?>
                      <td><?php echo $key->Value; ?></td>
                   <?php } ?> -->

                   <td><?php echo $key->Balance_Amount; ?></td>

                 <td><?php echo $key->Receivable_Amount;?></td>
                 
                  
                 
                </tr>
             <?php } ?>
       
               
        </tbody>
        <tfoot>
            <tr>
                <th>Status</th>
                <th>Contract Number</th>
                <th>Client</th>
                <th>Date Sign</th>
                <th>Contract Amount</th>
                <th>Current Balance</th>
                <th>Amount 2</th>
               
            </tr>
        </tfoot>
</table>
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>