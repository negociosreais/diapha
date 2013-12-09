<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" xml:lang="pt-br" lang="pt-br" xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <title><?= $title; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="description" content="<?= $description; ?>" /> 
        <meta name="keywords" content="<?= $keywords; ?>" /> 
        <!--<meta name="google-site-verification" content="d7hIciaQEVqvJnnZBtkhp_seF95tk05HFeCQ5y2mLUk" />-->
        <meta name="google-site-verification" content="9XUbjEaU4JPeEQXsnvClzxD7lI_Mj9P_Cn1SWEt29tw" />

        <script type="text/javascript" src="<?= base_url() . TEMPLATE; ?>/js/jquery-1.8.2.min.js"></script>
        <script type="text/javascript" src="<?= base_url() . TEMPLATE; ?>/js/validacao.js"></script>
        <script type="text/javascript" src="<?= base_url() . TEMPLATE; ?>/js/util.js"></script>
        <script type="text/javascript" src="<?= base_url() . TEMPLATE; ?>/js/jquery.meio.mask.js"></script>
        <script type="text/javascript" src="<?= base_url() . TEMPLATE; ?>/js/jquery-validate/jquery.validate-1.9.js"></script>
        <script type="text/javascript" src="<?= base_url() . TEMPLATE; ?>/js/jquery-validate/additional-methods.js"></script>
        <script type="text/javascript" src="<?= base_url() . TEMPLATE; ?>/js/jquery.blockUI.js"></script>
        <script type="text/javascript" src="<?= base_url() . TEMPLATE; ?>/js/formToWizard.js"></script>

        <link href="<?= base_url() . TEMPLATE; ?>/css/reset.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() . TEMPLATE; ?>/css/text.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() . TEMPLATE; ?>/css/960_24_col.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() . TEMPLATE; ?>/css/estilo.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() . TEMPLATE; ?>/css/menu.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() . TEMPLATE; ?>/css/lista.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() . TEMPLATE; ?>/css/formulario.css" rel="stylesheet" type="text/css" />

        <link href="<?= base_url() . TEMPLATE; ?>/js/tiptip/tipTip.css" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="<?= base_url() . TEMPLATE; ?>/js/jquery-ui/themes/base/jquery.ui.all.css" />

        <link rel="shortcut icon" href="http://www.diapha.com.br/favicon.ico"></link>

        <!-- BOOTSTRAP -->

        <link href="<?= base_url() . TEMPLATE; ?>/bootstrap/css/bootstrap-responsive.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() . TEMPLATE; ?>/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url() . TEMPLATE; ?>/bootstrap/css/bootstrap-lightbox.min.css" rel="stylesheet" type="text/css" />


        <script src="<?= base_url() . TEMPLATE; ?>/bootstrap/js/bootstrap-transition.js"></script>
        <script src="<?= base_url() . TEMPLATE; ?>/bootstrap/js/bootstrap-alert.js"></script>
        <script src="<?= base_url() . TEMPLATE; ?>/bootstrap/js/bootstrap-modal.js"></script>
        <script src="<?= base_url() . TEMPLATE; ?>/bootstrap/js/bootstrap-dropdown.js"></script>
        <script src="<?= base_url() . TEMPLATE; ?>/bootstrap/js/bootstrap-scrollspy.js"></script>
        <script src="<?= base_url() . TEMPLATE; ?>/bootstrap/js/bootstrap-tab.js"></script>
        <script src="<?= base_url() . TEMPLATE; ?>/bootstrap/js/bootstrap-tooltip.js"></script>
        <script src="<?= base_url() . TEMPLATE; ?>/bootstrap/js/bootstrap-popover.js"></script>
        <script src="<?= base_url() . TEMPLATE; ?>/bootstrap/js/bootstrap-button.js"></script>
        <script src="<?= base_url() . TEMPLATE; ?>/bootstrap/js/bootstrap-collapse.js"></script>
        <script src="<?= base_url() . TEMPLATE; ?>/bootstrap/js/bootstrap-carousel.js"></script>
        <script src="<?= base_url() . TEMPLATE; ?>/bootstrap/js/bootstrap-typeahead.js"></script>
        <script src="<?= base_url() . TEMPLATE; ?>/bootstrap/js/bootstrap-affix.js"></script>

        <script type="text/javascript" src="<?= base_url() . TEMPLATE; ?>/bootstrap/js/bootstrap-lightbox.min.js"></script>

        <!-- FIM BOOTSTRAP -->

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

        <script type="text/javascript">
                
            $(document).ready(function() {
                
                // Datas
                $("input[name*=dt_], input[name*=data_]").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    yearRange: '1910:2020'
                });
                
            });
            
        </script>

        <?
        // Carregar view para datas
        $this->load->view("inc/componentes/datepicker");

        // Checar usuário online
        usuario_online();
        ?>

    </head>


    <body>

        <?
        // carrega o header
        include_once("portal/inc/header_portal_view.php");

        // carrega o banner
        //include_once("portal/inc/banner_view.php");
        ?>

        <div class="container_24">

            <div class="conteudo960">
                <?= $content_for_layout ?>
            </div>

        </div>

        <?
        // carrega o rodape
        include_once("inc/footer_view.php");
        ?>

    </body>
</html>