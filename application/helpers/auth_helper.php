<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


if (!function_exists('checa_logado')) {

    function checa_logado($redirecionar = true) {

        $ci = & get_instance();

        $ci->load->model("usuario/usuario_model");

        $id_usuario = $ci->session->userdata('id_usuario');
        $nm_login = $ci->session->userdata('nm_login');
        $ds_senha = $ci->session->userdata('ds_senha');

        if ($id_usuario != ''):
            return true;
        else:
            if ($redirecionar):
                redirect(site_url('login'));
            else:
                return false;
            endif;
        endif;
    }

}

if (!function_exists('checa_dono')) {

    function checa_dono($id_usuario, $id_dono) {

        if ($id_usuario == $id_dono || checa_permissao(array('admin', 'operador'))) :
            return true;
        else :
            redirect("sem_acesso");
        endif;
    }

}

if (!function_exists('checa_permissao')) {

    function checa_permissao($permitido, $view = false) {

        $ci = & get_instance();

        $perfil = $ci->session->userdata('tp_usuario');

        if (trim($perfil) != ''):
        
            if (in_array($perfil, $permitido)) :
                return true;
            else:
                if ($view == true)
                    return false;
                else
                    redirect("sem_acesso");
            endif;
        else:
            return false;
        endif;
    }

}

if (!function_exists('checa_permissao_perfil')) {

    function checa_permissao_perfil($permitido, $view = false) {

        $ci = & get_instance();

        $perfil = $ci->session->userdata('relacao');

        if (in_array($perfil, $permitido)) {
            return true;
        } else {
            if ($view == true)
                return false;
            else
                redirect("sem_acesso");
        }
    }

}


if (!function_exists('checa_permissao_servico')) {

    function checa_permissao_servico($id_servico, $redirecionar = true, $js = false, $id_entidade = '') {

        if (!checa_permissao(array('vendedor'), true) && $id_entidade == ''):
            return true;
        endif;

        $ci = & get_instance();

        $ci->load->model("servico/servico_model");

        if ($id_entidade == ''):
            $id_entidade = usuario('id_entidade');
            $entidade = perfil();
        else:
            $entidade = "vendedor";
        endif;

        $param['id_servico'] = $id_servico;
        $param['st_status'] = "Ativo";
        $param['entidade'] = $entidade;
        $param['id_entidade'] = $id_entidade;
        $param['dt_validade'] = date("d/m/Y");

        $acesso = $ci->servico_model->selecionarServicoAcesso($param);

        if ($acesso) :
            return true;
        else :
            if ($redirecionar):
                if ($js):
                    echo "window.location.href='" . site_url('sem_acesso_servico') . "';";
                    echo 'return false;';
                else:
                    redirect(site_url('sem_acesso_servico'));
                endif;
            else:
                return false;
            endif;
        endif;
    }

}

if (!function_exists('perfil')) {

    function perfil() {

        $ci = & get_instance();

        return $ci->session->userdata('tp_usuario');
    }

}

if (!function_exists('usuario')) {

    function usuario($campo = '', $valor = '') {

        $ci = & get_instance();

        if ($valor != ''):
            $ci->session->set_userdata($campo, $valor);
        endif;

        if ($campo != ''):
            return $ci->session->userdata($campo);
        else:
            return $ci->session->all_userdata();
        endif;
    }

}

if (!function_exists('iniciar_sessao')) {

    function iniciar_sessao($usuario) {

        $ci = & get_instance();

        unset($_SESSION['username']);
        unset($_SESSION['openChatBoxes']);
        unset($_SESSION['chatHistory']);

        $ci->session->set_userdata($usuario);
    }

}

if (!function_exists('finalizar_sessao')) {

    function finalizar_sessao() {

        $ci = & get_instance();

        $ci->load->model('usuario/usuario_model');

        $ci->usuario_model->deletarUsuarioOnline(usuario('id_usuario'));

        $ci->session->sess_destroy();
        unset($_SESSION['username']);
        unset($_SESSION['openChatBoxes']);
        unset($_SESSION['chatHistory']);

        session_destroy();
    }

}

if (!function_exists('usuario_online')) {

    function usuario_online() {

        $ci = & get_instance();

        $ci->load->model('usuario/usuario_model');

        return $ci->usuario_model->usuarioOnline();
    }

}



/* End of file array_helper.php */
/* Location: ./system/helpers/array_helper.php */
?>