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
  margin: 0%!important;
  padding: 0%!important;
}
</style>



  <div class="container">
    <div class="row">
      <div class="col-3">
        <div class="vertical-menu">
          <a href="<?php echo base_url('statistics')?>" >Contract Status</a>
          <a href="<?php echo base_url('C_contracts/firmados')?>">Signed Contracts</a>
          <a href="<?php echo base_url('C_contracts/services')?>">Services</a>
          <!-- <a  href="<?php echo base_url('C_contracts/payments')?>">Payments Methods</a> -->
          <a  href="<?php echo base_url('C_contracts/totalincome')?>">Total Income</a>
          <a  href="<?php echo base_url('C_contracts/paymentform')?>">Payment Form</a>
          <a href="<?php echo base_url('C_contracts/newcontracts')?>">New Contracts</a>
          <a   class="active" href="<?php echo base_url('C_contracts/newcontractsonhold')?>">New Contracts on Hold</a>
          <a  href="<?php echo base_url('C_contracts/newcontractsf')?>">Contract Value</a>
          <a  href="<?php echo base_url('C_contracts/newpaymentsf')?>">Contract Monthly Payments</a>
          <a  href="<?php echo base_url('C_contracts/paymentshold')?>">Contracts no payments </a>
         
        </div>
      </div>

      <div class="col-9">
        <div class="row" >
          <div class="col-4 okss">
      <select name="changeMonth" class="form-control" id="month-select">
          <option selected value="0">Month</option>
          <option value="01">Jan</option>
          <option value="02">Feb</option>
          <option value="03">Mar</option>
          <option value="04">Apr</option>
          <option value="05">May</option>
          <option value="06">Jun</option>
          <option value="07">Jul</option>
          <option value="08">Aug</option>
          <option value="09">Sep</option>
          <option value="10">Oct</option>
          <option value="11">Nov</option>
          <option value="12">Dec</option>
      </select>
    </div>

    <div class="col-4 okss">
      <select name="changeMonth" class="form-control" id="year-select">
          <option selected value="0">Year</option>
          <option value="2016">2016</option>
          <option value="2017">2017</option>
          <option value="2018">2018</option>
          <option value="2019">2019</option>
          <option value="2020">2020</option>
          <option value="2021">2021</option>
          <option value="2022">2022</option>
          <option value="2023">2023</option>
          <option value="2024">2024</option>
          <option value="2025">2025</option>
          <option value="2026">2026</option>
          <option value="2027">2027</option>
      </select>
    </div>

    <div class="col-4">
       <button class="btn btn-info okss" onclick="actulizar();">
      Send
    </button>

    <button class="okss btn btn-info" type="button" onclick="imprimir();">Print</button>
    </div>

     <br>
    <!--  <button  style="margin-top: .5rem; margin-left: .8rem;" class="okss btn btn-info" onclick="exceltype()">Export to Excel</button> -->

     <button  style="margin-top: .5rem; margin-left: .8rem;" class="okss btn btn-info" onclick="excel()">Report</button>

       </div>

        <br>
        <br>
        <br>
        <center><h2 id="total"></h2></center>
        <center><h3 id="promedio"></h3></center>
       <div class="row"  id="todos">

         <canvas id="horizontal"></canvas>
         
       </div>

       <br>
    <br>
       <div class="tabla row"  id="imp1">
      <div class="col-md-4">
        <ul class="list-group" id="prueba">
          <li style="background-color: #007bff; color: #FFFFFF; height: 45px; margin-top:15px;" onclick="alert('ok');" class="list-group-item"></li>
        </ul>
      </div>

      <div class="col-md-4">
        <ul class="list-group" id="prueba1">
          <li style="background-color: #007bff; color: #FFFFFF; height: 45px; margin-top:15px;" onclick="alert('ok');" class="list-group-item"></li>
        </ul>
      </div>
      <div class="col-md-4">
        <ul class="list-group" id="prueba2">
          <li style="background-color: #007bff; color: #FFFFFF; height: 45px; margin-top:15px;" onclick="alert('ok');" class="list-group-item"></li>
        </ul>
      </div>

    </div>

      </div>
    </div>
    <br>
    <br>
    <br>
  </div>
    
    
  



<script>

  
    var ptt2 = document.getElementById('horizontal').getContext('2d');

  $( document ).ready(function() {
    
    var fechas = [];
    var cont = 0;
    var total = [];
    var sumatt = 0;  

    $.ajax({
      url: "<?php echo site_url('C_contracts/onholdcontracts');?>",
      type: 'POST',
      success:function(response){

       


         var nuevoxc =  JSON.parse(response);
         console.log(response);



            for (const prop in nuevoxc) {
            total[cont] = nuevoxc[prop];
            fechas[cont] = prop;
          

            cont++;

        }



      

    config = {
    type: 'bar',
    data: {
 
   
    labels: fechas,
    datasets: [{
        backgroundColor: "#009688",
        data: total,
      }]
},
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: 'Contracts',
        fontSize: 18
      },
      scales: {
            yAxes: [{
                ticks: {

                    fontSize: 15,
                }
            }]
        }
    }
};

          myBarChart = new Chart(ptt2, config);

          for (var i = 0; i < 10; i++) {

            if (total[i] === null) {
                total[i] = 0;
            }

            $("#prueba").append('<li  class="list-group-item d-flex justify-content-between align-items-center">'+fechas[i]+'<span onclick=elim() class="badge badge-primary badge-pill">'+total[i]+'</span></li>');
          }
          for (var i = 10; i < 20; i++) {

            if (total[i] === null) {
                total[i] = 0;
            }

            $("#prueba1").append('<li  class="list-group-item d-flex justify-content-between align-items-center">'+fechas[i]+'<span onclick=elim() class="badge badge-primary badge-pill">'+total[i]+'</span></li>');
          }

          for (var i = 20; i < fechas.length; i++) {

            if (total[i] === null) {
                total[i] = 0;
            }

            $("#prueba2").append('<li  class="list-group-item d-flex justify-content-between align-items-center">'+fechas[i]+'<span onclick=elim() class="badge badge-primary badge-pill">'+total[i]+'</span></li>');
          }

          totalonhold();

      }
    });  ///este es el ultimo 

    
    function totalonhold(){
      $.ajax({
      url: "<?php echo site_url('C_contracts/totalonhold');?>",
      type: 'GET',
      success:function(response){

           var nuevonumero = Number.parseFloat((parseInt(response, 10)/fechas.length)).toFixed(2);  
          $("#total").text("Contracts On Hold: " + new Intl.NumberFormat().format(response));
          $("#promedio").text("Average : " +nuevonumero);

      }});
    }




    

      });



    
  
   
    function actulizar() {

      var mes = $("#month-select").val();
      var year = $("#year-select").val();

       $("#prueba").children().remove(); 
      $("#prueba1").children().remove(); 
      $("#prueba2").children().remove();

      $("#prueba").append('<li style="background-color: #007bff; color: #FFFFFF; height: 45px; margin-top:15px;" onclick="alert();" class="list-group-item"></li>');
      $("#prueba1").append('<li style="background-color: #007bff; color: #FFFFFF; height: 45px; margin-top:15px;" onclick="alert();" class="list-group-item"></li>'); 
      $("#prueba2").append('<li style="background-color: #007bff; color: #FFFFFF; height: 45px; margin-top:15px;" onclick="alert();" class="list-group-item"></li>'); 
      
      var fechas = [];
      var cont = 0;
      var total = [];  


       $.ajax({
      url: "<?php echo site_url('C_contracts/onholdcontracts');?>",
      type: 'POST',
      data: {mes : mes, year: year},
      success:function(response){

          myBarChart.destroy();
         

          var nuevoxc =  JSON.parse(response);



           for (const prop in nuevoxc) {
            total[cont] = nuevoxc[prop];
            fechas[cont] = prop;

            cont++;

        }

          

        

      config = {
    type: 'bar',
    data: {
 
   
    labels: fechas,
    datasets: [{
        backgroundColor: "#009688",
        data: total,
      }]
},
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: 'Total Income',
        fontSize: 18
      },
      scales: {
            yAxes: [{
                ticks: {

                    fontSize: 15,
                }
            }]
        }
    }
};

        
     myBarChart = new Chart(ptt2, config);

     for (var i = 0; i < 10; i++) {

            if (total[i] === null) {
                total[i] = 0;
            }

            $("#prueba").append('<li  class="list-group-item d-flex justify-content-between align-items-center">'+fechas[i]+'<span onclick=elim() class="badge badge-primary badge-pill">'+total[i]+'</span></li>');
          }
          for (var i = 10; i < 20; i++) {

            if (total[i] === null) {
                total[i] = 0;
            }

            $("#prueba1").append('<li  class="list-group-item d-flex justify-content-between align-items-center">'+fechas[i]+'<span onclick=elim() class="badge badge-primary badge-pill">'+total[i]+'</span></li>');
          }

          for (var i = 20; i < fechas.length; i++) {

            if (total[i] === null) {
                total[i] = 0;
            }

            $("#prueba2").append('<li  class="list-group-item d-flex justify-content-between align-items-center">'+fechas[i]+'<span onclick=elim() class="badge badge-primary badge-pill">'+total[i]+'</span></li>');
          }
          
     totalonhold();
      }
    });



   function totalonhold(){
    $.ajax({

      url: "<?php echo site_url('C_contracts/totalonhold');?>",
      type: 'POST',
      data: {mes : mes, year: year},
      success:function(response){

  

          var nuevonumero = Number.parseFloat((parseInt(response, 10)/fechas.length)).toFixed(2);  
          $("#total").text("Contracts On Hold : " + new Intl.NumberFormat().format(response));
          $("#promedio").text("Average : " +nuevonumero);

      }});
   }

  };


function excel(){

 var mes = $("#month-select").val();
  var year = $("#year-select").val();


  window.location.href = "https://ezlawpay.com/ez/C_reports/download_excelsinpay?mes="+mes+"&year="+year+"";
  
 

}


function exceltype(){

  var valores = $('#month-select').val();
  var valores1 = $('#year-select').val();
  
  if (valores == '00' && valores1 == '00') {


    var f = new Date();
  var cantidad =  new Date(f.getFullYear() || new Date().getFullYear(), f.getMonth() , 0).getDate();
  var mes =  f.getMonth();
   if (mes < 10 ) {

    mes = "0"+mes;
   }

  var inicio = f.getFullYear() +"-" + mes + "-01";
  var fin = f.getFullYear() +"-"+ mes + "-"+ cantidad;

 
  window.location.href = "http://ezlawpay.com/ez/download_excel?start_date="+inicio+"&end_date="+fin+"&type=contracts";

  }else{

     var cantidad =  new Date(valores1 || new Date().getFullYear(), valores, 0).getDate();


  var inicio = valores1 +"-" + valores + "-01";
  var fin = valores1 +"-"+ valores + "-"+ cantidad;

 window.location.href = "http://ezlawpay.com/ez/download_excelsinpay?start_date="+inicio+"&end_date="+fin+"&type=contracts";

  }
}


function  imprimir(){

$('.vertical-menu').hide();
$('.okss').hide();
$('#breadcrumb').hide();
$('#jM5xn2k-1585957951891').hide();


document.getElementById("todos").style.marginLeft = "-200px";
document.getElementById("imp1").style.marginLeft = "-200px";
document.getElementById("promedio").style.marginLeft = "-200px";
document.getElementById("total").style.marginLeft = "-200px";




print();

location.reload();

}

   



</script>