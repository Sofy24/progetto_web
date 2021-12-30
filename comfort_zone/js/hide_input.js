$(document).ready(function(){
    const radioutente = $(":radio#utente");
    const radiovenditore = $(":radio#venditore");
    const radiofattorino = $(":radio#fattorino");
    $("label[for='imgmarchio']").hide();
    $("input#imgmarchio").hide();
    $("input#imgmarchio").prop("required", false);
    $("label[for='bankcode']").hide();
    $("input#bankcode").hide();
    $("input#bankcode").prop("required", false);
    $("label[for='cognome']").show();
    $("input#cognome").show();
    $("input#cognome").prop("required", true);
    $("label[for='pagamento']").show();
    $("input#pagamento").show();
    $("input#pagamento").prop("required", true);
    $("label[for='nome_marchio']").hide();
    $("input#nome_marchio").hide();
    $("input#nome_marchio").prop("required", false);
    $("label[for='nome']").show();
    $("input#nome").show();
    $("input#nome").prop("required", true);
    radiovenditore.attr("checked");

    radiovenditore.click(function(e){
        $("label[for='imgmarchio']").show();
        $("input#imgmarchio").show();
        $("input#imgmarchio").prop("required", true);
        $("label[for='bankcode']").show();
        $("input#bankcode").show();
        $("input#bankcode").prop("required", true);
        $("label[for='cognome']").hide();
        $("input#cognome").hide();
        $("input#cognome").prop("required", false);
        $("label[for='pagamento']").hide();
        $("input#pagamento").hide();
        $("input#pagamento").prop("required", false);
        $("label[for='nome_marchio']").show();
        $("input#nome_marchio").show();
        $("input#nome_marchio").prop("required", true);
        $("label[for='nome']").hide();
        $("input#nome").hide();
        $("input#nome").prop("required", false);
        radiovenditore.attr("checked");
    });

    radioutente.click(function(e){
        $("label[for='imgmarchio']").hide();
        $("input#imgmarchio").hide();
        $("input#imgmarchio").prop("required", false);
        $("label[for='bankcode']").hide();
        $("input#bankcode").hide();
        $("input#bankcode").prop("required", false);
        $("label[for='cognome']").show();
        $("input#cognome").show();
        $("input#cognome").prop("required", true);
        $("label[for='pagamento']").show();
        $("input#pagamento").show();
        $("input#pagamento").prop("required", true);
        $("label[for='nome_marchio']").hide();
        $("input#nome_marchio").hide();
        $("input#nome_marchio").prop("required", false);
        $("label[for='nome']").show();
        $("input#nome").show();
        $("input#nome").prop("required", true);
    });

    radiofattorino.click(function(e){
        $("label[for='imgmarchio']").hide();
        $("input#imgmarchio").hide();
        $("input#imgmarchio").prop("required", false);
        $("label[for='bankcode']").hide();
        $("input#bankcode").hide();
        $("input#bankcode").prop("required", false);
        $("label[for='cognome']").show();
        $("input#cognome").show();
        $("input#cognome").prop("required", true);
        $("label[for='pagamento']").hide();
        $("input#pagamento").hide();
        $("input#pagamento").prop("required", false);
        $("label[for='nome_marchio']").hide();
        $("input#nome_marchio").hide();
        $("input#nome_marchio").prop("required", false);
        $("label[for='nome']").show();
        $("input#nome").show();
        $("input#nome").prop("required", true);
    });


    
});
