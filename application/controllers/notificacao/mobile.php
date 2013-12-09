<?php

class Mobile extends CI_Controller {

    function Mobile() {
        parent::__construct();

        $this->load->model("notificacao/notificacao_model");
    }

    function listar() {
        $this->load->helper("xml");

        /**
         * Vamos trazer os últimos notificações
         */
        // Selecionar últimos posts
        $busca['order'] = 'n.datahora_cadastro DESC';
        $busca['id_usuario'] = $_GET['id_usuario'];
        $busca['st_lido'] = "0";
        $busca['tp_notificacao'] = "mensagem";
        $dados = $this->notificacao_model->selecionarNotificacoes($busca);

        #versao do encoding xml
        $dom = new DOMDocument("1.0", "UTF-8");

        #retirar os espacos em branco
        $dom->preserveWhiteSpace = false;

        #gerar o codigo
        $dom->formatOutput = true;

        #criando o nó principal (root)
        $notificacoes = $dom->createElement("notificacoes");

        $type = $dom->createAttribute('type');
        $type->value = 'array';

        $notificacoes->appendChild($type);

        if ($dados):
            foreach ($dados as $dado):

                // notificacao
                $notificacao = $dom->createElement("notificacao");

                $id_notificacao = $dom->createElement("id_notificacao", xml_convert($dado['id_notificacao']));
                $ds_notificacao = $dom->createElement("ds_notificacao", xml_convert($dado['ds_notificacao']));

                $notificacao->appendChild($id_notificacao);
                $notificacao->appendChild($ds_notificacao);

                $notificacoes->appendChild($notificacao);
            endforeach;
        endif;

        $dom->appendChild($notificacoes);

        #cabeçalho da página
        header("Content-Type: text/xml");
        # imprime o xml na tela
        print $dom->saveXML();
    }
    
    function lido(){
        
        // Selecionar últimos posts
        $dados['id_notificacao'] = $_GET['id_notificacao'];
        $dados['st_lido'] = "1";
        
        if ($this->notificacao_model->atualizarNotificacao($dados)):
            echo 'true';
        else:
            echo 'false';
        endif;
        
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */