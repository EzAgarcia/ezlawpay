 <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sl-1.3.1/datatables.min.css"/> -->
 

  
<?php date_default_timezone_set('America/Los_Angeles');; ?>

<style type="text/css">
  .container{
    position: relative;
    margin: auto auto;
  }

  #search{
    border-top: 0px solid #ccc;
    border-left: 0px solid #ccc;
    border-right: 0px solid #ccc;
    border-bottom: 1px solid #ccc;
  }

   /*table {
  table-layout:fixed;
  font-size: 12.5px;
  font-family: 'Roboto', sans-serif;
  font-weight: 400;

}*/
/*table td {
  word-wrap: break-word;
  max-width: 400px;
  padding: 15px;
  text-align: center;
}*/
/*th{
  padding: 15px;
  text-align: center;
}

tr{
  padding: 15px;
  border-radius: 100px!important;
}*/

.odd {
    background-color: #f9f9f9!important;
}

.span{
    color: #fff;
    padding: 10px 25px;
    font-size: 11px;
}

</style>


<div class="container" style="background-color: #efefef;">
  <br>
  <br>
  <center><h3>New Contract</h3></center>
<br>
 <div class="row">
  <div class="form-group col-8"></div>
   <div class="form-group col-4">
      <label for="inputCity">Contract Sign </label>
      <input class="form-control"  id="contractsign" min="2018-01-01" max="2099-01-01" name="initial" type="date"  value="<?php echo date('Y-m-d', strtotime($info[0]->Sign_Date));?>" required="required">
      <br>
 </div>
 </div>
  <center>
    <div class="col-md-9 row">
      <div class="col-10">
          <form method="post" class="form-inline" id="info1">
          <input type="text" name="search" id="search" class="form-control-lg rounded-0 col-md-12  p-4 mt-3 border-info" placeholder="Search Client" value="<?php echo $info[0]->C_Name; ?>" style="width: 80%;" required="required" >
      
         </form>
         <center> 
            <div class="list-group text-left col-12"  id="show-list" style="width: 97%; position: absolute; z-index: 1;">
      
            </div>
        
         </center>
      </div>
      <div class="col-2" style="margin-top: 25px;">
        <button onclick="addclient()" data-toggle="modal" data-target="#general_modal" class="btn btn-primary">Add Client</button>
      </div>
         
     </div>
  </center>
  <center>
    <div class="row" style="margin-top: 5%;"> 
      <div class="col-md-1"></div>
      <div class="col-md-5">
        <label>Select Services</label>
         <select class="js-example-basic-single" name="state" id="miselect" >
            <option value="0"></option>
           <!--  <option value="AL">Alabama</option>
            <option value="WY">Wyoming</option> -->
            <?php foreach ($services as $key) { ?>
               <option value="<?php echo $key->ID ?>"><?php echo $key->Service_Description; ?></option>
            <?php } ?>
        </select>
      </div>

      <div class="col-md-5">
        <ul class="list-group" id="prueba">
         
            <li style="background-color: #007bff; color: #FFFFFF; height: 45px; margin-top:15px;" onclick="alert('ok');" class="list-group-item">Services</li>
          <?php foreach ($servicess as $key) { ?>
              <li  class="list-group-item d-flex justify-content-between align-items-center"><?php echo $key->Service_Description; ?><span  class="badge badge-primary badge-pill">X</span></li>
             <?php  } ?>
         
        </ul>
      </div>
        

        
     </div>
  </center>
  <center>
    <br><br>
    <form class="form-group xdls"  id="newCon" method="post">
    <div class="col-10">
        <label for="inputCity">Services to: </label>
       <textarea  class="form-control text-left"  rows="4" id="servicesto" value name="servicesto" required="required">
        <?php 
          if (empty($referidos)) {
                      echo $info[0]->C_Name; 
                }else{

                    foreach ($referidos as $key) {
                     echo $key->Reference_Description.PHP_EOL;
                    } 
              }
        ?>
         
       </textarea>
    </div>
    <br><br><br>
    <div class="form-row">
      <div class="col-md-1"></div>
    <div class="form-group col-md-3">
      <label for="inputZip">Contract Number</label>
      <input type="text" class="form-control" id="contractnumber" name="contractnumber"  value="<?php echo $info[0]->Contract_N ?>" data-mask="00-00-0000" required="required">
    </div>

    <div class="form-group col-md-3">
      <label for="inputState">Contract Value</label>
      <div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text">$</span>
  </div>
  <input type="number" class="form-control" value="<?php echo intval($info[0]->Value) ?>" id="contractvalue" aria-label="Amount (to the nearest dollar)">
  <div class="input-group-append">
    <span class="input-group-text">.00</span>
  </div>
</div>
    </div>
    <div class="form-group col-md-4">
      <label for="inputCity">Description</label>
      <textarea  class="form-control" rows="4" id="description" name="description" required="required"></textarea>
    </div>
  </div>
    <br> <br>
    <div class="form-group" id="initial">
     
        <?php foreach ($initial as $key) { ?>
      
          <div class="row">
      <div class="col-md-1"></div>
      <div class="form-group col-md-4">
      <label for="inputCity">Initial Payment </label>
      <input class="form-control" id="initialfe" data-date-format="MM DD YYYY" min="2018-01-01" max="2099-01-01" name="initial" type="date" value="<?php echo $key->Initial_Pay_Date;?>" required="required">
    </div>
    <div class="form-group col-md-4">
      <label for="inputState">$Amount</label>
      <div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text">$</span>
  </div>
  <input type="number" class="form-control" name="initialp" id="initialp" aria-label="Amount (to the nearest dollar)"  value="<?php echo intval($key->Initial_Pay_Amount);?>" required="required">
  <div class="input-group-append">
    <span class="input-group-text">.00</span>
  </div>
</div>
    
    </div>
    <!-- <div class="form-group col-md-2">
      <label for="inputState">Add Payments </label><br>
      <input class="btn badge-danger" type="button" value="+" onclick="addinitial();">
    </div> -->
  </div>
        <?php } ?>
   
  </div>
  <br>
   <div class="form-row">
    <div class="form-group col-md-3">
      <label for="inputCity">Payment Plan</label>
      <input type="date" class="form-control" value="<?php echo date('Y-m-d', strtotime($info[0]->Date_Montly_P));?>" name="iniciopay" min="2018-01-01" max="2099-01-01" id="paymentplan" required="required">
    </div>
    
    <div class="form-group col-md-3">
      <label for="inputZip">$Amount</label>
      <div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text">$</span>
  </div>
  <input type="number" class="form-control" value="<?php echo intval($info[0]->Montly_Amount) ?>" name="amountpay" id="amountplan"  aria-label="Amount (to the nearest dollar)" required="required">
  <div class="input-group-append">
    <span class="input-group-text">.00</span>
  </div>
</div>
    
    </div>
    <div class="form-group col-md-3">
      <label for="inputState">Frecuency</label>
      <select id="frecuency" class="form-control"  required="required">
      
        <option value="1">One Time</option>
        <option value="2">Weekly</option>
        <option value="3">Every 2 Weeks</option>
        <option value="4">Monthly Payments</option>
      </select>
    </div>

    <div class="form-group col-md-3">
      <label for="inputState">Status</label>
      <select id="status" class="form-control" required="required">
      
        <option value="1">Paid in Full</option>
        <option value="2">On hold</option>
        <option value="3">Up to date</option>
        <option value="4">Overdue</option>
        <option value="5">Suspended</option>
        <option value="6">Cancelled</option>
      </select>
    </div>
  </div>
  
    <br><br>

    <div class="row">
      <div class="col-8"></div>
      <div class="col-4">
         
         <div class="form-group col-md-12 text-right">
        <button type="button" onclick="enviar()" class="btn btn-success btn-lg align-self-end">Save</button>
      </div>
      </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>

    
  
</form>
  </center>
</div>

<div class="container">
     <!-- <div class="col-md-12">
         <form method="post" class="form-inline" id="info1">
          <input type="text" name="search" id="search" class="form-control-lg rounded-0 col-md-12  p-4 mt-3 border-info" placeholder="Search Client" style="width: 80%;">
      
         </form>
         <div class="col-md-12">
            <div class="list-group col-md-8" id="show-list" style="position: fixed; z-index: 2;">
      
            </div>
         </div>
     </div> -->
     <br> <br> <br> <br>

     



  <ul class="list-group" id="listas">
  <!-- <li  onclick="alert('ok');" class="list-group-item active">Services</li> -->
 <!--  <li class="list-group-item">Dapibus ac facilisis in</li>
  <li class="list-group-item">Morbi leo risus</li>
  <li class="list-group-item">Porta ac consectetur ac</li>
  <li class="list-group-item">Vestibulum at eros</li> -->
     </ul>

  


</div>

<!-- <button onclick="enviar()">
  vamos a darle
</button>

<button class="btn btn-info" onclick="addinitial()">
  Add Initial Payments
</button> -->

<script type="text/javascript">
 
  var initial = 1;
  var services = [];
  var pays = [];
  var valp = [];

  $(document).ready(function(){
    var frecuencyx = <?php echo $info[0]->Frequency_ID?>;
    var statusx =  <?php echo $info[0]->Status_ID?>;
    $("#frecuency").val(frecuencyx);
    $("#status").val(statusx);

    $("#search").keyup(function(){
      var searchtext = $(this).val();
      if (searchtext != '') {
        $.ajax ({
          url: "<?php echo site_url('allclients');?>",
          method: 'post',
          data: {query:searchtext},
          success:function(response){
            $("#show-list").html(response);
          }

        });
      }else{
        $("#show-list").html('');
      }
    });   
     $(document).on('click', 'a', function(){
      $("#search").val($(this).text());
      $("#show-list").html('');
     })

     $('.js-example-basic-single').select2();

     $("#miselect").change(function() {
      var im = $("#miselect").val();
      services.push(im);
      var oks = $('select[name="state"] option:selected').text();
      var ok = "ok";

      // $("#add").append('<tr id="'+im+'"><th scope="row">1</th><td>'+oks+'</td><td>Otto</td><td><input type="button" value="ok" onclick=elim("'+im+'")></td></tr>');
      $("#prueba").append('<li id="'+im+'" class="list-group-item d-flex justify-content-between align-items-center">'+oks+'<span onclick=elim("'+im+'") class="badge badge-primary badge-pill">X</span></li>');

     
    });


     
    
  
  });

    function addinitial(){
      
      initial = initial+1;
       $("#initial").append('<div class="row"><div class="col-md-1"></div><div class="form-group col-md-4"><label for="inputCity">Initial Payment '+initial+' </label><input class="form-control" name="initial'+initial+'" id="initial'+initial+'"" type="date" min="2018-01-01" max="2099-01-01" value=""></div><div class="form-group col-md-4"><label for="inputState">$Amount</label> <div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text">$</span></div><input type="number" class="form-control"id="initialp'+initial+'" name="initial'+initial+'" aria-label="Amount (to the nearest dollar)"><div class="input-group-append"><span class="input-group-text">.00</span></div></div></div></div>');
      // $("#initial").append('<div class="row"><div class="col-md-1"></div><div class="form-group col-md-4"><label for="inputCity">Initial Payment '+initial+' </label><input class="form-control" name="initial'+initial+'" id="initial'+initial+'"" type="date" min="2018-01-01" max="2099-01-01" value=""></div><div class="form-group col-md-4"><label for="inputState">$Amount</label><input class="form-control" id="initialp'+initial+'" name="initial'+initial+'" type="number" value=""></div></div>');
    }



  function elim(im){
      $( "#"+im ).remove();
      var index = services.indexOf(im);
      if (index > -1) {
        services.splice(index, 1);
      }
       console.log(services);
    }

    function enviar(){

      var ss = 2;
      for (var i = 0; i < initial-1; i++) {
           
         
         
            pays.push($('#initial'+ss).val());
            valp.push($('#initialp'+ss).val());
           ss = ss+1;
      
      }

      // console.log(pays);
      var info1 = $('#search').val();
      var servicesto = $('#servicesto').val();
      var contractnumber = $('#contractnumber').val();
      var contractvalue = $('#contractvalue').val();
      var description = $('#description').val();
      var initialfe = $('#initialfe').val();
      var initialp = $('#initialp').val();
      var amountplan = $('#amountplan').val();
      var paymentplan = $('#paymentplan').val();
      var frecuency = $('#frecuency').val();
      var status = $('#status').val();
      var contractsign = $('#contractsign').val();
      var id =  "<?php echo $contract_data;?>";
      
      // $.ajax ({
      //     url: "<?php echo site_url('addContract1');?>",
      //     type: 'POST',
      //     data: {info1: info1, servicesto:servicesto, contractnumber:contractnumber, contractvalue:contractvalue, description:description, initialfe:initialfe, initialp:initialp, amountplan:amountplan, paymentplan:paymentplan, frecuency:frecuency, status:status, pays: pays, valp:valp, services:services, contractsign: contractsign },
      //     success:function(response){
           
      //     }

      //   });

      $.ajax ({
          url: "<?php echo site_url('C_contracts/editcont');?>",
          type: 'POST',
          data: {id:id, contractvalue:contractvalue, amountplan:amountplan, paymentplan:paymentplan, frecuency:frecuency , contractnumber:contractnumber, status:status,  contractsign:contractsign, servicesto:servicesto},
          success:function(response){
            setTimeout(function(){  window.location.assign("<?php echo site_url('contrac');?>"); }, 1000);
            if (response) {
              Swal.fire({
              title: 'Done!',
              text: 'Successfully Updated!',
              icon: 'success'
            }).then((result) => {
                setTimeout(function(){  window.location.assign("<?php echo site_url('contrac');?>"); }, 10);
             })
            }
          }

        });

      console.log(contractvalue,amountplan, paymentplan, frecuency , status,  contractsign);


    }

    function addclient(){
          
            $.ajax({
            data: {ok: ok},
            url: "<?php echo site_url('C_client/new_client');?>",
            type:"POST",
            dataType:"html",
            }).done(function(data) {
              $(".modal-title").html('Add User');
              $(".modal-body").html(data);

              

            });
          }
    

</script>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>