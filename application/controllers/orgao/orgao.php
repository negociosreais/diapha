<?php

class Orgao extends CI_Controller {

    function Orgao() {
        parent::__construct();

        $this->load->model("orgao/orgao_model");
    }

    function listar() {

        checa_logado();

        $dados["dados"] = $this->orgao_model->selecionarOrgaoes();

        // Paginação
        $this->load->helper("paginacao");
        $arr['inicio'] = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 0;
        $arr['por_pagina'] = 15;
        $arr['dados'] = $dados['dados'];
        $dados['dados'] = paginacao($arr);
        // Fim da paginação

        $this->layout->view("orgao/listar_view", $dados);
    }

    function buscar() {

        checa_logado();

        $dados["dados"] = $this->orgao_model->selecionarOrgaoes($_REQUEST);

        // Paginação
        $this->load->helper("paginacao");
        $arr['inicio'] = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 0;
        $arr['por_pagina'] = 999999999999;
        $arr['dados'] = $dados['dados'];
        $dados['dados'] = paginacao($arr);
        // Fim da paginação


        $this->layout->view("orgao/listar_view", $dados);
    }

    function cadastrar() {

        $this->load->library('facebook');
        $facebook = new Facebook(array(
                    'appId' => FB_APPID,
                    'secret' => FB_SECRET,
                ));

        $user = $facebook->getUser();

        if ($user) {
            try {
                $dados['profile_user'] = $facebook->api('/me');
            } catch (FacebookApiException $e) {
                error_log($e);
                $user = null;
            }
        }


        $this->layout->layout('layout_portal');

        $this->layout->view("orgao/cadastrar_view", $dados);
    }

    function validar($dados) {

        $campos_obrigatorios = array('');
    }

    function inserir() {

        $this->load->model("usuario/usuario_model");

        // quando a requisição for enviada de um mobile    
        if (isset($_GET['cadastro_mobile'])):
            $_POST = $_GET;
            $dados = $_POST;
        endif;

        if (checa_logado(false) == false):
            $_POST['cd_confirmacao'] = md5(date("Y-m-d H:i:s"));
        endif;

        $convites['email'] = $_POST['convite_email'];
        $convites['perfil'] = $_POST['convite_perfil'];
        unset($_POST['convite_email']);
        unset($_POST['convite_perfil']);

        // vamos inserir o usuário
        $usuario = $_POST;
        $usuario['tp_usuario'] = "orgao";
        $usuario['nm_usuario'] = $_POST['nm_representante'];
        $_POST['id_usuario'] = $this->usuario_model->inserirUsuario($usuario);

        if ($_POST['id_usuario'] == ""):
            flashMsg('erro', 'Erro ao cadastrar dados do usuário.');
            echo "<script>history.go(-2);</script>";
            die;
        endif;

        // vamos inserir o orgao
        if ($id = $this->orgao_model->inserirOrgao($_POST)) :

            // inserir o relacionamento do usuário com a entidade
            $this->load->model("relacionamento/relacionamento_model");
            $rel['id_usuario'] = $_POST['id_usuario'];
            $rel['id_entidade'] = $id;
            $rel['entidade'] = "orgao";
            $rel['relacao'] = "gestor";
            $rel['st_aceito'] = "1";
            if (!$this->relacionamento_model->inserirRelacionamento($rel)):
                $this->usuario_model->deletarUsuario($_POST['id_usuario']);
                $this->vendedor_model->deletarOrgao($id);
                echo "false";
            endif;

            // se o cadastro foi externo envia e-mail de confirmação
            if (isset($_POST['cd_confirmacao'])):

                // se o dpn for governamental ele envia o e-mail de confirmação
                // se não a confirmação do cadastro será via contato telefonico
                if ($this->_verificar_dpn_email($_POST['ds_email'])):
                    $this->_email_confirmacao($id);
                else:
                    $this->_email_entraremos_contato($id);
                endif;

            else:
                // se o cadastro foi interno envia e-mail de boas vindas
                $this->_email_boas_vindas($id);
            endif;

            // Vamos enviar os convites
            $convites['entidade'] = 'orgao';
            $convites['id_entidade'] = $id;
            $convites['id_usuario'] = $_POST['id_usuario'];
            $this->_enviar_convites($convites);

            echo "true";

        else:

            echo "false";

        endif;
    }

    function _email_confirmacao($id) {

        $this->load->model('tools/tools_model');

        $orgao = $this->orgao_model->selecionarOrgao($id);

        $email['de'] = EMAIL;
        $email['de_nome'] = "Diapha";
        $email['para'] = $orgao['ds_email'];
        $email['assunto'] = "Confirmação de cadastro";
        $dados['conteudo'] = "Seja bem vindo(a) ao Diapha! <br><br>

                Antes de acessar confirme seu cadastro clicando no link abaixo:<br><br>
                <a href='" . site_url('c/confirmar_cadastro/' . $orgao['cd_confirmacao']) . "'>" . site_url('c/confirmar_cadastro/' . $orgao['cd_confirmacao']) . "</a>
                <br><br>
                
                Caso não funcione, copie e cole o endereço em outra janela do navegador.
                <br><br>

                É muito bom ter você conosco. Obrigada por sua participação!<br><br>
        
                Att.<br>
                Diapha
                
                <br><br>
                Se você não foi o autor deste cadastro, por favor, desconsidere este e-mail.
                ";

        $email['msg'] = utf8_decode($this->load->view("email/modelo_view", $dados, TRUE));

        $this->tools_model->enviar_email($email);
    }

    function _email_boas_vindas($id) {

        $this->load->model('tools/tools_model');

        $orgao = $this->orgao_model->selecionarOrgao($id);

        $email['de'] = EMAIL;
        $email['de_nome'] = "Diapha";
        $email['para'] = $orgao['ds_email'];
        $email['assunto'] = "Seja bem vindo ao Diapha!";
        $dados['conteudo'] = "Sr (a),<br>
        Muito obrigado por colaborar por cidade ainda mais transparente. Acesse agora e comece a monitorar as ocorrências que são de responsabilidade do órgão que você atua para que sejam tomadas as devidas providências.
        
        <br>
        <br>

        Atenciosamente,<br>
        Equipe Diapha";

        $email['msg'] = utf8_decode($this->load->view("email/modelo_view", $dados, TRUE));

        $this->tools_model->enviar_email($email);
    }

    function _email_entraremos_contato($id) {

        $this->load->model('tools/tools_model');

        $orgao = $this->orgao_model->selecionarOrgao($id);

        $email['de'] = EMAIL;
        $email['de_nome'] = "Diapha";
        $email['para'] = $orgao['ds_email'];
        $email['assunto'] = "Seja bem vindo ao Diapha!";
        $dados['conteudo'] = "Olá!<br><br>

                Obrigado por efetuar o seu cadastro no Diapha!<br>
                Para melhor atendê-lo, e garantir a segurança das informações, entraremos em contato para validar o seu cadastro.<br>
        <br>

        Atenciosamente,<br>
        Equipe Diapha";

        $email['msg'] = utf8_decode($this->load->view("email/modelo_view", $dados, TRUE));

        $this->tools_model->enviar_email($email);
    }

    function _email_cadastro_confirmado($id) {

        $this->load->model('tools/tools_model');

        $orgao = $this->orgao_model->selecionarOrgao($id);

        $email['de'] = EMAIL;
        $email['de_nome'] = "Diapha";
        $email['para'] = $orgao['ds_email'];
        $email['assunto'] = "Seja bem vindo ao Diapha!";
        $dados['conteudo'] = "Olá,<br><br>
        Seu cadastro no Diapha foi confirmado.<br>
        Acesse agora e comece a monitorar as ocorrências que são de responsabilidade do órgão que você atua para que sejam tomadas as devidas providências.
        Colabore e ajude sua cidade a ser ainda mais transparente.
        <br>
        <br>

        Atenciosamente,<br>
        Equipe Diapha<br>
        <a href='http://www.diapha.com.br'>www.diapha.com.br</a>";

        $email['msg'] = utf8_decode($this->load->view("email/modelo_view", $dados, TRUE));

        $this->tools_model->enviar_email($email);
    }

    function _enviar_convites($convites) {

        $this->load->model("convite/convite_model");

        $param['id_usuario'] = $convites['id_usuario'];
        $usuario = $this->usuario_model->selecionarUsuario($param);

        // Gravar código do convite
        if ($convites):
            $x = 0;
            foreach ($convites['email'] as $ds_email):

                if ($ds_email != '' && $ds_email != 'E-mail do colaborador'):
                    $convite['x'] = $x;
                    $convite['ds_email'] = $ds_email;
                    $convite['relacao'] = $convites['perfil'][$x];
                    $convite['entidade'] = $convites['entidade'];
                    $convite['id_entidade'] = $convites['id_entidade'];
                    $convite['id_usuario'] = $usuario['id_usuario'];

                    if ($cd_convite = $this->convite_model->inserirConvite($convite)):

                        $dados['link'] = base_url() . "c/a?cd=" . $cd_convite;
                        $dados['usuario'] = $usuario;
                        $dados['nm_empresa'] = $_POST['nm_empresa'];

                        // Enviar o e-mail
                        $this->load->model('tools/tools_model');
                        $email['de'] = "contato@diapha.com.br";
                        $email['de_nome'] = $usuario['nm_usuario'] . " via Diapha";
                        $email['para'] = $ds_email;
                        $email['assunto'] = "Faça parte do Diapha";
                        $email['msg'] = utf8_decode($this->load->view("email/convite_orgao_view", $dados, TRUE));

                        $this->tools_model->enviar_email($email);

                    endif;

                endif;

                $x++;
            endforeach;
        endif;
    }

    function editar($id) {

        checa_logado();

        checa_dono(usuario('id_orgao'), $id);

        $dados["dado"] = $this->orgao_model->selecionarOrgao($id);

        $this->layout->layout("layout_portal");

        $this->layout->view("orgao/editar_view", $dados);
    }

    function atualizar($id) {

        checa_logado();

        if ($this->orgao_model->atualizarOrgao($_POST)) :
            flashMsg('sucesso', 'Registro atualizado com sucesso.');

            if (checa_permissao(array('admin', 'operador'), true)):
                echo '<script>history.go(-2);</script>';
            else:
                redirect('');
            endif;

        else:
            flashMsg('erro', 'Erro ao atualizar o registro.');
            echo '<script>history.go(-2);</script>';
        endif;
    }

    function editar_logo() {

        checa_logado();

        if ($_GET['id_orgao'] != ''):
            $dados['id_orgao'] = $_GET['id_orgao'];
        else:
            $dados['id_orgao'] = usuario('id_orgao');
        endif;


        $this->load->model("tools/tools_model");

        // Vamos fazer o upload da imagem
        if ($_FILES['nm_foto']['size'] > 0) :

            $dados = $_POST;

            $maior = array("x" => 300, "y" => 300);
            $dados['nm_foto'] = $this->tools_model->upload_imagem($_FILES['nm_foto'], "arquivos/diapha", $maior);

        endif;

        // Vamos redimensior e gravar a imagem
        if ($_POST['x'] != ''):

            $size['x'] = '200';
            $size['y'] = '200';

            $crop['y'] = $_POST['y'];
            $crop['x'] = $_POST['x'];
            $crop['h'] = $_POST['h'];
            $crop['w'] = $_POST['w'];

            // Vamos recortar a imagem
            $this->tools_model->canvas_crop("arquivos/diapha/", $_POST['nm_foto'], $crop, $size);

            // Vamos gravar os dados
            $param['campo'] = 'nm_foto';
            $param['valor'] = $_POST['nm_foto'];
            $param['id_orgao'] = $_POST['id_orgao'];

            if ($this->orgao_model->atualizarCampo($param)) :

                usuario('nm_foto', $_POST['nm_foto']);

                flashMsg('sucesso', 'Logomarca de perfil alterada com sucesso.');

                redirect('?view=feed');

            else:

                flashMsg('erro', 'Erro! Não foi possível alterar a logomarca de perfil.');

            endif;

        endif;

        $this->layout->layout('layout_portal');

        $this->layout->view("orgao/editar_logo_view", $dados);
    }

    function deletar($id) {

        checa_logado();

        if ($this->orgao_model->deletarOrgao($id)) :
            flashMsg('sucesso', 'Registro deletado com sucesso.');
            redirect('orgao/listar');
        else:
            flashMsg('erro', 'Erro ao deletar o registro.');
            redirect('orgao/listar');
        endif;
    }

    /**
     * Ajax
     */
    function checa_existe_login() {

        if ($this->orgao_model->selecionarLogin($_POST['nm_login'], $_POST['id']))
            echo "Usuário já cadastrado!";
    }

    function checa_existe_email() {
        $email = $_POST['ds_email'];

        if ($this->orgao_model->selecionarEmail($_POST['ds_email'], $_POST['id']))
            echo "E-mail já cadastrado!";
    }

    function confirmar_cadastro($cd_confirmacao) {

        $this->load->model('usuario/usuario_model');

        $param['cd_confirmacao'] = $cd_confirmacao;
        $orgao = $this->orgao_model->selecionarOrgaoes($param);

        if ($this->orgao_model->confirmarCadastro($cd_confirmacao)):
            $this->_email_cadastro_confirmado($orgao[0]['id_orgao']);

            if (checa_logado(false)):
                echo "<script>history.back(-2)</script>";
            else:

                flashMsg('sucesso', 'Seu cadastro foi confirmado com sucesso. Por medidas de segurança entre com seus dados de login.');
                redirect('portal/boas_vindas');

            endif;
        endif;
    }

    /**
     * Vamos verificar se o DPN (Domínio de Primeiro Nível) do e-mail é válido
     * @param type $email
     * @return type boolean
     */
    function _verificar_dpn_email($email) {

        //Vamos verificar o domínio do email se eh permitido
        list($user, $endereco) = explode("@", $email);

        $arr = explode(".", $endereco);
        $dominio = $arr[count($arr) - 2];
        $final = $arr[count($arr) - 1];

        $permitido = unserialize(DPN);

        if (count($arr) == 2 && $final == 'br') :
            return true;
        elseif (in_array($dominio, $permitido)) :
            return true;
        else:
            return false;
        endif;
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */