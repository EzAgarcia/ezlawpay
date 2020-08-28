<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>EZ Law Pay</title>

  <!-- Bootstrap core CSS -->
  <link href="<?php echo base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="<?php echo base_url()?>assets/css/font-awesome-all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

  <!-- Custom styles for this template -->
  <link href="<?php echo base_url()?>assets/css/agency.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.css" id="theme-styles">
  <!-- favicon
  ============================================ -->
  <link rel="icon" type="image/png" href="<?php echo base_url()?>assets/img/favico.ico">

   <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-175774193-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-175774193-1');
</script>



</head>

<body id="page-top">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
      <a href="https://ezlawpay.com"><img src="<?php echo base_url()?>assets/img/WhiteOnTransparent.png" alt="EZ Law Pay is a complete financial management solution for your law firm."></a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
      </button>
    </div>
  </nav>

  <!-- About -->
  <section id="about" style="padding-top: 200px">
    <div class="container">
      <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-3 text-center">
          <form class="ibox-body " method="post" style="color: #2c365d" role="form" id="form-login" name="form-login">
                <h4 class="font-strong text-center mb-5">Log In</h4>                                                                        
                <div class="form-group mb-4">
                  <input class="form-control form-control-line form-control-login" id="user" type="text" name="user" placeholder="User" required autofocus>
                </div>
                <div class="form-group mb-4">
                  <input class="form-control form-control-line form-control-login" id="password" type="password" name="password" placeholder="Password" required>
                </div>

                <div class="text-center mb-4">
                  <button class="btn btn-primary btn-rounded btn-block" style="border-color: #fff; background-color: #2c365d" type="submit" id="btnLogin">Log In</button>
                  <a id="forgot-password" data-toggle="modal" data-target="#general_modal1" class="blue-color" style="font-size: small;" href="#">forgot password?</a>
                </div>
                <div class="form-group text-center">
                  <label style="color:red"><?php if(isSet($text)){echo $text;} ?></label>
                </div>
                <div class="loginSignUpSeparator">
                  <span class="textInSeparator">or</span>
                </div>
                <div class="form-group mb-4 text-center">
                  <h6><a id="register-now" style="cursor: pointer"  data-toggle="modal" data-target="#general_modal" class="blue-color"  href="<?php echo base_url('Welcome/registronow')?>">Register Now</a></h6>
                </div>
              </form>        
            </div>
            <div class="col-lg-3">
              <a href="https://ezlawpay.com"><img src="<?php echo base_url()?>assets/img/logo_login.png" class="img-responsive" alt="EZ Law Pay is a complete financial management solution for your law firm"></a>
            </div>
      </div>
     
    </div>
  </section>


<div class="modal fade bd-example-modal-lg" tabindex="-1"  id="general_modal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_title">Register Now</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <div class="modal-body" id="modal_body">

  <form id="registronowa">
    <div class="form-row">
    <div class="form-group col-md-6">
      <label>First Name</label>
      <input type="text" class="form-control" name="nombre" required="required">
    </div>
   <div class="form-group col-md-6">
    <label>Last Name</label>
    <input type="text" class="form-control" name="apellido" required="required">
  </div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label >Email</label>
      <input type="email" class="form-control" name="email" required="required">
    </div>
    <div class="form-group col-md-6">
      <label>City</label>
      <input type="text" class="form-control" name="ciudad">
    </div>

  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label >Company</label>
      <input type="text" class="form-control" name="empresa">
    </div>
    <div class="form-group col-md-6">
      <label>Phone</label>
      <input type="text" class="form-control" name="telefono" required="required">
    </div>

  </div>

  <button type="submit" class="btn btn-primary">Send</button>
</form>

        </div>
          <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>

   <div class="modal fade bd-example-modal-lg" tabindex="-1"  id="general_modal1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_title">Reset password</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <div class="modal-body" id="modal_body">

  <form id="resetpass">
    <div class="form-row">
    <div class="form-group col-md-6">
      <label>Username</label>
      <input type="text" class="form-control" name="username" required="required">
    </div>
    <div class="form-group col-md-6">
      <label >Email</label>
      <input type="email" class="form-control" name="email" required="required">
    </div>
  </div>
  
  <button type="submit" class="btn btn-primary">Send</button>
</form>

        </div>
          <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
 

 

  <!-- Bootstrap core JavaScript -->
 <script src="<?php echo base_url()?>assets/js/jquery-3.4.1.js"></script>
 <script type="text/javascript">
    $("#form-login").submit(function(e) {
      e.preventDefault(); // avoid to execute the actual submit of the form.
      var form = $("#form-login").serialize();
      $.post( "<?php echo base_url()?>c_login/login",form, function( data ) {
        if (data=='SI'){
          location.href = "<?php echo base_url()?>dashboard";
        }else{
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!'
          })
        }
      });
    });


     $("#resetpass").submit(function(e) {
      e.preventDefault(); // avoid to execute the actual submit of the form.
      var form = $("#resetpass").serialize();
      $.post( "<?php echo base_url()?>c_login/resetpass",form, function( data ) {
        if (data==1){
            Swal.fire({
              title: 'Done!',
              text:  'Your new password was sent by mail.!',
              icon:  'success'
            }).then((result) => {
                location.href = "https://ezlawpay.com/ez/login";
             })
        }else{
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Verify your username!'
          })
        }
      });
    });



     $("#registronowa").submit(function(e) {
      e.preventDefault(); // avoid to execute the actual submit of the form.
      var form = $("#registronowa").serialize();
      $.post( "<?php echo base_url()?>c_login/clienteinfo",form, function( data ) {
        if (data==1){
            Swal.fire({
              title: 'Done!',
              text:  'Thank you for contacting us, an agent will contact you via email. Regards.!',
              icon:  'success'
            }).then((result) => {
                location.href = "https://ezlawpay.com/";
             })
        }else{
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '!'
          })
        }
      });
    });


    // $("#registronowa").submit(function(e) {
    //   e.preventDefault(); // avoid to execute the actual submit of the form.
    //   var formulario = $("#registronowa").serialize();

    //   $.post( "<?php echo base_url()?>c_login/registrarss",formulario, function( data ) { 
    //     // if (data=='SI'){
    //     //   location.href = "<?php echo base_url()?>dashboard";
    //     // }else{
    //     //   Swal.fire({
    //     //     icon: 'error',
    //     //     title: 'Oops...',
    //     //     text: 'Something went wrong!'
    //     //   })
    //     // }
    //   });
    // });
  </script>
   <script src="<?php echo base_url()?>assets/js/bootstrap.bundle.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="<?php echo base_url()?>assets/js/jquery.easing.min.js"></script>

  <!-- Contact form JavaScript -->
  <script src="<?php echo base_url()?>assets/js/jqBootstrapValidation.js"></script>
  <script src="<?php echo base_url()?>assets/js/contact_me.js"></script>

  <!-- Custom scripts for this template -->
  <script src="<?php echo base_url()?>assets/js/agency.min.js"></script>

  <!-- tawk chat JS -->
  <script src="<?php echo base_url()?>assets/js/tawk-chat.js"></script>
  


</body>

</html>
