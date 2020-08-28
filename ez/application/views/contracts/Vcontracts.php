
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sl-1.3.1/datatables.min.css"/>
 
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sl-1.3.1/datatables.min.js"></script>
  
<style type="text/css">
  table {
  table-layout:fixed;
  font-size: 12.5px;
  font-family: 'Roboto', sans-serif;
  font-weight: 400;

}
table td {
  word-wrap: break-word;
  max-width: 400px;
  padding: 15px;
  text-align: center;
}
th{
  padding: 15px;
  text-align: center;
}

tr{
  padding: 15px;
  border-radius: 100px!important;
}

.odd {
    background-color: #f9f9f9!important;
}

.span{
    color: #fff;
    padding: 10px 25px;
    font-size: 11px;
}




</style>


<link rel="stylesheet" href="<?php echo base_url()?>assets/css/datatables/style.css" type="text/css">
 <table id="example" class="table-striped" style="width:100%; border-radius: 5px; ">
        <thead>
            <tr>
                <th>Status</th>
                <th>Client</th>
                <th>Contract Number</th>
                <th>Balance</th>
                <th>Service</th>
                <th>Contract Amount</th>
            </tr>
        </thead>
        <tbody>
        
            <?php foreach ($valor as $key) { ?>

               <?php if($key->fnId>1000){ ?>
                  <tr> 
               <?php  }else{  ?>
                   <tr class="table-warning"> 
               <?php } ?>
             

                <?php if($key->fnId>1000){
                  $estatus = 'Activo';
                }else{
                   $estatus = 'En proceso';
                } ?>

                <td><span class="badge badge-success span">Activo</span></td>
                <td onclick="viewContract();"><?php echo $key->client; ?></td>
                <td><?php echo $key->fcContractNumber; ?></td>
                <td><?php echo $key->fnBalance; ?></td>
                <td><?php echo $key->fcName; ?></td>
                <td><?php echo $key->fnContractValue; ?></td>
            </tr>

            <?php  

             } ?>
            
        </tbody>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </tfoot>
    </table>

    <div class="modal fade" id="ModalViewContract" role="dialog">
        <div class="modal-dialog modal-large">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center white-color rounded-top rounded-bottom nk-indigo p-t-5">
                            <h4>Contracts Details</h4>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right">
                            <h4 class="indigo-color">Client :</h4>
                        </div>
                        <div id="modalClient" class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text-left">
                            Nombre del Cliente
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right">
                            <h4 class="indigo-color">Services To :</h4>
                        </div>
                        <div id="modalServicesTo" class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text-left">
                            Persona 1<br>Persona 2<br>Persona 3
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right">
                            <h4 class="indigo-color">Contract Number :</h4>
                        </div>
                        <div id="modalContractNumber" class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text-left">
                            Numero de Contrato
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right">
                            <h4 class="indigo-color">Service :</h4>
                        </div>
                        <div id="modalService" class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text-left">
                            Servicio
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right">
                            <h4 class="indigo-color">Description :</h4>
                        </div>
                        <div id="modalDescription" class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text-left">
                            Descripcion del servicio
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right">
                            <h4 class="indigo-color">Phone :</h4>
                        </div>
                        <div id="modalPhone" class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text-left" data-mask="(999) 999-9999">
                            Telefonos
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center white-color rounded-top rounded-bottom nk-cyan p-t-5">
                            <h4>Payment Plan</h4>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right">
                            <h4 class="cyan-color">Contract Amount :</h4>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text-left">
                            <p class="no-margin"><i class="fas fa-dollar-sign">&nbsp;</i><strong><span id="modalContractValue" style="font-size: 1rem;"></span></strong>&nbsp; <strong style="font-size: 1rem;">DLLS</strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right">
                            <h4 id="labelInitialPayments" class="cyan-color">Initial Payment :</h4>
                        </div>
                        <div id="modalInitialsPayments" class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text-left">
                            Initial Payment 1<br>Initial Payment 2<br>Initial Payment 3
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right">
                            <h4 id="labelPayment" class="cyan-color">Payment :</h4>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text-left">
                            <p class="no-margin"><i class="fas fa-dollar-sign">&nbsp;</i><strong><span id="modalPayments" style="font-size: 1rem;"></span></strong>&nbsp; <strong style="font-size: 1rem;">DLLS</strong></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right">
                            <h4 class="cyan-color">Due Date :</h4>
                        </div>
                        <div id="modalDueDate" class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text-left">
                            Frecuencia
                        </div>
                    </div>
                    <div id="rowFrequency" class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right">
                            <h4 class="cyan-color">Frequency :</h4>
                        </div>
                        <div id="modalFrequency" class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text-left">
                            Frecuencia
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right">
                            <h4 class="cyan-color">Notification :</h4>
                        </div>
                        <div id="modalNotification" class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text-left">
                            Tipo de Notificacion
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right">
                            <h4 class="cyan-color">Contract Sign :</h4>
                        </div>
                        <div id="modalSignDate" class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text-left">
                            Fecha Firma
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right">
                            <div class="toggle-select-act fm-cmp-mg text-right">
                                <div class="nk-toggle-switch" data-ts-color="red">
                                    <label for="ts1" class="ts-label cyan-color" style="font-size: 1.1rem;"><strong>On Hold :</strong></label>
                                    <input id="ts1" type="checkbox" onclick="return false;" >
                                    <label for="ts1" class="ts-helper"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 text-left"></div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center white-color rounded-top rounded-bottom nk-teal p-t-5">
                            <h4>Payment Detail</h4>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                                <table id="data-table-payments" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="teal-color">Payment Date</th>
                                            <th class="teal-color">Description</th>
                                            <th class="teal-color">Amount</th>
                                            <th class="teal-color">Type</th>
                                            <th class="teal-color">Fees</th>
                                            <th class="teal-color">State</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center color-single rounded-top rounded-bottom nk-green">
                                <h4>Current Balance</h4>
                                <p class="no-margin"><i class="fas fa-dollar-sign white-color">&nbsp;</i><strong><span id="modalBalance" style="font-size: 1rem;"></span></strong>&nbsp;<strong class="white-color" style="font-size: 1rem;">DLLS</strong></p>
                            </div>
                        </div>
                        <!-- <button id="saveAdministratorName" type="button" class="btn btn-default">Save changes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Discard</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>



  <script>

    
    $(document).ready(function() {
    $('#example').DataTable();

} );

       function viewContract($id) {
        if ($id != '') {
            setTimeout(function(){
                $.ajax({
                    type    : 'POST',
                    url     : "<?php echo site_url("C_clients/viewContract") ?>",
                    data    : {IdContract: $id},
                    dataType: 'json',
                    success : function(data) {
                        console.log(data);
                        $('#modalClient').text(data.contract.completeName);
                        //Services to
                        var servicesToData ="";
                        for (var i = 0; i < data.servicesTo.length; i++) {
                            servicesToData += data.servicesTo[i].fcFirstName+" "+ data.servicesTo[i].fcMiddleName+" "+data.servicesTo[i].fcLastName+" "+data.servicesTo[i].fcLastName2+"<br>";
                        }
                        $('#modalServicesTo').html(servicesToData);
                        $('#modalContractNumber').text(data.contract.fcContractNumber);
                        $('#modalService').text(data.contract.fcName);
                        var servicesTableData = "";
                        for (var i = 0; i < data.servicesTable.length; i++) {
                            servicesTableData += data.servicesTable[i].fcName+"<br>";
                        }
                        $('#modalService').html(servicesTableData);
                        var fcService = "";
                        if (data.contract.fcService != null) {
                            fcService = data.contract.fcService;
                        }
                        $('#modalDescription').text(data.contract.fcDescription+" "+fcService);
                        $('#modalPhone').text(data.contract.fcPhone);
                        $('#modalPhone').text(function(i, text) {
                            return text.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
                        });
                        $('#modalContractValue').text(MoneyFormatted(data.contract.fnContractValue));
                        //Initial payments
                        var InitialPayments ="";
                        var hoy = new Date();
       
                        //1
                        if(data.contract.fdInitialPayment == null) {
                            InitialPayments = '';
                        } else {
                            InitialPayments = '<span>' + getFormattedDate(data.contract.fdInitialPayment)+'</span>&nbsp;&nbsp;<i class="fas fa-grip-lines-vertical cyan-color"></i>&nbsp;&nbsp;<i class="fas fa-dollar-sign">&nbsp;</i><strong><span style="font-size: 1rem;">'+MoneyFormatted(data.contract.fnInitialPayment)+'</span></strong>&nbsp;<strong style="font-size: 1rem;">DLLS</strong><br>';

                        }
                       

                        if (data.contract.fdInitialPayment2 != null && data.contract.fnInitialPayment2 != 0) {
                            var fecha = data.contract.fdInitialPayment2;
                            array_fecha = fecha.split("-");
 
                            var dia=array_fecha[2];
                            var mes=(array_fecha[1]-1);
                            var ano=(array_fecha[0]);
                            var fechaDate = new Date(ano,mes,dia);
                           
                        

                        if (hoy > fechaDate) {
            
        
                            InitialPayments += '<span>' + getFormattedDate(data.contract.fdInitialPayment2)+'</span>&nbsp;&nbsp;<i class="fas fa-grip-lines-vertical cyan-color"></i>&nbsp;&nbsp;<i class="fas fa-dollar-sign">&nbsp;</i><strong><span style="font-size: 1rem;">'+MoneyFormatted(data.contract.fnInitialPayment2)+'</span></strong>&nbsp;<strong style="font-size: 1rem;">DLLS</strong><br>';
                            }
                        }
                        if (data.contract.fdInitialPayment3 != null && data.contract.fnInitialPayment3 != 0) {

                            array_fecha = fecha.split("-");
 
                            var dia=array_fecha[2];
                            var mes=(array_fecha[1]-1);
                            var ano=(array_fecha[0]);
                            var fechaDate = new Date(ano,mes,dia);
                        

                        // if (hoy > fechaDate) {
                            InitialPayments += '<span>' + getFormattedDate(data.contract.fdInitialPayment3)+'</span>&nbsp;&nbsp;<i class="fas fa-grip-lines-vertical cyan-color"></i>&nbsp;&nbsp;<i class="fas fa-dollar-sign">&nbsp;</i><strong><span style="font-size: 1rem;">'+MoneyFormatted(data.contract.fnInitialPayment3)+'</span></strong>&nbsp;<strong style="font-size: 1rem;">DLLS</strong><br>';
                         // }
                        }


                        if (data.contract.fdInitialPayment4 != null && data.contract.fnInitialPayment4 != 0) {
                             var fecha = data.contract.fdInitialPayment4;
                            array_fecha = fecha.split("-");
 
                            var dia=array_fecha[2];
                            var mes=(array_fecha[1]-1);
                            var ano=(array_fecha[0]);
                            var fechaDate = new Date(ano,mes,dia);
                        

                        if (hoy > fechaDate) {
                            InitialPayments += '<span>' + getFormattedDate(data.contract.fdInitialPayment4)+'</span>&nbsp;&nbsp;<i class="fas fa-grip-lines-vertical cyan-color"></i>&nbsp;&nbsp;<i class="fas fa-dollar-sign">&nbsp;</i><strong><span style="font-size: 1rem;">'+MoneyFormatted(data.contract.fnInitialPayment4)+'</span></strong>&nbsp;<strong style="font-size: 1rem;">DLLS</strong><br>';
                            }
                        }

                        $('#labelInitialPayments').text("Initial Payment :");



                        // if (data.contract.fnInitialPayment2 != null) {
                        //     InitialPayments += '<span>' + getFormattedDate(data.contract.fdInitialPayment2)+'</span>&nbsp;&nbsp;<i class="fas fa-grip-lines-vertical cyan-color"></i>&nbsp;&nbsp;<i class="fas fa-dollar-sign">&nbsp;</i><strong><span style="font-size: 1rem;">'+MoneyFormatted(data.contract.fnInitialPayment2)+'</span></strong>&nbsp;<strong style="font-size: 1rem;">DLLS</strong><br>';

                        // }else{
                        //   InitialPayments = '';  
                        // }
                        //  $('#labelInitialPayments').text("Initial Payment :");

                        // if (data.contract.fnInitialPayment3 != null) {
                        //     InitialPayments += '<span>' + getFormattedDate(data.contract.fdInitialPayment3)+'</span>&nbsp;&nbsp;<i class="fas fa-grip-lines-vertical cyan-color"></i>&nbsp;&nbsp;<i class="fas fa-dollar-sign">&nbsp;</i><strong><span style="font-size: 1rem;">'+MoneyFormatted(data.contract.fnInitialPayment3)+'</span></strong>&nbsp;<strong style="font-size: 1rem;">DLLS</strong><br>';

                        // }else{
                        //   InitialPayments = '';  
                        // }
                        //  $('#labelInitialPayments').text("Initial Payment :");

                        // if (data.contract.fnInitialPayment4 != null) {
                        //     InitialPayments += '<span>' + getFormattedDate(data.contract.fdInitialPayment4)+'</span>&nbsp;&nbsp;<i class="fas fa-grip-lines-vertical cyan-color"></i>&nbsp;&nbsp;<i class="fas fa-dollar-sign">&nbsp;</i><strong><span style="font-size: 1rem;">'+MoneyFormatted(data.contract.fnInitialPayment4)+'</span></strong>&nbsp;<strong style="font-size: 1rem;">DLLS</strong><br>';

                        // }else{
                        //   InitialPayments = '';  
                        // }
                        //  $('#labelInitialPayments').text("Initial Payment :");

                        // InitialPayments += '<span>' + getFormattedDate(data.contract.fdInitialPayment2)+'</span>&nbsp;&nbsp;<i class="fas fa-grip-lines-vertical cyan-color"></i>&nbsp;&nbsp;<i class="fas fa-dollar-sign">&nbsp;</i><strong><span style="font-size: 1rem;">'+MoneyFormatted(data.contract.fnInitialPayment2)+'</span></strong>&nbsp;<strong style="font-size: 1rem;">DLLS</strong><br>';
                        //     InitialPayments += '<span>' + getFormattedDate(data.contract.fdInitialPayment3)+'</span>&nbsp;&nbsp;<i class="fas fa-grip-lines-vertical cyan-color"></i>&nbsp;&nbsp;<i class="fas fa-dollar-sign">&nbsp;</i><strong><span style="font-size: 1rem;">'+MoneyFormatted(data.contract.fnInitialPayment3)+'</span></strong>&nbsp;<strong style="font-size: 1rem;">DLLS</strong><br>';

                        // if (data.contract.fnIdFrequencyIP == 6) {
                            // InitialPayments += '<span>' + getFormattedDate(data.contract.fdInitialPayment2)+'</span>&nbsp;&nbsp;<i class="fas fa-grip-lines-vertical cyan-color"></i>&nbsp;&nbsp;<i class="fas fa-dollar-sign">&nbsp;</i><strong><span style="font-size: 1rem;">'+MoneyFormatted(data.contract.fnInitialPayment2)+'</span></strong>&nbsp;<strong style="font-size: 1rem;">DLLS</strong><br>';
                            // InitialPayments += '<span>' + getFormattedDate(data.contract.fdInitialPayment3)+'</span>&nbsp;&nbsp;<i class="fas fa-grip-lines-vertical cyan-color"></i>&nbsp;&nbsp;<i class="fas fa-dollar-sign">&nbsp;</i><strong><span style="font-size: 1rem;">'+MoneyFormatted(data.contract.fnInitialPayment3)+'</span></strong>&nbsp;<strong style="font-size: 1rem;">DLLS</strong><br>';
                        //     $('#labelInitialPayments').text("Initials Payments :");
                        // }else if (data.contract.fnIdFrequencyIP == 5) {
                        //     InitialPayments += '<span>' + getFormattedDate(data.contract.fdInitialPayment2)+'</span>&nbsp;&nbsp;<i class="fas fa-grip-lines-vertical cyan-color"></i>&nbsp;&nbsp;<i class="fas fa-dollar-sign">&nbsp;</i><strong><span style="font-size: 1rem;">'+MoneyFormatted(data.contract.fnInitialPayment2)+'</span></strong>&nbsp;<strong style="font-size: 1rem;">DLLS</strong><br>';
                        //     $('#labelInitialPayments').text("Initials Payments :");
                        // }
                        $('#modalInitialsPayments').html(InitialPayments);
                        $('#modalPayments').text(MoneyFormatted(data.contract.fnPayment));
                        var date = new Date(getFormattedDate(data.contract.fdDueDatePayment));
                        $('#modalDueDate').html('<span>Day ' + date.getDate() + ' of each month</span>&nbsp;&nbsp;<i class="fas fa-grip-lines-vertical cyan-color"></i>&nbsp;&nbsp;<span style="font-size: 1rem;"><strong>Start on: </strong>'+ getFormattedDateSign(date) +'</span>');
                        //Frequency
                        $('#labelPayment').text("Payment :");
                        $('#rowFrequency').show();
                        if (data.contract.fnIdFrequency == 1) {
                            $('#modalFrequency').text("One Time");
                        } else if (data.contract.fnIdFrequency == 2) {
                            $('#modalFrequency').text("Weekly");
                        } else if (data.contract.fnIdFrequency == 3) {
                            $('#modalFrequency').text("Every 2 Weeks");
                        } else if (data.contract.fnIdFrequency == 4) {
                            $('#labelPayment').text("Monthly Payment :");
                            $('#modalFrequency').text("Monthly");
                            $('#rowFrequency').hide();
                        }else{
                            $('#modalFrequency').text("Other");
                        }
                        if (data.contract.fnIdReminder == 1) {
                            $('#modalNotification').text("By Email");
                        } else if (data.contract.fnIdReminder == 2) {
                            $('#modalNotification').text("By text message");
                        } else {
                            $('#modalNotification').text("By Email and text-message");
                        }
                        //Notificacion
                        $('#modalSignDate').text(getFormattedDateSign(data.contract.fdSignDate));
                        //Estatus
                        if (data.contract.fnIdStatus == 6) {
                            $('#ts1').prop('checked', true);
                        }

                        var table = "";
                        if (data.payments.length > 0) {
                            table = '<tr>';
                            for (i = 0; i < data.payments.length; i++) {
                                table+= '<td>'+getFormattedDateSign(data.payments[i].fdPaymentDate)+'</td><td>'+data.payments[i].fcDescription+'</td><td>'+data.payments[i].fnAmount+'</td><td>' +data.payments[i].fcName+ '</td>';

                                var fee = "";
                                if(data.payments[i].fnFeeId == 0) {
                                    fee = '';
                                }else if (data.payments[i].fnFeeId == 1) {
                                    fee = 'Administration Fee';
                                }else if(data.payments[i].fnFeeId == 2) {
                                    fee = 'Attorney Fee';
                                }else if(data.payments[i].fnFeeId == 3) {
                                    fee = 'Biometrics Fee';
                                }else if(data.payments[i].fnFeeId == 4) {
                                    fee = 'Copy Fee';
                                }else if(data.payments[i].fnFeeId == 5) {
                                    fee = 'Filing Fee';
                                }else if(data.payments[i].fnFeeId == 6) {
                                    fee = 'Goverment Fee';
                                }else if(data.payments[i].fnFeeId == 7) {
                                    fee = 'Late Fee';
                                }else if(data.payments[i].fnFeeId == 8) {
                                    fee = 'Mailing Fee';
                                }else if(data.payments[i].fnFeeId == 9) {
                                    fee = 'Traslation Fee';
                                }else if(data.payments[i].fnFeeId == 10) {
                                    fee = 'Traveling Fee';
                                }else if(data.payments[i].fnFeeId == 11) {
                                    fee = 'Check Fee';
                                }else if(data.payments[i].fnFeeId == 12) {
                                    fee = 'Interpreter Fee';
                                }else if(data.payments[i].fnFeeId == 13) {
                                    fee = 'Comision Fee';
                                }

                                table+= '<td>'+ fee +'</td>';

                                var status = "";
                                if (data.payments[i].idStatus == 7) {
                                    status = "status-paid";
                                }else if (data.payments[i].idStatus == 8) {
                                    status = "status-cancelled";
                                }else{
                                    status = "status-pending";
                                }
                                table+='<td class="text-center text-uppercase"><a><span class="status '+ status+'">'+data.payments[i].fcStatus+'</span></a></td></tr>';
                            }
                        }else{
                            table = '<tr><td colspan="6"class="text-center">No payments available for this contract <td></tr>';
                        }
                        $("#data-table-payments").find("tbody").html(table);

                        $('#modalBalance').text(MoneyFormatted(data.contract.fnBalance));
                        $('#ModalViewContract').modal('toggle');
                    },
                    error : function(jqXHR, textStatus, errorThrown) {
                        warningAlert();
                        //alert('Error ' + jqXHR +textStatus + errorThrown);
                    }
                });
            }, 750);
        } else {
            warningAlert();
        }
    }
    
   
  </script>
