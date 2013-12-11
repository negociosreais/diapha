<?php

class Proposta extends CI_Controller {

    function Proposta() {
        parent::__construct();

        $this->load->model("proposta/proposta_model");
    }
    
    function listar() {
        $this->layout->layout("layout_portal", $dados);
        $this->layout->view("diapha/propostas_view", $dados);
    }
    
    function cadastrar() {
        checa_logado();

        $this->load->model('relato/relato_model');
        $this->load->model('orgao/orgao_model');
        $this->load->model('relato_categoria/relato_categoria_model');
        $this->load->model("tools/tools_model");

        $param = $_GET;
        $dados['pagina'] = "propostas";

        $param['status'] = "Ativo";

        $dados['total_geral'] = count($this->relato_model->selecionarRelatos($param));
        
        $param['id_usuario'] = usuario('id_usuario');
        $dados['total_usuario'] = count($this->relato_model->selecionarRelatos($param));
        
        if ($_GET['meusrelatos'] == '1'):
            $dados['pagina'] = "meusrelatos";
        else:
            unset($param['id_usuario']);
        endif;
 
        $this->layout->layout("layout_portal", $dados);
        $this->layout->view("diapha/cadastrar_proposta_view", $dados);
    }
    
    function salvar() {
        $dados = $_POST;
        $dados['id_usuario'] = usuario('id_usuario');
        
        $this->load->model('tools/tools_model');

        // Vamos fazer upload do arquivo primeiramente
        if ($_FILES['nm_arquivo']['name'] != ''):
            $nome = $_POST['nm_arquivo'];
            $time = time();
            $dados['nm_arquivo'] = md5($time)."_".$this->tools_model->upload_arquivo($_FILES['nm_arquivo'], 'arquivos/diapha/propostas', false, $nome);
        endif;

        if ($this->proposta_model->inserirProposta($dados)) :

            flashMsg('sucesso', 'Proposta adicionada com sucesso.');
            redirect('?view=propostas&minhaspropostas=1&intervalo=');
        else:
            flashMsg('erro', 'Erro ao adicionar a proposta.');
            redirect('?view=propostas&minhaspropostas=1&intervalo=');
        endif;
    }
    
    function detalhes() {
        
        $dados['proposta'] = $this->proposta_model->selecionarProposta($_GET['id']);
        $dados['title'] = "Diapha: " . $dados['proposta']['ds_proposta'];
        $dados['description'] = "Diapha: " . $dados['proposta']['ds_proposta'];
        
        $this->layout->layout("layout_portal", $dados);
        $this->layout->view("diapha/detalhes_proposta_view", $dados);
    }
}



/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

