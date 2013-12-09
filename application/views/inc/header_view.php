<script>
    $(document).ready(function(){
   
        $(".botaoEncontre").click(function() {
            $("form[name=formBuscaProduto]").submit(); 
        });
   
    });
</script>

<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="<?= site_url(''); ?>">
                <img src="<?= base_url() . TEMPLATE; ?>/img/logoHorPequena.png" />
            </a>
            <div class="nav-collapse collapse navbar-responsive-collapse">
                <!--<ul class="nav">
                    <li><a href="#">Link</a></li>
                    <li><a href="#">Link</a></li>
                </ul>-->
                
                <ul class="nav pull-right">
                    <li><a href="<?=site_url('inicial'); ?>">Home</a></li>
                    <li class="divider-vertical"></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="text-transform: lowercase">
                            <?= usuario('nm_login'); ?><b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?= site_url(""); ?>">Voltar ao site</a></li>
                            <li><a href="<?= site_url("usuario/meus_dados"); ?>">Editar perfil</a></li>
                            
                            <li class="divider"></li>
                            <li><a href="<?= site_url("logoff"); ?>">Sair</a></li>

                        </ul>
                    </li>
                </ul>
                
            </div><!-- /.nav-collapse -->
        </div>
    </div>
</div>



<div class="container_24">


    <div class="barraSuperiorPerfil">

        <div class="grid_3 prefix_3 suffix_5">
        </div>

        <div class="grid_13">

        </div>

        <!--
        <div class="grid_9 right">
            <form name="formBuscaProduto" action="<?= site_url('produto/catalogo'); ?>" method="GET">
                <input class="textoBuscar" type="text" name="busca_produto" value="" />
                <input type="button" class="btn btn-success" value="Buscar" />
            </form>
        </div>
        <div class="grid_1">
            <a href='<?= site_url("inicial"); ?>'><img src="<?= base_url() . TEMPLATE; ?>/img/icoHome.png" /></a>
        </div>
        <div class="grid_1">
            <a href='<?= site_url('portal/contato'); ?>'><img src="<?= base_url() . TEMPLATE; ?>/img/icoBaloes.png" /></a>
        </div>
        <div class="grid_1">
            <a href='<?= site_url("usuario/meus_dados"); ?>'><img src="<?= base_url() . TEMPLATE; ?>/img/icoPerfil.png" /></a>
        </div>
        <div class="grid_1">
            <a href='<?= site_url('login/logoff'); ?>'><img src="<?= base_url() . TEMPLATE; ?>/img/icoPower.png" /></a>
        </div>
        
        -->

    </div>

    <div class="cabecalho">

        <div class="grid_3">
            <div class="fotoPerfilGrande">
                <a href="<?= site_url('usuario/editar_foto'); ?>" id="botaoAddFoto" title="Clique para adicionar uma foto ao seu perfil.">
                    <?
                    if (usuario('nm_foto') != ''):
                        ?>
                        <img src="<?= base_url() . "arquivos/usuario/" . usuario('nm_foto'); ?>" height="101"  class="img-polaroid"/>
                        <?
                    else:
                        ?>

                        <img src="<?= base_url() . TEMPLATE . "/img/logoGrande.jpg" ?>" class="img-polaroid" />
                    <?
                    endif;
                    ?>
                </a>
            </div>
        </div>
        <div class="grid_21">
            <div class="tituloPerfil">
                <div class="nomeUsuario">
                    <?= usuario('nm_usuario'); ?>
                </div>
                <div class="nomePerfil">
                    <?= perfil(); ?>
                </div>
            </div>
        </div>

    </div>


</div>