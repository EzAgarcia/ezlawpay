<form enctype="multipart/form-data" id="formuploadajax" method="post">
  <div class="custom-file">
    <input type="file" class="custom-file-input" id="customFile" name="customFile" accept=".csv">
    <label class="custom-file-label" for="customFile">Choose file</label>
  </div>
  <button type="submit" class="btn btn-primary">Upload</button>
</form>

<script>
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

$(function(){
        $("#formuploadajax").on("submit", function(e){
            e.preventDefault();
            var f = $(this);
            var formData = new FormData(document.getElementById("formuploadajax"));
            //formData.append(f.attr("name"), $(this)[0].files[0]);
            $.ajax({
                url: "<?php echo base_url()?>C_invoice/charge_file",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
	     processData: false
            })
                .done(function(res){
                    $("#mensaje").html("Respuesta: " + res);
                });
        });
    });
</script>