<?php

class Usuario extends CI_Controller {

    function Usuario() {
        parent::__construct();

        $this->load->model("usuario/usuario_model");

        
    }

    function listar() {

        checa_permissao(array('admin', 'operador'));

        if ($_GET['e'] != '' || $_GET['i'] != ''):
            $param['entidade'] = $_GET['e'];
            $param['id_entidade'] = $_GET['i'];
        else:
            $param['tipos'] = "'cidadao'";
        endif;

        $param['busca'] = $_GET['busca'];
        $dados['dados'] = $this->usuario_model->selecionarUsuarios($param);
        
        // Preparar parametros
        if (isset($_GET)):
            foreach ($_GET as $key => $val):
                if ($key == 'per_page')
                    continue;
                $dados['p'] .= "{$key}={$val}&";
            endforeach;
        endif;

        // Paginação
        $this->load->helper("paginacao");
        $arr['inicio'] = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 0;
        $arr['por_pagina'] = 10;
        $arr['dados'] = $dados['dados'];
        $arr['params'] = $dados['p'];
        $dados['dados'] = paginacao($arr);
        // Fim da paginação

        $this->layout->view("usuario/listar_view", $dados);
    }

    function cadastrar() {

        // vamos validar o convite
        if ($_GET['cd'] != ''):

            $this->load->model("convite/convite_model");
            $param['cd_convite'] = $_GET['cd'];
            $convite = $this->convite_model->selecionarConvite($param);

            // verificar se o convite realmente existe
            /* if (!$convite && !checa_permissao(array('admin'), true)):
              redirect('sem_acesso');
              die;
              endif; */

            // verificar se o e-mail já não está cadastrado
            if ($convite):
                $param['ds_email'] = $convite['ds_email'];
                $usuarios = $this->usuario_model->selecionarUsuarios($param);
                if ($usuarios):
                    $msg = "<div id='alerta'>Desculpe, você já está cadastrado em nosso sistema.</div>";
                    redirect("sem_acesso?msg=" . $msg);
                    die;
                endif;

                $dados['convite'] = $convite;
                
                $dados['ds_email'] = $convite['ds_email'];
            endif;

        else:

            $this->load->library('facebook');
            $facebook = new Facebook(array(
                        'appId' => FB_APPID,
                        'secret' => FB_SECRET,
                    ));

            $user = $facebook->getUser();

            if ($user) {
                try {
                    $dados['profile_user'] = $facebook->api('/me');
                    
                    $dados['ds_email'] = $dados['profile_user']['email'];
                    $dados['fb_user'] = $dados['profile_user']['username'];
                } catch (FacebookApiException $e) {
                    error_log($e);
                    $user = null;
                }
            }

        endif;

        $this->layout->layout('layout_portal');

        $this->layout->view("usuario/cadastrar_view", $dados);
    }

    function inserir() {

        // vamos validar o convite
        if ($_POST['cd_convite'] != ''):

            $this->load->model("convite/convite_model");
            $convite = $this->convite_model->selecionarConvite($_POST);

            if (!$convite && !checa_permissao(array('admin'), true)):
                redirect('sem_acesso');
                die;
            endif;

        endif;

        // vamos inserir o usuário
        $usuario = $_POST;
        if ($convite):
            $usuario['tp_usuario'] = $convite['entidade'];
        else:
            $usuario['tp_usuario'] = "cidadao";
        endif;

        if ($id = $this->usuario_model->inserirUsuario($usuario)) :

            // inserir o relacionamento do usuário com a entidade
            if ($usuario['tp_usuario'] != 'cidadao'):

                $this->load->model("relacionamento/relacionamento_model");
                $rel['id_usuario'] = $id;
                $rel['id_entidade'] = $convite['id_entidade'];
                $rel['entidade'] = $convite['entidade'];
                $rel['relacao'] = $convite['relacao'];
                $rel['st_aceito'] = "1";
                if (!$this->relacionamento_model->inserirRelacionamento($rel)):
                    $this->usuario_model->deletarUsuario($id);
                    echo "false";
                endif;

                // atualizar convite
                $this->convite_model->atualizarUsuarioConvidado($_GET['cd'], $id);

            endif;

            // Vamos enviar o e-mail
            $this->load->model('tools/tools_model');
            $email['de'] = "contato@diapha.com.br";
            $email['de_nome'] = "Diapha";
            $email['para'] = $_POST['ds_email'];
            $email['assunto'] = "Seja Bem Vindo ao Diapha!";

            switch ($usuario['tp_usuario']):

                case 'orgao':
                    $dados['conteudo'] = $_POST['nm_usuario'] . ", <br><br>
                
                    seja bem vindo(a) ao Diapha. <br><br>

                    Monitore todas ocorrências relacionadas ao órgão em que você atua.
                    Você estará colaborando com sua cidade para que juntos possamos fazer dela um ligar melhor pra se viver.<br><br>";
                    break;

                case 'cidadao':
                    $dados['conteudo'] = $_POST['nm_usuario'] . ", <br><br>
                
                    seja bem vindo(a) ao Diapha! <br><br>

                    Denuncie tudo o que acontece em sua cidade, cobre de quem é responsável. 
                    Ajude a tornar sua cidade mais transparente. Vamos juntos fazer dela um lugar melhor pra se viver.<br><br>";
                    break;

            endswitch;


            $dados['conteudo'] .= "
                Segue abaixo os dados de acesso ao Diapha:<br>
                    Login: " . $_POST['nm_login'] . "<br>
                    Senha: " . $_POST['ds_senha'] . "<br><br>
                
                    o Diapha agradece a sua colaboração.<br><br>
                    
                    Att.<br>
                    Diapha";

            $email['msg'] = $this->load->view("email/modelo_view", $dados, TRUE);

            $this->tools_model->enviar_email($email);
            // Fim do E-mail
            // Se for cadastro de usuário não logado
            if (!checa_logado(false)):

                // Se a requisição não vier de um app mobile inicia a sessão
                if (!isset($dados['cadastro_mobile'])):
                    $param['nm_login'] = $_POST['nm_login'];
                    $usuario = $this->usuario_model->selecionarUsuario($param);
                    iniciar_sessao($usuario);
                endif;

            endif;

            echo "true";
        else:

            echo "false";

        endif;
    }

    function editar($id_usuario) {

        checa_logado();

        checa_permissao(array('admin', 'operador'));

        $param['id_usuario'] = $id_usuario;
        $dados["dado"] = $this->usuario_model->selecionarUsuario($param);
        
        $this->layout->layout('layout_portal');

        $this->layout->view("usuario/editar_view", $dados);
    }

    function meus_dados() {

        checa_logado();

        $param['id_usuario'] = usuario('id_usuario');
        $dados["dado"] = $this->usuario_model->selecionarUsuario($param);
        
        $this->layout->layout('layout_portal');

        $this->layout->view("usuario/editar_view", $dados);
    }

    function preferencias() {

        checa_logado();

        $this->load->model('relato_categoria/relato_categoria_model');

        $param['id_usuario'] = usuario('id_usuario');
        $dados["dado"] = $this->usuario_model->selecionarUsuario($param);
        
        $preferencias = unserialize($dados['dado']['ds_preferencias']);
        $c = $preferencias['categorias'];
        $dados['marcados'] = explode(",",$c);
        
        $param['status'] = "Ativo";
        $categorias = $this->relato_categoria_model->selecionarCategorias($param);
        if ($categorias):
            foreach ($categorias as $categoria) :
                if ($categoria['id_categoria'] == $id)
                    continue;
                $dados['cbo_categorias'][$categoria[nm_apelido]] = $categoria['nm_categoria'];
            endforeach;
        endif;
        
        $this->layout->layout('layout_portal');

        $this->layout->view("usuario/preferencias_view", $dados);
    }

    function atualizar() {

        checa_logado();

        if (!checa_permissao(array('admin', 'operador'), true)):
            if ($_POST['id_usuario'] != usuario('id_usuario')):
                die;
            endif;
        endif;

        $usuario = $_POST;

        if ($this->usuario_model->atualizarUsuario($usuario)) :

            flashMsg('sucesso', 'Dados de usuário atualizados com sucesso.');

            echo "true";

        else:

            echo "false";

        endif;
    }

    function editar_foto() {

        checa_logado();

        if ($_GET['id_usuario'] != ''):
            $dados['id_usuario'] = $_GET['id_usuario'];
        else:
            $dados['id_usuario'] = usuario('id_usuario');
        endif;

        $this->load->model("tools/tools_model");

        // Vamos fazer o upload da imagem
        if ($_FILES['nm_foto']['size'] > 0) :

            $dados = $_POST;

            $maior = array("x" => 300, "y" => 300);
            $dados['nm_foto'] = $this->tools_model->upload_imagem($_FILES['nm_foto'], "arquivos/usuario", $maior);

        endif;

        // Vamos redimensior e gravar a imagem
        if ($_POST['x'] != ''):

            $size['x'] = '100';
            $size['y'] = '100';

            $crop['y'] = $_POST['y'];
            $crop['x'] = $_POST['x'];
            $crop['h'] = $_POST['h'];
            $crop['w'] = $_POST['w'];

            // Vamos recortar a imagem
            $this->tools_model->canvas_crop("arquivos/usuario/", $_POST['nm_foto'], $crop, $size);

            // Vamos gravar os dados
            $param['id_usuario'] = $_POST['id_usuario'];
            $usuario = $this->usuario_model->selecionarUsuario($param);
            $usuario['nm_foto'] = $_POST['nm_foto'];

            if ($this->usuario_model->atualizarUsuario($usuario)) :

                if ($_GET['id_usuario'] == ''):
                    usuario('nm_foto', $_POST['nm_foto']);
                endif;

                flashMsg('sucesso', 'Imagem de perfil alterada com sucesso.');

                if ($_GET['id_usuario'] != ''):
                    echo "<script>history.go(-3);</script>";
                else:
                    redirect('inicial');
                endif;


            else:

                flashMsg('erro', 'Erro! Não foi possível alterar a imagem de perfil.');

            endif;

        endif;
        
        $this->layout->layout('layout_portal');

        $this->layout->view("usuario/editar_foto_view", $dados);
    }

    function deletar($id) {

        checa_logado();
        checa_permissao(array('admin'));

        if ($this->usuario_model->deletarUsuario($id)) :
            flashMsg('sucesso', 'Registro deletado com sucesso.');
            echo "<script>history.back();</script>";
        else:
            flashMsg('erro', 'Erro ao deletar o registro.');
            echo "<script>history.back();</script>";
        endif;
    }

    function cancelar_notificacoes() {

        if ($_GET['cd'] != '' && $_GET['em'] != ''):

            $param['ds_email'] = $_GET['em'];
            $usuario = $this->usuario_model->selecionarUsuario($param);

            if ($usuario):

                if ($_GET['cd'] == md5($usuario['id_usuario'])):

                    if ($this->usuario_model->atualizarReceberEmail($usuario['id_usuario'])):
                        $dados['msg'] = "O recebimento de notificações foi cancelado com sucesso.";
                    else:
                        $dados['msg'] = "Não foi possível cancelar o recebimento de notificações. As informações não conferem.";
                    endif;

                    $this->layout->layout('layout_portal');

                    $this->layout->view("usuario/cancelar_notificacoes_view", $dados);

                endif;

            endif;

        endif;
    }

    function checa_existe_login() {

        $param['nm_login'] = $_POST['nm_login'];
        if ($usuario = $this->usuario_model->selecionarUsuario($param)):
            if (checa_logado(false)):
                if ($usuario['id_usuario'] != $_POST['id_usuario']):
                    echo "<div id='erro' class='sem-borda'>Usuário já cadastrado!</div>";
                endif;
            else:
                echo "<div id='erro' class='sem-borda'>Usuário já cadastrado!</div>";
            endif;
        endif;
    }

    function checa_existe_email() {

        $param['ds_email'] = $_POST['ds_email'];
        if ($usuario = $this->usuario_model->selecionarUsuarios($param)):
            if (checa_logado(false)):
                if ($usuario[0]['id_usuario'] != $_POST['id_usuario']):
                    echo "<div id='erro' class='sem-borda'>E-mail já cadastrado!</div>";
                endif;
            else:
                echo "<div id='erro' class='sem-borda'>E-mail já cadastrado!</div>";
            endif;
        endif;
    }

    function atualizar_preferencias() {

        checa_logado();

        if (!checa_permissao(array('admin', 'operador'), true)):
            if ($_POST['id_usuario'] != usuario('id_usuario')):
                die;
            endif;
        endif;

        if ($_POST['id_categoria']):
            $i = 0;
            foreach ($_POST['id_categoria'] as $c):
                $i++;
                if ($i > 1):
                    $preferencias['categorias'] .= ",";
                endif;
                $preferencias['categorias'] .= $c;

            endforeach;
        endif;

        $ds_preferencias = serialize($preferencias);

        if ($this->usuario_model->atualizarPreferencias($_POST['id_usuario'], $ds_preferencias)) :

            usuario('categorias', $preferencias['categorias']);
            
            flashMsg('sucesso', 'Suas preferências foram atualizadas com sucesso.');

            redirect('');

        else:

            flashMsg('erro', 'Erro! Não foi possível atualizar suas preferências.');
            echo "<script>history.back();</script>";

        endif;
    }


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */