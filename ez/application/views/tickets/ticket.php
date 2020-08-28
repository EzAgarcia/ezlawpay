<style>


 .especial a{
    color: #000 !important;
    font-size: 13px;
  }
  .especial a i{
    margin-right: 10px
  }
  td {
  border: orange 5px solid;
}

form{
     font-size: 17.5px;
  font-family: 'Roboto', sans-serif;
  font-weight: 400;
  }

  a{
    font-size: 15.5px!important;
  font-family: 'Roboto', sans-serif;
  font-weight: 400;
  }

    select {
    margin-left: 5px;
    width: 30%!important;
    border-radius: 5px;
}

</style>
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/datatables/style.css" type="text/css">
<h5>Tickets</h5>
<br>

<form enctype="multipart/form-data" action="<?php echo site_url('C_tickets/addtickets');?>" method="POST">
    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="">Area</label>
            <select name="types" class="form-control"  style="width: 80%!important;">
                <option></option>
                <option value="1">Contracts</option>
                <option value="2">Payments</option>
                <option value="3">Platform</option>
                <option value="4">Client</option>
                <option value="5">Observations or improvements</option>
                <option value="6">Balance request</option>
                <option value="7">Feedback / Review Ez LawPay</option>
               

            </select>
            <br>

            <label for="language" >Ticket description</label>
            <textarea class="form-control" rows="6" name="descrip" required="required"></textarea>

            <br>
            <input type="hidden" name="MAX_FILE_SIZE" value="30000000000" />
             <!-- El nombre del elemento de entrada determina el nombre en el array $_FILES -->
                  Attach files : <input name="fichero_usuario" type="file" />
                 <br><br>
            <input type="submit"  class="btn btn-info" value="Save" />
        
      
        </div>

        <div class="form-group col-md-7">

          <div class="container row">
                <label>Select Status: </label>
                <div style="width: 45%; margin-left: 20px;" id="userstable_filter"></div>
          </div>
           
          
            <table id="tickets" class="table table-bordered"  style="width:100%; border-radius: 5px; ">
            <thead>
                <tr>
                    <th>Status</th>
                    <th width="16%">Date</th>
                    <th>Description</th>
                    <th>Observation</th>
                
            </tr>
        </thead>
        <tbody>

         <?php foreach ($infot as $key) { ?>
            <tr>
                <?php if ($key->Status == 1) { ?>
                    <td>Not assigned</td>
                  
                <?php }elseif ($key->Status == 2) { ?>
                    <td>In process</td>
                <?php }else{ ?>
                    <td>Resolved</td>
                <?php } ?>
                <td><?php echo  date("m-d-Y", strtotime($key->fecha)); ?></td>
                <td><?php echo $key->Descripcion ?></td>
               <td><?php  echo $key->observaciones?></td>
              
            </tr>
          <?php } ?>

        </tbody>
        <tfoot>
            <tr>
                <th>Status</th>
                <th>Date</th>
                <th>Description</th>
                <th>Observation</th>
            
        
            </tr>
        </tfoot>
    </table>
        
      
        </div>
    </div>

</form>


<!-- <br>
<div class="form-row">
        

        <div class="form-group col-md-12">
           
            <label for="">Todos los Tickets</label>
            <table id="tickets" class="table table-bordered"  style="width:100%; border-radius: 5px; ">
            <thead>
                <tr>
                    <th width="30%" >Fecha</th>
                    <th>Ticket</th>
                    <th>Usuario</th>
                    <th>Select ticket</th>
                    <th>Show file</th>
     
            </tr>
        </thead>
        <tbody>

         <?php foreach ($ticketst as $key) { ?>
            <tr>
                
                <td><?php echo $key->fecha; ?></td>
                <td><?php echo $key->Descripcion ?></td>
                <td><?php echo $key->Name ?></td>
                <td><button class="form-control btn-info" onclick="tomar(<?php echo $key->ID ?>);">Tomar</button></td>
                <?php if (!empty($key->Archivo)) { ?>
                   
                    <td><a style="color: #17a2b8" target="_blank" href="<?php echo base_url()?>assets/tickets/<?php echo $key->Archivo ?>">Archivo</a></td>
                <?php }else{ ?>

                    <td>Sin archivo</td>

                 <?php  } ?>

                


            </tr>
          <?php } ?>

        </tbody>
        <tfoot>
            <tr>
                <th>Fecha</th>
                <th>Ticket</th>
                <th>Usuario</th>
                <th>Select ticket</th>
                <th>Show file</th>
        
         
            </tr>
        </tfoot>
    </table>
        
      
        </div>
    </div>

    <br>
    <br>
    <br>
    <div class="form-row">
        

        <div class="form-group col-md-12">
           
            <label for="">Tickets Asignados</label>
            <table id="tickets" class="table table-bordered"  style="width:100%; border-radius: 5px; ">
            <thead>
                <tr>
                    <th width="30%" >Fecha</th>
                    <th>Ticket</th>
                    <th>Usuario</th>
                    <th>Select ticket</th>
                    <th>Show file</th>
                
            </tr>
        </thead>
        <tbody>

         <?php foreach ($ticketstp as $key) { ?>
            <tr>
                
                <td><?php echo $key->fecha; ?></td>
                <td><?php echo $key->Descripcion ?></td>
                <td><?php echo $key->Name ?></td>
                <td><button class="form-control btn-info"  onclick="cerrar(<?php echo $key->ID ?>);">Cerrar</button></td>

                  <?php if (!empty($key->Archivo)) { ?>
                   
                    <td><a target="_blank" href="<?php echo base_url()?>assets/tickets/<?php echo $key->Archivo ?>">Archivo</a></td>
                <?php }else{ ?>

                    <td>Sin archivo</td>

                 <?php  } ?>


            </tr>
          <?php } ?>

        </tbody>
        <tfoot>
            <tr>
                <th>Fecha</th>
                <th>Ticket</th>
                <th>Usuario</th>
                <th>Select ticket</th>
                <th>Show file</th>            
             
            </tr>
        </tfoot>
    </table>
        
      
        </div>
    </div> -->
<br><br><br>


<?php if ($_SESSION['ezlow']['profile'] == 1) { ?>

<ul class="nav nav-tabs especial" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="pills-today-tab" data-toggle="pill" href="#pills-today" role="tab" aria-controls="pills-today" aria-selected="true">Tickets</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pills-week-tab" data-toggle="pill" href="#pills-week" role="tab" aria-controls="pills-week" aria-selected="false">Your tickets</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pills-month-tab" data-toggle="pill" href="#pills-month" role="tab" aria-controls="pills-month" aria-selected="false">Assigned tickets</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pills-year-tab" data-toggle="pill" href="#pills-year" role="tab" aria-controls="pills-year" aria-selected="false">Closed tickets</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="pills-today" role="tabpanel" aria-labelledby="pills-today-tab">
    <div class="card" style="border: none">
      <div class="card-body">
        <table id="tickets2" class="table table-bordered"  style="width:100%; border-radius: 5px; ">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Ticket</th>
                    <th>User</th>
                    <th>Select ticket</th>
                    <th>Show file</th>
                    
     
            </tr>
        </thead>
        <tbody>

         <?php foreach ($ticketst as $key) { ?>
            <tr>


                
                <td><?php echo  date("m-d-Y", strtotime($key->fecha)); ?></td>



                <?php switch ($key->Type) {
                  case 1: ?>
                    <td>Contracts</td>
                  <?php  break;

                  case 2: ?>
                   <td>Payments</td>

                  <?php  break;

                  case 3: ?>
                    <td>Platform</td>

                   <?php break;

                  case 4: ?>
                    <td>Client</td>
                   <?php break;

                  case 5: ?>
                    <td>Observations or improvements</td>
                   <?php  break; 

                  case 6: ?>
                    <td>Balance Request</td>
                   <?php break;

                   case 7: ?>
                    <td>Feedback / Review Ez LawPay</td>
                   <?php break;
                  
                  default: ?>
                    <td>Contracts</td>
                  <?php  break;

                } ?>
                <td><?php echo $key->Descripcion ?></td>
                <td><?php echo $key->Name ?></td>
                 <?php if ($_SESSION['ezlow']['iduser'] == 1 OR $_SESSION['ezlow']['iduser'] == 2 OR $_SESSION['ezlow']['iduser'] == 25 OR $_SESSION['ezlow']['iduser'] == 26 OR $_SESSION['ezlow']['iduser'] == 24) { ?>
                <td><button class="form-control btn-info" onclick="tomar(<?php echo $key->ID ?>);">Tomar</button></td>
                 <?php }else{ ?>
                    <td></td>
                  <?php } ?>
                <?php if (!empty($key->Archivo)) { ?>
                   
                    <td><a style="color: #17a2b8" target="_blank" href="<?php echo base_url()?>assets/tickets/<?php echo $key->Archivo ?>">Show file</a></td>
                <?php }else{ ?>

                    <td>No file</td>

                 <?php  } ?>

                


            </tr>
          <?php } ?>

        </tbody>
        <tfoot>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Ticket</th>
                <th>User</th>
                <th>Select ticket</th>
                <th>Show file</th>

        
         
            </tr>
        </tfoot>
    </table>
      </div>
    </div>
  </div>
  <div class="tab-pane fade" id="pills-week" role="tabpanel" aria-labelledby="pills-week-tab">
    <div class="card" style="border: none">
      <div class="card-body">
       <table id="tickets3" class="table table-bordered"  style="width:100%; border-radius: 5px; ">
            <thead>
                <tr>
                    <th width="30%" >Date</th>
                    <th>Ticket</th>
                    <th>User</th>
                    <th>Select ticket</th>
                    <th>Show file</th>
                    <th>Balance request</th>
                    <th>Edit</th>
                
            </tr>
        </thead>
        <tbody>

         <?php foreach ($ticketstp as $key) { ?>
            <tr>

                <?php
                   $infos = $this->M_tickets->obtener($key->ID);

                 ?>
                <td><?php echo  date("m-d-Y", strtotime($key->fecha)); ?></td>
                <td><?php echo $key->Descripcion ?></td>
                <td><?php echo $key->Name ?></td>
                <td><button class="form-control btn-info"  onclick="cerrar(<?php echo $key->ID ?>);">Cerrar</button></td>

                  <?php if (!empty($key->Archivo)) { ?>
                   
                    <td><a target="_blank" href="<?php echo base_url()?>assets/tickets/<?php echo $key->Archivo ?>">Show file</a></td>
                <?php }else{ ?>

                    <td>No file</td>

                 <?php  }

                 if (empty($infos)) { ?>
                   
                <td>Contract ID: <input type="text" class="form-control" id="<?php echo $key->ID ?>" style="margin-bottom: 3%">
                   <button class="btn btn-info" onclick="balance(<?php echo $key->ID ?>)">Save</button>
                </td>
                <td></td>

                 <?php  }else{ ?>

                  <td><a target="_blank" href="<?php echo site_url()?>pdf_contract/<?php echo $infos ?>">Show Balance</a></td>

                  <td><button class="btn btn-info" data-toggle="modal" data-target="#general_modal" onclick="editar(<?php echo $key->ID; ?>)">Editar</button></td>

                 <?php } ?>
            </tr>
          <?php } ?>

        </tbody>
        <tfoot>
            <tr>
                <th>Date</th>
                <th>Ticket</th>
                <th>User</th>
                <th>Select ticket</th>
                <th>Show file</th>
                <th>Balance request</th>
                <th>Edit</th>            
             
            </tr>
        </tfoot>
    </table>
          
      </div>
    </div>
  </div>
  <div class="tab-pane fade" id="pills-month" role="tabpanel" aria-labelledby="pills-month-tab">
    <div class="card" style="border: none">
      <div class="card-body">
        <table id="tickets4" class="table table-bordered"  style="width:100%; border-radius: 5px; ">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Ticket</th>
                    <?php if ($_SESSION['ezlow']['iduser'] != 21) { ?>
                       <th>User</th>
                    <?php } ?>
                   <!--  <th>Select ticket</th> -->
                    <th>Show file</th>
                
            </tr>
        </thead>
        <tbody>

         <?php foreach ($asignados as $key) { ?>
            <tr>
                
                <td><?php echo  date("m-d-Y", strtotime($key->fecha)); ?></td>
                <td><?php echo $key->Descripcion ?></td>
                <?php if ($_SESSION['ezlow']['iduser'] != 21) { ?>
                <td><?php echo $key->Name ?></td>
                <?php } ?>
                <!-- <td><button class="form-control btn-info"  onclick="cerrar(<?php echo $key->ID ?>);">Cerrar</button></td> -->

                  <?php if (!empty($key->Archivo)) { ?>
                   
                    <td><a target="_blank" href="<?php echo base_url()?>assets/tickets/<?php echo $key->Archivo ?>">Show file</a></td>
                <?php }else{ ?>

                    <td>No file</td>

                 <?php  } ?>


            </tr>
          <?php } ?>

        </tbody>
        <tfoot>
            <tr>
                <th>Date</th>
                <th>Ticket</th>
                <?php if ($_SESSION['ezlow']['iduser'] != 21) { ?>
                  <th>User</th>
                <?php } ?>
                
               <!--  <th>Select ticket</th> -->
                <th>Show file</th>            
             
            </tr>
        </tfoot>
    </table>
          
      </div>
    </div>
  </div>
  <div class="tab-pane fade" id="pills-year" role="tabpanel" aria-labelledby="pills-year-tab">
    <div class="card" style="border: none">
      <div class="card-body">

        <table id="tickets5" class="table table-bordered"  style="width:100%; border-radius: 5px; ">
            <thead>
                <tr>
                    <th width="10%">Date</th>
                    <th>Created by</th>
                    <th>Ticket</th>
                    <th>Show file</th>
                    <th>Solved by</th>
                    <th>Observation</th>

                
            </tr>
        </thead>
        <tbody>

         <?php foreach ($historial as $key) { ?>
            <tr>
                
                <td><?php echo  date("m-d-Y", strtotime($key->fecha)); ?></td>
                <td><?php echo  $key->creeo; ?></td>
                <td><?php echo $key->Descripcion ?></td>
                
            
            

                  <?php if (!empty($key->Archivo)) { ?>
                   
                    <td><a target="_blank" href="<?php echo base_url()?>assets/tickets/<?php echo $key->Archivo ?>">Show file</a></td>
                <?php }else{ ?>

                    <td>No file</td>

                 <?php  } ?>

                <td><?php echo $key->realiza ?></td>
                <td><?php echo $key->observaciones; ?></td>

            </tr>
          <?php } ?>

        </tbody>
        <tfoot>
            <tr>
                <th>Date</th>
                <th>Created by</th>
                <th>Ticket</th>
                <th>Show file</th>
                <th>Solved by</th>
                <th>Observation</th>              
             
            </tr>
        </tfoot>
    </table>
          
      </div>
    </div>
  </div>
</div>

<?php     } ?>

        <br>
        <br>
        <br>
        <br>
        <div class="form-group col-md-12">
           
            <h4><label for="">Balance Requests</label></h4>
            <table id="tickets6" class="table table-bordered"  style="width:100%; border-radius: 5px; ">
            <thead>
                <tr>
                    <th>Contract Number</th>
                    <th>Client</th>
                    <th>User</th>
                    <th>Requisition date</th>
                    <th>Show Balance PDF</th>
                
            </tr>
        </thead>
        <tbody>

    

         <?php foreach ($showbalances as $key) { ?>
           <tr>
             <td><?php echo $key->Contract_N?></td>
             <td><?php echo $key->C_Name; ?></td>
             <td><?php echo $key->Name?></td>
             <td><?php echo $key->fecha?></td>
             <td><a target="_blank" href="<?php echo site_url()?>pdf_contract/<?php echo $key->ID ?>">Show Balance</a></td>
           </tr>
          <?php } ?>

        </tbody>
        <tfoot>
            <tr>
                <th>Contract Number</th>
                <th>Client</th>
                <th>User</th>
                <th>Requisition date</th>
                <th>Show Balance PDF</th>
            
        
            </tr>
        </tfoot>
    </table>
        
      
        </div>




<script type="text/javascript">

     $(document).ready(function() {
      $('#tickets').DataTable( {
         "bLengthChange" : true,
         "ordering": false,
          "pageLength" : 4,
          initComplete: function () {
            this.api().columns([0]).every( function () {
                var column = this;
                var select = $('<select><option value="">Show all</option></select>')
                    .appendTo( '#userstable_filter' )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
        });

      $('#tickets2').DataTable({
        "searching": false,
        "lengthChange": false
      });
      $('#tickets3').DataTable({
        "searching": false,
        "lengthChange": false
      });
      $('#tickets4').DataTable({
        "searching": false,
        "lengthChange": false
      });
      $('#tickets5').DataTable({
        "searching": false,
         "lengthChange": false
      });

       $('#tickets6').DataTable({
         "lengthChange": false
      });


    });


     function editar(id){

         var url = "<?php echo site_url('C_tickets/editar');?>";
         $.ajax({
            url: url,
            type:"POST",
            data: {  id : id },
            dataType:"html",
          }).done(function(data) {
              $(".modal-title").html('Editar ID');
              $(".modal-body").html(data);
            });
     }



    function tomar(id){

       
       var url = "<?php echo site_url('C_tickets/tomar');?>";
       $.ajax({                        
           type: "POST",                 
           url: url, 
           data: {  id : id },
           success: function(response){
              setTimeout(location.reload() , 1000);
           }                   
       });
    }

    function balance(id_ticket){
      
      var id = $("#"+id_ticket).val();
      var id_tickets = id_ticket;
      var url = "<?php echo site_url('C_tickets/balance');?>";
      if (id != '') {
          $.ajax({                        
           type: "POST",                 
           url: url, 
           data: {  id:id , id_tickets:id_tickets },
           success: function(response){
              
              location.reload();
           }                   
       });
      }else{
        Swal.fire({
        icon: 'error',
        text: 'Invalid Value!'
        
})
      }
      
    }

    function cerrar(id){
        var observaciones = "";
       Swal.fire({
  title: 'Observaciones',
  input: 'textarea'
}).then(function(result) {
  if (result.value) {
    
    observaciones = result.value;
  }
     var url = "<?php echo site_url('C_tickets/cerrar');?>";
       $.ajax({                        
           type: "POST",                 
           url: url, 
           data: {  id : id, observaciones: observaciones },                   
       });
   setTimeout(location.reload() , 1000);
})


      

      
    }



</script>