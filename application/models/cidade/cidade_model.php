<?php

class Cidade_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function selecionarCidades($param) {

        $sql = "SELECT *
                    FROM cidade
                WHERE 1 = 1";

        if ($param['uf'] != ''):
            $sql .= " AND uf = '{$param[uf]}'";
        endif;
        
        if ($param['letra'] != ''):
            $sql .= " AND nome like '{$param[letra]}%'";
        endif;
        
        $sql .= " ORDER BY nome ASC";
        
        $query = $this->db->query($sql);

        return $query->result_array();

    }

}

//fim class
?>