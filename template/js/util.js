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