function deleteProduct(id_prodotto,url){
    var data = {function: "deleteProduct", id: id_prodotto};
  
    $.post("php_functions.php", data, function(response) {
        
    });
}


$(document).ready(function(e){
    if ($(".order-recap article").lenght > 1) { 
        $(".order-recap article::last-of-type").prev().attr("id","acquista_ora");
    }
    else {
        $(".order-recap article:first-of-type").attr("id","acquista_ora");
    }
});
