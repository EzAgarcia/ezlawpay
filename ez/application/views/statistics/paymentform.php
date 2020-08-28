<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.4.0/dist/chartjs-plugin-datalabels.min.js"></script> 

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
        <a href="<?php echo base_url('statistics')?>">Contract Status</a>
          <a href="<?php echo base_url('C_contracts/firmados')?>">Signed Contracts</a>
          <a href="<?php echo base_url('C_contracts/services')?>">Services</a>
          <!-- <a  href="<?php echo base_url('C_contracts/payments')?>">Payments Methods</a> -->
          <a  href="<?php echo base_url('C_contracts/totalincome')?>">Total Income</a>
          <a   class="active" href="<?php echo base_url('C_contracts/paymentform')?>">Payment Form</a>
          <a  href="<?php echo base_url('C_contracts/newcontracts')?>">New Contracts</a>
          <a  href="<?php echo base_url('C_contracts/newcontractsonhold')?>">New Contracts on Hold</a>
          <a  href="<?php echo base_url('C_contracts/newcontractsf')?>">Contract Value</a>
          <a  href="<?php echo base_url('C_contracts/newpaymentsf')?>">Contract Monthly Payments</a>
          <a  href="<?php echo base_url('C_contracts/paymentshold')?>">Contracts no payments </a>
        </div>
      </div>

      <div class="col-9">
        <div class="row">
          <div class="col-4 okss">
      <select name="changeMonth" class="form-control" id="month-select">
          <option selected value="00">Month</option>
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
          <option selected value="00">Year</option>
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
     <button  style="margin-top: .5rem; margin-left: .8rem;" class="okss btn btn-info" onclick="exceltype()">Export to Excel</button>

     <button  style="margin-top: .5rem; margin-left: .8rem;" class="okss btn btn-info" onclick="excel()">Export All</button>

       </div>

        <br>
        <br>
        <br>
        <center><h3>Payment Method</h3></center>
          <div id="todos" class="row" style="width: 125%; margin-left: -12%">
            <canvas id="horizontal"></canvas>
          </div>
        
        <br>
        <br>
       <div class="row">
     
       <canvas id="pruebat"></canvas>
      </div>
      </div>
    </div>
    <br>
    <br>
    <br>
  </div>
    
    


  




<script>

  var ctx = document.getElementById("horizontal").getContext('2d');
   var fechas = [];
   var cont = 0;
   var total = [];

  $( document ).ready(function() {

    $.ajax({
      url: "<?php echo site_url('C_contracts/paymenform');?>",
      type: 'GET',
      success:function(response){

        

        var suma = 0;
        var card = 0;
        var cash = 0;
        var other = 0;
       
         resultados = JSON.parse(response);



//         for(valor in resultados){

//             suma = suma + parseInt(resultados[valor], 10);
//         }

    

 
        card = resultados['card'];
        cash = resultados['cash'];
        other = resultados['other'];







data = {
 
    
    labels: ['CARD', 'CASH', 'OTHER'],
    datasets: [{
        backgroundColor: ["#70DF71" ,"#f93b20", "#009688" ],
        data: [parseInt(card, 10), parseInt(cash, 10), parseInt(other, 10)],
      }]
};




config = {
    type: 'pie',
    data: data,
    options: {
      plugins: {
     datalabels: {
       formatter: (value, ctx) => {
         let datasets = ctx.chart.data.datasets;
         if (datasets.indexOf(ctx.dataset) === datasets.length - 1) {
           let sum = datasets[0].data.reduce((a, b) => a + b, 0);
           let percentage = Math.round((value / sum) * 100) + '%';
           return percentage;
         } else {
           return percentage;
         }
       },
       color: '#fff',
     }
   },
      tooltips: {
        titleFontSize: 20,
        bodyFontSize: 18
       },
    legend: {
            labels: {
                
                fontSize: 15
           }
         }
  },
};


myPieChart = new Chart(ctx, config);
        

      }});

 
    



  });

   function actulizar() {

      var mes = $("#month-select").val();
      var year = $("#year-select").val();
      
     $.ajax({
      url: "<?php echo site_url('C_contracts/paymenform');?>",
      type: 'POST',
      data: {mes : mes, year: year},
      success:function(response){

        myPieChart.destroy();                  

        var suma = 0;
        var card = 0;
        var cash = 0;
        var other = 0;
       
         resultados = JSON.parse(response);



//         for(valor in resultados){

//             suma = suma + parseInt(resultados[valor], 10);
//         }

    

 
        card = resultados['card'];
        cash = resultados['cash'];
        other = resultados['other'];







data = {
 
    
    labels: ['CARD', 'CASH', 'OTHER'],
    datasets: [{
        backgroundColor: ["#70DF71" ,"#f93b20", "#009688" ],
        data: [parseInt(card, 10), parseInt(cash, 10), parseInt(other, 10)],
      }]
};




config = {
    type: 'pie',
    data: data,
    options: {
      plugins: {
     datalabels: {
       formatter: (value, ctx) => {
         let datasets = ctx.chart.data.datasets;
         if (datasets.indexOf(ctx.dataset) === datasets.length - 1) {
           let sum = datasets[0].data.reduce((a, b) => a + b, 0);
           let percentage = Math.round((value / sum) * 100) + '%';
           return percentage;
         } else {
           return percentage;
         }
       },
       color: '#fff',
     }
   },
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


 myPieChart = new Chart(ctx, config);
        

      }});



  

  };


  function excel(){

  var valores = $('#month-select').val();
  var valores1 = $('#year-select').val();
  
  if (valores == '00' && valores1 == '00') {
    var f = new Date();
  var cantidad =  new Date(f.getFullYear() || new Date().getFullYear(), f.getMonth() , 0).getDate();
  var mes =  f.getMonth();
   if (mes < 10 ) {

    mes = "0"+mes;
   }

  var inicio = f.getFullYear() +"-" + mes + "-01" +" 00:00:00";
  var fin = f.getFullYear() +"-"+ mes + "-"+ cantidad +" 00:00:00";

  window.location.href = "http://ezlawpay.com/ez/download_excel?start_date="+inicio+"&end_date="+fin;

  }else{

     var cantidad =  new Date(valores1 || new Date().getFullYear(), valores, 0).getDate();


  var inicio = valores1 +"-" + valores + "-01" +" 00:00:00";
  var fin = valores1 +"-"+ valores + "-"+ cantidad +" 00:00:00";

  window.location.href = "http://ezlawpay.com/ez/download_excel?start_date="+inicio+"&end_date="+fin;

  }

   

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

 
  window.location.href = "http://ezlawpay.com/ez/download_excel?start_date="+inicio+"&end_date="+fin+"&type=payments";

  }else{

     var cantidad =  new Date(valores1 || new Date().getFullYear(), valores, 0).getDate();


  var inicio = valores1 +"-" + valores + "-01";
  var fin = valores1 +"-"+ valores + "-"+ cantidad;

 window.location.href = "http://ezlawpay.com/ez/download_excel?start_date="+inicio+"&end_date="+fin+"&type=payments";

  }
}


function  imprimir(){

$('.vertical-menu').hide();
$('.okss').hide();
$('#breadcrumb').hide();
$('#jM5xn2k-1585957951891').hide();


document.getElementById("todos").style.marginLeft = "-200px";
// document.getElementById("imp1").style.marginLeft = "-200px";
// document.getElementById("total").style.marginLeft = "-200px";




print();

location.reload();

}

  
</script>