function esci(){
    $.ajax({url:"template/logout.php", success:function(){
        window.location.href = "./template/logout.php";

        //chiusura db e arrivederci
        header("Location:../index.php");


        }
    })
}