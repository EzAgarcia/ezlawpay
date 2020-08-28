
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
          <a href="<?php echo base_url('C_contracts/graficas')?>">Contract Status</a>
          <a href="<?php echo base_url('C_contracts/firmados')?>">Signed Contracts</a>
          <a  class="active" href="<?php echo base_url('C_contracts/services')?>">Services</a>
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
            <button class="btn btn-sm btn-info" type="button" onclick="download_excel('services')" style="height: 60%; margin-top: -1%;">Exportar Excel</button>
            <button class="btn btn-sm btn-success" type="button" onclick="download_excel()" style="height: 60%; margin-top: -1%;">Exportar Excel General</button>

            <button class="btn btn-sm btn-success" type="button" onclick="imprimir()" style="height: 60%; margin-top: -1%;">Print</button>
          </div>
        </div>
        <div class="row">
          <div class="col-11" style=" margin-top: 5%;">
            <canvas id="services"  height="1000"></canvas>
          </div>
        </div>
        <br><br><br>
      </div>
    </div>
  </div>
  <br><br><br>
<script>
$( document ).ready(function() {
  var rawData = '<?php print($services) ?>';
  jsonData = oderaizeData(JSON.parse(rawData));
  var graph = document.getElementById('services').getContext('2d');
  var myPieChart = '';
  puplateGraph(jsonData);

  initialData = oderaizeData(rawData);

  $(function() {
    $('input[name="daterange"]').daterangepicker({
      linkedCalendars: false,
      ranges: {
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'All Time': [moment().subtract(49, 'month').startOf('month'), moment()]
      },
    }, function(start_date, end_date, label) {
      console.log("A new date selection was made: " + start_date.format('YYYY-MM-DD') + ' to ' + end_date.format('YYYY-MM-DD'));
      refreshData(start_date.format('YYYY-MM-DD'), end_date.format('YYYY-MM-DD'))
    });
  });


  function puplateGraph(initialData) {
    config = { type: 'horizontalBar',
      data: initialData,
      options: {
        legend: { display: false },
        title: {
          display: true,
          text: 'Hired Services'
        }
      }
    }



    myPieChart = new Chart(graph, config);
  }

  function refreshData(start_date, end_date){
    $.ajax({
      url: "<?php echo base_url()?>services_data",
      type: 'POST',
      data: { start_date: start_date, end_date: end_date },
      success: function(data) {
        var organizeData = oderaizeData(data);
        var data_size = organizeData.labels.length;
        var graph_size = { h: '500px', w: '500px', f: 18, ff: 15 } ;

        myPieChart.destroy();
        config = { type: 'horizontalBar',
          data: organizeData,
          options: {
            legend: { display: false ,
             labels: {
                // This more specific font property overrides the global property
               fontSize  : 30
            },
          },
            title: {
              display: true,
              text: 'Services.'
            }
          }
        }
        graph.canvas.height = 500;
        myPieChart = new Chart(graph, config);
      }
    });
  }

  function oderaizeData(data) {
    servicesData = {
      labels: data.tag,
      datasets: [{
        backgroundColor: ["#009688", "#000000","#2c365d", "#009688", "#000000","#2c365d" , "#009688", "#000000","#2c365d", "#009688", "#000000","#2c365d" ,"#009688", "#000000","#2c365d", "#009688", "#000000","#2c365d" ,"#009688", "#000000","#2c365d", "#009688", "#000000","#2c365d" ,"#009688", "#000000","#2c365d", "#009688", "#000000","#2c365d" ,"#009688", "#000000","#2c365d", "#009688", "#000000","#2c365d" ,"#009688", "#000000","#2c365d", "#009688", "#000000","#2c365d" ,"#009688", "#000000","#2c365d", "#009688", "#000000","#2c365d" ,"#009688", "#000000","#2c365d", "#009688", "#000000","#2c365d" , "#009688", "#000000","#2c365d", "#009688", "#000000","#2c365d" ,"#009688", "#000000","#2c365d", "#009688", "#000000","#2c365d" ,"#009688", "#000000","#2c365d", "#009688", "#000000","#2c365d" ,"#009688", "#000000","#2c365d", "#009688", "#000000","#2c365d" , "#009688", "#000000","#2c365d", "#009688", "#000000","#2c365d" ,"#009688", "#000000","#2c365d", "#009688", "#000000","#2c365d" ],
        data: data.data,
      }]
    };

    return servicesData;
  }

  function dates(){
    var select_val = $('input[name="daterange"]').val();
    select_val.substr(0,10);
    select_val.substr(12,22);

    var obj = {
      start_date: select_val.substr(6,4)+'-'+select_val.substr(3,2)+'-'+select_val.substr(0,2),
      end_date: select_val.substr(19,4)+'-'+select_val.substr(16,2)+'-'+select_val.substr(13,2)
    };

    return obj;
  }

  function download_excel(type = ''){
    var base_url = "<?php echo base_url()?>download_excel";
    var date_url = "?start_date=" + dates.start_date + "&end_date=" + dates.end_date;

    if(type == ''){
      return window.location.href = base_url + date_url;
    }

    return window.location.href = base_url + date_url + "&type=" + type;
  }
});

function download_excel(type = ''){
  var select_val = $('input[name="daterange"]').val();
  select_val.substr(0,10);
  select_val.substr(12,22);

  var dates = {
    start_date: select_val.substr(6,4)+'-'+select_val.substr(0,2)+'-'+select_val.substr(3,2),
    end_date: select_val.substr(19,4)+'-'+select_val.substr(13,2)+'-'+select_val.substr(16,2)
  };

  var base_url = "<?php echo base_url()?>download_excel";
  var date_url = "?start_date=" + dates.start_date + "&end_date=" + dates.end_date;

  if(type == ''){
    window.location.href = base_url + date_url;
    return
  }

  var type_url = base_url + date_url + "&type=" + type;
  window.location.href = type_url;
}

function  imprimir(){

$('.vertical-menu').hide();
$('.okss').hide();
$('#breadcrumb').hide();
$('#jM5xn2k-1585957951891').hide();


document.getElementById("todos").style.marginLeft = "-130px";
// document.getElementById("imp1").style.marginLeft = "-200px";
// document.getElementById("total").style.marginLeft = "-200px";




print();

location.reload();

}
   

</script>