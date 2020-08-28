<div class="container">
	<div>
		Ingrese ID <input id="nuevo" type="text" class="form-control"><br>
		<button class="btn btn-info" onclick="editarba(<?php echo $id; ?>)">Editar</button>
	</div>
</div>



<script>
	 function editarba(id) {

	 	var nuevo = $('#nuevo').val();
	 	var url = "<?php echo site_url('C_tickets/addedit');?>";
       $.ajax({                        
           type: "POST",                 
           url: url, 
           data: {  id : id, nuevo : nuevo },
           success: function(response){
              setTimeout(location.reload() , 1000);
           }                   
       });
	 }
</script>