<?php

class Categoria_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function selecionarCategorias($param) {

        $sql = "SELECT a.*, b.nm_categoria as nm_categoria_pai,
                       (SELECT count(*) FROM produto p 
                        WHERE p.id_categoria = a.id_categoria AND
                              p.dt_exclusao is null AND p.st_status = 'Ativo' AND
                              p.dt_validade >= '".date('Y-m-d')."') as qtd_produtos
                    FROM categoria a
                LEFT JOIN categoria b ON b.id_categoria = a.id_categoria_pai
                WHERE a.dt_exclusao is null";

        if ($param['status'] != "")
            $sql .= " AND a.st_status = '$param[status]'";

        if ($param['id_categoria_pai'] != ""):
            $sql .= " AND a.id_categoria_pai = '$param[id_categoria_pai]'";
        endif;
        
        if ($param['pai'] != ''):
            $sql .= " AND a.id_categoria_pai = 0";
        endif;
        
        $sql .= " ORDER BY a.nm_categoria";
        
        $query = $this->db->query($sql);

        return $query->result_array();

    }

    function selecionarCategoria($id) {

        $sql = "SELECT *
                    FROM categoria a
                    
                WHERE
                    a.id_categoria = $id
                    AND a.dt_exclusao is null";

        $query = $this->db->query($sql);

        return $query->row_array();

    }

    function selecionarCategoriaNome($nome) {

        $sql = "SELECT *
                    FROM categoria a

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

        // Trato os dados necessários
        if ($dados['id_categoria_pai'] == '')
            $dados['id_categoria_pai'] = 'NULL';

        // Monto a query
        $sql = "INSERT INTO categoria ( ";

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
        $sql = "UPDATE categoria SET ";

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

        $sql .= " UPDATE categoria SET dt_exclusao = '".date("Y-m-d")."' WHERE id_categoria = $id";

        return $this->db->query($sql);

    }

}

//fim class
?>