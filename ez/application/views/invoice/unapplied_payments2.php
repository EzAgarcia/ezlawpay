
<div class="container">
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-body">
					<table id="example" class="table-striped" style="width:100%">
				        <thead>
				            <tr>
				                <th>Date</th>
				                <th>Amount</th>
				                <th>Description</th>
				                <th></th>
				            </tr>
				        </thead>
				        <tbody>
				            <?php 
				            foreach ($unapplieds as $unapplied) {
				            	?>
				            	<tr>
				            		<td><?php echo $unapplied->Date ?></td>
				            		<td><?php echo $unapplied->Pay_Amount ?></td>
				            		<td><?php echo $unapplied->Pay_Description ?></td>
				            		<td>
				            			<input type="radio"  class="form-check-input square" name="square" value="<?php echo $unapplied->ID?>" id="<?php echo $unapplied->ID?>" onclick="view_square('<?php echo $unapplied->ID?>')">
										<label class="form-check-label" for="exampleCheck1">Select</label>
				            		</td>
				            	</tr>
				            	<?php
				            }
				            ?>
				        </tbody>
				        <tfoot>
				            <tr>
				                <th>Date</th>
				                <th>Amount</th>
				                <th>Description</th>
				                <th></th>
				            </tr>
				        </tfoot>
				    </table>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Details</h5>
					<div id="details_payment"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">contracts</h5>
					
					<table id="example2" class="table-striped" style="width:100%">
				        <thead>
				            <tr>
				                <th>Contract</th>
				                <th>Name</th>
				                <th>Amount</th>
				                <th></th>
				            </tr>
				        </thead>
				        <tbody>
				        	<?php
				        	foreach ($contracts as $cont) {
				        		?>
				        		<tr>
				        			<td><?php echo $cont->Contract_N ?></td>
				        			<td><?php echo $cont->C_Name ?></td>
				        			<td><?php echo $cont->Montly_Amount ?></td>
				        			<td>
				        				
				        				<input type="radio"  class="form-check-input square2" value="<?php echo $cont->ID?>" name="square2" id="<?php echo $cont->ID?>" onclick="view_contract('<?php echo $cont->ID?>')">
										<label class="form-check-label" for="exampleCheck1">Select</label>

				        			</td>
				        		</tr>
				        		<?php
				        	}
				        	?>
				        </tbody>
				        <tfoot>
				            <tr>
				                <th>Contract</th>
				                <th>Name</th>
				                <th>Amount</th>
				                <th></th>
				            </tr>
				        </tfoot>
				    </table>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Contract Details</h5>
					<div id="contract_details"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col ">
			<button type="button" onclick="save_pay()" class="btn btn-success float-right">Save</button>
		</div>
	</div>
</div>


<script type="text/javascript">

$(document).ready(function() {
    $('#example').DataTable( {
        scrollY:        '25vh',
        scrollCollapse: true,
        paging:         false
    } );
    $('#example2').DataTable( {
        scrollY:        '25vh',
        scrollCollapse: true,
        paging:         false
    } );
} );
function view_square(square){
		$.post( "<?php echo base_url()?>C_invoice/view_payment_details2",{square:square}, function( data ) {
            $("#details_payment").html(data);
        });
	
}
function view_contract(contract){

		$.post( "<?php echo base_url()?>showContract",{ok:contract}, function( data ) {
            $("#contract_details").html(data);
        });
	}
function save_pay(){
	var square= $('input:radio[name=square]:checked').val();
	var contract=$('input:radio[name=square2]:checked').val() ;


	
	if(typeof square==='undefined'){
	
		Swal.fire({
			icon: 'error',
			title: 'Oops',
			text:  'Something went wrong!'
		});
		return false;
	}
	if (typeof contract==='undefined'){
	
		Swal.fire({
			icon: 'error',
			title: 'Oops',
			text:  'Something went wrong!'
		});
		return false;
		
	}

	
	$.post(  "<?php echo base_url()?>C_invoice/save_pay2",{
		square:square,
		contract:contract}, function( data ) {

      $.post('<?php echo base_url()?>C_contracts/actualizarin',{id:contract},function($data){
  			location.reload();
  		})

    });
}
function upload_file(){
	$('#modal_title').html('Upload Square Report');
    $.post( "<?php echo base_url()?>C_invoice/upload_report", function( data ) {
        $('#modal_body').html(data);
    });
}

</script>