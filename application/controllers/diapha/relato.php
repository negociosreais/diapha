<?php

class Relato extends CI_Controller {

    function Relato() {
        parent::__construct();

        $this->load->model("relato/relato_model");
        $this->load->model("orgao/orgao_model");
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

    function cadastrar($id_vendedor) {

        checa_permissao(array('admin'));

        $this->layout->view("diapha/cadastrar_view");
    }

    function inserir() {

        $this->load->library('facebook');
        $facebook = new Facebook(array(
                    'appId' => FB_APPID,
                    'secret' => FB_SECRET,
                ));
        $user = $facebook->api('/' . $_REQUEST['fb_user']);

        $dados = $_REQUEST;

        $dados['fb_name'] = $user['name'];

        // Antes de inserir vamos buscar os dados de localização do relato
        $url = 'http://maps.google.com.br/maps/api/geocode/json?';
        $url .= "latlng=" . $dados['ds_latitude'] . "," . $dados['ds_longitude'] . "&sensor=false";

        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        $conteudo = curl_exec($c);
        curl_close($c);

        $json = json_decode($conteudo, false);

        //debug($json);
        //debug($json->results[0]->address_components);

        foreach ($json->results[0]->address_components as $a):

            switch ($a->types[0]):

                case 'street_number':

                    $dados['ds_endereco'] = $a->long_name;

                    break;

                case 'route':
                    $dados['ds_endereco'] .= "," . $a->long_name;
                    break;

                case 'sublocality':
                    $dados['nm_bairro'] = $a->long_name;
                    break;

                case 'locality':
                    $dados['nm_cidade'] = $a->long_name;
                    break;

                case 'administrative_area_level_1':
                    $dados['nm_estado'] = $a->short_name;
                    break;

                case 'country':
                    $dados['nm_pais'] = $a->short_name;
                    break;

                case 'postal_code':
                    $dados['nr_cep'] = $a->long_name;
                    break;

            endswitch;

        endforeach;

        //debug($dados);
        // Vamos fazer o upload da imagem
        if ($_FILES['foto']['size'] > 0) :
            $this->load->model('tools/tools_model');

            //$maior = array("x" => 800, "y" => 800);
            //$dados['nm_foto'] = $this->tools_model->upload_imagem($_FILES['foto'], "arquivos/diapha");
            $dados['nm_foto'] = $this->tools_model->upload_arquivo($_FILES['foto'], "arquivos/diapha");

        endif;

        if ($id = $this->relato_model->inserirRelato($dados)) :
            
            $relato = $this->relato_model->selecionarRelato($id);
            
            echo 'http://www.diapha.com.br/relato/' . $relato['nm_apelido'] . '/detalhes?id=' . $id;
        else:
            echo 'false';
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
            $icones = unserialize($dado['ds_icones']);
            $ico['vermelho'] = ($icones['vermelho']) ? $icones['vermelho'] : $ico['vermelho'];
            $ico['amarelo'] = ($icones['amarelo']) ? $icones['amarelo'] : $ico['amarelo'];
            $ico['verde'] = ($icones['verde']) ? $icones['verde'] : $ico['verde'];

            $dados['ds_icones'] = serialize($ico);
        endif;

        if ($this->relato_categoria_model->atualizarCategoria($dados)) :
            flashMsg('sucesso', 'Registro atualizado com sucesso.');
            redirect('diapha/categoria/listar');
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
    
    function apoiar() {
        $dados['id_relato'] = $_POST['id_relato'];
        $dados['id_usuario'] = $_POST['id_usuario'];
        
        $apoio = $this->relato_model->inserirApoio($dados);
        
        echo $apoio;
    }

    /**
     * Lista XML de categorias
     */
    function xml() {

        $param = $_GET;
        
        $param['status'] = "Ativo";
        $param['fb_email'] = $_GET['fb_email'];
        $param['intervalo'] = $_GET['intervalo'];
        $relatos = $this->relato_model->selecionarRelatos($param);
        
        usuario('categorias', $_GET['categorias']);

        #versao do encoding xml
        $dom = new DOMDocument("1.0", "UTF-8");

        #retirar os espacos em branco
        $dom->preserveWhiteSpace = false;

        #gerar o codigo
        $dom->formatOutput = true;

        #criando o nó principal (root)
        $markers = $dom->createElement("markers");

        foreach ($relatos as $rel):

            $icones = unserialize($rel['ds_icones']);

            switch ($rel['st_status']):
                case '0':
                    $nm_icone = $icones['vermelho'];
                    break;
                case '1':
                    $nm_icone = $icones['amarelo'];
                    break;
                case '2':
                    $nm_icone = $icones['verde'];
                    break;
            endswitch;

            $marker = $dom->createElement("marker");

            $id = $dom->createAttribute('id');
            $id->value = $rel['id_relato'];

            $lat = $dom->createAttribute('lat');
            $lat->value = $rel['ds_latitude'];

            $lng = $dom->createAttribute('lng');
            $lng->value = $rel['ds_longitude'];

            $tit = $dom->createAttribute('tit');
            $tit->value = (strlen($rel['ds_relato']) < 170) ? $rel['ds_relato'] : substr($rel['ds_relato'], 0, 170) . "...";

            $local = $dom->createAttribute('local');
            $local->value = $rel['ds_endereco'] . ", " . $rel['nm_bairro'] . ", " . $rel['nm_cidade'];

            $fb_user = $dom->createAttribute('fb_user');
            $fb_user->value = $rel['fb_user'];

            $fb_name = $dom->createAttribute('fb_name');
            $fb_name->value = $rel['fb_name'];

            if ($rel['st_status'] == '0'):
                $st_status = "<span class='nao-respondido'>Não respondido</span>";
            elseif ($rel['st_status'] == '1'):
                $st_status = "<span class='em-analise'>Em análise</span>";
            else:
                $st_status = "<span class='respondido'>Respondido</span>";
            endif;

            $status = $dom->createAttribute('status');
            $status->value = $st_status;

            $icone = $dom->createAttribute('icone');
            $icone->value = $nm_icone;

            $categoria = $dom->createAttribute('categoria');
            $categoria->value = $rel['nm_categoria'];

            $apelido = $dom->createAttribute('apelido');
            $apelido->value = $rel['nm_apelido'];

            #adiciona os nós (informacaoes do marker) em markers
            $marker->appendChild($id);
            $marker->appendChild($lat);
            $marker->appendChild($lng);
            $marker->appendChild($tit);
            $marker->appendChild($local);
            $marker->appendChild($fb_user);
            $marker->appendChild($fb_name);
            $marker->appendChild($icone);
            $marker->appendChild($status);
            $marker->appendChild($categoria);
            $marker->appendChild($apelido);
            $markers->appendChild($marker);

        endforeach;

        $dom->appendChild($markers);

        #cabeçalho da página
        header("Content-Type: text/xml");
        # imprime o xml na tela
        print $dom->saveXML();
    }

    /**
     * Lista JSON de categorias
     */
    function json() {

        $param = $_REQUEST;
        $param['status'] = "Ativo";
        $param['fb_email'] = $_REQUEST['fb_email'];
        $relatos = $this->relato_model->selecionarRelatos($param);

        #versao do encoding xml
        $dom = new DOMDocument("1.0", "UTF-8");

        #retirar os espacos em branco
        $dom->preserveWhiteSpace = false;

        #gerar o codigo
        $dom->formatOutput = true;

        #criando o nó principal (root)  
        $markers = $dom->createElement("markers");

        $i = 0;
        $retorno = array();
        foreach ($relatos as $rel):

            $icones = unserialize($rel['ds_icones']);

            switch ($rel['st_status']):
                case '0':
                    $nm_icone = $icones['vermelho'];
                    break;
                case '1':
                    $nm_icone = $icones['amarelo'];
                    break;
                case '2':
                    $nm_icone = $icones['verde'];
                    break;
            endswitch;

            $retorno[$i]['id'] = $rel['id_relato'];
            $retorno[$i]['lat'] = $rel['ds_latitude'];
            $retorno[$i]['lng'] = $rel['ds_longitude'];
            $retorno[$i]['tit'] = $rel['ds_relato'];
            $retorno[$i]['local'] = $rel['ds_endereco'] . ", " . $rel['nm_bairro'] . ", " . $rel['nm_cidade'];
            $retorno[$i]['fb_user'] = $rel['fb_user'];
            $retorno[$i]['fb_name'] = $rel['fb_name'];
            $retorno[$i]['icone'] = $nm_icone;
            $retorno[$i]['status'] = $rel['st_status'];
            $retorno[$i]['datahora'] = formataDate($rel['dt_cadastro'], "-") . " " . $rel['hr_cadastro'];
            $retorno[$i]['foto'] = base_url() . "arquivos/diapha/" . $rel['nm_foto'];
            $retorno[$i]['historico'] = unserialize($rel['ds_historico']);

            $i++;
        endforeach;

        echo json_encode($retorno);
    }
    
    function android_json() {

        $param = $_REQUEST;
        $param['status'] = "Ativo";
        $param['fb_email'] = $_REQUEST['fb_email'];
        $relatos = $this->relato_model->selecionarRelatos($param);

        #versao do encoding xml
        $dom = new DOMDocument("1.0", "UTF-8");

        #retirar os espacos em branco
        $dom->preserveWhiteSpace = false;

        #gerar o codigo
        $dom->formatOutput = true;

        #criando o nó principal (root)  
        $markers = $dom->createElement("markers");

        $i = 0;
        $retorno = array();
        foreach ($relatos as $rel):

            $icones = unserialize($rel['ds_icones']);

            switch ($rel['st_status']):
                case '0':
                    $nm_icone = $icones['vermelho'];
                    break;
                case '1':
                    $nm_icone = $icones['amarelo'];
                    break;
                case '2':
                    $nm_icone = $icones['verde'];
                    break;
            endswitch;

            $retorno[$i]['id'] = $rel['id_relato'];
            $retorno[$i]['lat'] = $rel['ds_latitude'];
            $retorno[$i]['lng'] = $rel['ds_longitude'];
            $retorno[$i]['tit'] = $rel['ds_relato'];
            $retorno[$i]['local'] = $rel['ds_endereco'] . ", " . $rel['nm_bairro'] . ", " . $rel['nm_cidade'];
            $retorno[$i]['fb_user'] = $rel['fb_user'];
            $retorno[$i]['fb_name'] = $rel['fb_name'];
            $retorno[$i]['icone'] = $nm_icone;
            $retorno[$i]['status'] = $rel['st_status'];
            $retorno[$i]['datahora'] = formataDate($rel['dt_cadastro'], "-") . " " . $rel['hr_cadastro'];
            $retorno[$i]['foto'] = base_url() . "arquivos/diapha/" . $rel['nm_foto'];
            $retorno[$i]['historico'] = unserialize($rel['ds_historico']);

            $i++;
        endforeach;

        echo '{ "relatos": '.json_encode($retorno).' } ';
    }

    function detalhes($c) {

        $dados['categoria'] = $c;

        $dados['relato'] = $this->relato_model->selecionarRelato($_GET['id']);
        $dados['title'] = "Diapha: " . $dados['relato']['ds_relato'];
        $dados['description'] = "Diapha: " . $dados['relato']['ds_relato'];
        
        $this->layout->layout("layout_portal", $dados);

        $this->layout->view("diapha/detalhes_view", $dados);
    }

    function alterar_status() {

        $dados = $_REQUEST;

        $relato = $this->relato_model->selecionarRelato($dados['id_relato']);
        $ds_historico = unserialize($relato['ds_historico']);

        if ($ds_historico != ''):
            $i = count($ds_historico);
        else:
            $i = 0;
        endif;

        $novo[$i]['st_status'] = $dados['st_status'];
        $novo[$i]['ds_mensagem'] = $dados['mensagem'];
        $novo[$i]['id_usuario'] = usuario('id_usuario');
        $novo[$i]['id_orgao'] = usuario('id_orgao');
        $novo[$i]['email_facebook'] = (usuario('email_facebook') != '') ? usuario('email_facebook') : $dados['email_facebook'];
        $novo[$i]['nm_orgao'] = usuario('nm_orgao');
        $novo[$i]['nm_usuario'] = ($dados['email_facebook'] != '') ? $relato['fb_user']:"";
        $novo[$i]['dt_alteracao'] = date('Y-m-d');
        $novo[$i]['hr_alteracao'] = date('H:i:s');

        if ($i > 0):
            $ds_historico = array_merge($ds_historico, $novo);
        else:
            $ds_historico = $novo;
        endif;

        $dado['id_relato'] = $dados['id_relato'];
        $dado['st_status'] = $dados['st_status'];
        $dado['ds_historico'] = serialize($ds_historico);


        if ($this->relato_model->atualizarRelato($dado)):
            flashMsg('sucesso', 'Status alterado com sucesso.');
            echo 'true';
        else:
            flashMsg('sucesso', 'Ops! Não foi possível alterar o status.');
            echo 'false';
        endif;
    }

}

/* End of file welcome.php */
        /* Location: ./system/application/controllers/welcome.php */






        