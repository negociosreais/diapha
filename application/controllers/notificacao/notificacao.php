<?php

class Notificacao extends CI_Controller {

    function Notificacao() {
        parent::__construct();

        $this->load->model("notificacao/notificacao_model");
    }

    function notificar() {

        if (!isset($_GET['cd'])):
            redirect('sem_acesso');
            die;
        endif;

        // vamos buscar os dados do convite
        $convite = $this->convite_model->selecionarNotificacao($_GET);

        if ($convite):
            // vamos aceitar o convite
            $this->convite_model->atualizarStatusNotificacao($_GET['cd']);

            // e redirecionar para página de cadastro
            redirect('usuario/cadastrar?cd=' . $_GET['cd']);
        endif;
    }
    
    function exibir_popup() {
        
        $busca['id_usuario'] = usuario('id_usuario');
        $busca['id_entidade'] = (perfil() == "vendedor") ? usuario('id_vendedor'):usuario('id_orgao');
        $busca['entidade'] = perfil();
        $busca['tp_notificacao'] = "popup";
        $busca['ds_notificacao'] = $_POST['ds_notificacao'];
        $busca['st_lido'] = "1";
        
        if ($this->notificacao_model->selecionarNotificacoes($busca)):
            echo 'true';
        endif;
        
    }

    function ler_popup() {

        $notificacao['id_usuario'] = usuario('id_usuario');
        $notificacao['ds_notificacao'] = $_POST['ds_notificacao'];
        $notificacao['ds_url'] = "";
        $notificacao['id_entidade'] = (perfil() == "vendedor") ? usuario('id_vendedor'):usuario('id_orgao');
        $notificacao['entidade'] = perfil();
        $notificacao['ds_email'] = "";
        $notificacao['nm_usuario'] = usuario('nm_usuario');
        $notificacao['st_lido'] = "1";
        $notificacao['tp_notificacao'] = "popup";

        $this->notificacao_model->inserirNotificacao($notificacao);
        
    }
    
    function lido(){
        
        // Selecionar últimos posts
        $dados['id_notificacao'] = $_POST['id_notificacao'];
        $dados['st_lido'] = "1";
        
        if ($this->notificacao_model->atualizarNotificacao($dados)):
            echo 'true';
        else:
            echo 'false';
        endif;
        
    }
    
    function qtd_notificacoes() {
        
        checa_logado();
        
        unset($busca);
        $busca['id_usuario'] = usuario('id_usuario');
        $busca['st_lido'] = '0';
        
        echo count($this->notificacao_model->selecionarNotificacoes($busca));
        
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */