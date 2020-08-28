
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

<style>
  .vertical-menu {
  width: 200px; /* Set a width if you like */
}

.vertical-menu a {
  background-color: #FFFFFF; /* Grey background color */
  color: black; /* Black text color */
  display: block; /* Make the links appear below each other */
  padding: 12px; /* Add some padding */
  text-decoration: none; /* Remove underline from links */
}

.vertical-menu a:hover {
  background-color: #ccc; /* Dark grey background on mouse-over */
}

.vertical-menu a.active {
  background-color: #4CAF50; /* Add a green color to the "active/current" link */
  color: white;
}

.container{
  margin: 0%;
  padding: 0%;
}
</style>



  <div class="container">
    <div class="row">
      <div class="col-3">
        <div class="vertical-menu">
          <a href="#" class="active">Contract Status</a>
          <a href="<?php echo base_url('C_contracts/firmados')?>">Signed Contracts</a>
          <a href="<?php echo base_url('C_contracts/services')?>">Services</a>
          <!-- <a  href="<?php echo base_url('C_contracts/payments')?>">Payments Methods</a> -->
          <a  href="<?php echo base_url('C_contracts/totalincome')?>">Total Income</a>
          <a  href="<?php echo base_url('C_contracts/paymentform')?>">Payment Form</a>
          <a  href="<?php echo base_url('C_contracts/newcontracts')?>">New Contracts</a>
          <a  href="<?php echo base_url('C_contracts/newcontractsonhold')?>">New Contracts on Hold</a>
          <a  href="<?php echo base_url('C_contracts/newcontractsf')?>">Contract Value</a>
          <a  href="<?php echo base_url('C_contracts/newpaymentsf')?>">Contract Monthly Payments</a>
          <a  href="<?php echo base_url('C_contracts/paymentshold')?>">Contracts no payments </a>
        </div>
      </div>

      <div class="col-9">
        <div class="row okss">
          <div class="col-2 text-right">
              <p>Select dates :</p>
          </div>
          <div class="col-10">
            <input  class="text-center rango" style="width: 300px;  border: 1px solid #888 !important; border-radius: 5px;" type="text" name="daterange" value="<?php echo date("d/m/Y"); ?>" />

           <button class="btn btn-sm btn-info" type="button" onclick="exceltype()" style="height: 60%; margin-top: -1%;">Exportar Excel</button>
            <button class="btn btn-sm btn-success" type="button" onclick="excel()" style="height: 60%; margin-top: -1%;">Exportar Excel General</button>

            <button class="btn btn-sm btn-success" type="button" onclick="imprimir()" style="height: 60%; margin-top: -1%;">Print</button>
         </div>

       </div>

       <div class="row">
        <div class="col-8" style=" margin-top: 5%;"  id="todos">
          <canvas id="myChart" width="30" height="30"></canvas>
          <canvas id="myChart1" width="30" height="30"></canvas>

        </div>
        <div class="col-2" style="margin-top: 25%;">
          <div class="col-12" id="pagado0"> 
              
              <span class="badge badge-secondary" style="padding: 5px; font-size: 15px; background-color: #000000; width: 200px; ">Cancel : <?php print_r($cancel[0]->total); ?></span> 
          </div>
          <br>
          <div class="col-12" id="pagado1"> 
            <span class="badge badge-secondary" style="padding: 5px; font-size: 15px; background-color: #f8f32b; width: 200px;" >Pending / On Hold : <?php print_r($hold[0]->total); ?></span>  
               
          </div>
          <br>
          <div class="col-12" id="pagado2">

             <span class="badge badge-secondary" style="padding: 5px; font-size: 15px; margin-top: 3%; background-color: #f93b20; width: 200px;">Up to Date : <?php print_r($uptodate[0]->total); ?></span> 
               
          </div>
          <br>
          <div class="col-12" id="pagado3">

             <span class="badge badge-secondary"  style="padding: 5px; font-size: 15px; background-color: #70DF71; width: 200px;" >Paid in Ful :<?php print_r($paid[0]->total); ?></span>

           
                
          </div>
          <br>
          <div class="col-12" id="pagado4">
              <span class="badge badge-secondary" style="padding: 5px; font-size: 15px; background-color: #009688; margin-top: 3%; width: 200px;" >Overdue : <?php print_r($overdue[0]->total); ?></span>
          </div>
        </div>
         
       </div>
      </div>
    </div>
    <br>
    <br>
    <br>

    <div class="row" id="imp1">
      <div class="col-4"></div>
      <div class="col-6">
        <div class="list-group">
          <a href="#" class="list-group-item list-group-item-action active text-center">
             Contract status
          </a>
          <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between align-items-center list-group-item list-group-item-action" id="tabla0">
                 Paid in Full 
                  <span class="badge badge-primary badge-pill"  id="tablas0"><?php print_r($paid[0]->total); ?></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center list-group-item list-group-item-action" id="tabla1">
                 Pending / On Hold
                  <span class="badge badge-primary badge-pill" id="tablas1"><?php print_r($hold[0]->total); ?></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center list-group-item list-group-item-action" id="tabla2">
                 Cancel
                  <span class="badge badge-primary badge-pill" id="tablas2"><?php print_r($cancel[0]->total); ?></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center list-group-item list-group-item-action" id="tabla3">
                 Up to Date
                  <span class="badge badge-primary badge-pill" id="tablas3"><?php print_r($overdue[0]->total); ?></span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center list-group-item list-group-item-action" id="tabla4">
                 Overdue
                  <span class="badge badge-primary badge-pill" id="tablas4"><?php print_r($uptodate[0]->total); ?></span>
              </li>
          </ul>
        </div>

      </div>
    </div>
  </div>
    
  

<script>

  $('#myChart1').hide();

    var arreglo = [<?php echo $hold[0]->total?>, <?php echo $cancel[0]->total?>, <?php echo $paid[0]->total?>, <?php echo $uptodate[0]->total?>, <?php echo $overdue[0]->total?>];

    var ctx = document.getElementById('myChart').getContext('2d');
    var ctx1 = document.getElementById('myChart1').getContext('2d');
   
    $(function() {
    $('input[name="daterange"]').daterangepicker({
    linkedCalendars: false,
     ranges: {
        'This Month': [moment().startOf('month'), moment().endOf('month')]
        // 'All Time': [moment().subtract(49, 'month').startOf('month'), moment()]

    },

  }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));

       var inicio =  start.format('YYYY-MM-DD');
       var fin = end.format('YYYY-MM-DD');

      $.ajax({
      url: "<?php echo site_url('C_contracts/estatuscontract');?>",
      data: {inicio : inicio , fin: fin},
      type: 'POST',
      success:function(response){

            $('#myChart').hide();
            $('#myChart1').show();


            myPieChart.destroy();

            var  arreglo1 = [0,0,0,0,0];
            var arregloinfo= [];
            var arres = ['Cancel', 'Overdue', 'Up to date', 'On hold', 'Paid in full'];
            var calncelsus = 0;

            var nuevo = JSON.parse(response);

           
      
            
   

            for (var i = nuevo.length - 1; i >= 0; i--) {


          switch (nuevo[i]['Status']) {
            case 'Suspended': 

          
               calncelsus = calncelsus + parseInt(nuevo[i]['total'], 10);
               

            break;

            case 'On hold': 

               
               arreglo1[3] = nuevo[i]['total'];
               

            break;

            case 'Overdue': 

             
               arreglo1[1] = nuevo[i]['total'];
               


            break;

            case 'Paid in full': 


              
               arreglo1[4] = nuevo[i]['total'];
               

            break;

            case 'Up to date': 

            
               arreglo1[2] = nuevo[i]['total'];
               

            break;

            case 'Cancelled': 

            
               calncelsus = calncelsus + parseInt(nuevo[i]['total'], 10);
               

            break;
            
            }

            }

            arreglo1[0]=calncelsus;

           

            // $("#pagado"+i).html(arres[i]+': '+arreglo1[i]);

            // $("#tabla"+i).html(arres[i]+'<span class="badge badge-primary badge-pill" id="tablas'+i+'"></span>');
            // $("#tablas"+i).text(arreglo1[i]);

            // switch (nuevo[i]['Status']) {
            // case 'Suspended': 

          
            //    arreglo1[i] = nuevo[i]['total'];
               

            // break;

            // case 'On hold': 

               
            //    arreglo1[i] = nuevo[i]['total'];
               

            // break;

            // case 'Overdue': 

             
            //    arreglo1[i] = nuevo[i]['total'];
               


            // break;

            // case 'Paid in full': 


              
            //    arreglo1[i] = nuevo[i]['total'];
               

            // break;

            // case 'Up to date': 

            
            //    arreglo1[i] = nuevo[i]['total'];
               

            // break;
            
            // }

            
            
               


            for (var i = 4; i >= 0; i--) {

             

            switch (arres[i]) {
                case 'Cancel': 


                  $("#pagado"+i).html('<span class="badge badge-secondary" style="padding: 5px; font-size: 15px; background-color: #000000; width: 200px; " >'+arres[i]+' / Suspended: '+arreglo1[i]+'</span> ');
                  

                break;

                case 'On hold': 
                 

                  $("#pagado"+i).html('<span class="badge badge-secondary" style="padding: 5px; font-size: 15px; background-color: #f8f32b; width: 200px; " >'+arres[i]+' : '+arreglo1[i]+'</span> ');

                break;

                case 'Overdue': 

               
                  
                  $("#pagado"+i).html('<span class="badge badge-secondary" style="padding: 5px; font-size: 15px; background-color: #70DF71; width: 200px; " >'+arres[i]+' : '+arreglo1[i]+'</span> ');

                break;

                case 'Paid in full':

                

                  $("#pagado"+i).html('<span class="badge badge-secondary" style="padding: 5px; font-size: 15px; background-color: #009688; width: 200px; " >'+arres[i]+' : '+arreglo1[i]+'</span> ');

                break;

                case 'Up to date': 

                   
                  
                  $("#pagado"+i).html('<span class="badge badge-secondary" style="padding: 5px; font-size: 15px; background-color: #f93b20; width: 200px; " >'+arres[i]+' : '+arreglo1[i]+'</span> ');

                break;
            
            }


               

               $("#tabla"+i).html(arres[i]+'<span class="badge badge-primary badge-pill" id="tablas'+i+'"></span>');
               $("#tablas"+i).text(arreglo1[i]);
            }


             

      
            data = {
 
    
    labels: arres,
    datasets: [{
        backgroundColor: ["#000000","#70DF71" ,"#f93b20", "#f8f32b", "#009688" ],
        data: arreglo1,
      }]
};




config = {
    type: 'pie',
    data: data,
    options: {
      tooltips: {
        titleFontSize: 20,
        bodyFontSize: 18
       },
    title: {
      display: true,
      text: 'Contract Status.',
      fontSize: 18
    },
    legend: {
            labels: {
                
                fontSize: 15
           }
         }
  },
};

myPieChart = new Chart(ctx1, config);


      }});
  });
});

 data = {
 
    
    labels: [
        'Pending / Hold',
        'Cancel',
        'Paid in Full',
        'Up to Date',
        'Overdue'
    ],
    datasets: [{
        backgroundColor: ["#f8f32b", "#000000","#70DF71", "#f93b20", "#009688" ],
        data: arreglo,
      }]
};


var myPieChart = new Chart(ctx, {
    type: 'pie',
    data: data,
    options: {
      tooltips: {
        titleFontSize: 20,
        bodyFontSize: 18
       },
    title: {
      display: true,
      text: 'Contract Status.',
      fontSize: 18
    },
    legend: {
            labels: {
                
                fontSize: 15
           }
         }
  },
});


function excel(){


  var cadena = $('input[name="daterange"]').val();

  cadena.substr(0,10);
  cadena.substr(12,22);

  var inicio = cadena.substr(6,4)+'-'+cadena.substr(3,2)+'-'+cadena.substr(0,2);
  var fin = cadena.substr(19,4)+'-'+cadena.substr(16,2)+'-'+cadena.substr(13,2);

  window.location.href = "http://ezlawpay.com/ez/download_excel?start_date="+inicio+"&end_date="+fin;

}


function exceltype(){


  var cadena = $('input[name="daterange"]').val();

  cadena.substr(0,10);
  cadena.substr(12,22);

  var inicio = cadena.substr(6,4)+'-'+cadena.substr(0,2)+'-'+cadena.substr(3,2);
  var fin = cadena.substr(19,4)+'-'+cadena.substr(13,2)+'-'+cadena.substr(16,2);

  window.location.href = "http://ezlawpay.com/ez/download_excel?start_date="+inicio+"&end_date="+fin+"&type=contracts";

}

function  imprimir(){

$('.vertical-menu').hide();
$('.okss').hide();
$('#breadcrumb').hide();
$('#jM5xn2k-1585957951891').hide();


document.getElementById("todos").style.marginLeft = "-130px";
document.getElementById("imp1").style.marginLeft = "-200px";
// document.getElementById("total").style.marginLeft = "-200px";




print();

location.reload();

}
   



</script>