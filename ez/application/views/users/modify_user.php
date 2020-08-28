<form method="post" id="formulario">


    <div class="form-group row">
    <div class="col-1"></div>
    <label class="col-sm-3 col-form-label">Nick Name</label>
    <div class="col-sm-6">
      <input  class="form-control"  value="<?php echo $info[0]->UserName; ?>" name="nickname"  required>
    </div>
     <div class="col-2"></div>
  </div>
  <div class="form-group row">
    <div class="col-1"></div>
  <label for="inputPassword3" class="col-sm-3 col-form-label">User Type</label>
     <div class="col-sm-6">
        <select class="form-control"  id="sel" name="typeuser">
          <option value="1">Administrator</option>
          <option value="2">Authorized User</option>
          <option value="3">Read Only User</option>
        </select>
    </div>
    <div class="col-2"></div>
  </div>

  <div class="form-group row">
    <div class="col-1"></div>
    <label class="col-sm-3 col-form-label">User Name</label>
    <div class="col-sm-6">
      <input  class="form-control"  value="<?php echo $info[0]->Name; ?>" name="username" placeholder="User Name" required>
    </div>
    <div class="col-2"></div>
  </div>

  <input class="form-control" style="background-color: #2c365d; border-color: #2c365d; color:#FFFFFF;" type="button" id="btn-add" value="Save" />

</form>

<script type="text/javascript">

  $(document).ready(function(){
     $("#sel").val(<?php echo $info[0]->Profile_ID; ?>);
  });

  $("#btn-add").click(function(e) {

         var id = "<?php echo $info[0]->ID; ?>";
         var url = "<?php echo site_url('add_userdbmod');?>";
        $.ajax({                        
           type: "POST",                 
           url: url,                     
           data: { info : $("#formulario").serialize(), id : id }, 
           success: function(data)             
           {
            
            if (data == true) {
    

                Swal.fire({
                icon: 'success',
                title: 'Good job!',
                text: 'You clicked the button!',
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