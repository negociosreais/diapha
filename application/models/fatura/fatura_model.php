<?php

class Fatura_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function selecionarFaturas($param) {

        $sql = "SELECT a.*, v.nm_empresa, p.nm_plano, p.nr_valor as valor_plano, p.ds_tipo
                    FROM fatura a
                LEFT JOIN vendedor v ON v.id_vendedor = a.id_vendedor
                LEFT JOIN plano p ON p.id_plano = a.id_plano
                WHERE a.dt_exclusao is null";

        if ($param['st_status'] != "")
            $sql .= " AND a.st_status = '$param[st_status]'";

        if ($param['id_vendedor'] != "")
            $sql .= " AND a.id_vendedor = '$param[id_vendedor]'";

        $sql .= " ORDER BY a.dt_fatura DESC";

        $query = $this->db->query($sql);

        return $query->result_array();

    }

    function selecionarFatura($id) {

        $sql = "SELECT *
                    FROM fatura a
                    
                WHERE
                    a.id_fatura = $id
                    AND a.dt_exclusao is null";

        $query = $this->db->query($sql);

        return $query->row_array();

    }

    function inserirFatura($dados) {

        // Retiro os dados desnecessários
        unset($dados['btn_gravar']);

        // Trato os dados necessários
        $dados['dt_fatura'] = formataDate($dados['dt_fatura'], "/");

        // Monto a query
        $sql = "INSERT INTO fatura ( ";

        // Campos
        foreach ($dados as $key=>$val) :
            $i++;
            if ($i > 1) $sql .= ",";
            $sql .= "$key";
        endforeach;

        $sql .= ") VALUES (";

        // Valores
        $i = 0;
        foreach ($dados as $key=>$val) :
            $i++;
            if ($i > 1) $sql .= ",";
            $val = addslashes($val); $sql .= "'$val'";
        endforeach;

        $sql .= ")";

        $this->db->query($sql);

        return $this->db->insert_id();

    }

    function atualizarFatura($dados) {

        $id_fatura = $dados['id_fatura'];
        
        // Retiro os dados desnecessários
        unset($dados['btn_gravar']);
        unset($dados['id_fatura']);

        // Trata os dados
        if (isset($dados['dt_fatura']))
            $dados['dt_fatura'] = formataDate($dados['dt_fatura'], "/");

        $dados['dt_alteracao'] = date("Y-m-d");

        // Monto a query
        $sql = "UPDATE fatura SET ";

        // Campos
        foreach ($dados as $key=>$val) :
            $i++;
            if ($i > 1) $sql .= ",";
            $val = addslashes($val); $sql .= "$key = '$val'";
        endforeach;

        $sql .= " WHERE id_fatura = $id_fatura";

        return $this->db->query($sql);

    }

    function deletarFatura($id) {

        $sql .= " UPDATE fatura SET dt_exclusao = '".date("Y-m-d")."' WHERE id_fatura = $id";

        if ($this->db->query($sql)) {
            $sql = "DELETE FROM credito WHERE id_fatura = $id";
            return $this->db->query($sql);
        }


    }

    /**
     * PagSeguro
     */

    function inserirPagseguro($dados) {

        // Retiro os dados desnecessários
        //unset($dados['btn_gravar']);

        // Trato os dados necessários
        

        // Monto a query
        $sql = "INSERT INTO pagseguro ( ";

        // Campos
        foreach ($dados as $key=>$val) :
            $i++;
            if ($i > 1) $sql .= ",";
            $sql .= "$key";
        endforeach;

        $sql .= ") VALUES (";

        // Valores
        $i = 0;
        foreach ($dados as $key=>$val) :
            $i++;
            if ($i > 1) $sql .= ",";
            $val = addslashes($val); $sql .= "'$val'";
        endforeach;

        $sql .= ")";

        $this->db->query($sql);

        return $this->db->insert_id();

    }

}

//fim class
?>