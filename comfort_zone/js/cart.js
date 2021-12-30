
function addToCart(id_prodotto, username) {
    const data = {function: "addToCart", id: id_prodotto, username: username};

    $.post("js_to_php.php", data, function(response) {});
}

function deleteFromCart(id_prodotto, username) {
    const data = {function: "deleteFromCart", id: id_prodotto, username: username};

    $.post("js_to_php.php", data, function(response) {});
}

function removeFromCart(id_prodotto, username) {
    const data = {function: "removeFromCart", id: id_prodotto, username: username};

    $.post("js_to_php.php", data, function(response) {});
}

function exeDeliver(id_ordine, username) {
    const data = {function: "exeDeliver", id: id_ordine, username: username};

    $.post("js_to_php.php", data, function(response) {});
}

function requestRestock (id_prodotto, username) {
    const data = {function: "requestRestock", id: id_prodotto, username: username};

    $.post("js_to_php.php", data, function(response) {});  
}


$(document).ready(function(){
    
});