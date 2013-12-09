<?php

class Portlets extends CI_Controller {

    function Portlets() {
        parent::__construct();
    }

    function notificacoes() {

        checa_logado();

        /**
         * Vamos trazer os últimos posts
         */
        $this->load->model("notificacao/notificacao_model");
        $this->load->model("relacionamento/relacionamento_model");

        // Selecionar últimos posts
        $busca['id_usuario'] = usuario('id_usuario');
        $busca['limit'] = '0,' . $_POST['limit'];
        //$busca['limit'] = '0,10';
        //$busca['objeto'] = true;
        $busca['order'] = 'datahora_cadastro DESC';
        $notificacoes = $this->notificacao_model->selecionarNotificacoes($busca);

        $i = 0;

        foreach ($notificacoes as $notificacao):
            $i++;

            $dados['notificacoes'][$i]['id_notificacao'] = $notificacao['id_notificacao'];
            $dados['notificacoes'][$i]['ds_url'] = $notificacao['ds_url'];
            $dados['notificacoes'][$i]['st_lido'] = $notificacao['st_lido'];
            $dados['notificacoes'][$i]['datahora_cadastro'] = $notificacao['datahora_cadastro'];

            if ($notificacao['objeto'] != ''):
                switch ($notificacao['objeto']):

                    case "produto_acesso":

                        $this->load->model("produto_acesso/produto_acesso_model");

                        $produto_acesso = $this->produto_acesso_model->selecionarProdutoAcesso($notificacao['id_objeto']);

                        $dados['notificacoes'][$i]['titulo'] = $produto_acesso['nm_produto'];
                        $dados['notificacoes'][$i]['texto'] = "Nova oportunidade de compra.";
                        $dados['notificacoes'][$i]['imagem'] = "arquivos/produtos/" . $produto_acesso['nm_imagem'];

                        break;

                    case "produto_interesse":

                        $this->load->model("produto_interesse/produto_interesse_model");

                        $produto_interesse = $this->produto_interesse_model->selecionarProdutoInteresse($notificacao['id_objeto']);

                        $dados['notificacoes'][$i]['titulo'] = $produto_interesse['nm_produto'];
                        $dados['notificacoes'][$i]['texto'] = "Nova oportunidade de compra.";
                        $dados['notificacoes'][$i]['imagem'] = "arquivos/produtos/" . $produto_interesse['nm_imagem'];
                        $dados['notificacoes'][$i]['quantidade'] = $produto_interesse['qtd_interesse'];

                        break;

                    case "documento":

                        $this->load->model("documento/documento_model");

                        $documento = $this->documento_model->selecionarDocumento($notificacao['id_objeto']);

                        $dados['notificacoes'][$i]['titulo'] = $documento['nm_orgao'];
                        $dados['notificacoes'][$i]['texto'] = "convidou você a colaborar em um <b>Termo de Referência.</b>";
                        $dados['notificacoes'][$i]['imagem'] = "arquivos/logos/" . $documento['nm_logo'];

                        break;

                    case "documento_comentario":

                        $this->load->model("documento/documento_model");

                        $comentario = $this->documento_model->selecionarComentario($notificacao['id_objeto']);

                        if ($comentario['nm_empresa'] != ''):

                            $dados['notificacoes'][$i]['titulo'] = $comentario['nm_empresa'];
                            $dados['notificacoes'][$i]['imagem'] = ($comentario['logo_vendedor'] != '') ? "arquivos/logos/" . $comentario['logo_vendedor'] : base_url() . TEMPLATE . "/img/logoEmpresaP.jpg";

                        elseif ($comentario['nm_orgao'] != ''):

                            $dados['notificacoes'][$i]['titulo'] = $comentario['nm_orgao'];
                            $dados['notificacoes'][$i]['imagem'] = ($comentario['logo_orgao'] != '') ? "arquivos/logos/" . $comentario['logo_orgao'] : base_url() . TEMPLATE . "/img/logoGovernoP.jpg";

                        else:

                            $dados['notificacoes'][$i]['titulo'] = "Portal ARP";
                            $dados['notificacoes'][$i]['imagem'] = base_url() . TEMPLATE . "/img/logo_parte.png";

                        endif;

                        $dados['notificacoes'][$i]['texto'] = "comentou o <b>Termo de Referência ({$comentario[nm_documento]})</b>: \"" . substr($comentario['ds_comentario'], 0, 30) . "...\"";

                        break;

                    case "estimativa_preco":

                        $this->load->model("estimativa_preco/estimativa_preco_model");

                        $estimativa = $this->estimativa_preco_model->selecionarEstimativa($notificacao['id_objeto']);

                        $dados['notificacoes'][$i]['titulo'] = $estimativa['nm_orgao'];
                        $dados['notificacoes'][$i]['texto'] = "tem uma nova <b>Oportunidade de Licitação</b> para o produto <b>{$estimativa[produto]}</b>.";
                        $dados['notificacoes'][$i]['imagem'] = "arquivos/logos/" . $estimativa['nm_logo'];

                        break;

                    case "estimativa_comentario":

                        $this->load->model("estimativa_preco/estimativa_preco_model");

                        $comentario = $this->estimativa_preco_model->selecionarComentario($notificacao['id_objeto']);

                        if ($comentario['nm_empresa'] != ''):

                            $dados['notificacoes'][$i]['titulo'] = $comentario['nm_empresa'];
                            $dados['notificacoes'][$i]['imagem'] = ($comentario['logo_vendedor'] != '') ? "arquivos/logos/" . $comentario['logo_vendedor'] : base_url() . TEMPLATE . "/img/logoEmpresaP.jpg";

                        elseif ($comentario['nm_orgao'] != ''):

                            $dados['notificacoes'][$i]['titulo'] = $comentario['nm_orgao'];
                            $dados['notificacoes'][$i]['imagem'] = ($comentario['logo_orgao'] != '') ? "arquivos/logos/" . $comentario['logo_orgao'] : base_url() . TEMPLATE . "/img/logoGovernoP.jpg";

                        else:

                            $dados['notificacoes'][$i]['titulo'] = "Portal ARP";
                            $dados['notificacoes'][$i]['imagem'] = base_url() . TEMPLATE . "/img/logo_parte.png";

                        endif;

                        $dados['notificacoes'][$i]['texto'] = "comentou uma <b>Oportunidade de Licitação</b>: \"" . substr($comentario['ds_comentario'], 0, 30) . "...\"";


                        break;

                    case "post_comentario":

                        $this->load->model("post/post_model");

                        unset($param);
                        $param['id_comentario'] = $notificacao['id_objeto'];
                        $comentario = $this->post_model->selecionarComentario($param);

                        if ($comentario['nm_empresa'] != ''):

                            $dados['notificacoes'][$i]['titulo'] = $comentario['nm_empresa'];
                            $dados['notificacoes'][$i]['imagem'] = ($comentario['logo_vendedor'] != '') ? "arquivos/logos/" . $comentario['logo_vendedor'] : base_url() . TEMPLATE . "/img/logoEmpresaP.jpg";

                        elseif ($comentario['nm_orgao'] != ''):

                            $dados['notificacoes'][$i]['titulo'] = $comentario['nm_orgao'];
                            $dados['notificacoes'][$i]['imagem'] = ($comentario['logo_orgao'] != '') ? "arquivos/logos/" . $comentario['logo_orgao'] : base_url() . TEMPLATE . "/img/logoGovernoP.jpg";

                        else:

                            $dados['notificacoes'][$i]['titulo'] = "Portal ARP";
                            $dados['notificacoes'][$i]['imagem'] = base_url() . TEMPLATE . "/img/logo_parte.png";

                        endif;

                        $dados['notificacoes'][$i]['texto'] = "comentou no <b>Diapha</b>: \"" . substr($comentario['ds_comentario'], 0, 30) . "...\"";

                        break;

                    case "estimativa_resposta":

                        $this->load->model("estimativa_preco/estimativa_preco_model");

                        $resposta = $this->estimativa_preco_model->selecionarResposta($notificacao['id_objeto']);

                        if ($resposta['nm_empresa'] != ''):

                            $dados['notificacoes'][$i]['titulo'] = $resposta['nm_empresa'];
                            $dados['notificacoes'][$i]['imagem'] = ($resposta['logo_vendedor'] != '') ? "arquivos/logos/" . $resposta['logo_vendedor'] : base_url() . TEMPLATE . "/img/logoEmpresaP.jpg";

                        else:

                            $dados['notificacoes'][$i]['titulo'] = "Portal ARP";
                            $dados['notificacoes'][$i]['imagem'] = base_url() . TEMPLATE . "/img/logo_parte.png";

                        endif;

                        $dados['notificacoes'][$i]['texto'] = "respondeu sua <b>estimativa de preço</b>: \"" . substr($resposta['mensagem_resposta'], 0, 30) . "...\"";


                        break;
                endswitch;

            else:    
                
                $dados['notificacoes'][$i]['ds_notificacao'] = $notificacao['ds_notificacao'];
                
            endif;

        endforeach;


        unset($busca);
        $busca['id_usuario'] = usuario('id_usuario');
        $busca['st_lido'] = '0';
        $busca['objeto'] = true;
        $dados['nao_lidas'] = count($this->notificacao_model->selecionarNotificacoes($busca));

        $this->load->view("inicial/portlets/notificacoes_view", $dados);
    }

    function usuarios_online() {

        //checa_logado();

        /**
         * Vamos usuários online
         */
        $this->load->model("usuario/usuario_model");

        $dados['usuarios'] = $this->usuario_model->selecionarUsuariosOnline();

        $this->load->view("inicial/portlets/usuarios_online_view", $dados);
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
?>
