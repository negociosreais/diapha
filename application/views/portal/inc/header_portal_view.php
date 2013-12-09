<?
include_once('fb_connector.php');


$this->load->library('facebook');
$facebook = new Facebook(array(
            'appId' => FB_APPID,
            'secret' => FB_SECRET,
        ));

$user = $facebook->getUser();

if ($user) :
    try {
        $profile_user = $facebook->api('/me');

        usuario('fb_user', $profile_user['username']);
    } catch (FacebookApiException $e) {
        error_log($e);
        $user = null;
    }
endif;
?>

<script>

    $(document).ready(function() {

        $("input[name=login]").focus(function() {
            $(this).val(''); 
        });
        
        $("input[name=login]").blur(function() {
            if ($(this).val() == ''){
                $(this).val('Usuário');
            } 
        });
        
        $("input[name=senha]").focus(function() {
            $(this).val(''); 
        });
        
        $("input[name=senha]").blur(function() {
            if ($(this).val() == ''){
                $(this).val('Senha');
            } 
        });
        
       
        
    });
    

</script>


<div class="barraSuperiorInfinita">

    <div class="container_24">

        <div class="barraSuperior">

            <?
            if (!checa_logado(false)):
                ?>
                <?= showStatus(); ?>

                <div class="grid_7">
                    <div class="logoPortal">
                        <a href="<?= site_url(''); ?>" title="Diapha | Por uma cidade transparente">
                            <img src="<?= base_url() . TEMPLATE; ?>/img/logoPortal.png" alt="Diapha | Por uma cidade transparente" />
                        </a>
                    </div>

                </div>
                <div class="grid_9" style="padding-top: 10px;">
                    <ul class="nav nav-pills menu-portal" >
                        <li>
                            <a href="?view=mapa<?= ($_GET['meusrelatos']) ? '&meusrelatos=1' : '' ?>&intervalo=<?= $intervalo; ?>">Mapa</a>
                        </li>
                        <li><a href="<?= site_url('portal/quem_somos'); ?>">Quem somos</a></li>
                    </ul>
                </div>
                <div class="grid_8" style="padding-top: 5px;text-align: right">

                    <a href="<?= site_url('login'); ?>" class="btn btn-info btn-large">Entrar</a>

                    <!--<a href="<?= $loginUrl; ?>" class="btn btn-primary btn-large">Entre com FACEBOOK</a>-->
                </div>


                <?
            else:
                ?>



                <div class="grid_6">
                    <div class="logoPortal">
                        <a href="<?= site_url(''); ?>" title="Diapha | Por uma cidade transparente">
                            <img src="<?= base_url() . TEMPLATE; ?>/img/logoPortal.png" alt="Diapha | Por uma cidade transparente" />
                        </a>
                    </div>
                </div>

                <div class="grid_9" style="padding-top: 10px;">
                    <ul class="nav nav-pills menu-portal" >
                        <li>
                            <a href="<?= site_url(''); ?>">Home</a>
                        </li>
                        <li><a href="<?= site_url('portal/quem_somos'); ?>">Quem somos</a></li>
                    </ul>
                </div>


                <div class="grid_9" style="text-align: right">

                    <? if ($user): ?>
                        <img src="https://graph.facebook.com/<?= $user; ?>/picture" height="35" style="margin: 08px 10px 0 0;">
                    <? endif; ?>

                    <div style="float: right; text-align: left;margin-top: 5px">    
                        <div class="btn-group">

                            <button class="btn btn-info btn-large dropdown-toggle" data-toggle="dropdown">
                                <?= substr(usuario('ds_email'), 0, 25); ?>
                                <?= (strlen(usuario('ds_email')) > 25) ? "..." : "" ?>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">

                                <?
                                if (checa_permissao(array('admin'), true)):
                                    ?>
                                    <li>
                                        <a href="<?= site_url('inicial'); ?>">Administrar</a>
                                    </li>
                                    <?
                                endif;
                                ?>

                                <?
                                if (checa_permissao(array('orgao', 'cidadao'), true)):
                                    ?>
                                    <li>
                                        <a href="<?= site_url('usuario/preferencias'); ?>">Preferências</a>
                                    </li>
                                    <?
                                endif;
                                ?>

                                <?
                                if (checa_permissao(array('orgao'), true)):
                                    ?>
                                    <li>
                                        <a href="<?= site_url('convidar'); ?>">Convide suas equipe</a>
                                    </li>
                                    <li>
                                        <a href="<?= site_url('orgao/' . usuario('id_orgao') . '/editar'); ?>">Dados do órgão</a>
                                    </li>
                                    <li>
                                        <a href="<?= site_url('orgao/editar_logo?id_orgao=' . usuario('id_entidade')); ?>">Editar imagem de perfil</a>
                                    </li>
                                    <?
                                endif;
                                ?>

                                <li>
                                    <a href="<?= site_url('usuario/meus_dados'); ?>">Dados de usuário</a>
                                </li>

                                <li>
                                    <a href="<?= site_url('logoff'); ?>">Sair</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            <?
            endif;
            ?>

        </div>

    </div>

</div>


<!-- start Mixpanel --><script type="text/javascript">(function(e,b){if(!b.__SV){var a,f,i,g;window.mixpanel=b;a=e.createElement("script");a.type="text/javascript";a.async=!0;a.src=("https:"===e.location.protocol?"https:":"http:")+'//cdn.mxpnl.com/libs/mixpanel-2.2.min.js';f=e.getElementsByTagName("script")[0];f.parentNode.insertBefore(a,f);b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==
        typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");for(g=0;g<i.length;g++)f(c,i[g]);
    b._i.push([a,e,d])};b.__SV=1.2}})(document,window.mixpanel||[]);
mixpanel.init("58cdb5d525db9ebf34c144e2937a62fc");</script><!-- end Mixpanel -->