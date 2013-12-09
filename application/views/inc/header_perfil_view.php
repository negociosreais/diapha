<?
$this->load->view('inc/componentes/dialog');

// Facebook connect
$this->load->library('facebook');
$facebook = new Facebook(array(
            'appId' => FB_APPID,
            'secret' => FB_SECRET,
        ));

$user = $facebook->getUser();
?>

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
                    <li><a href="<?= site_url('inicial'); ?>" title="Voltar à página inicial">Home</a></li>
                    <li class="divider-vertical"></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="text-transform: lowercase" title="Opções do usuário">
                            <?= usuario('nm_login'); ?><b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?= site_url(""); ?>" title="Voltar à página inicial do site">Voltar ao site</a></li>
                            <li><a href="<?= site_url("usuario/meus_dados"); ?>" title="Editar perfil de usuário">Editar perfil</a></li>
                            <li class="divider"></li>
                            <li><a href="<?= site_url("logoff"); ?>">Sair</a></li>

                        </ul>
                    </li>
                </ul>

                <form class="navbar-search pull-right" action="<?= site_url('produto/catalogo'); ?>" method="GET">
                    <input type="text" name="busca_produto" class="search-query span2" placeholder="Buscar por produtos" title="Busque por produtos de qualquer categoria ou ata.">
                </form>
            </div><!-- /.nav-collapse -->
        </div>
    </div>
</div>

<div class="container_24" style="margin-bottom: 10px;">

    <div class="barraSuperiorPerfil">

    </div>

    <div class="cabecalho">

        <div class="grid_14">
            <div class="fotoPerfilGrande">
                <a href="<?= site_url(usuario('entidade') . '/editar_logo'); ?>" id="botaoAddLogo" title="Clique para adicionar uma logomarca.">
                    <?
                    $logo = usuario('nm_logo');

                    if ($logo != ''):
                        ?>
                        <img src="<?= base_url() . "arquivos/logos/" . $logo; ?>" height="101" class="img-polaroid" />
                        <?
                    else:
                        ?>
                        <img src="<?= base_url() . TEMPLATE . "/img/logoGrande.jpg" ?>"  height="101" class="img-polaroid"  />
                    <?
                    endif;
                    ?>
                </a>
            </div>
            <div class="fotoPerfilPequena">
                <span id="numero1">
                    <a href="<?= site_url('usuario/editar_foto'); ?>" id="botaoAddFoto" title="Clique para adicionar uma foto ao seu perfil.">
                        <?
                        if (usuario('nm_foto') != ''):
                            ?>
                            <img src="<?= base_url() . "arquivos/usuarios/" . usuario('nm_foto'); ?>" height="49" class="img-polaroid" />
                            <?
                        elseif ($user):
                            ?>
                            <img src="https://graph.facebook.com/<?= $user; ?>/picture" height="49" class="img-polaroid">
                            <?
                        else:
                            ?>
                            <img src="<?= base_url() . TEMPLATE . "/img/fotoPequena.jpg" ?>" class="img-polaroid" />
                        <?
                        endif;
                        ?>
                    </a>
                </span>
            </div>

            <div class="tituloPerfil">
                <div class="nomeEmpresa">
                    <?
                    if (perfil() == 'orgao'):

                        echo "<span title='" . usuario('nm_orgao') . "'>";
                        echo "<a href='" . site_url("orgao/" . usuario('id_orgao') . "/editar") . "'>";
                        echo (strlen(usuario('nm_orgao')) > 30) ? substr(usuario('nm_orgao'), 0, 30) . "..." : usuario('nm_orgao');
                        echo "</a>";
                        echo "</span>";

                    endif;
                    ?>
                </div>
                <div class="nomeUsuario">
                    <?= usuario('nm_usuario'); ?>
                </div>
                <div class="nomePerfil">
                    <?= usuario('relacao'); ?>
                </div>
            </div>
        </div>


    </div>


</div>