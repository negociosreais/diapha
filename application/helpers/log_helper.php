<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


if (!function_exists('gravaAcessoProduto')) {

    function gravaAcessoProduto($param) {

        $ci = & get_instance();

        // Vamos carregar o model e gravar o log
        $ci->load->model('produto_acesso/produto_acesso_model');
        $ci->load->model('credito/credito_model');
        $ci->load->model('produto/produto_model');

        $dados['dt_acesso'] = date("Y-m-d");
        $dados['hr_acesso'] = date("H:i:s");
        $dados['ip_acesso'] = $_SERVER['REMOTE_ADDR'];
        $dados['id_orgao'] = ($param['id_orgao'] != '') ? $param['id_orgao'] : usuario('id_orgao');
        $dados['id_produto'] = $param['id_produto'];
        $dados['id_ata_importada_item'] = $param['id_ata_importada_item'];
        $dados['id_usuario'] = usuario('id_usuario');
        $dados['tp_arquivo'] = $param['tp_arquivo'];

        // Antes de gravar o lead vamos verificar se este orgao já acessou este produto hoje
        $ja_acessou = $ci->produto_acesso_model->selecionarProdutoAcessoOrgao($dados['id_produto'], $dados['id_orgao'], $dados['id_ata_importada_item']);

        // Vamos verificar também se o Vendedor possui créditos
        $produto = $ci->produto_model->selecionarProduto($param['id_produto']);

        if ($produto):
            $qt_creditos = $ci->credito_model->contarCreditos($produto['id_vendedor'], NULL, 'Leads');
        endif;

        // Só deverá gerar leads para o Vendedor se o mesmo pagou pelo anúncio do produto
        //if ($produto['st_anunciado_gratis'] == 0) :
        // Se o produto ainda não foi acessado e a empresa possui créditos ou tem permissão para o serviço
        if (!$ja_acessou && ($qt_creditos > 0 || checa_permissao_servico('3', false, false, $produto['id_vendedor']))):

            $dados['st_lead'] = 1;
            $credito['id_vendedor'] = $produto['id_vendedor'];
            $credito['qt_credito'] = '-1';
            $credito['ds_tipo'] = "Leads";
            $ci->credito_model->descontarCredito($credito); 

        endif;
        //endif;

        $id = $ci->produto_acesso_model->inserirProdutoAcesso($dados);
        
        // Vamos notificar a empresa do lead
        if (!$ja_acessou && $produto):

            $ci->load->model('usuario/usuario_model');
            $ci->load->model('notificacao/notificacao_model');

            unset($param);
            $param['entidade'] = 'vendedor';
            $param['id_entidade'] = $produto['id_vendedor'];
            $param['st_status'] = "Ativo";
            $equipe = $ci->usuario_model->selecionarEquipe($param);

            if ($equipe && $param['id_vendedor'] != ''):
                foreach ($equipe as $e):

                    $notificacao['id_usuario'] = $e['id_usuario'];
                    $notificacao['ds_notificacao'] = "Uma nova oportunidade está disponível.<br>Isso significa que um Órgão ou Empresa Pública acessou um de seus produtos e pode estar interessado na adesão.";
                    $notificacao['ds_url'] = "produto_acesso/detalhes/" . $id;
                    $notificacao['id_entidade'] = $e['id_entidade'];
                    $notificacao['entidade'] = $e['entidade'];
                    $notificacao['ds_email'] = $e['ds_email'];
                    $notificacao['nm_usuario'] = $e['nm_usuario'];
                    $notificacao['id_objeto'] = $id;
                    $notificacao['objeto'] = "produto_acesso";

                    $ci->notificacao_model->inserirNotificacao($notificacao);

                endforeach;
            endif;


        endif;
    }

}



/* End of file combo_helper.php */
/* Location: ./system/helpers/form_helper.php */
?>