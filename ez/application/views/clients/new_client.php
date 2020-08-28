<form id="client_form" method="POST">
	<div class="form-row">
    	<div class="form-group col-md-6">
      		<label for="name">Name</label>
      		<input type="text" class="form-control" name="name" id="name"  >
		</div>
		<div class="form-group col-md-6">
      		<label for="sex">Sex</label>
      		<select name="sex" class="form-control">
				<option></option>
				<option value="F">Female</option>
				<option value="M">Male</option>
			</select>
    	</div>
		<div class="form-group col-md-6">
	    	<label for="birthdate" >Date of Birth</label>
	      	<input type="date" class="form-control" name="birthdate" >
	  	</div>
	  	<div class="form-group col-md-6">
	    	<label for="b_country" >Birth Country</label>
	  		<select name="b_country" class="form-control">
				<option></option>
				<?php
				foreach ($countryes as $country) {
										?>
					<option  value="<?php echo $country->ID ?>"><?php echo $country->Country_Name ?></option>
					<?php
				}
				?>
			</select>
	  	</div>
	  	<div class="form-group col-md-6">
			<label for="language" >Native Language</label>
			<input type="text" class="form-control" name="language">
		</div>
		<div class="form-group col-md-6">
			<label for="address" >Address</label>
			<input type="text" class="form-control" name="address" >
		</div>
		<div class="form-group col-md-6">
			<label for="city" >City</label>
			<input type="text" class="form-control" name="city" >
		</div>
		<div class="form-group col-md-6">
			<label for="zip" >Zip Code</label>
			<input type="text" class="form-control" name="zip" >
		</div>
		<div class="form-group col-md-6">
			<label for="estate" >State</label>
			<select name="estate" class="form-control" > 
				<option></option>
				<?php 
				foreach ($states as $state) {
					
					?>
					<option  value="<?php echo $state->ID?>"><?php echo $state->State_Name?></option>
					<?php
				}
				?>
			</select>
		</div>
		<div class="form-group col-md-6">
			<label for="country" >Country</label>
			<select name="country" class="form-control">
				<option></option>
				<?php 
				foreach ($countryes as $country) {
					
					?>
					<option  value="<?php echo $country->ID?>"><?php echo $country->Country_Name?></option>
					<?php
				}
				?>
			</select>
		</div>
		<div class="form-group col-md-6">
			<label for="phone" >Phone Number</label>
			<input type="text" data-mask="(000) 000-0000" class="form-control" name="phone"  >
		</div>
	  	<div class="form-group col-md-6">
	    	<label for="email" >Email</label>
	      	<input type="email" class="form-control" name="email" >
	  	</div>
	  	<div class="form-group col-md-12 text-right">
	    	<button type="submit" class="btn btn-danger btn-lg align-self-end">Save</button>
	  	</div>
	</div>
  	
</form>
<script type="text/javascript">
	$("#client_form").submit(function(e) {
		e.preventDefault();
		var name=$('#name').val();
		var text=name.split(' ');
		if (text.length>=3){
			//e.preventDefault(); // avoid to execute the actual submit of the form.
			var form = $("#client_form").serialize();
			$.post( "<?php echo base_url()?>c_client/save_client",form, function( data ) {
				if (data=='SI'){
					Swal.fire({
              title: 'Done!',
              text: '',
              icon: 'success'
            })
            setTimeout(function () { location.reload(1); }, 1500);
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
				text: 'It is necessary to put a full name'
			})
			return false;
		}
			
    });
</script>



<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>