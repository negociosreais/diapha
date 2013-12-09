<?php

class Convite extends CI_Controller {

    function Convite() {
        parent::__construct();

        $this->load->model("convite/convite_model");
    }

    function convidar() {

        checa_logado();

        $this->layout->layout('layout_portal');

        $this->layout->view('convite/convidar_view');
    }

    function aceitar() {

        if (!isset($_GET['cd'])):
            redirect('sem_acesso');
            die;
        endif;

        // vamos buscar os dados do convite
        $convite = $this->convite_model->selecionarConvite($_GET);

        if ($convite):
            // vamos aceitar o convite
            $this->convite_model->atualizarStatusConvite($_GET['cd']);

            // e redirecionar para página de cadastro
            redirect('usuario/cadastrar?cd=' . $_GET['cd']);
        endif;
    }

    function enviar_convite() {
        
        error_reporting(E_ALL);

        $this->load->model("usuario/usuario_model");

        if ($_POST['id_usuario'] == '' || $_POST['ds_email'] == ''):
            die;
        endif;

        if ($_POST['ds_email'] != ''):
            $arr = explode(",", $_POST['ds_email']);
        endif;

        $param['id_usuario'] = $_POST['id_usuario'];
        $usuario = $this->usuario_model->selecionarUsuario($param);

        $erro = "";
        if ($arr):
            foreach ($arr as $a):
                $x++;
            
                // Gravar código do convite
                $convite['ds_email'] = trim($a);
                $convite['relacao'] = "Colaborador";
                $convite['entidade'] = perfil();
                $convite['id_entidade'] = usuario('id_orgao');
                $convite['id_usuario'] = $_POST['id_usuario'];
                $convite['x'] = $x;
                
                if ($cd_convite = $this->convite_model->inserirConvite($convite)):

                    $dados['link'] = base_url() . "c/a?cd=" . $cd_convite;
                    $dados['usuario'] = $usuario;
                    $dados['nm_empresa'] = usuario('nm_orgao');

                    // Enviar o e-mail
                    $this->load->model('tools/tools_model');
                    $email['de'] = "contato@diapha.com.br";
                    $email['de_nome'] = $usuario['nm_usuario'] . " via Diapha";
                    $email['para'] = $_POST['ds_email'];
                    $email['assunto'] = "Faça parte do Portal ARP";

                    $email['msg'] = $this->load->view("email/convite_orgao_view", $dados, TRUE);

                    if (!$this->tools_model->enviar_email($email)):
                        $erro = "deu erro";
                    endif;

                endif;

            endforeach;

            if ($erro == ''):
                flashMsg('sucesso', 'Convites enviados com sucesso.');
                redirect();
            else:
                flashMsg('erro', 'Ops! Ocorreu um erro');
                redirect('convidar');
            endif;


        endif;
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */