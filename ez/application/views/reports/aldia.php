<style type="text/css">
    i:hover{
        cursor: pointer;
        color: #4d5a89;
    }
    i{
        margin-left: 5px;
    }
</style>
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/datatables/style.css" type="text/css">
<h5 class="card-title">Upcoming Payments For Today</h5>


<table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
    <thead>
            <tr>
            
                <th>Contract Number</th>
                <th>Client</th>
                <th>Payment Due Date</th>
                <th>Amount</th>
                <th>Type</th>
          
            </tr>
        </thead>
        <tbody>
			<?php foreach ($registros as $key => $value ) { ?>
			<tr>
				<td><?php echo $value['Contrato']; ?></td>
                <td style='text-align: left !important; white-space: normal;' data-toggle="modal" data-target="#general_modal" onclick="showContract(<?php echo $value['ID']; ?>);"><span style="cursor:pointer;" class="ccolor"><?php echo $value['Nombre']; ?></span></td>
				<td><?php echo $value['Initial_Pay_Date']; ?></td>
				<td><?php echo $value['Initial_Pay_Amount']; ?></td>
                <?php if ($value['Tipo'] == 1){ ?>
                <td>Initial Payment</td>
                <?php }else{ ?>
                <td>Monthly payment</td>
                <?php } ?>
			</tr>
			<?php } ?>
         
       
               
        </tbody>
        <tfoot>
            <tr>
                
                <th>Contract Number</th>
                <th>Client</th>
                <th>Payment Due Date</th>
                <th>Amount</th>
                <th>Type</th>              
               
            </tr>
        </tfoot>
</table>
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
} );

function showContract(id){
    $.ajax({
        data: {ok: id},
        url: "<?php echo site_url('showContract');?>",
        type:"POST",
        dataType:"html",
        }).done(function(data) {
            $(".modal-body").html(data);
    });
}


</script>