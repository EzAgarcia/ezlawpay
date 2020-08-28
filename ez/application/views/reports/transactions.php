<style type="text/css">
    i:hover{
        cursor: pointer;
        color: #4d5a89;
    }
    i{
        margin-left: 5px;
    }
</style>
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/datatables/style.css" type="text/css">
<h5 class="card-title">By Transactions</h5>
<table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
    <thead>
        <tr>
            <th>Reference Number</th>
            <th>Services To</th>
            <th>Mount</th>
            <th>Type</th>
            <th>Payment Method</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
     
    </tbody>
    <tfoot>
        <tr>
            <th>Reference Number</th>
            <th>Services To</th>
            <th>Mount</th>
            <th>Type</th>
            <th>Payment Method</th>
            <th></th>
        </tr>
    </tfoot>
</table>
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>