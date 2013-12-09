<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" xml:lang="pt-br" lang="pt-br" xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <title><?= $titulo; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="description" content="Portal criado com o objetivo de ser pioneiro no segmento de mercado de compras públicas, especificamente em Registro de Preço. Determinado a atender o mercado proporcionando informação e serviços de utilidade pública, disponibilizando para seus clientes uma enorme gama de serviços, que contribuam com as atividades do seu dia-a-dia." /> 
        <meta name="keywords" content="Portal, ARP,SRP, adesao a registro de preco, sistema de registro de preco, registro de preco, ata, atas, licitacao, licitacão publica, edital pregao, pesquisa de mercado, pesquisa de preco, lei 8.666, itens, orgaos, municipios, compras, compras publicas, solucoes, copa, copa do mundo, 2014, federal, municipal, estadual, menor preco, pregao eletronico, pregao presencial, compra direta." /> 
        <!--<meta name="google-site-verification" content="d7hIciaQEVqvJnnZBtkhp_seF95tk05HFeCQ5y2mLUk" />-->
        <meta name="google-site-verification" content="9XUbjEaU4JPeEQXsnvClzxD7lI_Mj9P_Cn1SWEt29tw" />

        <script type="text/javascript" src="<?= base_url() . TEMPLATE; ?>/js/validacao.js"></script>
        <script type="text/javascript" src="<?= base_url() . TEMPLATE; ?>/js/util.js"></script>
        <script type="text/javascript" src="<?= base_url() . TEMPLATE; ?>/js/jquery.meio.mask.js"></script>
        <script type="text/javascript" src="<?= base_url() . TEMPLATE; ?>/js/tiptip/jquery.tipTip.js"></script>
        <script type="text/javascript" src="<?= base_url() . TEMPLATE; ?>/js/jquery-validate/jquery.validate-1.5.js"></script>
        <script type="text/javascript" src="<?= base_url() . TEMPLATE; ?>/js/jquery.blockUI.js"></script>

        <link href="<?= base_url() . TEMPLATE; ?>/css/reset.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() . TEMPLATE; ?>/css/text.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() . TEMPLATE; ?>/css/960_24_col.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() . TEMPLATE; ?>/css/estilo.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() . TEMPLATE; ?>/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() . TEMPLATE; ?>/css/lista.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() . TEMPLATE; ?>/css/formulario.css" rel="stylesheet" type="text/css" />

        <link href="<?= base_url() . TEMPLATE; ?>/js/tiptip/tipTip.css" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="<?= base_url() . TEMPLATE; ?>/js/jquery-ui/themes/base/jquery.ui.all.css" />

        <link rel="shortcut icon" href="http://www.portalarp.com.br/portal/favicon.ico"></link>

        <!-- Google Analytics -->

        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-25041338-3']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

        </script>

        <!-- Fim do código Google Analytics -->
        
        

        <script>
                
            $(document).ready(function() {
                    
                // Datas
                $("input[name*=dt_], input[name*=data_]").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    yearRange: '1910:2020'
                });
                
                // ToolTip
                $("a, img, button, input, span").each(function() {
                    if ($(this).attr("title") != ''){
                        $(this).tipTip({maxWidth: "auto", edgeOffset: 10});
                    }
                });
                   
            });
            
        </script>
        

    </head>
    <?
    // Carregar view button
    $this->load->view("inc/componentes/button");

    // Carregar view para datas
    $this->load->view("inc/componentes/datepicker");
    ?>

    <body>
        
        <?
        // carrega o header
        if (checa_permissao(array('orgao', 'vendedor'), true)):

            include_once("inc/header_perfil_view.php");

        elseif (checa_permissao(array('admin', 'operador'), true)):

            include_once("inc/header_view.php");

        endif;
        ?>

        <div class="container_24">

            <div class="barraLateral">
                <div class="grid_5">

                    <?
                    // carrega o menu interno
                    if (checa_permissao(array('vendedor', 'admin', 'operador'), true)):
                        include_once("inc/menu_view.php");
                    endif;
                    ?>

                    <?
                    // carrega o boxEquipe
                    if (checa_permissao(array('orgao', 'vendedor'), true)):
                        include_once("inc/equipe_view.php");
                    endif;
                    ?>

                </div>

            </div>

            <div class="conteudo">
                
                <?= $content_for_layout ?>
                
            </div>

        </div>

        <?
        // carrega o rodape
        include_once("inc/footer_view.php");
        ?>

    </body>
</html>

