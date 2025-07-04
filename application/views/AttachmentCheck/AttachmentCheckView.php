<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            /* overflow: hidden; */
        }

        iframe {
            width: 90%;
            height: 650px;
            border: 0;
            margin: 10px;
        }
    </style>
</head>

<body>
<div class="container d-flex justify-content-center mt-5">
    <div>
    Enter ERS LOAN ID :
    </div>
    <div>
       
        <input type="text" name="id" class="form-control" id="loan-id" value="" placeholder="enter here">
       
    </div> 
    <div>
    <button class="btn btn-success" id="go-btn">Go</button>
    </div>
   
</div>
<hr>
<?php
if(!empty($data)) : ?>
    <div class="row m-5 p-2" style="height: 800px;">
      <center>  <h3>Folder/ERS ID : <?= $id ?></h3></center>
    <?php foreach ($data as $key => $value) :
        if ($value == '..' || $value == '.') continue;
    ?>
    <div class="col-md-6 p-3" style="height:750px; align-items: center;border: 1px solid gray; ">
        <center> <h5 style="bac"><?= $value ?></h5>
       <iframe src="<?= base_url() . 'assets/attachments/' . $id . '/' . $value ?> " frameborder="0"></iframe></center>
    </div>
    <?php endforeach; ?>
    </div>
<?php else : ?>
    <center><h5>No Attachment</h5></center>
<?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#loan-id').focus();

            $(document).on('click', '#go-btn', function() {
                loadFiles()
            })
            $($('#loan-id')).keypress(function(event) {
                if (event.which === 13) {
                    loadFiles()
                }
            });
            function loadFiles(){
                var existing_id = '<?= $id ?>'
                var id = $('#loan-id').val();
                if(existing_id == id){
                    return false;
                }
                window.location.href = '<?= base_url() ?>attachment-checker/' + id

            }
        })
    </script>

</body>

</html>