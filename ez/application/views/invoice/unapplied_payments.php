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
		max-width: 500px;
	}
	.odd {
		background-color: #f9f9f9!important;
	}
	.span{
		color: #fff;
		padding: 5px 12px;
		font-size: 11px;
	}
</style>
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/datatables/style.css" type="text/css">
<button type="button" class="btn btn-success" Data-toggle="modal" data-target="#general_modal" onclick="upload_file()" ><i class="fas fa-upload"></i>   Upload Square Report</button>
<br></br>
<button type="button" class="btn btn-success" Data-toggle="modal" data-target="#general_modal" onclick="upload_file()" >Upload Square Report</button>
<div class="container">
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-body">
					<table id="example" class="table-striped" style="width:100%">
				        <thead>
				            <tr>
				                <th>ID Square</th>
				                <th>Date</th>
				                <th>Type</th>
				                <th>Amount</th>
				                <th></th>
				            </tr>
				        </thead>
				        <tbody>
				        </tbody>
				        <tfoot>
				            <tr>
				                <th>ID Square</th>
				                <th>Date</th>
				                <th>Type</th>
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
					<h5 class="card-title">Payment Type</h5>
					<div class="container">
						<div class="row">
							<div class="col-sm">
								<b><input type="radio"  class="form-check-input type" name="type" value="contract" >Contract Payment:</b> 
							</div>
							<div class="col-sm">
								<b><input type="radio"  class="form-check-input type" name="type" value="fee" >Fee:</b>
								<select class="custom-select custom-select-sm" name="type_fee" id="type_fee">
								  <option></option>
								  <?php
								  foreach ($fees as $fee) {
								  	?>
								  	<option value="<?php echo $fee->ID?>"><?php echo $fee->Fee_Type?></option>
								  	<?php
								  }
								  ?>
								</select> 
							</div>
						</div>
					</div>
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
	<br>
	<div class="row">
		<div class="col ">
			<button type="button" onclick="save_pay()" class="btn btn-success float-right">Save</button>
		</div>
	</div>
</div>


<script type="text/javascript">

$(document).ready(function() {
	var status = {  1: 'Cash', 2: 'Deposit', 3: 'Check', 4: 'Card', 8: 'MoneyOrder', 9: 'Other' };
	$('#example').DataTable( {
		"processing": true,
		"serverSide": true,
		"ajax": {
		url: '<?php echo base_url()?>' + 'unapplied_payments_list',
		type: 'POST'
		},
		"columnDefs": [{
		"targets": -1,
		"data": null,
		"render": function ( data, type, row, meta ) {
			return '<input style="width=20px;" type="radio"  class="form-check-input square" name="square" value="' + row[0] + '" id="' + row[0] + '" onclick="view_square(' + row[0] + ')"><label class="form-check-label" for="exampleCheck1">Select</label>';
		}},{
		"targets": 0,
		"data": null,
		"render": function ( data, type, row, meta ) {
			return row[5];
		}},{
		"targets": 1,
		"data": null,
		"render": function ( data, type, row, meta ) {
			return row[2];
		}},{
		"targets": 2,
		"data": null,
		"render": function ( data, type, row, meta ) {
			return status[row[1]];
		},
	}]
	} );

	$('#example2').DataTable( {
		"processing": true,
		"serverSide": true,
		"ajax": {
		url: '<?php echo base_url()?>' + 'unapplied_payments_contracts_list',
		type: 'POST'
		},
		"columnDefs": [{
		"targets": -1,
		"data": null,
		"render": function ( data, type, row, meta ) {
			return '<input type="radio"  class="form-check-input square2" value="' + row[0] + '" name="square2" id="' + row[0] + '" onclick="view_contract(' + row[0] + ')"><label class="form-check-label" for="exampleCheck1">Select</label>';
		}},{
		"targets": 0,
		"data": null,
		"render": function ( data, type, row, meta ) {
			return row[2];
		}},{
		"targets": 1,
		"data": null,
		"render": function ( data, type, row, meta ) {
			return row[7];
		}},{
		"targets": 2,
		"data": null,
		"render": function ( data, type, row, meta ) {
			return row[4];
		}}
	]
	} );
} );

$('#example').unbind().bind('keyup', function() {
  table.column(2).search( this.value ).draw();
});


function view_square(square){
		$.post( "<?php echo base_url()?>C_invoice/view_payment_details",{square:square}, function( data ) {
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
	var type=$('input:radio[name=type]:checked').val() ;

	if (type=='fee'){
		var type_fee=$('#type_fee').val();
	}else{
		var type_fee='';
	}


	
	if(typeof square==='undefined'){
	
		Swal.fire({
			icon: 'error',
			title: 'Oops',
			text:  'Payment!'
		});
		return false;
	}
	if (typeof contract==='undefined'){
	
		Swal.fire({
			icon: 'error',
			title: 'Oops',
			text:  'Contract!'
		});
		return false;
		
	}
	if (typeof type==='undefined'){
		
		Swal.fire({
			icon: 'error',
			title: 'Oops',
			text:  'Type!'
		});
		return false;
		
	}
	
	$.post(  "<?php echo base_url()?>C_invoice/save_pay",{
		square:square,
		contract:contract,
		type:type,
		type_fee:type_fee}, function( data ) {
      if (data=='SI'){
        // Swal.fire({
        //   icon: 'error',
        //   title: 'Oops...',
        //   text: 'Something went wrong!'
        // })
        location.reload();
      }else{
      	
      	 Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'The contract exceeds your balance payments.!',
                }).then(function () {
                  
                })
        
      }
    });
}
function upload_file(){
	$('#modal_title').html('Upload Square Report');
    $.post( "<?php echo base_url()?>C_invoice/upload_report", function( data ) {
        $('#modal_body').html(data);
    });
}

</script>