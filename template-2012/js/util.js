/**
* Metodo para submeter o paginador
* antes era por querystring ... atualmente � submetido o formulario top da pesquisa o FORM[0]
* utilizando Jquery para criar o campo hidden per_page e submeter o form[0]
* por  CV  Lourival 
*/
function paginador(val) {
    $("form[name=paginador]").append("<input type='hidden' name='per_page' value='" + val + "'>");
    $("form[name=paginador]").submit();
}

function confirmaApagar(url){

    if (confirm("Tem certeza que deseja excluir este registro?")){

        window.location = url;

    }

}

function confirmaApagarArquivo(url){

    if (confirm("Tem certeza que deseja excluir este arquivo? Cuidado! Após a exclusão não será possível a sua recuperação!")){

        window.location = url;

    }

}

function alterarCorLinhas() {
    var i = 0;
    $(".lista tr").each(function(){
        i = parseFloat(i) + parseFloat(1);
        if (i % 2 == 0 && $(this).attr('class') != 'trInterna' && $(this).attr('class') != 'trRodape'){
            $(this).addClass('alterna');
        }
    });
    
    $(".lista-branca tr").each(function(){
        $(this).removeClass('alterna');
    });
    
    $(".trBranco").each(function(){
        $(this).removeClass('alterna');
    });
   
}

function alterarCorLinhasMouse() {
    $(".lista tr").mouseover(function(){
        $(this).addClass("mouse");
    });
    
    $(".lista tr").mouseout(function(){
        $(this).removeClass("mouse");
    });
    
    $(".lista .trInterna").mouseover(function(){
        $(this).removeClass("mouse");
    });
    
    $(".lista .trRodape").mouseover(function(){
        $(this).removeClass("mouse");
    });
    
    $(".lista .trBranco").mouseover(function(){
        $(this).removeClass("mouse");
    });
}

function carregarTela() {
       
    $.blockUI({ 
        message: "<img src='./template-2012/img/ajaxLoaderGrande.gif' />",
        css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#ffffff', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .2, 
            color: '#ffffff'
        } 
    });

    setTimeout($.unblockUI, 2000);
    
}

function carregarMensagem(msg, tempo) {
    
    if (tempo == ''){
        tempo = 2000;
    }
    
    $.blockUI({ 
        title: "Mensagem",
        message: msg,
        theme: true,
        css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .2, 
            color: '#ffffff'
            
        } 
    });

    setTimeout($.unblockUI, tempo);
    
}

/**
 * JQuery
 */
$(document).ready(function() {
    
    // Alternar cor das linhas das listas
    alterarCorLinhas();
    
    // Alterar cor da linha quando passar o mouse em cima
    alterarCorLinhasMouse();
    
    
});