<style type="text/css">
	.especial a{
		color: #000 !important;
		font-size: 13px;
	}
	.especial a i{
		margin-right: 10px
	}
</style> 
<link rel="stylesheet" href="<?php echo base_url()?>assets/myfont/styles.css">
<style type="text/css">html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td{margin:0;padding:0;border:0;outline:0;font-weight:inherit;font-style:inherit;font-family:inherit;font-size:100%;vertical-align:baseline}body{line-height:1;color:#000;background:#fff}ol,ul{list-style:none}table{border-collapse:separate;border-spacing:0;vertical-align:middle}caption,th,td{text-align:left;font-weight:normal;vertical-align:middle}a img{border:none}*{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}body{font-family:'Dosis','Tahoma',sans-serif}.container{margin:15px auto;width:80%}h1{margin:40px 0 20px;font-weight:700;font-size:38px;line-height:32px;color:#fb565e}h2{font-size:18px;padding:0 0 21px 5px;margin:45px 0 0 0;text-transform:uppercase;font-weight:500}.small{font-size:14px;color:#a5adb4;}.small a{color:#a5adb4;}.small a:hover{color:#fb565e}.glyphs.character-mapping{margin:0 0 20px 0;padding:20px 0 20px 30px;color:rgba(0,0,0,0.5);border:1px solid #d8e0e5;border-radius:3px;}.glyphs.character-mapping li{margin:0 30px 20px 0;display:inline-block;width:90px}.glyphs.character-mapping .icon{margin:10px 0 10px 15px;padding:15px;position:relative;width:55px;height:55px;color:#162a36 !important;overflow:hidden;border-radius:3px;font-size:32px;}.glyphs.character-mapping .icon svg{fill:#000}.glyphs.character-mapping input{margin:0;padding:5px 0;line-height:12px;font-size:12px;display:block;width:100%;border:1px solid #d8e0e5;border-radius:5px;text-align:center;outline:0;}.glyphs.character-mapping input:focus{border:1px solid #fbde4a;-webkit-box-shadow:inset 0 0 3px #fbde4a;box-shadow:inset 0 0 3px #fbde4a}.glyphs.character-mapping input:hover{-webkit-box-shadow:inset 0 0 3px #fbde4a;box-shadow:inset 0 0 3px #fbde4a}.glyphs.css-mapping{margin:0 0 60px 0;padding:30px 0 20px 30px;color:rgba(0,0,0,0.5);border:1px solid #d8e0e5;border-radius:3px;}.glyphs.css-mapping li{margin:0 30px 20px 0;padding:0;display:inline-block;overflow:hidden}.glyphs.css-mapping .icon{margin:0;margin-right:10px;padding:13px;height:50px;width:50px;color:#162a36 !important;overflow:hidden;float:left;font-size:24px}.glyphs.css-mapping input{margin:0;margin-top:5px;padding:8px;line-height:16px;font-size:16px;display:block;width:150px;height:40px;border:1px solid #d8e0e5;border-radius:5px;background:#fff;outline:0;float:right;}.glyphs.css-mapping input:focus{border:1px solid #fbde4a;-webkit-box-shadow:inset 0 0 3px #fbde4a;box-shadow:inset 0 0 3px #fbde4a}.glyphs.css-mapping input:hover{-webkit-box-shadow:inset 0 0 3px #fbde4a;box-shadow:inset 0 0 3px #fbde4a}</style>
<script>(function() {
  var glyphs, i, len, ref;
  ref = document.getElementsByClassName('glyphs');
  for (i = 0, len = ref.length; i < len; i++) {
    glyphs = ref[i];
    glyphs.addEventListener('click', function(event) {
      if (event.target.tagName === 'INPUT') {
        return event.target.select();
      }
    });
  }
}).call(this);
    </script>
<ul class="nav nav-tabs especial" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="pills-account-tab" data-toggle="pill" href="#pills-account" role="tab" aria-controls="pills-account" aria-selected="true"><i class="fas fa-user-alt"></i>Account</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pills-square-tab" data-toggle="pill" href="#pills-square" role="tab" aria-controls="pills-square" aria-selected="false"><i class="icon icon-square"></i> Square</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="pills-account" role="tabpanel" aria-labelledby="pills-account-tab">
    <div class="card" style="border: none">
      <div class="card-body">
        <form id="profile_form" method="POST">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="name">New Password</label>
              <input type="Password" class="form-control" name="pass1" id="pass1" >
            </div>
            <div class="form-group col-md-6">
              <label for="name">Confirm Password</label>
              <input type="Password" class="form-control" name="pass2" id="pass2" >
            </div>
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i>   Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="tab-pane fade" id="pills-square" role="tabpanel" aria-labelledby="pills-square-tab">
    <div class="card" style="border: none">
      <div class="card-body">
        <?php
        if ($square->num_rows()>0){
          ?>
          <form id="square_form" method="POST">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="name">Application ID</label>
                <input type="text" class="form-control" name="application_id" value="<?php echo $square->result()[0]->fcApplicationID?>" >
              </div>
              <div class="form-group col-md-6">
                <label for="name">Personal Access Token</label>
                <input type="text" class="form-control" name="tocken" value="<?php echo $square->result()[0]->fcPersonalAccessToken?>" >
              </div>
              <div class="form-group col-md-6">
                <label for="birthdate" >Location ID</label>
                <input type="text" class="form-control" name="location" value="<?php echo $square->result()[0]->fcLocationID?>" >
              </div>
              <div class="form-group col-md-6">
                <label for="language" >Sandbox Application ID</label>
                <input type="text" class="form-control" name="sandbox" value="<?php echo $square->result()[0]->fcSandboxApplicationID?>" >
              </div>
              <div class="form-group col-md-6">
                <label for="address" >Sandbox Access Token</label>
                <input type="text" class="form-control" name="sandobox_tocken" value="<?php echo $square->result()[0]->fcSandboxAccessToken?>">
              </div>
              <div class="form-group col-md-6">
                <label for="address" >Sandbox Location ID</label>
                <input type="text" class="form-control" name="sandobox_location" value="<?php echo $square->result()[0]->fcSandboxLocationID?>">
              </div>
            </div>
            <input type="text" name="id" style="display: none" value="<?php echo $square->result()[0]->fnId?>">
            <button type="submit" class="btn btn-danger btn-lg">Save</button>
          </form>
          <?php
        }else{
          ?>
          <form id="square_form" method="POST">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="name">Application ID</label>
                <input type="text" class="form-control" name="application_id"  >
              </div>
              <div class="form-group col-md-6">
                <label for="name">Personal Access Token</label>
                <input type="text" class="form-control" name="tocken"  >
              </div>
              <div class="form-group col-md-6">
                <label for="birthdate" >Location ID</label>
                <input type="text" class="form-control" name="location"  >
              </div>
              <div class="form-group col-md-6">
                <label for="language" >Sandbox Application ID</label>
                <input type="text" class="form-control" name="sandbox"  >
              </div>
              <div class="form-group col-md-6">
                <label for="address" >Sandbox Access Token</label>
                <input type="text" class="form-control" name="sandobox_tocken" >
              </div>
              <div class="form-group col-md-6">
                <label for="address" >Sandbox Location ID</label>
                <input type="text" class="form-control" name="sandobox_location" >
              </div>
            </div>
            <input type="text" name="id" style="display: none" value="new">
            <button type="submit" class="btn btn-danger btn-lg">Save</button>
          </form>
          <?php
        }
        ?>
      </div>
    </div>
  </div>

       <!--   <input type="text" name="id" style="display: none" value="new">
        <button type="submit" onclick="test()" class="btn btn-danger btn-lg">TEST</button>
 -->
</div>
<script type="text/javascript">
  $("#square_form").submit(function(e) {
      e.preventDefault(); // avoid to execute the actual submit of the form.
      var form = $("#square_form").serialize();
      $.post( "<?php echo base_url()?>welcome/save_square",form, function( data ) {
        if (data=='SI'){
          location.reload();
        }else{
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!'
          })
        }
      });
    });
  $("#profile_form").submit(function(e) {
      e.preventDefault(); // avoid to execute the actual submit of the form.

      if ($('#pass1').val()==$('#pass2').val()){
        var form = $("#profile_form").serialize();
        $.post( "<?php echo base_url()?>welcome/save_profile",form, function( data ) {
          if (data=='SI'){
               Swal.fire({
                title: 'Done!',
                text:  'Successfully modified!',
                icon:  'success'
              }).then((result) => {
                location.href = "<?php echo base_url()?>dashboard";
             })
          }else{
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
          }
        });
      }else{
        
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'you must enter the same password'
          })
        return false;
      }

        
    });

    function test(){
            $.ajax({
            url: "<?php echo site_url('C_contracts/test_global');?>",
            type:"POST",
            dataType:"html",
            }).done(function(data) {
              $(".modal-title").html('Add User');
              $(".modal-body").html(data);
            });
          }
</script>
	