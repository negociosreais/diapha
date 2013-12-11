<?
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
    else:
        if (perfil() == 'orgao'):
            $cidade = usuario('com_cidade') . " - " . usuario('com_estado');
        elseif (perfil() == 'vendedor'):
            $cidade = usuario('ven_cidade') . " - " . usuario('ven_estado');
        else:
            $cidade = "Brasilia - Brasil";
        endif;
    endif;

endif;
?>
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

<style>

    .detalhes {
        padding: 20px;
    }

    h3 {
        padding-left: 10px;
    }

    p {
        font-size: 12px;
        line-height: 15px;
        margin: 0;
    }

    .detalhes td {
        padding-left: 10px;
    }

    .barraStatus {

        margin-right: -3px; 
        color:#999999;

        float: right;
    }

    .datahora {
        color:#999999;
        font-size: 13px;
        margin-top: 5px;
        margin-bottom: 10px;
    }

    .status {
        width: 80px;
        margin-right: 5px;
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

    .fb-img {
        margin-right: 10px;
    }

    .fb-comments {
        padding: 0 15px;
    }

</style>


<!-- Modal Status -->
<div class="modal" id="modalStatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display:none">
    <form name="formStatus" action="" method="GET">

        <input type="hidden" name="st_status" />
        <input type="hidden" name="id_relato" value="<?= $relato['id_relato']; ?>" />

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
        <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
        <button class="btn" type="submit" id="btnStatus" onclick="alterarStatus()">Confirmar</button>
    </div>

</div>

<div class="grid_24">


    <div class="caixa">

        <div class="tituloCaixa" style="padding: 10px; height: 70px; font-size: 16px;">
            <img class='img-polaroid fb-img' src='https://graph.facebook.com/<?= $relato['fb_user'] ?>/picture' height='60' align='left' />
            <b><?= $relato['fb_name']; ?></b>
        </div>
        <? showStatus(); ?>

        <!--<ul class="breadcrumb">
            <li><a href="<?= site_url(''); ?>">Relatos</a> <span class="divider">/</span></li>
            <li><a href="<?= site_url('?view=lista'); ?>"><?= $categoria; ?></a> <span class="divider">/</span></li>
            <li class="active">Detalhes</li>
        </ul>

        <div class="btn-group" style="float: right">
            <a href="<?= site_url('?view=mapa'); ?>" class="btn btn-info" title="Exibir relatos no Mapa">
                <img src="<?= base_url() . TEMPLATE; ?>/img/icones/icon-mapa.png" /> Mapa
            </a>
            <a href="<?= site_url('?view=lista'); ?>" class="btn btn-info active" title="Exibir relatos em lista">
                <img src="<?= base_url() . TEMPLATE; ?>/img/icones/icon-lista.png" /> Lista
            </a>
            <a href="<?= site_url('?view=telacheia'); ?>" class="btn btn-info" title="Tela cheia">
                <img src="<?= base_url() . TEMPLATE; ?>/img/icones/icon-telacheia.png" />
            </a>
        </div>-->

        <div class="clear"></div>

        <!--<ul class="breadcrumb">
            <li><a href="<?= site_url(); ?>">Relatos</a> <span class="divider">/</span></li>
            <li><a href="<?= site_url('relatos/categoria/' . $relato['nm_apelido'] . '?view=lista'); ?>"><?= $relato['nm_categoria']; ?></a> <span class="divider">/</span></li>
            <li class="active">Detalhes do relato</li>
        </ul>-->

        <div class="detalhes">

            <table width="100%">
                <tbody>

                    <?
                    if ($relato['nm_foto']):
                    // Vamos recortar a imagem
                    //$this->tools_model->gira_imagem("arquivos/diapha/" . $relato['nm_foto'], '90');
                    endif;

                    if ($relato['st_status'] == 0):
                        $status = '<span class="status nao-respondido">Não respondido</span>';
                    elseif ($relato['st_status'] == 1):
                        $status = '<span class="status em-analise">Em análise</span>';
                    else:
                        $status = '<span class="status respondido">Respondido</span>';
                    endif;
                    ?>

                    <tr>
                        <td>
                            <p style="font-size: 18px;">
                                <br>
                                <?= $relato['ds_relato']; ?>
                            </p>

                            <div class="clear" style="height: 10px; margin-bottom: 10px;"></div>
                            
                            <div class="clear"></div>

                            <p class="datahora">
                                <img src="<?= base_url() . TEMPLATE; ?>/img/icones/icon-relogio.png" />
                                Enviado em <?= formata_data_extenso(formataDate($relato['dt_cadastro'], "-")); ?> às <?= substr($relato['hr_cadastro'], 0, 5) ?>.
                                <br>
                                <img src="<?= base_url() . TEMPLATE; ?>/img/icones/icon-map-marcador.png" />
                                Local: <?= $relato['ds_endereco'] . ", " . $relato['nm_bairro'] . ", " . $relato['nm_cidade'] . ", " . $relato['nm_estado']; ?>
                            </p> 
                            
                            <?
                            if ($relato['nm_foto'] != ''):
                                ?>
                                <img src="<?= base_url(); ?>/arquivos/diapha/<?= $relato['nm_foto']; ?>" height="250" class="img-polaroid" />
                                <?
                            else:
                                ?>
                                <img src="<?= base_url() . TEMPLATE; ?>/img/semImagem.jpg" height="250" class="img-polaroid" />
                            <?
                            endif;
                            ?>

                            <?
                            $preferencias = unserialize(usuario('ds_preferencias'));

                            $arr = explode(",", $preferencias['categorias']);

                            $historico = unserialize($relato['ds_historico']);

                            /**
                             * Histórico
                             */
                            if ($historico):

                                foreach ($historico as $h):

                                    // Se for órgão que respondeu
                                    if ($h['nm_orgao'] != ''):
                                        $nome = $h['nm_orgao'];

                                        $orgao = $this->orgao_model->selecionarOrgao($h['id_orgao']);
                                        if ($orgao['nm_foto'] != ''):
                                            $foto = base_url() . "/arquivos/diapha/" . $orgao['nm_foto'];
                                        else:
                                            $foto = base_url() . TEMPLATE . "/img/semImagemP.jpg";
                                        endif;

                                    // Se for o próprio usuário que respondeu
                                    elseif ($h['email_facebook'] != ''):
                                        $nome = $relato['fb_name'];
                                        $foto = "https://graph.facebook.com/" . $relato['fb_user'] . "/picture";
                                    endif;

                                    if ($h['st_status'] == '1'):
                                        $msg = "alterou o status para <b>Em análise</b>.<br>";
                                    elseif ($h['st_status'] == '2'):
                                        $msg = "alterou o status para <b>Respondido</b>.<br>";
                                    endif;
                                    
                                    ?>

                                    <div style="margin-top: 5px;background: #f0fcff;min-height: 40px;padding: 5px;font-size: 11px">
                                        <img class='img-polaroid fb-img' src='<?= $foto; ?>' height='30' align='left' />
                                        <b><?= $nome; ?></b>
                                        <?= $msg; ?>
                                        <span style="font-size: 10px;">
                                            <?= formata_data_extenso(formataDate($h['dt_alteracao'], "-")); ?> às <?= substr($h['hr_alteracao'], 0, 5) ?>.
                                        </span>
                                        <br>
                                        <div style="margin-left: 50px"><?=$h['ds_mensagem'];?></div>
                                    </div>

                                    <?
                                endforeach;

                            endif;

                            /*
                             * Mudança de status
                             */
                            if ($relato['st_status'] == '0' || $relato['st_status'] == '1'):

                                if ((in_array($relato['nm_apelido'], $arr) && checa_permissao(array('orgao'), true)) || $relato['fb_email'] == usuario('email_facebook')):
                                    ?>
                                    <div style="margin-top: 40px;color: #ff3200;background: #f2f2f2;padding: 3px 3px;">

                                        Informe o status da ocorrência<br>

                                        <?
                                        if ($relato['st_status'] == '0'):
                                            ?>
                                            <button class="btn" onclick="mostrarStatus(1)">Em análise</button>
                                            <button class="btn" onclick="mostrarStatus(2)">Resolvido</button>
                                            <?
                                        elseif ($relato['st_status'] == '1'):
                                            ?>
                                            <button class="btn" onclick="mostrarStatus(2)">Resolvido</button>
                                            <?
                                        endif;
                                        ?>
                                    </div>
                                    <?
                                endif;
                            endif;
                            ?>
                            
                        </td>
                        <td width="250">

                            <div class="barraStatus">
                                <?= $status; ?>
                            </div>
                            <div class="clear" style="height: 10px; margin-bottom: 10px;"></div>
                            <div id="mapa" class="img-polaroid" style="height: 200px;"></div>
                            
                        </td>
                    </tr>

                </tbody>
            </table>

        </div>

        <div class="fb-comments">

            <!-- Facebook comments -->
            <div id="fb-root"></div>
            <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1&appId=<?= FB_APPID ?>";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>

            <div class="fb-comments" data-href="http://<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" data-width="890" data-num-posts="50"></div>

        </div>


    </div>

</div>

<script type="text/javascript">
    
    var lat;
    var lng;
    var map;
    var zoom = <?=(usuario('cidade') == 'Brasil') ? 3:10; ?>;
    var infoWindow = null;
    
$(document).ready(function() {
    carregarMapa();
    $("#btnBuscarCategorias").click(function() {
        updateMap();
    });
        
    $('.btn').tooltip()
    
    carregarLocalDoRelatoNoMapa(<?= $relato['ds_latitude']; ?>,<?= $relato['ds_longitude']; ?>);
});

function carregarMapa() {
 
    var mapOptions = {
        zoom: zoom,
        center: new google.maps.LatLng(-15.47, -47.52)
    };
    map = new google.maps.Map(document.getElementById('mapa'),mapOptions);
}

function carregarLocalDoRelatoNoMapa(lat, lng) {
    
    var point = new google.maps.LatLng(lat, lng);
    var options = {
          map: map,
          position: new google.maps.LatLng(lat, lng)
        };
        
        map.setZoom(14);
        map.setCenter(options.position);
        
    var markerIcon = {
            url: '<?= base_url(); ?>arquivos/diapha/ico/crime_vermelho.png',
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
}

function mostrarCategorias() {
        
    $('#modalCategorias').modal();
        
}

function mostrarStatus(status) {
        
    $("input[name=st_status]").val(status);   
    
        
    if (status == 1){
        $("#btnStatus").addClass('btn-warning');
    }else{
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
        success: function(retorno){
                        
            setTimeout($.unblockUI, 5000);
                        
            if ($.trim(retorno) == 'true'){
                            
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

</script>
