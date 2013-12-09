<?php

class Orgao_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function selecionarOrgaoes($param) {

        $sql = "SELECT com.*,
                       u.id_usuario, u.nm_usuario, u.nm_login, u.ds_email,u.nr_telefone, 
                       u.nr_celular, u.nm_foto, u.tp_usuario
                    FROM orgao com
                    LEFT JOIN usuario u ON u.id_usuario = com.id_usuario
                WHERE com.dt_exclusao is null";

        /**
         * Busca
         */
        if ($param['nm_orgao'] != ''):
            $sql .= " AND com.nm_orgao like '%" . $param['nm_orgao'] . "%' ";
        endif;
        if ($param['nm_representante'] != ''):
            $sql .= " AND com.nm_representante like '%" . $param['nm_representante'] . "%' ";
        endif;
        if ($param['dt_inicio'] != ''):
            $sql .= " AND com.dt_cadastro >= '" . formataDate($param['dt_inicio'], "/") . "' ";
        endif;
        if ($param['dt_fim'] != ''):
            $sql .= " AND com.dt_cadastro <= '" . formataDate($param['dt_fim'], "/") . "' ";
        endif;
        if ($param['nm_cidade'] != ''):
            $sql .= " AND (com.nm_cidade like '%" . $param['nm_cidade'] . "%' OR com.nm_estado like '%" . $param['nm_cidade'] . "%')";
        endif;
        if ($param['nm_estado'] != ''):
            $sql .= " AND com.nm_estado = '" . $param['nm_estado'] . "'";
        endif;
        if ($param['cd_confirmacao'] != ''):
            $sql .= " AND com.cd_confirmacao = '" . $param['cd_confirmacao'] . "' ";
        endif;
        if ($param['st_status'] != ''):
            $sql .= " AND com.st_status = '" . $param['st_status'] . "' ";
        endif;

        if ($param['order'] != ''):
            $sql .= " ORDER BY " . $param['order'];
        else:
            $sql .= " ORDER BY nm_orgao, nm_representante";
        endif;


        $query = $this->db->query($sql);

        return $query->result_array();
    }

    function selecionarCidades($param) {

        $sql = "SELECT DISTINCT(com.nm_cidade)
                    FROM orgao com
                WHERE com.dt_exclusao is null";

        /**
         * Busca
         */
        if ($param['nm_estado'] != ''):
            $sql .= " AND com.nm_estado = '" . $param['nm_estado'] . "'";
        endif;
        if ($param['st_status'] != ''):
            $sql .= " AND com.st_status = '" . $param['st_status'] . "' ";
        endif;

        $sql .= " ORDER BY nm_cidade ASC";


        $query = $this->db->query($sql);

        return $query->result_array();
    }

    function selecionarOrgao($id) {

        $sql = "SELECT *
                    FROM orgao
                WHERE
                    id_orgao = $id
                    AND dt_exclusao is null";
        
        $query = $this->db->query($sql);

        return $query->row_array();
    }

    function inserirOrgao($dados) {

        // Retiro os dados desnecessários
        unset($dados['confirma_senha']);
        unset($dados['btn_gravar']);
        unset($dados['concordo']);
        unset($dados['email_confirmacao']);
        unset($dados['cadastro_mobile']);
        unset($dados['email_facebook']);
        unset($dados['ds_sexo']);
        unset($dados['dt_nascimento']);
        unset($dados['nm_login']);
        unset($dados['url']);

        // Trato os dados necessários
        $dados['ds_senha'] = base64_encode(md5($dados['ds_senha'], true));
        $dados['dt_cadastro'] = date("Y-m-d H:i:s");

        // Monto a query
        $sql = "INSERT INTO orgao ( ";

        // Campos
        foreach ($dados as $key => $val) :
            $i++;
            if ($i > 1)
                $sql .= ",";
            $sql .= "$key";
        endforeach;

        $sql .= ") VALUES (";

        // Valores
        $i = 0;
        foreach ($dados as $key => $val) :
            $i++;
            if ($i > 1)
                $sql .= ",";
            $val = trim(addslashes($val));
            if ($val == ''):
                $sql .= "NULL";
            else:
                $sql .= "'$val'";
            endif;

        endforeach;

        $sql .= ")";

        $this->db->query($sql);

        return $this->db->insert_id();
    }

    function atualizarOrgao($dados) {

        $id_orgao = $dados['id_orgao'];

        // Retiro os dados desnecessários
        unset($dados['confirma_senha']);
        unset($dados['btn_gravar']);
        unset($dados['id_orgao']);
        unset($dados['concordo']);
        unset($dados['email_confirmacao']);

        // Trato os dados necessários
        if ($dados['ds_senha'] != ""):
            $dados['ds_senha'] = base64_encode(md5($dados['ds_senha'], true));
        else:
            unset($dados['ds_senha']);
        endif;
        
        if ($dados['dt_acesso_inicio'] != ''):
            $dados['dt_acesso_inicio'] = formataDate($dados['dt_acesso_inicio'], "/");
        endif;
        
        if ($dados['dt_acesso_fim'] != ''):
            $dados['dt_acesso_fim'] = formataDate($dados['dt_acesso_fim'], "/");
        endif;

        // Monto a query
        $sql = "UPDATE orgao SET ";

        // Campos
        foreach ($dados as $key => $val) :
            $i++;
            if ($i > 1)
                $sql .= ",";
            $val = addslashes($val);
            $sql .= "$key = '$val'";
        endforeach;

        $sql .= " WHERE id_orgao = $id_orgao";

        return $this->db->query($sql);
    }

    function atualizarCampo($param) {

        $id_orgao = $param['id_orgao'];

        $dados[$param['campo']] = $param['valor'];

        // Monto a query
        $sql = "UPDATE orgao SET ";

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

        $sql .= " WHERE id_orgao = $id_orgao";

        return $this->db->query($sql);
    }

    function deletarOrgao($id) {

        $sql = " UPDATE orgao SET dt_exclusao = '" . date("Y-m-d") . "' WHERE id_orgao = $id";

        $this->db->query($sql);

        $sql = " UPDATE relacionamento SET dt_exclusao = '" . date("Y-m-d") . "' WHERE id_entidade = $id AND entidade = 'orgao'";

        return $this->db->query($sql);
    }

    function selecionarLogin($nm_login, $id = '') {

        $sql = "SELECT *
                    FROM orgao
                WHERE
                    nm_login = '$nm_login' AND dt_exclusao is null ";

        if ($id != '')
            $sql .= " AND id_orgao <> $id";

        $query = $this->db->query($sql);

        return $query->row_array();
    }

    function selecionarEmail($ds_email, $id = '') {

        $sql = "SELECT *
                    FROM orgao
                WHERE
                    ds_email = '$ds_email' AND dt_exclusao is null ";

        if ($id != '')
            $sql .= "AND id_orgao <> $id";

        $query = $this->db->query($sql);

        return $query->row_array();
    }

    function confirmarCadastro($cd_confirmacao) {

        // Monto a query
        $sql = "UPDATE orgao SET cd_confirmacao = NULL ";

        $sql .= " WHERE cd_confirmacao = '$cd_confirmacao'";

        return $this->db->query($sql);
    }

}

//fim class
?>