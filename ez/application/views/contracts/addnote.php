<form method="post" id="formulario">
 

 
 
  <div class="form-group">
    <label for="exampleFormControlTextarea1">Add Note</label>
    <textarea id="info" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
  </div>


  <center><input class="form-control" style="background-color: #2c365d; border-color: #2c365d; color:#FFFFFF; width: 70%;" type="button" id="btn-add" value="Save" /></center>



</form>

<script type="text/javascript">
  $("#btn-add").click(function() {
  	     var id =  "<?php echo $id; ?>";
         var url = "<?php echo site_url('C_contracts/addnotad');?>";
        $.ajax({                        
           type: "POST",                 
           url: url,                     
           data: { info : $("#info").val(), id : id },
           success: function(data)             
           {
            
            if (data == true) {
    

                Swal.fire({
                icon: 'success',
                title: 'Good job!',
                text: 'Successfully added!',
                }).then(function () {
                  location.reload();
                })
                
             }else{
                Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
                })
             }             
           }
       });
    });
</script>