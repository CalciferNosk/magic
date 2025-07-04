<style>

.button-wrapper-dl {
  position: relative;
  width: 150px;
  text-align: center;
}

.button-wrapper-dl span.labeldl {
  position: relative;
  z-index: 0;
  display: inline-block;
  width: 100%;
  background-color: #1c3393 !important;
  cursor: pointer;
  color: #fff;
  padding: 10px 0;
  text-transform:uppercase;
  font-size:12px;
}

#uploaddl {
    display: inline-block;
    position: absolute;
    z-index: 1;
    width: 100%;
    height: 50px;
    top: 0;
    left: 0;
    opacity: 0;
    cursor: pointer;
}
</style>
<!--html>
<body>
<center>
<h3>PHP OCR Test</h3>
<form action="<?php echo base_url();?>Test/submit" method="POST" enctype="multipart/form-data">
<input type="file" name="image" />
<input type="submit"/>
</form>
</center>
</body-->
 <form name="upload_img" enctype="multipart/form-data" id="upload_img">
<div class="button-wrapper-dl">
  <span class="labeldl">
    Upload File
  </span>
  
    <input type="file" name="image" id="uploaddl" class="upload-box" placeholder="Upload File">
  
</div>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
	alert('test');
$('#uploaddl').change(function()
{
	alert('test');
    var form = new FormData(document.getElementById('upload_img'));
    //append files
    var file = document.getElementById('uploaddl').files[0];
    if (file) {   
        form.append('uploaddl', file);
    }
    $.ajax({
        type: "POST",
        url: "Test/submit",
        data: form,             
        cache: false,
        contentType: false, //must, tell jQuery not to process the data
        processData: false,
        //data: $("#upload_img").serialize(),
        success: function(data)
        {
        	alert(data);
            if(data == 1)
                $('#img_msg').html("Image Uploaded Successfully");
            else
                $('#img_msg').html("Error While Image Uploading");
        }
    });

});
</script>