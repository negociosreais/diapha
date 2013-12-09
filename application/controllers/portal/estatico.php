<?php

class Estatico extends CI_Controller {

    function Estatico() {
        parent::__construct();

        $this->layout->layout('layout_portal');
    }

    function index() {

        $this->layout->view("portal/inicial_view", $dados);
    }

    function quem_somos() {
        
        $dados['title'] = "Conheça o Diapha.";
        $dados['description'] = "Portal criado com o objetivo de ser uma central de transparência e ouvidoria ao cidadão. A partir de agora o cidadão poderá bota a boca no trombone e exigir que a administração pública tome atitudes, por outro lado esta iniciativa também evidenciará os municípios que mais solucionaram os problemas de sua cidade, posicionando o município no Rank dos municípios que atendem melhor o cidadão.";
        $dados['keywords'] = "Cidades, Transparência, Relatos, Ocorrências";
        
        $this->layout->layout("layout_portal",$dados);

        $this->layout->view("portal/quem_somos_view", $dados);
    }

    function servicos() {

        $this->layout->view("portal/servicos_view", $dados);
    }

    function representantes() {

        $this->layout->view("portal/representantes_view", $dados);
    }

    function email_marketing() {

        $this->layout->view("portal/email_marketing_view", $dados);
    }

    function banner_site() {

        $this->layout->view("portal/banner_site_view", $dados);
    }

    function consultores() {

        $this->layout->view("portal/consultores_view", $dados);
    }

    function contato() {

        $this->layout->view("portal/contato_view", $dados);
    }

    function contrato_servico() {

        $this->load->view("portal/contrato_servico_view", $dados);
        
    }

    function confirma_cadastro() {

            $this->layout->view("portal/confirma_cadastro_view", $dados);

    }

    function boas_vindas() {

        $this->layout->view("portal/boas_vindas_view");
        
    }

    function selecionar_perfil() {

        $this->layout->layout('layout_portal');

        $this->layout->view("portal/selecionar_perfil_view", $dados);
    }
    
    function selecionar_perfil2() {

        $this->layout->layout('layout_portal');

        $this->layout->view("portal/selecionar_perfil2_view", $dados);
    }

    function enviar_mensagem() {
        
        $this->load->model('tools/tools_model');
        
        $dado = $_POST;
        
        $email['de'] = $dado['email'];
        $email['de_nome'] = $dado['nome'];
        $email['para'] = 'contato@diapha.com.br';
        //$email['copia_oculta'] = 'rafaelmenezes86@gmail.com';
        $email['assunto'] = $dado['assunto'];
        $dados['conteudo'] = "
                Nome: $dado[nome] <br>
                Empresa: $dado[empresa] <br>
                Telefone: $dado[telefone] <br>
                Celular: $dado[celular] <br>
                E-mail: $dado[email] <br>
                Assunto: $dado[assunto] <br>
                Mensagem: <br> $dado[mensagem]";
        
        
        $email['msg'] = utf8_decode($this->load->view("email/modelo_view", $dados, TRUE));

        if ($this->tools_model->enviar_email($email)) :
            flashMsg('sucesso', 'Sua mensagem foi enviado com sucesso. Obrigado por entrar em contato.');
            redirect('');
        else:
            flashMsg('erro', 'Erro! Não foi possível enviar sua mensagem. Tente mais tarde!');
            redirect('portal/contato/');
        endif;
    }


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */