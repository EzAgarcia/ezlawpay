<?php 
$session_expire = !isset($_SESSION['ezlow']);
ob_start();
if ($session_expire){ header('Location: '.base_url().'/login'); }

$profile = (isset($_SESSION['ezlow']['profile']) && !empty($_SESSION['ezlow']['profile'])) ? $_SESSION['ezlow']['profile'] : 0;
$id_user = (isset($_SESSION['ezlow']['iduser']) && !empty($_SESSION['ezlow']['iduser'])) ? $_SESSION['ezlow']['iduser'] : 0;
?><!DOCTYPE html>
<html>
<head>
	<title>EZ Law Pay</title>

	<link rel="icon" type="image/png" href="<?php echo base_url()?>assets/img/favico.ico">
	<link href="<?php echo base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url()?>assets/css/font-awesome-all.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url()?>assets/css/notika-custom-icon.css">
	<link rel="stylesheet" href="<?php echo base_url()?>assets/css/scrolling/fonts.css" type="text/css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/css/scrolling/estilo.css" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css' rel='stylesheet' type='text/css'>
  <link href='https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sl-1.3.1/datatables.min.css"/>
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sl-1.3.1/datatables.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
  <link href="<?php echo base_url()?>assets/css/agency.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sl-1.3.1/datatables.min.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sl-1.3.1/datatables.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.css" id="theme-styles">
	<link href="<?php echo base_url()?>assets/css/agency.css" rel="stylesheet">
	

	<link rel="stylesheet" href="<?php echo base_url()?>assets/css/scrolling/fonts.css" type="text/css">
	<link rel="stylesheet" href="<?php echo base_url()?>assets/css/scrolling/estilo.css" type="text/css">
	<link href="<?php echo base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo base_url()?>assets/css/font-awesome-all.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
	<link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

	<style type="text/css">
		.dropdown-item i{
			padding-right: 20%;
		}
		.dropdown-item{
			padding-top: 5%;
			padding-bottom: 5%;
		}
		.dropdown-menu {
			font-size: 18px;
    		width: 300px !important;
		}
		.nav-link{
			font-size: 20px;
			color: #fff !important;
		}
		footer {
			background-color: #2c365d !important;	
			width: 100%;
			height: 60px;
			padding: 15px;
			color: #fff;
			font-size: 15px;
			bottom: 0px;
		}
		footer a{
			color: #fff;
			text-decoration:none;
		}
		footer a:hover{
			color: #000;
			text-decoration:none;
		}

		#contetn{
			 margin: 0 auto;
			width: 95%;
		}
		.loading{
			background: rgba(0,0,0,0.8);
			width: 100%;
			float: left;
			top: 0;
			position: absolute;
			height: 100%;
		}
		.loading img{
			margin-top: 20%;
		}
		.loadings{
			display: none;
		}
		.navbar-custom {
				background-color: #2c365d !important;
		}
		.navbar-custom .navbar-brand,
		.navbar-custom .navbar-text {
				color: rgba(255,255,255,.8);
		}
		.navbar-custom .navbar-nav .nav-link {
				color: rgba(255,255,255,.5);
		}
		.navbar-custom .nav-item.active .nav-link,
		.navbar-custom .nav-item:focus .nav-link,
		.navbar-custom .nav-item:hover .nav-link {
				color: #C0C0C0 !important;
		}
		.header-icon {
			padding-right: 10px !important;
		}
		.logo {
			padding-right: 0px !important;
			width: 40%;
		}
		.menu {
			padding-left: 10px !important;
			width: 100%;
			font-size: 12px !important;
			margin-right: -50px !important;
		}
		.nav-name-custom {
			width: 20%;
		}
		.mr-auto {
			width: 100%;
		}
		.nav-item-custom {
			padding: 0px  15px 0px 15px !important;
		}
		.custom-text {
			font-size: 17px !important;
		}
		.tickets {
			float: left;
			margin: -3px  0px 0px -12px !important;	
    			color: red !important;
			height: 50px;
		}
		.ticket {
			float: left;
			margin: -2px  0px 0px -20px !important;
    			color: #38BEC9 !important;
		}
		.ticket-balance {
			float: left;
			margin: 2px  0px 0px -20px !important;
    			color: #9B1B5A !important;
		}
		.ticket-number {
			float: left;
			font-size:   10px;
			margin-top:  -2px;
			margin-left: -22px;
			display:    block;
		}
		.ticket-number-balance {
			float: left;
			font-size:   10px;
			margin-top:  3px;
			margin-left: -22px;
			display:    block;
		}
		.balance_processed {
			margin: 0px  0px 0px -25px !important;
			color: whitesmoke !important;
		}
		.dropdown-menu-settings-custom {
			line-height: 0.2 !important;
		}
		.fa-file-contract-icon-dropdown, .fa-users-icon-dropdown,
		.fa-users-icon-dropdown, .fa-money-bill-wave-icon-dropdown,
		.fa-envelope-icon-dropdown, .fa-chart-area-icon-dropdown,
		.fa-money-bill-wave-icon-dropdown, .fa-user-circle-icon-dropdown,
		.fa-question-circle-icon-dropdown, .fa-sign-out-alt-icon-dropdown {
			padding-right: 15px !important;
		}
		#breadcrumb ul {
			display: flex; /* A key part of our menu, displays items side by side, and allows reversing them */
			flex-direction: row-reverse; /* Reverse the items */	
		}	

		/* Background container */
		#breadcrumb-container {
			height: 220px;
			background-color: white;
		}

		/* Menu container */
		#breadcrumb {
			display: inline-block;
			margin-top: 30px;
			margin-bottom: 10px;
			font-family: Helvetica, sans-serif;
			font-size: 0.875rem;
			line-height: 1em;
			border-radius: 2px;
			overflow: hidden;
		}

		/* Icons */
		#breadcrumb i {
			transform: scale(1.4);
		}

		/* Menu */
		#breadcrumb ul {
			display: flex;
			flex-direction: row-reverse;
			list-style: none;
			margin: 0;
			padding: 0;
		}

		#breadcrumb ul li {
			margin: 0;
		}

		/* Menu items */
		#breadcrumb ul li a {
			display: inline-block;
			font-family: sans-serif;
			font-size: 0.9em;
			font-weight: 600;
			padding: 12px 30px 12px 45px;
			margin-left: -20px;
			color: #FFFFFF;
			background-color: #243853;
			text-decoration: none;
			text-transform: uppercase;
			border-radius: 0 100px 100px 0;
			box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
		}

		#breadcrumb ul li:hover a {
			background-color: #334E68;
		}

		#breadcrumb ul li:first-child a {
			box-shadow: none;
		}

		#breadcrumb ul li.active a {
			color: #F0F4F8;
			background-color: #627D98;
		}

		#breadcrumb ul li.active + li a {
			box-shadow: none;
		}

		#fa-custom-icon, #breadcrumb i{
			margin-right: 10px !important;
		}

		.new_balance {
			margin: 3px  0px 0px -20px !important;
			color: #69D169 !important;
		}
	</style>
</head>
<body>
	<div class="modal fade bd-example-modal-lg" tabindex="-1"  id="general_modal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modal_title"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
					<div class="modal-body" id="modal_body">
				</div>
					<div class="modal-footer">
				</div>
			</div>
		</div>
	</div>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark navbar-custom">
	<div class = "logo">
		<a class="navbar-brand" href="<?php echo site_url('dashboard'); ?>"><img src="<?php echo base_url()?>assets/img/WhiteOnTransparent.png" alt=""></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
	</div>
	<div class = "menu">
		<div class="collapse navbar-collapse" id="navbarSupportedContent">

			<ul class="navbar-nav mr-auto">

				<?php if ($_SESSION['ezlow']['lawfirm'] != 2  AND $_SESSION['ezlow']['profile'] != 3) { ?>
					
				
				<li class="nav-item dropdown nav-item-custom">
					<a class="nav-link dropdown-toggle custom-text" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-chart-line header-icon"></i>Reports
					</a>
					<div class="dropdown-menu dropdown-menu-settings-custom" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="<?php echo base_url()?>clients_sign_today"><i class="fas fa-file-contract fa-file-contract-icon-dropdown"></i>Contracts Signed Today</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="<?php echo base_url()?>by_users"><i class="fas fa-users fa-users-icon-dropdown"></i>Total Collected</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="<?php echo base_url()?>monthly_bills"><i class="fas fa-money-bill-wave  fa-money-bill-wave-icon-dropdown"></i>By Invoices</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="<?php echo base_url()?>phone_messages"><i class="fas fa-envelope fa-envelope-icon-dropdown"></i>Text Message Reminder</a>

						<?php if ($profile == 1) { ?>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="<?php echo base_url()?>statistics"><i class="fas fa-chart-area fa-chart-area-icon-dropdown"></i>Statistics</a>
						<?php	} ?>
					</div>
				</li>

				<?php } ?>
				<li class="nav-item nav-item-custom">
					<a class="nav-link custom-text" href="<?php echo base_url()?>clients">
					<i class="fas fa-users header-icon"></i>Clients
					</a>
				</li>

				<?php if ($_SESSION['ezlow']['lawfirm'] != 2) { ?>
				<li class="nav-item nav-item-custom">
					<a class="nav-link custom-text" href="<?php echo base_url('contrac')?>">
					<i class="fas fa-file-contract header-icon"></i>Contracts
					</a>
				</li>

				<?php } ?>

				<?php if ($_SESSION['ezlow']['lawfirm'] == 2) { ?>
				<li class="nav-item nav-item-custom">
					<a class="nav-link custom-text" href="<?php echo base_url('C_contracts/contracuk')?>">
					<i class="fas fa-file-contract header-icon"></i>Contracts UK
					</a>
				</li>
				<?php } ?>


				<?php if ($profile == 1) { ?>
					<li class="nav-item nav-item-custom">
						<a class="nav-link custom-text" href="<?php echo base_url('list_user')?>">
						<i class="fas fa-user-friends header-icon"></i>Users
						</a>
					</li>
				<?php } ?>
				<li class="nav-item nav-item-custom nav-name-custom">
					<a class="nav-link custom-text" href="<?php echo base_url('profile')?>">
						<?php $username = isset($this->session->ezlow['name']) ? $this->session->ezlow['name'] : 'Guest' ; ?>
						<i class="fas fa-user header-icon"></i><?php echo $username?>
					</a>
				</li>
				<li class="nav-item dropdown nav-item-custom">
					<a class="nav-link dropdown-toggle custom-text" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-cogs header-icon"></i></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-menu-settings-custom" aria-labelledby="navbarDropdown">
						<?php if ($profile == 1 or $profile == 2){ ?>
							<a class="dropdown-item" href="<?php echo base_url()?>unapplied_payments" ><i class="fas fa-money-bill-wave fa-money-bill-wave-icon-dropdown"></i>Unapplied Payments</a>

							<a class="dropdown-item" href="<?php echo base_url()?>C_contracts/reasignacion" ><i class="fas fa-money-bill-wave fa-money-bill-wave-icon-dropdown"></i>Reassignment of payments</a>
							
						<?php	} ?>
						<a class="dropdown-item" href="<?php echo base_url()?>profile"><i class="fas fa-user-circle fa-user-circle-icon-dropdown"></i>Profile</a>
						<a class="dropdown-item" href="<?php echo base_url()?>C_tickets/tickets"><i class="far fa-question-circle fa-question-circle-icon-dropdown"></i>Support</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#" onclick="log_out()"><i class="fas fa-sign-out-alt fa-sign-out-alt-icon-dropdown"></i>Log Out</a>
					</div>
				</li>
				<div class= "tickets">
					<?php if($profile == 1 ){ ?>
						<li class="nav-item">
							<?php if(isset($_SESSION['ezlow']['ntickets']) && $_SESSION['ezlow']['ntickets'] > 0 ){ ?>
								<li class="nav-item nav-item-custom">
									<a class="nav-link custom-text" href="<?php echo base_url()?>C_tickets/tickets">
									<i class="fas fas fa-comment header-icon ticket"></i>
										<span class="ticket-number">
											<?php print($_SESSION['ezlow']['ntickets']); ?>
										</span>
									</a>
								</li>
							<?php } ?>
						</li>
					<?php } ?>
					<?php if($profile == 1){ ?>
						<li class="nav-item">
							<?php if(isset($_SESSION['ezlow']['nbalance']) && !empty($_SESSION['ezlow']['nbalance']['waiting']) > 0 ){ ?>
								<li class="nav-item nav-item-custom">
									<a class="nav-link custom-text" href="<?php echo base_url()?>C_tickets/tickets">
									<i class="fas fas fa-comment header-icon ticket-balance"></i>
										<span class="ticket-number-balance">
											<?php print($_SESSION['ezlow']['nbalance']['waiting']); ?>
										</span>
									</a>
								</li>
							<?php } ?>
						</li>
					<?php } ?>
				</div>
				<?php if($profile == 2 || $id_user == 21){ ?>
					<li class="nav-item">
						<?php if(isset($_SESSION['ezlow']['nbalance']) && !empty($_SESSION['ezlow']['nbalance']['processed']) ){ ?>
							<li class="nav-item nav-item-custom">
								<a class="nav-link custom-text" href="<?php echo base_url()?>C_tickets/tickets">
								<i class="fas fas fa-file-import header-icon new_balance"></i>
								</a>
							</li>
						<?php } ?>
					</li>
				<?php } ?>
			</ul>
		</div>
	</div>
</nav>
<?php
$breadcrumb = [
	'welcomedashboard'            => ['show_name' => 'Home', 'father' => '', 'link' => base_url().'dashboard'],
	'C_reportsclients_sign_today' => ['show_name' => 'Contracts Signed Today', 'father' => 'Reports', 'link' => base_url().'clients_sign_today'],
	'C_reportsby_users'           => ['show_name' => 'Total Collected', 'father' => 'Reports', 'link' => base_url().'by_users'],
	'C_reportsmonthly_bills'      => ['show_name' => 'By Invoices', 'father' => 'Reports', 'link' => base_url().'monthly_bills'],
	'C_reportsphone_messages'     => ['show_name' => 'Text Message Reminder', 'father' => 'Reports', 'link' => base_url().'phone_messages'],
	'C_contractsgraficas'         => ['show_name' => 'Statics', 'father' => 'Reports', 'link' => base_url().'statistics'],
	'c_clientclients'             => ['show_name' => 'Clients', 'father' => '', 'link' => base_url().'clients'],
	'C_contractscontrac'          => ['show_name' => 'Contracts', 'father' => '', 'link' => base_url().'contrac'],
	'C_userslist_user'            => ['show_name' => 'Users', 'father' => '', 'link' => base_url().'list_user'],
	'C_invoiceunapplied_payments' => ['show_name' => 'Unapplied Payments', 'father' => 'Settings', 'link' => base_url().'unapplied_payments'],
	'welcomeprofile'              => ['show_name' => 'Profile', 'father' => 'Settings', 'link' => base_url().'profile'],
	'C_ticketstickets'            => ['show_name' => 'Tickets', 'father' => 'Settings', 'link' => base_url().'C_tickets/tickets'],
	'C_reportsaldia'              => ['show_name' => 'Total Upcoming Payments For Today', 'father' => 'Reports', 'link' => base_url().'clients_sign_today'],
	'C_contractsmodificontract'   => ['show_name' => 'Edit Contract', 'father' => 'Contracts', 'link' => base_url().'C_contracts/modificontract'],
	'C_reportstransactions'       => ['show_name' => 'Transactions', 'father' => 'Reports', 'link' => base_url().'C_contracts/transactions'],
	'C_invoiceunapplied_payments2' => ['show_name' => 'Unapplied Payments', 'father' => 'Settings', 'link' => base_url().'C_contracts/unapplied_payments2'],
	'C_contractsnewview'           => ['show_name' => 'Contracts New', 'father' => 'Contracts', 'link' => base_url().'C_contracts/newview'],
	'C_contractsfirmados'           => ['show_name' => 'Statistics', 'father' => 'Reports', 'link' => base_url().'statistics'],
	'C_contractsservices'           => ['show_name' => 'Statistics', 'father' => 'Reports', 'link' => base_url().'statistics'],
	'C_contractspayments'           => ['show_name' => 'Statistics', 'father' => 'Reports', 'link' => base_url().'statistics'],
	'C_contractstotalincome'           => ['show_name' => 'Statistics', 'father' => 'Reports', 'link' => base_url().'statistics'],
	'C_contractspaymentform'           => ['show_name' => 'Statistics', 'father' => 'Reports', 'link' => base_url().'statistics'],
	'C_contractsnewcontracts'           => ['show_name' => 'Statistics', 'father' => 'Reports', 'link' => base_url().'statistics'],
	'C_contractsnewcontractsonhold'           => ['show_name' => 'Statistics', 'father' => 'Reports', 'link' => base_url().'statistics'],
	'C_contractsnewcontractsf'           => ['show_name' => 'Statistics', 'father' => 'Reports', 'link' => base_url().'statistics'],
	'C_contractsnewpaymentsf'           => ['show_name' => 'Statistics', 'father' => 'Reports', 'link' => base_url().'statistics'],
	'C_contractspaymentshold'           => ['show_name' => 'Statistics', 'father' => 'Reports', 'link' => base_url().'statistics'],
	'C_contractscontracuk'           => ['show_name' => 'Contracts', 'father' => '', 'link' => base_url().'C_contracts/contracuk'],
	'C_contractsreasignacion'           => ['show_name' => 'Payment Reassign', 'father' => '', 'link' => base_url().'C_contracts/reasignacion'],



];

$location = $this->router->fetch_class().$this->router->fetch_method();
$base_breadcrumb = $breadcrumb[$location];
$show_name = $base_breadcrumb['show_name'];
$father = $base_breadcrumb['father'];
$link = $base_breadcrumb['link'];

?>

<?php if(!empty($father)){?>
<div id="breadcrumb" class="breadcrumb-father">
  <ul>
		<li class="active"><a href="<?php echo $link; ?>"><?php echo $show_name; ?></a></li>
		<li><a href="#"><?php echo $father; ?></a></li>
		<li	><a href="<?php echo base_url()?>dashboard"><i class="fa fa-home fa-custom-icon"></i>Home</a></li>
  </ul>
</div>
<?php } elseif($show_name != 'Home') {?>
<div id="breadcrumb" class="breadcrumb-sub">
	<ul>
		<li class="active"><a href="<?php echo $link; ?>"><?php echo $show_name; ?></a></li>
		<li	><a href="<?php echo base_url()?>dashboard"><i class="fa fa-home fa-custom-icon"></i>Home</a></li>
	<ul>
</div>
<?php } else {?>
<div id="breadcrumb">
	<ul>
		<li	><a href="<?php echo base_url()?>dashboard"><i class="fa fa-home fa-custom-icon"></i>Home</a></li>
	<ul>
</div>
<?php } ?>

	<br><br>
	<section id="contetn">
		<div class="row">
			<div class="col-lg-12">
			<?php
			print_r($content);
			?>
			</div>
		</div>
	</section>

	<footer>
			<p><center>Copyright &copy; 2019. All rights reserved. <a href="https://ezlawpay.com">Ez Law Pay</a>.</center></p>    
	</footer>
</body>
<script src="<?php echo base_url()?>assets/js/jquery-3.4.1.js"></script>
<script src="<?php echo base_url()?>assets/js/bootstrap.bundle.min.js"></script>

<!-- Plugin JavaScript -->
<script src="<?php echo base_url()?>assets/js/jquery.easing.min.js"></script>

<!-- Contact form JavaScript -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="<?php echo base_url()?>assets/js/contact_me.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<!--  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script> -->


<div class="loading loadings" id="loading">
	<center>
		<img src="<?php echo base_url()?>assets/img/loading.svg">
	</center>
</div>
  
<!-- Custom scripts for this template -->
<!--   <script src="<?php echo base_url()?>assets/js/agency.min.js"></script> -->
<!-- tawk chat JS -->
<script src="<?php echo base_url()?>assets/js/tawk-chat.js"></script>

<script type="text/javascript">
	function ir_by_urser(){
		$("#loading").show();
		window.location.href = "<?php echo base_url()?>by_users";
	}
	function log_out() {
		Swal.fire({
		title: 'Are you sure?',
		text: "You want to exit?",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Yes'
	}).then((result) => {
		if (result.value) {
			window.location.href = "<?php echo base_url()?>log_out";
		}
	})
	}
</script>
  <!-- tawk chat JS -->

</html>
<script src="<?php echo base_url()?>assets/js/jqBootstrapValidation.js"></script>

<script>
(function worker() {
  $.ajax({
    url: '<?php echo base_url()?>' + 'balance_request', 
    success: function(data) {
			var request = parseInt(data, 10);
			var blackList = ['21'];
			var user_id = "<?php echo $id_user ?>";
			if( request > 0 && !blackList.includes(user_id)){
				alert('Hi, there is a new ' + data + ' balance request!!');
			}
    },
    complete: function() {
      setTimeout(worker, 20000);
    }
  });
})();
</script>