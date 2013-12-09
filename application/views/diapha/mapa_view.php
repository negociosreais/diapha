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
            $cidade = "Brasil";
        endif;
    else:
        $cidade = usuario('cidade');
    endif;

endif;

usuario('cidade', $cidade);
?>

<script src="<?= base_url() . TEMPLATE; ?>/js/highcharts/js/highcharts.js"></script>
<script src="<?= base_url() . TEMPLATE; ?>/js/highcharts/js/modules/exporting.js"></script>
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

<style>
    #googleMap {
        min-height: 420px;
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

    .area-grafico {
        width: 940px;
    }

</style>

<? showStatus(); ?>


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

    <div class="caixaMapa">

        <!--<h1 class="tituloCaixa">
            Relatos de Ocorrência / <?= $cidade; ?>
            <?= ($intervalo != '') ? " / " . $intervalo : "" ?>


        </h1>

        <div style="float: left">
            <ul class="nav nav-pills">
                <li >

                    <a href="?view=mapa&intervalo=<?= $intervalo; ?>" <?= ($pagina == 'relatos') ? 'class="btn-info"' : ''; ?>>Relatos</a>

                </li>

                <?
                if (checa_permissao(array('cidadao'), true)):
                    ?>
                    <li>
                        <a href="?view=mapa&meusrelatos=1&intervalo=<?= $intervalo; ?>" <?= ($pagina == 'meusrelatos') ? 'class="btn-info"' : ''; ?>>Meus Relatos</a>
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
                            <a href="?view=mapa&meusrelatos=<?= $meusrelatos; ?>&intervalo=">Todos</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="?view=mapa&meusrelatos=<?= $meusrelatos; ?>&intervalo=Hoje">Hoje</a>
                        </li>
                        <li>
                            <a href="?view=mapa&meusrelatos=<?= $meusrelatos; ?>&intervalo=Esta semana">Esta semana</a>
                        </li>
                        <li>
                            <a href="?view=mapa&meusrelatos=<?= $meusrelatos; ?>&intervalo=Este mês">Este mês</a>
                        </li>
                        <li>
                            <a href="?view=mapa&meusrelatos=<?= $meusrelatos; ?>&intervalo=Este ano">Este ano</a>
                        </li>

                    </ul>
                </li>
            </ul>
        </div>

        <div class="btn-group" style="float: right">
            <a href="?view=mapa<?= ($_GET['meusrelatos']) ? '&meusrelatos=1' : '' ?>&intervalo=<?= $intervalo; ?>" class="btn btn-primary active" title="Exibir relatos no Mapa">

                <img src="<?= base_url() . TEMPLATE; ?>/img/icones/icon-mapa.png" /> Mapa

            </a>

            <a href="?view=feed<?= ($_GET['meusrelatos']) ? '&meusrelatos=1' : '' ?>&intervalo=<?= $intervalo; ?>" class="btn btn-primary" title="Exibir relatos em feed">

                <img src="<?= base_url() . TEMPLATE; ?>/img/icones/icon-lista.png" /> Feed

            </a>

            <a href="?view=telacheia" class="btn btn-primary" title="Tela cheia">
                <img src="<?= base_url() . TEMPLATE; ?>/img/icones/icon-telacheia.png" />
            </a>
        </div>

        <div class="clear"></div>

        <div style="margin-top: -10px;padding: 10px 0;float: right" id="labelCategorias">

            <?
            if (usuario('categorias')):
                ?>

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

                <?
            endif;
            ?>

        </div>

        <div class="clear"></div>-->


        <div id="googleMap" style="height: 100%;"></div>
        <button class="btn btn-info btn-large" style="z-index: 10; position: absolute;">Proponha!</button>
        
    </div>

    <!--<div class="clear"></div>


    <div class="caixa">
        <ul class="nav nav-tabs" id="tabGraficos">
            <li class="active">
                <a href="#por_categoria">Ocorrências por categoria</a>
            </li>
            <li>
                <a href="#por_ano">Ocorrências por Ano</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="por_categoria">
            </div>

            <div class="tab-pane" id="por_ano">
            </div>
        </div>
    </div>-->

<script>
/**
* Returns an XMLHttp instance to use for asynchronous
* downloading. This method will never throw an exception, but will
* return NULL if the browser does not support XmlHttp for any reason.
* @return {XMLHttpRequest|Null}
*/
function createXmlHttpRequest() {
 try {
   if (typeof ActiveXObject != 'undefined') {
     return new ActiveXObject('Microsoft.XMLHTTP');
   } else if (window["XMLHttpRequest"]) {
     return new XMLHttpRequest();
   }
 } catch (e) {
   changeStatus(e);
 }
 return null;
};

/**
* This functions wraps XMLHttpRequest open/send function.
* It lets you specify a URL and will call the callback if
* it gets a status code of 200.
* @param {String} url The URL to retrieve
* @param {Function} callback The function to call once retrieved.
*/
function downloadUrl(url, callback) {
 var status = -1;
 var request = createXmlHttpRequest();
 if (!request) {
   return false;
 }

 request.onreadystatechange = function() {
   if (request.readyState == 4) {
     try {
       status = request.status;
     } catch (e) {
       // Usually indicates request timed out in FF.
     }
     if (status == 200) {
       callback(request.responseXML, request.status);
       request.onreadystatechange = function() {};
     }
   }
 }
 request.open('GET', url, true);
 try {
   request.send(null);
 } catch (e) {
   changeStatus(e);
 }
};

/**
 * Parses the given XML string and returns the parsed document in a
 * DOM data structure. This function will return an empty DOM node if
 * XML parsing is not supported in this browser.
 * @param {string} str XML string.
 * @return {Element|Document} DOM.
 */
function xmlParse(str) {
  if (typeof ActiveXObject != 'undefined' && typeof GetObject != 'undefined') {
    var doc = new ActiveXObject('Microsoft.XMLDOM');
    doc.loadXML(str);
    return doc;
  }

  if (typeof DOMParser != 'undefined') {
    return (new DOMParser()).parseFromString(str, 'text/xml');
  }

  return createElement('div', null);
}

/**
 * Appends a JavaScript file to the page.
 * @param {string} url
 */
function downloadScript(url) {
  var script = document.createElement('script');
  script.src = url;
  document.body.appendChild(script);
}

</script>

<script>

    var novas_categorias = "";
    var geocoder;
    var lat;
    var lng;
    var map;
    var zoom = <?=(usuario('cidade') == 'Brasil') ? 3:10; ?>;
    var infoWindow = null;
    
    var mapOptions = {
        zoom: zoom,
        center: new google.maps.LatLng(-15.47, -47.52)
    };
    map = new google.maps.Map(document.getElementById('googleMap'),mapOptions);
   
    google.maps.event.addListener(map, "zoomend", function() {
        updateMap();
    });
    
    google.maps.event.addListener(map, "dragend", function() {
        updateMap();
    });
    
    iniciar();
    
    function iniciar() {
        
        // var address = document.getElementById("address").value;
        geocoder = new google.maps.Geocoder();
        
        var address = "<?= $cidade; ?>";
        geocoder.geocode( { 'address': address}, function(results, status) {
            
            if (status === google.maps.GeocoderStatus.OK) {
                
                //Passo os valores
                lat = results[0].geometry.location.lat();
                lng = results[0].geometry.location.lng();
                
                createMap();
            }
        });
        
        
    }
    
    function createMap() {
        
        map.setCenter(new google.maps.LatLng(lat, lng), zoom);
        
        var categorias = "<?= $categorias; ?>";
        var fb_email = "<?= $fb_email; ?>";
        var intervalo = "<?= $intervalo; ?>";
        var url = "<?= base_url(); ?>diapha/relato/xml?categorias=" + categorias + "&fb_email=" + fb_email + "&intervalo=" + intervalo;
        
        downloadUrl(url,parseMarkers);

        function parseMarkers(data){
            var markers = data.documentElement.getElementsByTagName("marker");
            for (var i = 0; i < markers.length; i++) {
            
                var point = new google.maps.LatLng(parseFloat(markers[i].getAttribute("lat")),parseFloat(markers[i].getAttribute("lng")));
                var title = markers[i].getAttribute("tit");
                var local = markers[i].getAttribute("local");
                var fb_user = markers[i].getAttribute("fb_user");
                var fb_name = markers[i].getAttribute("fb_name");
                var icone = markers[i].getAttribute("icone");
                var status = markers[i].getAttribute("status");
                var categoria = markers[i].getAttribute("categoria");
                var id = markers[i].getAttribute("id");
                var apelido = markers[i].getAttribute("apelido");
                createMarker(point, title, local, fb_user, fb_name, icone, status, categoria, id, apelido);
                    
            }
        }
    }
    
    function updateMap() {
        $('#modalCategorias').modal('hide');
        
        map.clearOverlays();
        
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

        downloadUrl(url, function(data) {
            var markers = data.documentElement.getElementsByTagName("marker");
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
        
        var markerIcon = {
            url: '<?= base_url(); ?>arquivos/diapha/ico/' + icone,
            size: new google.maps.Size(40, 40),
            anchor: new google.maps.Point(16, 52)
        };
        
        var marker = new google.maps.Marker({
            position:point,
            map:map,
            icon:markerIcon
        }); 
        
        google.maps.event.addListener(marker, 'click', function() { 
            if (infoWindow)
                infoWindow.close();
        
            infoWindow = new google.maps.InfoWindow();
            infoWindow.setContent("<img class='img-polaroid' src='https://graph.facebook.com/"+fb_user+"/picture' height='25' align='left' style='margin-right: 5px'><b>" + categoria + "</b> " + status + "<br>" + title + " <a href='<?= site_url('relato'); ?>/"+apelido +"/detalhes?id="+id+"'>mais detalhes</a><br><img src='<?= base_url() . TEMPLATE; ?>/img/icones/icon-map-marcador-cinza.png' />Local: " + local + ". Enviado por " + fb_name + ".");
            infoWindow.open(map,marker);
        }); 
        return marker; 
    } 
    

</script>


<!--<script	type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>-->

<script type="text/javascript">
    
    $(document).ready(function() {
        
        $('#tabGraficos a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        })
        
        $("#btnBuscarCategorias").click(function() {
            $("#labelCategorias").html('');
            
            // Vamos fazer um loop e verificar quais são as categorias marcas
            novas_categorias = "";
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
        
        $('.btn').tooltip()
        
        /**
         * Carregar gráficos
         */
        graficoPorCategoria();
        graficoPorAno();
        
    });

    function mostrarCategorias() {
        
        $('#modalCategorias').modal();
        
    }
    
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
    
    $(".gmnoprint").click(function() {
        // This sends us an event every time a user clicks the button
        mixpanel.track("<?= usuario('nm_usuario'); ?> clicou em um relato no mapa!"); 
    });

</script>