<?php

$this->load->library('facebook');
$ci = & get_instance();
$ci->load->model('usuario/usuario_model');

if ($_GET['logoff'] == 1):
    session_destroy();
endif;

// Create our Application instance (replace this with your appId and secret).

$facebook = new Facebook(array(
            'appId' => FB_APPID,
            'secret' => FB_SECRET,
        ));

if ($_GET['auth'] == 1):
    // Get User ID
    $user = $facebook->getUser();
endif;


// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {

    try {
        // Proceed knowing you have a logged in user who's authenticated.
        $user_profile = $facebook->api('/me');
    } catch (FacebookApiException $e) {
        error_log($e);
        $user = null;
    }
}

// Primeiro verificamos se o usuário já está integrado com o facebook
if ($user_profile) {
    $param['email_facebook'] = $user_profile['email'];
    $usuario = $ci->usuario_model->selecionarUsuario($param);

    // Se estiver faremos todo o procedimento de autenticação
    if ($usuario):

        // Vamos verificar se ele está ativo
        if ($usuario['st_status'] == 'Inativo' || $usuario['com_confirmacao'] != '' || $usuario['ven_confirmacao'] != ''):
            flashMsg('erro', 'Usuário inativo ou ainda não confirmado.');
            redirect("");
        else:
            
            iniciar_sessao($usuario);
            redirect("");
        endif;

    else:
        unset($param);
        $param['ds_email'] = $user_profile['email'];
        $usuario = $ci->usuario_model->selecionarUsuario($param);

        if ($usuario):
            $this->usuario_model->atualizarEmailFacebook($usuario['id_usuario'], $user_profile['email']);
            $usuario = $ci->usuario_model->selecionarUsuario($param);
            iniciar_sessao($usuario);
            
            redirect("");
        else:
            redirect("portal/selecionar_perfil/fb");
        endif;


    endif;
}

// Login or logout url will be needed depending on current user state.
if ($user && usuario('id_usuario')) {
    unset($param);
    $param['next'] = site_url('logoff');
    $logoutUrl = $facebook->getLogoutUrl($param);
} else {
    $param['redirect_uri'] = urldecode(site_url('?auth=1'));
    $param['scope'] = 'publish_stream,email,user_birthday,user_location';
    $loginUrl = $facebook->getLoginUrl($param);
}
?>



