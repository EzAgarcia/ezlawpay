<style type="text/css">
    i:hover{
        cursor: pointer;
        color: #4d5a89;
    }
    i{
        margin-left: 5px;
    }
    table {
        table-layout:fixed;
        font-size: 13.5px;
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
    .btn {
        background-color: #9B1B5A;
        border: 1px #9B1B5A;
    }
</style>
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/datatables/style.css" type="text/css">

<?php if ($_SESSION['ezlow']['profile'] != 3) { ?>
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#general_modal" onclick="new_client()" style="margin-bottom: 2%"><i class="fas fa-user-plus"></i> New Client</button>
<?php  } ?>

<table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
    <thead>
        <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>City</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
        <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>City</th>
            <th></th>
        </tr>
    </tfoot>
</table>

<script>
$(document).ready(function() {
    $('#example').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": {
        url: '<?php echo base_url()?>' + 'client_list',
        type: 'POST'
        },
        "columnDefs": [{
        "targets": -1,
        "data": null,
        "render": function ( data, type, row, meta ) {
            return edit_tools(row[4])
        }}]
} );
});

$(document).ready(function (){
    var table = $('#contracts').DataTable();
    
    $('#table-filter').on('change', function(){
        table.search(this.value).draw();   
    });
});

function edit_tools(client) {

    if ("<?php echo $_SESSION['ezlow']['profile']; ?>" != 3) {

        return '<i class="fas fa-list-ul"  data-toggle="modal" title="Edit Client"  data-target="#general_modal" onclick="edit('+client+')"></i><i class="fas fa-trash-alt"  title="Delete Client" onclick="del('+client+')"></i>';
   }else{
    
      return '';
   }
    
}

function edit(id){
    $('#modal_title').html('Edit Client');
    $.post( "<?php echo base_url()?>C_client/detail_client",{id:id}, function( data ) {
        $('#modal_body').html(data);
    });
}
function new_client(){
    $('#modal_title').html('New Client');
    $.post( "<?php echo base_url()?>C_client/new_client", function( data ) {
        $('#modal_body').html(data);
    });
}
function del(id){
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.value) {
        $.post( "<?php echo base_url()?>C_client/del_client",{id:id}, function( data ) {
            if (data=='SI'){
                location.reload();
            }
        });
                
      }
    })
}
</script>