window.onload = () => {
 const myInput = document.getElementsByClassName('mobile');
 myInput.onpaste = e => e.preventDefault();
}

 $(".mobile").attr("onpaste","return false;");

$('.alp').bind('keyup blur',function(){ 
    var node = $(this);
    node.val(node.val().replace(/[^A-Za-z ]/g,'') ); }
);