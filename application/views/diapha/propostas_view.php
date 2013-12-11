<?
$view = $_GET['view'];
$minhaspropostas = $_GET['minhaspropostas'];
$intervalo = $_GET['intervalo'];

?>

<!-- FancyBox -->

<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="<?= base_url() . TEMPLATE; ?>/js/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

<!-- Add fancyBox main JS and CSS files -->
<script type="text/javascript" src="<?= base_url() . TEMPLATE; ?>/js/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url() . TEMPLATE; ?>/js/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />

<!-- Add Button helper (this is optional) -->
<link rel="stylesheet" type="text/css" href="<?= base_url() . TEMPLATE; ?>/js/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
<script type="text/javascript" src="<?= base_url() . TEMPLATE; ?>/js/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>

<!-- Add Thumbnail helper (this is optional) -->
<link rel="stylesheet" type="text/css" href="<?= base_url() . TEMPLATE; ?>/js/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
<script type="text/javascript" src="<?= base_url() . TEMPLATE; ?>/js/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

<!-- Add Media helper (this is optional) -->
<script type="text/javascript" src="<?= base_url() . TEMPLATE; ?>/js/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

<!-- Fim FancyBox -->


<style>

    .lista td {
        padding-left: 10px;
    }

    .lista td .barraStatus {
        margin-top: -30px;
        margin-right: -3px; 
        color:#999999;
        float: right;
    }

    .lista td .local {
        color:#999999;
        float: left;
    }

    .status {
        width: 80px;
    }

    .nao-respondido {
        background: #ff0000;
        padding: 3px;
        color: #ffffff;
    }

    .em-analise {
        background: #f89406;
        padding: 3px;
        color: #ffffff;
    }

    .respondido {
        background: #468847;
        padding: 3px;
        color: #ffffff;
    }

    .mais-detalhes {
        float: right;
    }

    #loading {
        text-align: center;
    }

    #loading .progress {
        width: 300px;
        margin: 0 auto;
    }

</style>

<!-- Modal Status -->
<div class="modal" id="modalStatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display:none">
    <form name="formStatus" action="" method="GET">

        <input type="hidden" name="st_status" />
        <input type="hidden" name="id_proposta" value="" />

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Alterando status da ocorrência</h3>
        </div>
        <div class="modal-body" style="min-height: 10px">

            <p>
                Deixe uma mensagem:
            </p>
            <textarea rows="3" style="width: 520px" name="mensagem"></textarea>

        </div>

    </form>
    <div class="modal-footer">
        <button class="btn btn-large" data-dismiss="modal" aria-hidden="true">Fechar</button>
        <button class="btn btn-large" type="submit" id="btnStatus" onclick="alterarStatus()">Confirmar</button>
    </div>

</div>

<!-- Header -->
<div class="grid_24">
    <div class="caixa header-perfil">
        <div class="col-1">
            <? if (usuario('fb_user') != ''): ?>

            <img src="https://graph.facebook.com/<?= usuario('fb_user'); ?>/picture?width=147&height=140" />

            <?
            elseif (usuario('nm_foto') != '' || usuario('com_logo')):
            ?>

            <img src="<?= base_url(); ?>/arquivos/diapha/<?= (usuario('nm_foto') != '') ? usuario('nm_foto') : usuario('com_logo'); ?>" height="140" />

            <?
            else:
            ?>

            <img src="<?= base_url() . TEMPLATE; ?>/img/semImagemP.jpg" height="140" />

            <?
            endif;
            ?>
        </div>
        <div class="col-2">
            <h1 class="tituloCaixa">
                <?= usuario('nm_usuario'); ?>
                <br>
                <span>
                    <?= usuario('cidade'); ?>
                </span>
            </h1>

            <!--<div class="col-relatos-1">
            <?= $total; ?> relato(s) publicado(s)
            </div>

            <div class="col-relatos-2">
                <a href="<?= $_SERVER ['REQUEST_URI']; ?>&status=0"><span class="status nao-respondido"><?= $nao_respondido; ?> não foi(ram) respondida(s)</span></a>
                <a href="<?= $_SERVER ['REQUEST_URI']; ?>&status=1"><span class="status em-analise"><?= $em_analise; ?> está(ão) em análise</span></a>
                <a href="<?= $_SERVER ['REQUEST_URI']; ?>&status=2"><span class="status respondido"><?= $resolvido; ?> foram resolvidos</span></a>
            </div>-->

        </div>
    </div>

</div>

<div class="clear"></div>

<!-- Corpo -->
<div class="grid_4">
    <div class="caixa menu-perfil">

        <ul class="nav nav-pills nav-stacked">
            <li>
                <a href="?view=feed&intervalo=<?= $intervalo; ?>"  <?= ($pagina == 'relatos') ? 'class="btn-info"' : ''; ?>>Relatos <span class="badge badge-inverse pull-right"><?= $total_geral; ?></span></a>
                <!--<ul class="nav">
                    <li><a href="<?= $_SERVER ['REQUEST_URI']; ?>&status=0"><span class="status nao-respondido"><?= $nao_respondido; ?> pendentes</span></a></li>
                    <li><a href="<?= $_SERVER ['REQUEST_URI']; ?>&status=1"><span class="status em-analise"><?= $em_analise; ?> em análise</span></a></li>
                    <li><a href="<?= $_SERVER ['REQUEST_URI']; ?>&status=2"><span class="status respondido"><?= $resolvido; ?> resolvidos</span></a></li>
                </ul>-->
            </li>

            <?
            if (checa_permissao(array('cidadao'), true)):
            ?>
            <li>
                <a href="<?= site_url('') ?>?view=feed&meusrelatos=1&intervalo=<?= $intervalo; ?>" <?= ($pagina == 'meusrelatos') ? 'class="btn-info"' : ''; ?>>Meus Relatos <span class="badge badge-inverse pull-right"><?= $total_usuario; ?></span></a>
            </li>

            <li>
                <a href="<?= site_url('') ?>?view=propostas&minhaspropostas=1&intervalo=<?= $intervalo; ?>" <?= ($pagina == 'minhaspropostas') ? 'class="btn-info"' : ''; ?>>Minhas Propostas</a>
            </li>
            <?
            endif;
            ?>
        </ul>
    </div>
    <div class="caixa menu-perfil">
        <ul class="nav nav-pills nav-stacked">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="icon-time"></i>
                    Intervalo
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="?view=propostas&minhaspropostas=1&intervalo=">Todos</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="?view=propostas&minhaspropostas=1&intervalo=Hoje">Hoje</a>
                    </li>
                    <li>
                        <a href="?view=propostas&minhaspropostas=1&intervalo=Esta semana">Esta semana</a>
                    </li>
                    <li>
                        <a href="?view=propostas&minhaspropostas=1&intervalo=Este mês">Este mês</a>
                    </li>
                    <li>
                        <a href="?view=propostas&minhaspropostas=1&intervalo=Este ano">Este ano</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <a href="<?= site_url('proposta/cadastrar'); ?>"><button class="btn btn-info btn-large">Cadastrar proposta!</button></a>
</div>

<div class="grid_20">
    <div >

        <div class="clear"></div>

        <div class="feeds">

            <?
            if (perfil() == 'orgao'):
            if (date("Y-m-d") < usuario('dt_acesso_inicio') || date("Y-m-d") > usuario('dt_acesso_fim')):
            ?>
            <div class="alert">
                Para responder as ocorrências de responsabilidade do seu órgão entre em <a href="<?= site_url('portal/contato'); ?>">contato</a> conosco e saiba como ativar essa funcionalidade.
            </div>
            <?
            endif;
            endif;
            ?>

            <?
            if (is_array($propostas)):
            //echo $pagina;
            //exit();
            foreach ($propostas as $proposta):
            $endereco = $proposta['ds_endereco'];

            if ($proposta['status_proposta'] == 0):
            $status = '<span class="status nao-respondido">Não respondido</span>';
            elseif ($proposta['status_proposta'] == 1):
            $status = '<span class="status em-analise">Em análise</span>';
            else:
            $status = '<span class="status respondido">Respondido</span>';
            endif;

            //$apoiado = $this->relato_model->selecionarApoio($relato['id_relato'], usuario('id_usuario'));
            ?>

            <div class="feed">

                <div class="feed-img-user">
                    <? if ($proposta['fb_user'] != ''): ?>

                    <img class='img-polaroid fb-img' src='https://graph.facebook.com/<?= $proposta['fb_user'] ?>/picture' height='60' align='left' />

                    <?
                    else:
                    ?>

                    <img class="img-polaroid fb-img" src="<?= base_url() . TEMPLATE; ?>/img/semImagemPequena.jpg" height="60" />

                    <?
                    endif;
                    ?>

                </div>

                <div class="feed-arrow">
                </div>

                <div class="feed-content caixa">

                    <div class="feed-header">
                        <span class="feed-name-user"><b><?= $proposta['nm_usuario']; ?></b></span>

                        <span class="feed-date pull-right">
                            <img src="<?= base_url() . TEMPLATE; ?>/img/icones/icon-relogio.png" />
                            <?= formata_data_extenso(formataDate($proposta['dt_cadastro'], "-")); ?> às <?= substr($proposta['hr_cadastro'], 0, 5) ?>.
                        </span>
                    </div>

                    <div class="clear"></div>

                    <div class="feed-middle">

                        <p style="font-size: 16px;">
                            <b></b><br>

                            <?= $proposta['ds_proposta']; ?>

                            <br>
                        </p>

                        <div class="feed-location">
                            <img src="<?= base_url() . TEMPLATE; ?>/img/icones/icon-map-marcador.png" />
                            <?= $endereco; ?>
                        </div>

                    </div>

                    <div class="feed-historic">
                        <?
                        $preferencias = unserialize(usuario('ds_preferencias'));

                        $arr = explode(",", $preferencias['categorias']);

                        $historico = unserialize($proposta['ds_historico']);

                        /**
                        * Histórico
                        */
                        if ($historico):

                        foreach ($historico as $h):

                        // Se for órgão que respondeu
                        if ($h['nm_orgao'] != ''):
                        $nome = $h['nm_orgao'];

                        $orgao = $this->orgao_model->selecionarOrgao($h['id_orgao']);
                        if ($orgao['nm_logo'] != ''):
                        $foto = base_url() . "/arquivos/orgao/" . $orgao['nm_logo'];
                        else:
                        $foto = base_url() . TEMPLATE . "/img/semImagemP.jpg";
                        endif;

                        // Se for o próprio usuário que respondeu
                        elseif ($h['email_facebook'] != ''):
                        $nome = $proposta['fb_name'];
                        $foto = "https://graph.facebook.com/" . $proposta['fb_user'] . "/picture";
                        endif;

                        if ($h['st_status'] == '1'):
                        $msg = "alterou o status para <b>Em análise</b>.<br>";
                        elseif ($h['st_status'] == '2'):
                        $msg = "alterou o status para <b>Respondido</b>.<br>";
                        endif;
                        ?>

                        <div class="reply">
                            <div class="col-1">
                                <img class='img-polaroid fb-img' src='<?= $foto; ?>' height='40' align='left' />
                            </div>

                            <div class="col-2">
                                <span>
                                    <b><?= $nome; ?></b>
                                    <?= $msg; ?>
                                </span>
                                <span style="font-size: 10px;">
                                    <?= formata_data_extenso(formataDate($h['dt_alteracao'], "-")); ?> às <?= substr($h['hr_alteracao'], 0, 5) ?>.
                                </span>
                                <br>
                                <div class="reply-msg"><?= $h['ds_mensagem']; ?></div>
                            </div>
                        </div>
                        <div class="clear"></div>

                        <?
                        endforeach;

                        endif;
                        ?>

                    </div>
                    <div class="feed-footer">
                        <div style="float: left">
                            <a href="<?= site_url('proposta/detalhes?id=' . $proposta['id_proposta']); ?>" class="btn btn-info" title="Ver mais detalhes da proposta" style="padding: 8px">
                                <i class="icon-plus icon-white"></i>
                            </a>
                        </div>
                    </div>
                    <!--<div class="fb-comments">

                        Facebook comments
                        <div id="fb-root"></div>
                        <script>(function(d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0];
                                if (d.getElementById(id))
                                    return;
                                js = d.createElement(s);
                                js.id = id;
                                js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1&appId=<?= FB_APPID ?>";
                                fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));</script>

                        <div class="fb-comments" data-href="<?= site_url('relato/' . $proposta['nm_apelido'] . '/detalhes?id=' . $proposta['id_proposta']); ?>" data-width="710" data-num-posts="10"></div>

                    </div>-->

                </div>

            </div>

            <div class="clear"></div>

            <?
            endforeach;
            else:
            ?>
            <div class="alert alert-info">Você ainda não enviou nenhuma proposta pois</div>
            <?
            endif;
            ?>


        </div>

        <div id="loading" style="padding-top: 30px;height: 50px">
        </div>

    </div>

</div>



<script type="text/javascript">

    iniciarFancybox();

    $(document).ready(function() {

        var fim = false;
        $(window).scroll(function() {

            if (fim == false) {

                if (($(window).scrollTop() + $(window).height() + 20) >= $(document).height()) {

                    var qtd = $(".feeds .feed").length;

                    $("#loading").html('<div class="progress progress-striped active"><div class="bar" style="width: 20%;"></div></div>');

                    $.get('<?= site_url('lista/adicionar_ajax') ?>',
                            {minhaspropostas: '<?= $_GET['minhaspropostas']; ?>', intervalo: '<?= $_GET['intervalo']; ?>', i: qtd},
                    function(data) {

                        if ($.trim(data) == '0' && fim == false) {
                            fim = true;

                            $("#loading").html('');
                            $(".feeds").append('<div style="margin-left: 80px">Não temos mais resultados para exibir.</div>');
                            return false;
                        }

                        if ($.trim(data) == '0') {
                            $("#loading").html('');
                            return false;
                        }

                        $("#loading").html('<div class="progress progress-striped active"><div class="bar" style="width: 80%;"></div></div>');

                        $(".feeds").append(data);

                        alterarCorLinhas();

                        $("#loading").html('');

                        iniciarFancybox();

                    });
                }

            }

        });

        $('.btn').tooltip();
    });

    function mostrarCategorias() {

        $('#modalCategorias').modal();

    }

    function iniciarFancybox() {

        // Set custom style, close if clicked, change title type and overlay color
        $(".fancybox-effects-c").fancybox({
            wrapCSS: 'fancybox-custom',
            closeClick: true,
            openEffect: 'none',
            helpers: {
                title: {
                    type: 'inside'
                },
                overlay: {
                    css: {
                        'background': 'rgba(238,238,238,0.85)'
                    }
                }
            }
        });

    }

</script>