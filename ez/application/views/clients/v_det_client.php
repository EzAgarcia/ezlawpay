<form id="client_form" method="POST">
	<div class="form-row">
    	<div class="form-group col-md-6">
      		<label for="name">Full Name</label>
      		<input type="text" class="form-control" name="name" id="name" value="<?php echo $det[0]->C_Name?>" >
		</div>
    	<div class="form-group col-md-6">
      		<label for="sex">Sex</label>
      		<select name="sex" class="form-control">
      			<?php
      			switch ($det[0]->sex) {
      				case 'F':
      					?>
      					<option></option>
						<option value="F" selected="selected">Female</option>
						<option value="M">Male</option>
      					<?php
      					break;
      				case 'M':
      					?>
      					<option></option>
						<option value="F">Female</option>
						<option value="M" selected="selected">Male</option>
      					<?php
      					break;
      				
      				default:
      					?>
      					<option></option>
						<option value="F">Female</option>
						<option value="M">Male</option>
      					<?php
      					break;
      			}
      			?>
				
			</select>
    	</div>
		<div class="form-group col-md-6">
	    	<label for="birthdate" >Birth date</label>
	      	<input type="date" class="form-control" name="birthdate" value="<?php echo $det[0]->Birth_Date?>">
	  	</div>
	  	<div class="form-group col-md-6">
	    	<label for="b_country" >Birth Country</label>
	  		<select name="b_country" class="form-control">
				<option></option>
				<?php
				foreach ($countryes as $country) {
					if ($det[0]->Birth_Country_ID==$country->ID){
						$selected='selected="selected"';
					}else{
						$selected='';
					}
					?>
					<option <?php echo $selected?> value="<?php echo $country->ID ?>"><?php echo $country->Country_Name ?></option>
					<?php
				}
				?>
			</select>
	  	</div>
	  	<div class="form-group col-md-6">
			<label for="language" >Native Language</label>
			<input type="text" class="form-control" name="language" value="<?php echo $det[0]->Mother_Language?>" >
		</div>
		<div class="form-group col-md-6">
			<label for="address" >Address</label>
			<input type="text" class="form-control" name="address" value="<?php echo $det[0]->Address?>">
		</div>
		<div class="form-group col-md-6">
			<label for="city" >City</label>
			<input type="text" class="form-control" name="city" value="<?php echo $det[0]->City?>">
		</div>
		<div class="form-group col-md-6">
			<label for="zip" >Zip Code</label>
			<input type="text" class="form-control" name="zip" value="<?php echo $det[0]->Zip_Code?>">
		</div>
		<div class="form-group col-md-6">
			<label for="estate" >State</label>
			<select name="estate" class="form-control">
				<option></option>
				<?php 
				foreach ($states as $state) {
					if ($det[0]->State_ID==$state->ID){
						$selected='selected="selected"';
					}else{
						$selected='';
					}
					?>
					<option <?php echo $selected?> value="<?php echo $state->ID?>"><?php echo $state->State_Name?></option>
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
					if ($det[0]->Country==$country->ID){
						$selected='selected="selected"';
					}else{
						$selected='';
					}
					?>
					<option <?php echo $selected?> value="<?php echo $country->ID?>"><?php echo $country->Country_Name?></option>
					<?php
				}
				?>
			</select>
		</div>
		<div class="form-group col-md-6">
			<label for="phone" >Phone Number</label>
			<input type="text" class="form-control" name="phone" value="<?php echo $det[0]->Phone_Number?>">
		</div>
	  	<div class="form-group col-md-6">
	    	<label for="email" >Email</label>
	      	<input type="email" class="form-control" name="email" value="<?php echo $det[0]->Email?>">
	  	</div>
	  	<div class="form-group col-md-12 text-right">
	    	<button type="submit" class="btn btn-danger btn-lg align-self-end">Save</button>
	  	</div>
	</div>
	<input type="text" name="id" value="<?php echo $id?>" style='display: none'>
  	
</form>
<script type="text/javascript">
	$("#client_form").submit(function(e) {
		var name=$('#name').val();
		var text=name.split(' ');
		console.log(text.length);
		if (text.length>=3){
			e.preventDefault(); // avoid to execute the actual submit of the form.
			var form = $("#client_form").serialize();
			$.post( "<?php echo base_url()?>c_client/save_edit_client",form, function( data ) {
				if (data=='SI'){
					 Swal.fire({
              title: 'Done!',
              text: '',
              icon: 'success'
            }).then((result) => {
                location.reload();
             })
				}else{
					 Swal.fire({
              title: 'Done!',
              text: '',
              icon: 'success'
            }).then((result) => {
                location.reload();
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