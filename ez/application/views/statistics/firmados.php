
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
          <a href="<?php echo base_url('C_contracts/graficas')?>">Contracts</a>
          <a class="active" href="<?php echo base_url('C_contracts/firmados')?>">Signed Contracts</a>
          <a href="<?php echo base_url('C_contracts/services')?>">Services</a>
          <a  href="<?php echo base_url('C_contracts/payments')?>">Payments</a>
          <a  href="<?php echo base_url('C_contracts/totalincome')?>">Total Income</a>
          <a  href="<?php echo base_url('C_contracts/paymentform')?>">Payment Form</a>
          <a  href="<?php echo base_url('C_contracts/newcontracts')?>">New Contracts</a>
          <a  href="<?php echo base_url('C_contracts/newcontractsonhold')?>">New Contracts on Hold</a>
          <a  href="<?php echo base_url('C_contracts/newcontractsf')?>">Contract Value</a>
          <a  href="<?php echo base_url('C_contracts/newpaymentsf')?>">Contract Payment</a>
          <a  href="<?php echo base_url('C_contracts/paymentshold')?>">No Payments</a>
        </div>
      </div>

      <div class="col-9">
        <div class="row">
          <div class="col-2 text-right">
              <p>Select dates :</p>
          </div>
          <div class="col-10">
            <input  class="text-center rango" style="width: 300px;  border: 1px solid #888 !important; border-radius: 5px;" type="text" name="daterange" value="<?php echo date("d/m/Y"); ?>" />

           <button class="btn btn-sm btn-info" type="button" onclick="excel()" style="height: 60%; margin-top: -1%;">Exportar Excel</button>
            <button class="btn btn-sm btn-success" type="button" onclick="excel()" style="height: 60%; margin-top: -1%;">Exportar Excel General</button>
         </div>

       </div>

       <div class="row">
        <div class="col-12" style=" margin-top: 5%;">
          <canvas id="myChart2" width="180"></canvas>
        </div>
        
      </div>

      <br>
      <br>
      <br>
      

      <div class="row">
      <div class="col-4">
        <div class="row">
          <div class="col-12">
            <div class="list-group">
          <a href="#" class="list-group-item list-group-item-action active text-center">
             Contracts Created
          </a>
          <ul class="list-group">
            

              <li class="list-group-item d-flex justify-content-between align-items-center list-group-item list-group-item-action">
                 THIS WEEK
                  <span class="badge badge-secondary" style="padding: 5px; font-size: 15px; margin-bottom: 3%; width: 130px;"><?php echo $semanafirm;  ?></span>
              </li>

               <li class="list-group-item d-flex justify-content-between align-items-center list-group-item list-group-item-action">
                 THIS MONTH
                  <span class="badge badge-secondary" style="padding: 5px; font-size: 15px; margin-bottom: 3%; width: 130px;"><?php echo $mesfirm;  ?></span>
              </li>

               <li class="list-group-item d-flex justify-content-between align-items-center list-group-item list-group-item-action">
                 THIS YEAR
                  <span class="badge badge-secondary" style="padding: 5px; font-size: 15px; margin-bottom: 3%; width: 130px;"><?php echo $aniofimr;  ?></span>
              </li>
           
             
          </ul>
        </div>
          </div>

          <div class="col-12" style="margin-top: 10%;" id="range1">
            <div class="list-group">
          <a href="#" class="list-group-item list-group-item-action active text-center">
            Contracts in date range
          </a>
          <ul class="list-group" id="range">
            

      
           
             
          </ul>
        </div>
          </div>
          
      </div>
        
      </div>
      <div class="col-4">
        <div class="list-group">
          <a href="#" class="list-group-item list-group-item-action active text-center">
             Contracts Signed per Day
          </a>
          <ul class="list-group" id="prueba">
            <!-- <?php for ($i=10; $i > 0; $i--) { ?>

              <li class="list-group-item d-flex justify-content-between align-items-center list-group-item list-group-item-action">
                 <?php echo $arreglo[$i];  ?>
                  <span class="badge badge-secondary" style="padding: 5px; font-size: 15px; margin-bottom: 3%; width: 130px;"><?php echo $informacion[$i];  ?></span>
              </li>
              
            <?php } ?> -->
             
          </ul>
        </div>

      </div>

      <div class="col-4" >
        <div class="list-group">
          <a href="#" class="list-group-item list-group-item-action active text-center">
             Contracts On hold per Day
          </a>
          <ul class="list-group" id="prueba2">
            <!-- <?php for ($i=10; $i > 0; $i--) { ?>

              <li class="list-group-item d-flex justify-content-between align-items-center list-group-item list-group-item-action">
                 <?php echo $arreglo[$i];  ?>
                  <span class="badge badge-secondary" style="padding: 5px; font-size: 15px; margin-bottom: 3%; width: 130px;"><?php echo $informacion[$i];  ?></span>
              </li>
              
            <?php } ?> -->
             
          </ul>
        </div>

      </div>


    </div>
         
       </div>
      </div>
    </div>
    <br>
    <br>
    <br>

   

<script>

   
  var arreglosdxzz = Object.values(<?php echo json_encode($arreglo);?>);
  var arreglosdx = arreglosdxzz.reverse();
  var vamosxsa = Object.values(<?php echo json_encode($informacion);?>);
  var vamos = vamosxsa.reverse();

  var onhold = Object.values(<?php echo json_encode($onhold);?>);
  var onhold1 = onhold.reverse();


  var ctx2 = document.getElementById('myChart2').getContext('2d');

  $( document ).ready(function() {


  
    $("#prueba").children().remove();
      $("#prueba2").children().remove();
      $("#range1").hide();

        
        var fechas = [];
      var cont = 0;
      var total = []; 
      var total2 = []; 
      var totalfirma = 0;
      var totalhold = 0;

      $.ajax({
      url: "<?php echo site_url('C_contracts/firmadosdiass');?>",
      type: 'POST',
      success:function(response){




       
          var nuevoxc =  JSON.parse(response);

          for (const prop in nuevoxc) {

             

            total[cont] =nuevoxc[prop][0];
            total2[cont] =nuevoxc[prop][1];
            fechas[cont] = prop;

            cont++;

        }


        fechas = fechas.reverse();
        total  = total.reverse()
        total2 = total2.reverse()


        config = {
  type: 'line',
  data: {
    labels: fechas,
    datasets: [{ 
        data: total,
        label: "Signed Contracts",
        borderColor: "#f93b20",
        fill: false
      },
      { 
        data: total2,
        label: "On Hold",
        borderColor: "#3e95cd",
        fill: false
      }

    ]
  },
  options: {
    title: {
      display: true,
      text: 'Contracts Created.',
      fontSize: 18
    },
    legend: {
            labels: {
             
                fontSize: 15
           }
         }
  }
}

 myPieChart = new Chart(ctx2, config);



 for (var i = 0; i < fechas.length; i++) {

            if (total[i] === null || total2[i] === undefined) {
                total[i] = 0;
            }

            if (total2[i] === null || total2[i] === undefined) {
                total2[i] = 0;
            }

            // alert(total2[i]);

            $("#prueba").append('<li class="list-group-item d-flex justify-content-between align-items-center list-group-item list-group-item-action">'+fechas[i]+'<span class="badge badge-secondary" style="padding: 5px; font-size: 15px; margin-bottom: 3%; width: 130px;">'+total[i]+'</span></li>');

           


            $("#prueba2").append('<li class="list-group-item d-flex justify-content-between align-items-center list-group-item list-group-item-action">'+fechas[i]+'<span class="badge badge-secondary" style="padding: 5px; font-size: 15px; margin-bottom: 3%; width: 130px;">'+total2[i]+'</span></li>');

           



          }


           

      }
    });
  });
   
    $(function() {
    $('input[name="daterange"]').daterangepicker({
    linkedCalendars: false,
    maxSpan: {
        days: 90
    },

     ranges: {
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'All Time': [moment().subtract(49, 'month').startOf('month'), moment()]

    },

  }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));

      $("#prueba").children().remove();
      $("#prueba2").children().remove();
      $('#range').children().remove();
      $('#range1').show();
      
        inicio = start.format('YYYY-MM-DD');
        fin = end.format('YYYY-MM-DD');
        var fechas = [];
      var cont = 0;
      var total = []; 
      var total2 = []; 

       var totalfirma = 0;
      var totalhold = 0;

      $.ajax({
      url: "<?php echo site_url('C_contracts/firmadosdiass');?>",
      type: 'POST',
      data: {inicio : inicio, fin: fin},
      success:function(response){




           myPieChart.destroy();
          var nuevoxc =  JSON.parse(response);

          for (const prop in nuevoxc) {

             

            total[cont] =nuevoxc[prop][0];
            total2[cont] =nuevoxc[prop][1];
            fechas[cont] = prop;

            cont++;

        }


        config = {
  type: 'line',
  data: {
    labels: fechas,
    datasets: [{ 
        data: total,
        label: "Signed Contracts",
        borderColor: "#f93b20",
        fill: false
      },
      { 
        data: total2,
        label: "On Hold",
        borderColor: "#3e95cd",
        fill: false
      }

    ]
  },
  options: {
    title: {
      display: true,
      text: 'Signed Contracts.',
      fontSize: 18
    },
    legend: {
            labels: {
             
                fontSize: 15
           }
         }
  }
}

 myPieChart = new Chart(ctx2, config);



 for (var i = 0; i < fechas.length; i++) {

            if (total[i] === null) {
                total[i] = 0;
            }

            if (total2[i] === null) {
                total2[i] = 0;
            }

            $("#prueba").append('<li class="list-group-item d-flex justify-content-between align-items-center list-group-item list-group-item-action">'+fechas[i]+'<span class="badge badge-secondary" style="padding: 5px; font-size: 15px; margin-bottom: 3%; width: 130px;">'+total[i]+'</span></li>');

            totalfirma = totalfirma + parseInt(total[i],10);

            $("#prueba2").append('<li class="list-group-item d-flex justify-content-between align-items-center list-group-item list-group-item-action">'+fechas[i]+'<span class="badge badge-secondary" style="padding: 5px; font-size: 15px; margin-bottom: 3%; width: 130px;">'+total2[i]+'</span></li>');

              totalhold = totalhold + parseInt(total2[i],10);

          }

          $("#range").append('<li class="list-group-item d-flex justify-content-between align-items-center list-group-item list-group-item-action">Contract Signed<span class="badge badge-secondary" style="padding: 5px; font-size: 15px; margin-bottom: 3%; width: 130px;">'+totalfirma+'</span></li>');

             


            $("#range").append('<li class="list-group-item d-flex justify-content-between align-items-center list-group-item list-group-item-action">Contract on Hold<span class="badge badge-secondary" style="padding: 5px; font-size: 15px; margin-bottom: 3%; width: 130px;">'+totalhold+'</span></li>');

             

      }
    });

     
  });
});

 
 

//   config = {
//   type: 'line',
//   data: {
//     labels: arreglosdx,
//     datasets: [{ 
//         data: vamos,
//         label: "Signed Contracts",
//         borderColor: "#f93b20",
//         fill: false
//       },
//       { 
//         data: onhold1,
//         label: "On Hold",
//         borderColor: "#3e95cd",
//         fill: false
//       }

//     ]
//   },
//   options: {
//     title: {
//       display: true,
//       text: 'Contracts signed the last 10 days.',
//       fontSize: 18
//     },
//     legend: {
//             labels: {
             
//                 fontSize: 15
//            }
//          }
//   }
// }

//  myPieChart = new Chart(ctx2, config);
   
function excel(){


  var cadena = $('input[name="daterange"]').val();

  cadena.substr(0,10);
  cadena.substr(12,22);

  var inicio = cadena.substr(6,4)+'-'+cadena.substr(3,2)+'-'+cadena.substr(0,2);
  var fin = cadena.substr(19,4)+'-'+cadena.substr(16,2)+'-'+cadena.substr(13,2);

  window.location.href = "http://ezlawpay.com/ez/download_excel?start_date="+inicio+"&end_date="+fin;

}

function excelindo(){


  var cadena = $('input[name="daterange"]').val();

  cadena.substr(0,10);
  cadena.substr(12,22);

  var inicio = cadena.substr(6,4)+'-'+cadena.substr(3,2)+'-'+cadena.substr(0,2);
  var fin = cadena.substr(19,4)+'-'+cadena.substr(16,2)+'-'+cadena.substr(13,2);

  window.location.href = "http://ezlawpay.com/ez/download_excel?start_date="+inicio+"&end_date="+fin+"&type=contracts";

}



</script>