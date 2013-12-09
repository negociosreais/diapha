<?php

class Relato_Categoria_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function selecionarCategorias($param) {

        $sql = "SELECT a.*
                    FROM relato_categoria a
                
                WHERE a.dt_exclusao is null";

        if ($param['status'] != ""):
            $sql .= " AND a.st_status = '$param[status]'";
        endif;
        
        if ($param['nm_apelido'] != ""):
            $sql .= " AND a.nm_apelido = '$param[nm_apelido]'";
        endif;

        $sql .= " ORDER BY a.nm_categoria";
        
        $query = $this->db->query($sql);

        return $query->result_array();

    }

    function selecionarCategoria($id) {

        $sql = "SELECT *
                    FROM relato_categoria a
                    
                WHERE
                    a.id_categoria = $id
                    AND a.dt_exclusao is null";

        $query = $this->db->query($sql);

        return $query->row_array();

    }

    function selecionarCategoriaNome($nome) {

        $sql = "SELECT *
                    FROM relato_categoria a

                WHERE
                    a.nm_categoria = '$nome'
                    AND a.dt_exclusao is null";

        echo $sql;

        $query = $this->db->query($sql);

        return $query->row_array();

    }

    function inserirCategoria($dados) {

        // Retiro os dados desnecessários
        unset($dados['btn_gravar']);

        // Monto a query
        $sql = "INSERT INTO relato_categoria ( ";

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

    function atualizarCategoria($dados) {

        $id_categoria = $dados['id_categoria'];
        
        // Retiro os dados desnecessários
        unset($dados['btn_gravar']);
        unset($dados['id_categoria']);

        // Monto a query
        $sql = "UPDATE relato_categoria SET ";

        // Campos
        foreach ($dados as $key=>$val) :
            $i++;
            if ($i > 1) $sql .= ",";
            $val = addslashes($val); $sql .= "$key = '$val'";
        endforeach;

        $sql .= " WHERE id_categoria = $id_categoria";

        return $this->db->query($sql);

    }

    function deletarCategoria($id) {

        $sql .= " UPDATE relato_categoria SET dt_exclusao = '".date("Y-m-d")."' WHERE id_categoria = $id";

        return $this->db->query($sql);

    }

}

//fim class
?>