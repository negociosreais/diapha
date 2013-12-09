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

        $cidade = $profile_user['location']['name'];
    elseif (usuario('cidade') == ''):
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

<script src="<?= base_url() . TEMPLATE; ?>/js/highcharts/js/highcharts.js"></script>
<script src="<?= base_url() . TEMPLATE; ?>/js/highcharts/js/modules/exporting.js"></script>

<script src="http://maps.google.com/maps?file=api&v=2&key=AIzaSyAaErZudm4TPoS4BqCjSloNMLGrTE9DwYE" type="text/javascript"></script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=true"></script>

<style>

    html, body { margin:0; height: 100% !important;}

    .caixa {
        height: 100%;

        padding: 0;
    }

    #googleMap {
        min-height: 420px;
        height: 60%;
    }

    .menu-suspenso {
        position: fixed;
        top: -155px;
        background: #ffffff;
        z-index: 99;
        padding: 5px;
        width: 99%;
        margin: 0 2px;
        border-bottom: solid 3px #00ccff;
        -moz-box-shadow: 0px 2px 4px #e3e3e3; /* FF3.5+ */
        -webkit-box-shadow: 0px 2px 4px #e3e3e3; /* Saf3.0+, Chrome */
        box-shadow: 0px 2px 4px #e3e3e3; /* Opera 10.5, IE 9.0 */
    }   

    .aberto {
        top: 0 !important;
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

    #graficos {
        height: 40%;
    }

    .area-grafico {
        width: 100%;
    }

    .box-grafico {
        width: 49%;
        margin: 0 5px;
    }
</style>

<script>

    $(document).ready(function() {
    
        $('.aba-fechar').hide();
        
   
        $(".aba").click(function() {
            $(".menu-suspenso").addClass('aberto');
            $(".aba").hide();
            $(".aba-fechar").show();
            $('.aba-fechar').tooltip('title');
      
        });
   
        $(".aba-fechar").click(function() {
            $(".menu-suspenso").removeClass('aberto');
            $(".aba").show();
            $(".aba-fechar").hide();
      
        });
   
    });

</script>

<!-- Modal Categorias -->
<div class="modal" id="modalCategorias" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display:none">

    <form name="formCategorias">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Escolha as categorias que deseja ver</h3>
        </div>
        <div class="modal-body">

            <?
            checkbox("id_categoria", $cbo_categorias, '3', $marcados);
            ?>

        </div>
    </form>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
        <button class="btn btn-info" id="btnBuscarCategorias">Buscar</button>
    </div>
</div>


<div class="menu-suspenso">

    <div style="float: left">
        <ul class="nav nav-pills">
            <li >

                <a href="?view=telacheia&intervalo=<?= $intervalo; ?>" <?= ($pagina == 'relatos') ? 'class="btn-info"' : ''; ?>>Relatos</a>

            </li>

            <?
            if (checa_permissao(array('cidadao'), true)):
                ?>
                <li>
                    <a href="?view=telacheia&meusrelatos=1&intervalo=<?= $intervalo; ?>" <?= ($pagina == 'meusrelatos') ? 'class="btn-info"' : ''; ?>>Meus Relatos</a>
                </li>
                <?
            endif;
            ?>
            <li>
                <a href="javascript:mostrarCategorias()" id="btnCategorias">Categorias</a>
            </li>
            <li>
                <a href="<?= site_url('estados'); ?>">Cidades</a>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="icon-time"></i>
                    Intervalo
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="?view=telacheia&meusrelatos=<?= $meusrelatos; ?>&intervalo=">Todos</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="?view=telacheia&meusrelatos=<?= $meusrelatos; ?>&intervalo=Hoje">Hoje</a>
                    </li>
                    <li>
                        <a href="?view=telacheia&meusrelatos=<?= $meusrelatos; ?>&intervalo=Esta semana">Esta semana</a>
                    </li>
                    <li>
                        <a href="?view=telacheia&meusrelatos=<?= $meusrelatos; ?>&intervalo=Este mês">Este mês</a>
                    </li>
                    <li>
                        <a href="?view=telacheia&meusrelatos=<?= $meusrelatos; ?>&intervalo=Este ano">Este ano</a>
                    </li>

                </ul>
            </li>
        </ul>

        <div class="aba" title="Clique aqui para abrir ver o menu" data-placement="bottom"></div>

        <div class="aba-fechar" title="Clique aqui para fechar o menu" data-placement="bottom"></div>
    </div>

    <div class="btn-group" style="float: right">
        <a href="?view=mapa<?= ($_GET['meusrelatos']) ? '&meusrelatos=1' : '' ?>&intervalo=<?= $intervalo; ?>" class="btn btn-primary" data-placement="bottom" title="Exibir relatos no Mapa">

            <img src="<?= base_url() . TEMPLATE; ?>/img/icones/icon-mapa.png" /> Mapa

        </a>

        <a href="?view=feed<?= ($_GET['meusrelatos']) ? '&meusrelatos=1' : '' ?>&intervalo=<?= $intervalo; ?>" class="btn btn-primary" data-placement="bottom" title="Exibir relatos em lista">

            <img src="<?= base_url() . TEMPLATE; ?>/img/icones/icon-lista.png" /> Feed

        </a>

        <a href="?view=telacheia" class="btn btn-primary active" title="Tela cheia" data-placement="bottom">
            <img src="<?= base_url() . TEMPLATE; ?>/img/icones/icon-telacheia.png" />
        </a>
    </div>

    <div class="clear"></div>


    <h1 class="tituloCaixa">
        Relatos de Ocorrência / <?= $cidade; ?>
<?= ($intervalo != '') ? " / " . $intervalo : "" ?>


    </h1>

    <?
    if (usuario('categorias')):
        ?>
        <div style="margin-top: -10px;padding: 10px 0;float: right" id="labelCategorias">
            <?
            $arr = explode(',', usuario('categorias'));
            foreach ($arr as $c):
                if ($c == ''):
                    continue;
                endif;
                ?>
                <span class="label label-warning"><?= $c; ?></span>
                <?
            endforeach;
            ?>
        </div>
        <?
    endif;
    ?>


</div>



<div id="googleMap"></div>

<div id="graficos">
    <div id="por_categoria" class="caixa box-grafico" style="float: left">
    </div>

    <div id="por_ano" class="caixa box-grafico" style="float: right">
    </div>
</div>




<script>

    var novas_categorias = "";
    var geocoder;
    var lat;
    var lng;
    var map = new GMap2(document.getElementById("googleMap"));
    
    GEvent.addListener(map, "zoomend", function() {
        updateMap();
    });
    
    GEvent.addListener(map, "dragend", function() {
        updateMap();
    });
    
    iniciar();
    
    function iniciar() {
        
        // var address = document.getElementById("address").value;
        geocoder = new google.maps.Geocoder();
        
        var address = "<?= $cidade; ?>";
        geocoder.geocode( { 'address': address}, function(results, status) {
            
            if (status == google.maps.GeocoderStatus.OK) {
                
                //Passo os valores
                lat = results[0].geometry.location.lat();
                lng = results[0].geometry.location.lng();
                
                createMap();
            }
        });
        
        
    }
    
    function createMap() {
        
        map.addControl(new GSmallMapControl());
        map.addControl(new GMapTypeControl());
        map.setCenter(new GLatLng(lat, lng), 10);
        
        var categorias = "<?= $categorias; ?>";
        var fb_email = "<?= $fb_email; ?>";
        var intervalo = "<?= $intervalo; ?>";
        var url = "<?= base_url(); ?>diapha/relato/xml?categorias=" + categorias + "&fb_email=" + fb_email + "&intervalo=" + intervalo;
        
        GDownloadUrl(url, function(data, responseCode) {
            var xml = GXml.parse(data);
            var markers = xml.documentElement.getElementsByTagName("marker");
            for (var i = 0; i < markers.length; i++) {
            
                var point = new GLatLng(parseFloat(markers[i].getAttribute("lat")),parseFloat(markers[i].getAttribute("lng")));
                var title = markers[i].getAttribute("tit");
                var local = markers[i].getAttribute("local");
                var fb_user = markers[i].getAttribute("fb_user");
                var fb_name = markers[i].getAttribute("fb_name");
                var icone = markers[i].getAttribute("icone");
                var status = markers[i].getAttribute("status");
                var categoria = markers[i].getAttribute("categoria");
                var id = markers[i].getAttribute("id");
                var apelido = markers[i].getAttribute("apelido");
                var marker = createMarker(point, title, local, fb_user, fb_name, icone, status, categoria, id, apelido);
           
                map.addOverlay(marker);
                    
            }
        });
        
    }
    
    function updateMap() {
        
        $('#modalCategorias').modal('hide');
        
        map.clearOverlays();
        
        map.addControl(new GSmallMapControl());
        map.addControl(new GMapTypeControl());
        
        var bounds = map.getBounds();
        
        var southWest = bounds.getSouthWest();
        var northEast = bounds.getNorthEast();
        var swLng = southWest.lng();
        var swLat = southWest.lat();
        var neLng = northEast.lng();
        var neLat = northEast.lat();
        
        var categorias = "";
        var fb_email = "<?= $fb_email; ?>";
        var intervalo = "<?= $intervalo; ?>";
        
        if (novas_categorias == ""){
            if (categorias == ""){
                categorias = "<?= $categorias; ?>";
            }
        } else {
            categorias = novas_categorias;
        }
        
        var url = "<?= base_url(); ?>diapha/relato/xml?swLng="+swLng+"&swLat="+swLat+"&neLng="+neLng+"&neLat="+neLat+"&categorias="+categorias+"&fb_email=" + fb_email + "&intervalo=" + intervalo;

        GDownloadUrl(url, function(data, responseCode) {
            var xml = GXml.parse(data);
            var markers = xml.documentElement.getElementsByTagName("marker");
            for (var i = 0; i < markers.length; i++) {
            
                var point = new GLatLng(parseFloat(markers[i].getAttribute("lat")),parseFloat(markers[i].getAttribute("lng")));
                var title = markers[i].getAttribute("tit");
                var local = markers[i].getAttribute("local");
                var fb_user = markers[i].getAttribute("fb_user");
                var fb_name = markers[i].getAttribute("fb_name");
                var icone = markers[i].getAttribute("icone");
                var status = markers[i].getAttribute("status");
                var categoria = markers[i].getAttribute("categoria");
                var id = markers[i].getAttribute("id");
                var apelido = markers[i].getAttribute("apelido");
                var marker = createMarker(point, title, local, fb_user, fb_name, icone, status, categoria, id, apelido);
           
                map.addOverlay(marker);
                
            }
        });
        
    }
    
    
    function createMarker(point, title, local, fb_user, fb_name, icone, status, categoria, id, apelido) { 
        
        var myIcon = new GIcon(G_DEFAULT_ICON,'<?= base_url(); ?>arquivos/diapha/ico/' + icone);
        
        myIcon.iconSize = new GSize(40,40);
        myIcon.iconAnchor = new GPoint(16, 52);
        var dados = {icon: myIcon};
        var marker = new GMarker(point, dados); 
        
        
        GEvent.addListener(marker, 'click', function() { 
            marker.openInfoWindowHtml("<img class='img-polaroid' src='https://graph.facebook.com/"+fb_user+"/picture' height='25' align='left' style='margin-right: 5px'><b>" + categoria + "</b> " + status + "<br>" + title + " <a href='<?= site_url('relato'); ?>/"+apelido +"/detalhes?id="+id+"'>mais detalhes</a><br><img src='<?= base_url() . TEMPLATE; ?>/img/icones/icon-map-marcador-cinza.png' />Local: " + local + ". Enviado por " + fb_name + "."); 
        }); 
        return marker; 
    } 
    

</script>


<script	type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>

<script type="text/javascript">
    
    
    
    $(document).ready(function() {
        
        $('.btn').tooltip();
        $('.aba').tooltip();        
        
        $("#btnBuscarCategorias").click(function() {
            $("#labelCategorias").html('');
            
            // Vamos fazer um loop e verificar quais são as categorias marcas
            $("form[name=formCategorias] input").each(function(){
            
                if ($(this).is(':checked') == true){
                
                    $("#labelCategorias").append('<span class="label label-warning">'+$(this).val()+'</span>');
                
                    novas_categorias += $(this).val() + ",";
                }
            });
            
            updateMap();
            graficoPorCategoria();
            graficoPorAno();
        });
        
        
        /**
         * Carregar gráficos
         */
        graficoPorCategoria();
        graficoPorAno();
    });
    
    function graficoPorCategoria(){
        
        $.post('<?= site_url('grafico/por_categoria') ?>',
        { intervalo: '<?= $intervalo; ?>' },
        function(data) {
            $("#por_categoria").html(data);
        });
        
    }
    
    function graficoPorAno(){
        
        $.post('<?= site_url('grafico/por_ano') ?>',
        { intervalo: '<?= $intervalo; ?>' },
        function(data) {
            $("#por_ano").html(data);
        });
        
    }

    function mostrarCategorias() {
        
        $('#modalCategorias').modal();
        
    }
    
    $(".gmnoprint").click(function() {
        // This sends us an event every time a user clicks the button
        mixpanel.track("<?= usuario('nm_usuario'); ?> clicou em um relato no mapa!"); 
    });

</script>