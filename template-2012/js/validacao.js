$(document).ready(function() {

    /**
                 * Vendedor
                 */
    $("form[name=cadastrar_vendedor]").validate({
        rules: {
            nm_representante: "required",
            nm_empresa: "required",
            nr_telefone: "required",
            nm_cidade: "required",
            nm_estado: "required",
            nm_login: "required",
            ds_senha: "required",
            concordo: "required",
            ds_email: {
                required: true,
                email: true
            },
            email_confirmacao: {
                equalTo: "#ds_email"
            }
        },
        messages: {
            nm_representante: " Campo obrigatório ",
            nm_empresa: " Campo obrigatório ",
            nr_telefone: " Campo obrigatório ",
            nm_cidade: " Campo obrigatório ",
            nm_estado: " Campo obrigatório ",
            nm_login: " Campo obrigatório ",
            ds_senha: " Campo obrigatório ",
            concordo: " Campo obrigatório ",
            ds_email: " Preencha o campo e-mail corretamente. ",
            email_confirmacao: " E-mail não confere. "
        }
    });

    $("form[name=editar_vendedor]").validate({
        rules: {
            nm_representante: "required",
            nm_empresa: "required",
            nr_telefone: "required",
            nm_cidade: "required",
            nm_estado: "required",
            nm_login: "required",
            ds_email: {
                required: true,
                email: true
            },
            email_confirmacao: {
                equalTo: "#ds_email"
            }
        },
        messages: {
            nm_representante: " Campo obrigatório ",
            nm_empresa: " Campo obrigatório ",
            nr_telefone: " Campo obrigatório ",
            nm_cidade: " Campo obrigatório ",
            nm_estado: " Campo obrigatório ",
            nm_login: " Campo obrigatório ",
            ds_email: " Preencha o campo e-mail corretamente. ",
            email_confirmacao: " E-mail não confere. "
        }
    });



    /**
                 * Produto
                 */

    $("form[name=cadastrar_produto]").validate({
        rules: {
            nm_produto: "required",
            nm_marca: "required",
            nr_valor: "required",
            nr_valor_unit: "required",
            id_categoria: "required",
            qt_mes: "required",
            nm_peso: "required"
        },
        messages: {
            nm_produto: " Campo obrigatório ",
            nm_marca: " Campo obrigatório ",
            nr_valor: " Campo obrigatório ",
            nr_valor_unit: " Campo obrigatório ",
            id_categoria: " Campo obrigatório ",
            qt_mes: " Campo obrigatório ",
            nm_peso: " Campo obrigatório "
        }
    });

    /**
                 * Ata
                 */

    $("form[name=cadastrar_ata]").validate({
        rules: {
            ds_pregao: "required",
            ds_itens: "required"
        },
        messages: {
            ds_pregao: " Campo obrigatório ",
            ds_itens: " Campo obrigatório "
        }
    });

    $("form[name=editar_ata]").validate({
        rules: {
            ds_pregao: "required",
            ds_itens: "required"
        },
        messages: {
            ds_pregao: " Campo obrigatório ",
            ds_itens: " Campo obrigatório "
        }
    });
                

                

		
});
