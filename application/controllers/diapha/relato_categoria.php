<?php

class Relato_Categoria extends CI_Controller {

    function Relato_Categoria() {
        parent::__construct();

        $this->load->model("relato_categoria/relato_categoria_model");
    }

    function listar() {

        checa_logado();

        $dados['dados'] = $this->relato_categoria_model->selecionarCategorias();

        // Paginação
        $this->load->helper("paginacao");
        $arr['inicio'] = isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 0;
        $arr['por_pagina'] = 10;
        $arr['dados'] = $dados['dados'];
        $dados['dados'] = paginacao($arr);
        // Fim da paginação

        $this->layout->view("diapha/relato_categoria/listar_view", $dados);
    }

    function cadastrar() {

        checa_logado();

        $this->layout->view("diapha/relato_categoria/cadastrar_view");
    }

    function inserir() {

        checa_logado();
        $dados = $_POST;
        $this->load->model('tools/tools_model');

        // Vamo fazer upload dos icones primeiramente
        if ($_FILES['ico_vermelho']['name'] != ''):
            $nome = $_POST['nm_categoria'] . "_vermelho";
            $icones['vermelho'] = $this->tools_model->upload_arquivo($_FILES['ico_vermelho'], 'arquivos/diapha/ico', false, $nome);
        endif;

        if ($_FILES['ico_amarelo']['name'] != ''):
            $nome = $_POST['nm_categoria'] . "_amarelo";
            $icones['amarelo'] = $this->tools_model->upload_arquivo($_FILES['ico_amarelo'], 'arquivos/diapha/ico', false, $nome);
        endif;

        if ($_FILES['ico_verde']['name'] != ''):
            $nome = $_POST['nm_categoria'] . "_verde";
            $icones['verde'] = $this->tools_model->upload_arquivo($_FILES['ico_verde'], 'arquivos/diapha/ico', false, $nome);
        endif;
        
        $dados['ds_icones'] = serialize($icones);

        if ($this->relato_categoria_model->inserirCategoria($dados)) :

            flashMsg('sucesso', 'Registro adicionado com sucesso.');
            redirect('relato/categoria/listar');
        else:
            flashMsg('erro', 'Erro ao adicionar o registro.');
            redirect('relato/categoria/listar/');
        endif;
    }

    function editar($id) {

        checa_logado();

        $dados["dado"] = $this->relato_categoria_model->selecionarCategoria($id);
        
        $this->layout->view("diapha/relato_categoria/editar_view", $dados);
    }

    function atualizar() {

        checa_logado();
        $dados = $_POST;
        $this->load->model('tools/tools_model');
        
        // Vamo fazer upload dos icones primeiramente
        if ($_FILES['ico_vermelho']['name'] != ''):
            $nome = $_POST['nm_categoria'] . "_vermelho";
            $icones['vermelho'] = $this->tools_model->upload_arquivo($_FILES['ico_vermelho'], 'arquivos/diapha/ico', false, $nome);
        endif;

        if ($_FILES['ico_amarelo']['name'] != ''):
            $nome = $_POST['nm_categoria'] . "_amarelo";
            $icones['amarelo'] = $this->tools_model->upload_arquivo($_FILES['ico_amarelo'], 'arquivos/diapha/ico', false, $nome);
        endif;

        if ($_FILES['ico_verde']['name'] != ''):
            $nome = $_POST['nm_categoria'] . "_verde";
            $icones['verde'] = $this->tools_model->upload_arquivo($_FILES['ico_verde'], 'arquivos/diapha/ico', false, $nome);
        endif;
        
        if ($icones):
            $dado = $this->relato_categoria_model->selecionarCategoria($dados['id_categoria']);
            $antigos = unserialize($dado['ds_icones']);
            $ico['vermelho'] = ($icones['vermelho']) ? $icones['vermelho']:$antigos['vermelho'];
            $ico['amarelo'] = ($icones['amarelo']) ? $icones['amarelo']:$antigos['amarelo'];
            $ico['verde'] = ($icones['verde']) ? $icones['verde']:$antigos['verde'];
            
            $dados['ds_icones'] = serialize($ico);
            
        endif;

        
        
        if ($this->relato_categoria_model->atualizarCategoria($dados)) :
            flashMsg('sucesso', 'Registro atualizado com sucesso.');
            redirect('relato/categoria/listar');
        else:
            flashMsg('erro', 'Erro ao deletar o registro.');
            echo "<script>history.go(-2);</script>";
        endif;
    }

    function deletar($id) {

        checa_logado();

        if ($this->relato_categoria_model->deletarCategoria($id)) :
            flashMsg('sucesso', 'Registro deletado com sucesso.');
            echo "<script>history.back();</script>";
        else:
            flashMsg('erro', 'Erro ao deletar o registro.');
            echo "<script>history.back();</script>";
        endif;
    }

    /**
     * Lista XML de categorias
     */
    function json() {

        $param['status'] = "Ativo";
        $cats = $this->relato_categoria_model->selecionarCategorias($param);
        
        
        $i = 0;
        foreach ($cats as $cat):
            $categorias[$i]['id_categoria'] = $cat['id_categoria'];
            $categorias[$i]['nm_categoria'] = $cat['nm_categoria'];
            $categorias[$i]['nm_apelido'] = $cat['nm_apelido'];
            $i++;
        endforeach;


        // produto
        echo json_encode($categorias);
        
    }
    
    
    function android_json() {

        $param['status'] = "Ativo";
        $cats = $this->relato_categoria_model->selecionarCategorias($param);
        
        
        $i = 0;
        foreach ($cats as $cat):
            $categorias[$i]['id_categoria'] = $cat['id_categoria'];
            $categorias[$i]['nm_categoria'] = $cat['nm_categoria'];
            $categorias[$i]['nm_apelido'] = $cat['nm_apelido'];
            $i++;
        endforeach;


        // produto
        echo '{ "categorias": '.json_encode($categorias).' }';
        
    }

}

/* End of file welcome.php */
        /* Location: ./system/application/controllers/welcome.php */






        