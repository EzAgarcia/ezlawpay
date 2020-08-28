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
} else {

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
    echo $key->Service_Description;?> <br>
               <?php }
?>
            </div>
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
    echo $key->Initial_Pay_Amount;?> <span style="color: red"> || </span> <?php echo date("m-d-Y", strtotime($key->Initial_Pay_Date)); ?><br>
               <?php }
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

        <br>

        <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action active">
                 Monthly payments
            </a>
            <div class="list-group-item list-group-item-action">
                <div class="row col-12">
                    <span href="" class="col-lg-1" style="color: #007bff;"></span>
                    <span href="" class="col-lg-3" style="color: #007bff;">Payment Date</span>
                    <span href="" class="col-lg-3" style="color: #007bff;">Amount</span>
                    <!-- <span href="" class="col-lg-2" style="color: #007bff;">Payment method</span>
                    <span href="" class="col-lg-3" style="color: #007bff;">Type</span> -->
                    <span href="" class="col-lg-4" style="color: #007bff;">Status</span>
                    <span href="" class="col-lg-1" style="color: #007bff;"></span>
                </div>
            </div>

            <?php foreach ($bills as $key) {?>
               <div class="list-group-item list-group-item-action">
                    <div class="row col-12">
                        <span class="col-lg-1"></span>
                        <span href="" class="col-lg-3" style="color: #000000"><?php echo date("m-d-Y", strtotime($key->fechap)); ?></span>
                        <span href="" class="col-lg-3" style="color: #000000"><?php echo $key->monto; ?></span>
                        <!-- <span href="" class="col-lg-2" style="color: #000000"><?php echo $key->Pay_Method; ?></span> -->
                       <!--  <span href="" class="col-lg-3" style="color: #000000">Pago</span> -->
                       <?php if ($key->id_pago != 0) {?>

                           <a href="<?php echo base_url() ?>C_invoice/view_invoice/<?php echo $key->id_pago ?>" target="_blank" class="col-lg-4" style="color:#4CAF50"><span class="label label-success">APPLIED</span></a>

                       <?} else {?>

                        <a class="col-lg-4" style="color:#eb4b3d"><span class="label label-success">NOT APPLIED</span></a>

                       <?}?>

                        <span class="col-lg-1"></span>
                    </div>
                </div>
            <?php }?>

            <br><br>

            <a href="#" style="background-color: #4CAF50; border-color:#4CAF50; " class="list-group-item list-group-item-action active">
               Current Balance <br>
               <h5 class="col-lg-3" style="color: #FFFFFF!important">$ <?php echo $balance; ?> DLLS</h5>
            </a>
    </div>
</div>

