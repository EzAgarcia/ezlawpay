<form method="post" id="formulario">
 

    <div class="form-group row">
    <div class="col-1"></div>
    <label class="col-sm-3 col-form-label">Nick Name</label>
    <div class="col-sm-6">
      <input  class="form-control"  name="nickname" placeholder="Nick Name" required>
    </div>
     <div class="col-2"></div>
  </div>
  <div class="form-group row">
    <div class="col-1"></div>
    <label   class="col-sm-3 col-form-label">Password</label>
    <div class="col-sm-6">
      <input type="password" class="form-control"  name="pass" placeholder="Password" required>
    </div>
  </div>
  <div class="form-group row">
    <div class="col-1"></div>
  <label for="inputPassword3" class="col-sm-3 col-form-label">User Type</label>
     <div class="col-sm-6">
        <select class="form-control" name="typeuser">
         <!--  <option value="1">Administrator</option>
          <option value="2">Authorized User</option>
          <option value="3">Read Only User</option> -->

        <?php foreach ($type as $key) { ?>

            <option value="<?php echo $key->ID?>"><?php echo $key->Profile_Description?></option>
          <?php  }  ?>
        </select>
    </div>
    <div class="col-2"></div>
  </div>

  <div class="form-group row">
    <div class="col-1"></div>
    <label class="col-sm-3 col-form-label">User Name</label>
    <div class="col-sm-6">
      <input  class="form-control"  name="username" placeholder="User Name" required>
    </div>
    <div class="col-2"></div>
  </div>

  <input class="form-control" style="background-color: #2c365d; border-color: #2c365d; color:#FFFFFF;" type="button" id="btn-add" value="Save" />

</form>

<script type="text/javascript">
  $("#btn-add").click(function() {
         var url = "<?php echo site_url('add_userdb');?>";
        $.ajax({                        
           type: "POST",                 
           url: url,                     
           data: $("#formulario").serialize(), 
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