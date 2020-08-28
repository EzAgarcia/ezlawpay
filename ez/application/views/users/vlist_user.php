

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.2/umd/popper.min.js"></script>


  

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

.dropdown-item{
  font-size: 15px;
}




</style>
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/datatables/style.css" type="text/css">
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#general_modal" onclick="add_user()"><i class="fas fa-user-plus"></i> Add User</button>
<br> <br>

 <table id="example" class="table table-bordered" style="width:100%; border-radius: 5px; ">
        <thead>
            <tr>
                <th>ID</th>
                <th>User Name</th>
                <th>Name</th>
                <th>Company</th>
                <th>User type</th>
                <th>Options</th>
    
                
            </tr>
        </thead>
        <tbody>
                <?php foreach ($valor as $key) {   ?>
                  <tr>
                    <td><?php echo $key->ID; ?></td>
                    <td><?php echo $key->UserName; ?></td>
                    <td><?php echo $key->Name; ?></td>
                    <td><?php echo $key->namecompa; ?></td>
                    <td><?php echo $key->Profile_Description; ?></td>
                    <td><div class="btn-group">
                         <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-list-ul" ></i></button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" data-toggle="modal" data-target="#general_modal" onclick="modif(<?php echo $key->ID; ?>);">Edit</a>
                              <a class="dropdown-item" onclick="reset(<?php echo $key->ID; ?>)">Reset Password</a>
                              <a class="dropdown-item" onclick="elim(<?php echo $key->ID; ?>)">Delete</a>
                            </div>
                        </div></td>
                  
                    
                  </tr>
                <?php } ?>
               
        </tbody>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>User Name</th>
                <th>Name</th>
                <th>Company</th>
                <th>User type</th>
                <th>Options</th>
            
            </tr>
        </tfoot>
    </table>

    


  <script>

    
    $(document).ready(function() {
      $('#example').DataTable();
    });

         function add_user() {

        $.ajax({
            url: "<?php echo site_url('add_user');?>",
            type:"POST",
            dataType:"html",
          }).done(function(data) {
              $("#modal_title").html("Add User");
              $(".modal-body").html(data);
            });
        }

        function modif(ids){
          var id = ids;
          $.ajax({
            url: "<?php echo site_url('modifyuser');?>",
            type:"POST",
            data: { id: ids },
            dataType:"html",
          }).done(function(data) {
              $("#modal_title").html("Modify User");
              $(".modal-body").html(data);
            });
        }

        function reset(ids){
          var id= ids;
        Swal.fire({
            title: 'Do you want to reset the password?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
            }).then((result) => {
                $.ajax({
                    url: "<?php echo site_url('reset');?>",
                    type:"POST",
                    data: {id:ids},
                 })

                if (result.value) {
                   Swal.fire(
                    'Perfect!',
                    'Password Reset.',
                    'success'
                   )}
            })
          }

          function elim(ids){
          var id= ids;
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
            }).then((result) => {
                $.ajax({
                    url: "<?php echo site_url('delete');?>",
                    type:"POST",
                    data: {id:ids},
                 })

                if (result.value) {
                   Swal.fire({
                    title : 'Perfect!',
                    text: 'Your file has been deleted.',
                    icon: 'success'
                   }).then((result) => {
                    location.reload();
                   })

                 }
            })


          }


   
    
    
   
  </script>
