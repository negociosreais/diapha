<?
$view = $_GET['view'];
$meusrelatos = $_GET['meusrelatos'];
$intervalo = $_GET['intervalo'];


if ($cidade == ""):

$this->load->library('facebook');
$facebook = new Facebook(array(
'appId' => FB_APPID,
'secret' => FB_SECRET,
));

$user = $facebook->getUser();

if ($user) :
try {
$profile_user = $facebook->api('/me');
} catch (FacebookApiException $e) {
error_log($e);
$user = null;
}

$cidade = $profile_user['location']['name']; elseif (usuario('cidade') == ''):
if (perfil() == 'orgao'):
$cidade = usuario('com_cidade') . " " . usuario('com_estado');
elseif (perfil() == 'vendedor'):
$cidade = usuario('ven_cidade') . " " . usuario('ven_estado');
else:
$cidade = "Brasilia Brasil";
endif;
else:
$cidade = usuario('cidade');
endif;

endif;

usuario('cidade', $cidade);
?>

<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
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

<!-- Modal Categorias -->
<div class="modal" id="modalCategorias" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display:none">
    <form name="formCategorias" action="" method="GET">

        <input type="hidden" name="view" value="feed" />

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Escolha as categorias que deseja ver</h3>
        </div>
        <div class="modal-body" style="min-height: 10px">

            <?
            checkbox("categoria", $cbo_categorias, '3', $marcados);
            ?>

        </div>
        <div class="modal-footer">
            <button class="btn btn-large" data-dismiss="modal" aria-hidden="true">Fechar</button>
            <button class="btn btn-info btn-large" type="submit" id="btnBuscarCategorias">Buscar</button>
        </div>
    </form>
</div>

<!-- Modal Status -->
<div class="modal" id="modalStatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display:none">
    <form name="formStatus" action="" method="GET">

        <input type="hidden" name="st_status" />
        <input type="hidden" name="id_relato" value="" />

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


<?= showStatus(); ?>

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
                    <a href="<?= site_url() ?>?view=feed&intervalo=<?= $intervalo; ?>"  <?= ($pagina == 'relatos') ? 'class="btn-info"' : ''; ?>>Relatos <span class="badge badge-inverse pull-right"><?= $total_geral; ?></span></a>
                </li>

                <?
                if (checa_permissao(array('cidadao'), true)):
                    ?>
                    <li>
                        <a href="<?= site_url('') ?>?view=feed&meusrelatos=1&intervalo=<?= $intervalo; ?>" <?= ($pagina == 'meusrelatos') ? 'class="btn-info"' : ''; ?>>Meus Relatos<span class="badge badge-inverse pull-right"><?= $total_usuario; ?></span></a>
                    </li>

                    <li>
                        <a href="<?= site_url('') ?>?view=propostas&minhaspropostas=1&intervalo=<?= $intervalo; ?>" <?= ($pagina == 'minhaspropostas') ? 'class="btn-info"' : ''; ?>>Minhas Propostas</a>
                    </li>
                    <?
                endif;
                ?>
            </ul>
    </div>
</div>

<div class="grid_20">
    <form id="form_proposta" class="form-horizontal" action="<?= site_url("proposta/salvar"); ?>" enctype="multipart/form-data" method="POST">
        <div class="control-group">
            <label class="control-label" for="tit_proposta">Título da Proposta</label>
            <div class="controls">
                <input id="tit_proposta" name="tit_proposta" type="text" class="form-control span8" id="tit_proposta" placeholder="Digite o título da sua proposta">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="ds_proposta">Descrição</label>
            <div class="controls">
                <textarea id="ds_proposta" name="ds_proposta" class="form-control span8" rows="4"></textarea>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="nm_arquivo">Arquivo</label>
            <div class="controls">
                <input type="file" id="nm_arquivo" name="nm_arquivo" class="span8">
            </div>
            <p class="help-block controls">Envie um arquivo anexo à sua proposta, como imagem ou PDF.</p>
        </div>
        <div class="caixa form-inline" style="width: 100%;">
            <div class="input-append" style="width: 75%;">
                <input id="ds_endereco" name="ds_endereco" type="text" class="form-control" placeholder="Digite o endereço ou CEP do local para a proposta" style="width: 65%; height: 25px;">
                <button class="btn" type="button" onclick="pesquisarEndereco()">Pesquisar</button>
            </div>
            <button id="btnRetangulo" type="button" class="btn btn-default pull-right" onclick="criarRetangulo()">Retângulo</button>
            <button id="btnCirculo" type="button" class="btn btn-default pull-right" onclick="criarCirculo()">Círculo</button>
            <div style="height: 5px;"></div>
            <div id="mapa" style="width: 98%; height: 320px;" class="img-polaroid"></div>
        </div>
        <input type="hidden" name="tipo_marcacao" id="tipo_marcacao">
        <input type="hidden" name="coordenadas" id="coordenadas">
        
        <button type="button" onclick="salvarProposta()" class="btn btn-default">Salvar</button>
    </form>
</div>



<script type="text/javascript">
    var lat;
    var lng;
    var map;
    var zoom = <?= (usuario('cidade') == 'Brasil') ? 3 : 8; ?>;
    var circulo;
    var retangulo;
    var geocoder;
    
    iniciarFancybox();

    $(document).ready(function() {

        carregarMapa();
        var fim = false;
        $(window).scroll(function() {

            if (fim == false) {

                if (($(window).scrollTop() + $(window).height() + 20) >= $(document).height()) {

                    var qtd = $(".feeds .feed").length;

                    $("#loading").html('<div class="progress progress-striped active"><div class="bar" style="width: 20%;"></div></div>');

                    $.get('<?= site_url('lista/adicionar_ajax') ?>',
                            {meusrelatos: '<?= $_GET['meusrelatos']; ?>', intervalo: '<?= $_GET['intervalo']; ?>', i: qtd},
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

    function carregarMapa() {

        var mapOptions = {
            zoom: zoom,
            center: new google.maps.LatLng(-15.47, -47.52)
        };
        map = new google.maps.Map(document.getElementById('mapa'), mapOptions);
        
        geocoder = new google.maps.Geocoder();
        
        google.maps.event.addListener(map, 'bounds_changed', function() {
                  var bounds =  map.getBounds();
                  var ne = bounds.getNorthEast();
                  var sw = bounds.getSouthWest();
                  //do whatever you want with those bounds
         });
    }
    
    function pesquisarEndereco() {
        var endereco = document.getElementById("ds_endereco").value;
        geocoder.geocode( { 'address': endereco}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
            map.setZoom(14);
            var marker = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location
            });
        }else {
            alert("Não foi possível encontrar o endereço");
        }
        });
    }
    
    function criarCirculo() {
        document.getElementById("btnRetangulo").disabled = true; 
        document.getElementById("btnCirculo").disabled = true;
        var opcoesCirculo = {
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            map: map,
            center: map.getCenter(),
            radius: 100,
            editable: true,
            draggable: true
         };
         
         circulo = new google.maps.Circle(opcoesCirculo);
        
    }
    
    function criarRetangulo() {
        document.getElementById("btnRetangulo").disabled = true; 
        document.getElementById("btnCirculo").disabled = true;
        
        var bounds =  map.getBounds();
        var ne = bounds.getNorthEast();
        var sw = bounds.getSouthWest();
                
        var coordSW = new google.maps.LatLng(sw.lat()+(((ne.lat()-sw.lat())/2)/1.2), sw.lng()-(((sw.lng()-ne.lng())/2)/1.2));
        var coordNE = new google.maps.LatLng(ne.lat()-(((ne.lat()-sw.lat())/2)/1.2), ne.lng()+(((sw.lng()-ne.lng())/2)/1.2));
        
        retangulo = new google.maps.Rectangle({
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            map: map,
            bounds: new google.maps.LatLngBounds(coordSW,coordNE),
            draggable: true,
            editable: true
            });
    }
    
    function salvarProposta() {
        var titulo = document.getElementById("tit_proposta").value;
        var descricao = document.getElementById("ds_proposta").value;
        var endereco = document.getElementById("ds_endereco").value;
        var tipoDeMarcacao;
        var coordenadas;
        
        if (retangulo) {
            tipoDeMarcacao = "retangulo";
            
            var bounds =  retangulo.getBounds();
            var ne = bounds.getNorthEast();
            var sw = bounds.getSouthWest();
        
            coordenadas = sw.lat()+","+sw.lng()+"|"+ne.lat()+","+ne.lng();
            
        }else if (circulo) {
            tipoDeMarcacao = "circulo";
            
            var center = circulo.getCenter();
            coordenadas = center.lat()+","+center.lng()+"|"+circulo.getRadius();
        }
        
        document.getElementById("tipo_marcacao").value = tipoDeMarcacao;
        document.getElementById("coordenadas").value = coordenadas;
        
        document.getElementById("form_proposta").submit();
    }

    function mostrarCategorias() {

        $('#modalCategorias').modal();

    }

    function mostrarStatus(status, id) {

        $("input[name=id_relato]").val(id);
        $("input[name=st_status]").val(status);

        if (status == 1) {
            $("#btnStatus").addClass('btn-warning');
        } else {
            $("#btnStatus").addClass('btn-success');
        }

        $('#modalStatus').modal();

        $("textarea[name=mensagem]").focus();

    }

    function alterarStatus() {

        var dados = $('form[name=formStatus]').serialize();


        $.ajax({
            type: "POST",
            url: "<?= site_url('relato/alterar_status') ?>",
            data: dados,
            success: function(retorno) {

                setTimeout($.unblockUI, 5000);

                if ($.trim(retorno) == 'true') {

                    location.reload();

                } else {

                    $.blockUI({
                        message: "Desculpe! Não foi possível atualizar o status da ocorrência.",
                        css: {
                            border: 'none',
                            padding: '15px',
                            backgroundColor: '#000',
                            '-webkit-border-radius': '10px',
                            '-moz-border-radius': '10px',
                            opacity: .5,
                            color: '#fff'
                        }
                    });

                    setTimeout($.unblockUI, 2000);

                }

            }
        });


    }

    function apoio(id_relato, id_usuario) {

        $.post('<?= site_url('relato/apoio') ?>',
                {id_relato: id_relato,
                    id_usuario: id_usuario},
        function(data) {
            if ($.trim(data) == '1') {
                var a = $("#apoio-" + id_relato + " .badge").html();
                a = parseInt(a) + 1;

                $("#apoio-" + id_relato + " .badge").html(a);
                $("#apoio-" + id_relato + " .texto").html("Apoiado");
                $("#apoio-" + id_relato).attr("disabled", "disabled");
            }
        });

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