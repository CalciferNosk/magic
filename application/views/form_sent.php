<?php
?>
<script>
var id = '<?php echo $id;?>';
if(id == ''){
alert('System error: Record not saved to database. Please re-submit the form. Thank you.');
window.history.back();
}
else{
alert('Form Sent. Your Record Id is ' + id + '. Thank you for choosing Motortrade Group.');
window.history.back();
location.reload(); 
}
</script>