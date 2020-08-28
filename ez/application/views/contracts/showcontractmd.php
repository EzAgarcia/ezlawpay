<style>
 

.contra {
    padding: 50px 0px;
    border-top-width: 10px;
    border: 2px solid #2c365d;
}

.contra.text-right{
    color: #2c365d;
    font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
}

.modal-header , .modal-footer{
    display:none!important;

}

h6{
    font-size: 15px!important;
}

.modifcx{
    font-size: 16px!important;
}


</style>
<div class="container contra">
	<center>
        <a href="#" class="list-group-item list-group-item-action active">
                Contracts Details
        </a>
       <br>
    	<div class="row">
          
    		<div class="col-5">
    			<h6 class="text-right">Client :</h6>
    		</div>
    		<div class="col-7 text-left modifcx">
    			<?php echo $info[0]->C_Name; ?>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-5">
    			<h6 class="text-right">Services To :</h6>
    		</div>
    		<div class="col-7 text-left modifcx">
    			<?php 
                if (empty($referidos)) {
                      echo $info[0]->C_Name; 
                }else{

                    foreach ($referidos as $key) {
                     echo $key->Reference_Description;
                    } 
              }
                ?>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-5">
    			<h6 class="text-right">Contract Number :</h6>
    		</div>
    		<div class="col-7 text-left modifcx">
    			<?php echo $info[0]->Contract_N; ?>
    		</div>
    	</div>
    	<div class="row">
    		<div class="col-5">
    			<h6 class="text-right">Services :</h6>
    		</div>
    		<div class="col-7 text-left modifcx">
    			<?php 
                foreach ($services as $key) {
                    echo $key->Service_Description; ?> <br>
               <?php  }
                 ?>
    		</div>
    	</div>
    	<!-- <div class="row">
    		<div class="col-5">
    			<h6 class="text-right">Description :</h6>
    		</div>
    		<div class="col-7 text-left modifcx">
    			<?php echo $info[0]->C_Name; ?>
    		</div>
    	</div> -->
    	<div class="row">
    		<div class="col-5">
    			<h6 class="text-right">Phone :</h6>
    		</div>
    		<div class="col-7 text-left modifcx">
    			<?php echo $info[0]->Phone_Number; ?>
    		</div>
    	</div>
        
        <br>
        <a href="#" class="list-group-item list-group-item-action active">
                Payment Plan
        </a>
        <br>

        <div class="row">
            <div class="col-5">
                <h6 class="text-right">Contract Amount :</h6>
            </div>
            <div class="col-7 text-left modifcx">
                <?php 
                    echo $info[0]->Value;
                 ?>
            </div>
        </div>

        <div class="row">
            <div class="col-5">
                <h6 class="text-right">Initial Payments :</h6>
            </div>
            <div class="col-7 text-left modifcx">
                <?php 
                foreach ($initial as $key) {
                    echo $key->Initial_Pay_Amount; ?> <span style="color: red"> || </span> <?php echo  date("m-d-Y", strtotime($key->Initial_Pay_Date)); ?><br>
               <?php  }
                 ?>
            </div>
        </div>

        <div class="row">
            <div class="col-5">
                <h6 class="text-right">Due Date :</h6>
            </div>
            <div class="col-7 text-left modifcx">
                Start on :
                <?php 
                    
                    echo date("m-d-Y", strtotime($info[0]->Date_Montly_P));
                 ?>
            </div>
        </div>

        <div class="row">
            <div class="col-5">
                <h6 class="text-right">Monthly Amount :</h6>
            </div>
            <div class="col-7 text-left modifcx">
                <?php 
                    echo $info[0]->Montly_Amount;
                 ?>
            </div>
        </div>

        <div class="row">
            <div class="col-5">
                <h6 class="text-right">Contract Sign :</h6>
            </div>
            <div class="col-7 text-left modifcx">
            
                <?php 

                    echo date("m-d-Y", strtotime($info[0]->Sign_Date));
                 ?>
            </div>
        </div>


        <?php if (!empty($notas)) { ?>
            


        

        <br>

        <a href="#" class="list-group-item list-group-item-action active">
                 Notes
            </a>

        <br>

        <?php foreach ($notas as $key ) { ?>

            <div class="row" id="<?php echo $key->ID; ?>">
                <div class="col-5">
                     <h6 class="text-right"><?php echo $key->Name; ?> :</h6>
                </div>
                <div class="col-6 text-left modifcx">
                    
            

                         
                        <?php  echo $key->fecha; ?>

                        <span style="color: red"> || </span> <?php echo $key->nota; ?><br>


                 </div>
                 <div><button onclick="elim(<?php echo $key->ID;?>)"  class="btn btn-danger align-content-center">x</button></div>
            </div>
            <br>


           
        <?php } ?>

        <br>

        <?php } ?>

       <!--  <div class="row">
            <div class="col-4">
                <h6 class="text-right">Pagos :</h6>
            </div>
            <div class="col-8 text-left">
            
                <?php 
                    foreach ($pay as $key) {
                       echo $key->Pay_Amount; ?> <br>
                      <?php
                    }
                 ?>
            </div>
        </div> -->

        <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action active">
                 Payment Detail
            </a>
            <div class="list-group-item list-group-item-action">
                <div class="row col-12">
                    <span href="" class="col-lg-3" style="color: #007bff;">Payment Date</span>
                    <span href="" class="col-lg-2" style="color: #007bff;">Amount</span>
                    <span href="" class="col-lg-2" style="color: #007bff;">Payment method</span>
                    <span href="" class="col-lg-3" style="color: #007bff;">Move to</span>
                    <span href="" class="col-lg-2" style="color: #007bff;"></span>
                </div>
            </div>

            <?php foreach ($paymos as $key) { ?>
               <div class="list-group-item list-group-item-action" id="<?php echo $key->ID; ?>a">
                    <div class="row col-12">
                        <span href="" class="col-lg-3" style="color: #000000"><?php echo date("m-d-Y", strtotime($key->Date)); ?></span>
                        <span href="" class="col-lg-2" style="color: #000000"><?php echo $key->Pay_Amount; ?></span>
                        <span href="" class="col-lg-2" style="color: #000000">Pago</span>
                        <input type="text"  class="col-lg-3" id="<?php echo $key->ID; ?>">
                        <a style="cursor: pointer;" onclick="reasigna(<?php echo $key->ID; ?>)" class="col-lg-2"><span style="color:#4CAF50!important" class="label label-success">Re-asign</span></a>
                    </div>
                </div>
            <?php } ?>

            <?php foreach ($fees as $key) { ?>
               <div class="list-group-item list-group-item-action" id="<?php echo $key->ID; ?>a">
                    <div class="row col-12">
                        <span href="" class="col-lg-3" style="color: #000000"><?php echo date("m-d-Y", strtotime($key->Date)); ?></span>
                        <span href="" class="col-lg-2" style="color: #000000"><?php echo $key->Pay_Amount; ?></span>
                        <span href="" class="col-lg-2" style="color: #000000"><?php echo $key->Fee_Type; ?></span>
                        <input type="text"  class="col-lg-3" id="<?php echo $key->ID; ?>">
                        <a style="cursor: pointer;" onclick="reasigna(<?php echo $key->ID; ?>)" class="col-lg-2"><span style="color:#4CAF50!important" class="label label-success">Re-asign</span></a>
                    </div>
                </div>
            <?php } ?>

            <br><br>
<!-- 
             <a class="btn btn-danger" href="<?php echo base_url() ?>pdf_contract/<?php echo $id ?>" target="_blank" role="button" style="font-size: 13px; height: 35px; margin-left: 15px; margin-bottom: 15px; width: 30%"> Generate Balance</a>
 -->
          

            <!-- <div class="list-group-item list-group-item-action">
                <div class="row col-12">
                    <a href="" class="col-lg-3">Payment Date</a>
                    <a href="" class="col-lg-3">Amount</a>
                    <a href="" class="col-lg-3">Type</a>
                    <a href="" class="col-lg-3">Fees</a>
                </div>
            </div>
  <a href="#" class="list-group-item list-group-item-action">Dapibus ac facilisis in</a>
  <a href="#" class="list-group-item list-group-item-action">Morbi leo risus</a>
  <a href="#" class="list-group-item list-group-item-action">Porta ac consectetur ac</a>
  <a href="#" class="list-group-item list-group-item-action disabled" tabindex="-1" aria-disabled="true">Vestibulum at eros</a> -->
</div>







  <a href="#" style="background-color: #4CAF50; border-color:#4CAF50; " class="list-group-item list-group-item-action active">
               Current Balance <br>
               <h5 class="col-lg-3" style="color: #FFFFFF!important">$ <?php echo $balance; ?> DLLS</h5>
            </a>
            
        



        
 	
    </center>
</div>

<script>
    
   

function reasigna(id){


  var contrato = $('#'+id).val();


  if (contrato != '') {
   
  

  $.post( "<?php echo base_url()?>C_contracts/cambiac",{id:id, contrato:contrato}, function( data ) {
            if (data == 1){

                Swal.fire({
                title: 'Done!',
                text:  'Successfully reassigned!',
                icon:  'success'
              }).then((result) => {
                 $("#"+id+'a').hide();
             })
              
            }else{

                alert('error');
            }

        });
}else{

}

}


$("#myModal").on('hidden.bs.modal', function () {
            alert("Esta accion se ejecuta al cerrar el modal")
    });
    
</script>