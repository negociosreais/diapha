<?php

class Notificacao_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function selecionarNotificacoes($param) {

        $sql = "SELECT *
                FROM notificacao n 
                WHERE 1 = 1";

        if ($param['id_usuario'] != ''):
            $sql .= " AND n.id_usuario = '{$param[id_usuario]}'";
        endif;

        if ($param['id_entidade'] != ''):
            $sql .= " AND n.id_entidade = '{$param[id_entidade]}'";
        endif;

        if ($param['entidade'] != ''):
            $sql .= " AND n.entidade = '{$param[entidade]}'";
        endif;

        if ($param['tp_notificacao'] != ''):
            $sql .= " AND n.tp_notificacao = '{$param[tp_notificacao]}'";
        endif;

        if ($param['ds_notificacao'] != ''):
            $sql .= " AND n.ds_notificacao = '{$param[ds_notificacao]}'";
        endif;

        if ($param['st_lido'] != ''):
            $sql .= " AND n.st_lido = '{$param[st_lido]}'";
        endif;

        if ($param['objeto'] != ''):
            $sql .= " AND (n.objeto is not null AND n.id_objeto is not null)";
        endif;

        if ($param['order'] != ''):
            $sql .= " ORDER BY {$param[order]}";
        endif;

        if ($param['limit'] != ''):
            $sql .= " LIMIT {$param[limit]}";
        endif;

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    function inserirNotificacao($dados) {

        $dado = $dados;
        unset($dado['assunto']);
        
        // Vamos selecionar o usuário
        $this->load->model('usuario/usuario_model');
        $param['id_usuario'] = $dado['id_usuario'];
        $usuario = $this->usuario_model->selecionarUsuario($param);

        $dado['datahora_cadastro'] = date("Y-m-d H:i:s");
        unset($dado['nm_usuario']);

        // Monto a query
        $sql = "INSERT INTO notificacao ( ";

        // Campos
        foreach ($dado as $key => $val) :
            $i++;
            if ($i > 1)
                $sql .= ",";
            $sql .= "$key";
        endforeach;

        $sql .= ") VALUES (";

        // Valores
        $i = 0;
        foreach ($dado as $key => $val) :
            $i++;
            if ($i > 1)
                $sql .= ",";
            $val = addslashes($val);
            if ($val == ''):
                $sql .= "NULL";
            else:
                $sql .= "'$val'";
            endif;

        endforeach;

        $sql .= ")";


        try {

            $this->db->query($sql);

            $id = $this->db->insert_id();

            if ($dados['tp_notificacao'] != 'popup'):

                if ($usuario['st_receber_email'] == 1):
                    $this->_enviar_email($dados);
                endif;

            endif;
        } catch (Exception $e) {

            echo $e->getMessage();
        };

        return $id;
    }

    function atualizarNotificacao($dados) {

        $id_notificacao = $dados['id_notificacao'];

        // Retiro os dados desnecessários
        unset($dados['btn_gravar']);
        unset($dados['id_notificacao']);

        // Monto a query
        $sql = "UPDATE notificacao SET ";

        // Campos
        foreach ($dados as $key => $val) :
            $i++;
            if ($i > 1)
                $sql .= ",";
            $val = addslashes($val);
            if ($val == ''):
                $sql .= "$key = NULL";
            else:
                $sql .= "$key = '$val'";
            endif;

        endforeach;

        $sql .= " WHERE id_notificacao = $id_notificacao";

        return $this->db->query($sql);
    }

    function _enviar_email($dados) {

        $this->load->model('tools/tools_model'); 

        $email['de'] = EMAIL;
        $email['de_nome'] = "PortalArp";
        $email['para'] = $dados['ds_email'];
        //$email['para'] = "rafaelmenezes86@gmail.com";
        $email['copia_oculta'] = "contato@portalarp.com.br, rafaelmenezes86@gmail.com";
        $email['assunto'] = ($dados['assunto'] != '') ? $dados['assunto']:"Notificação Portal ARP";
        $dados['conteudo'] = "Sr(a) {$dados[nm_usuario]}, <br><br>

                {$dados[ds_notificacao]}<br><br>
                Acesse agora <a href='http://www.portalarp.com.br/login?url={$dados[ds_url]}'>www.portalarp.com.br</a> para obter mais informações.<br><br>
                        
                Att.<br>
                Portal ARP
                ";

        $email['msg'] = utf8_decode($this->load->view("email/modelo_view", $dados, TRUE));

        $this->tools_model->enviar_email($email);
    }

}

//fim class
?>