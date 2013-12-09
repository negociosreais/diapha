<?php

class Proposta_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function selecionarPropostas($param) {

        $sql = "SELECT p.*
                FROM proposta p";
        
        if ($param['id_usuario'] != ""):
            $sql .= " WHERE p.id_usuario = '".$param['id_usuario']."'";
        endif;

        if (isset($param['status_proposta'])):
            $sql .= " AND p.status_proposta = ".$param['status_proposta'];
        endif;

        if (isset($param['order'])):
            $sql .= " ORDER BY ".$param['order'];
        else:
            $sql .= " ORDER BY p.dt_cadastro DESC, p.hr_cadastro DESC";
        endif;
        
        if (isset($param['limit'])):
            $sql .= " LIMIT " . $param['limit'];
        endif;
        
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    function selecionarProposta($id) {

        $sql = "SELECT p.*
                FROM proposta p
                WHERE p.id_proposta = $id";

        $query = $this->db->query($sql);

        return $query->row_array();
    }

    function inserirProposta($dados) {

        $dados['dt_cadastro'] = date("Y-m-d");
        $dados['hr_cadastro'] = date("H:i:s");

        // Monto a query
        $sql = "INSERT INTO proposta ( ";

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
            $val = addslashes($val);
            $sql .= "'$val'";
        endforeach;

        $sql .= ")";

        $this->db->query($sql);

        return $this->db->insert_id();
    }

    function atualizarProposta($dados) {

        $id_proposta = $dados['id_proposta'];

        // Monto a query
        $sql = "UPDATE proposta SET ";

        // Campos
        foreach ($dados as $key => $val) :
            $i++;
            if ($i > 1)
                $sql .= ",";
            $val = addslashes($val);
            $sql .= "$key = '$val'";
        endforeach;

        $sql .= " WHERE id_proposta = $id_proposta";

        return $this->db->query($sql);
    }

    function deletarProposta($id) {

        $sql .= " UPDATE proposta SET dt_exclusao = '" . date("Y-m-d H:i:s") . "' WHERE id_proposta = $id";

        return $this->db->query($sql);
    }
}

//fim class
?>