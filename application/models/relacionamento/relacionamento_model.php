<?php

class Relacionamento_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function selecionarRelacionamento($param) {
        
        $sql = "SELECT * FROM relacionamento rel
                WHERE rel.dt_exclusao is null ";
        
        if ($param['id_entidade'] != ""):
            $sql .= " AND rel.id_entidade = $param[id_entidade]";
        endif;
        if ($param['entidade'] != ""):
            $sql .= " AND rel.entidade = '$param[entidade]'";
        endif;
        if ($param['id_usuario'] != ""):
            $sql .= " AND rel.id_usuario = $param[id_usuario]";
        endif;
        if ($param['relacao'] != ""):
            $sql .= " AND rel.relacao = '$param[relacao]'";
        endif;
        
        $query = $this->db->query($sql);

        return $query->result_array();
        
    }

    function inserirRelacionamento($dados) {

        // Monto a query
        $sql = "INSERT INTO relacionamento ( ";

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

        return $this->db->query($sql);

    }
    
    function deletarRelacionamento($param) {

        $sql .= " UPDATE relacionamento SET dt_exclusao = '" . date("Y-m-d") . "' 
                  WHERE id_entidade = $param[id_entidade] 
                        AND entidade = '$param[entidade]' 
                        AND id_usuario = $param[id_usuario] 
                        AND relacao = '$param[relacao]' ";

        return $this->db->query($sql);
    }


}

//fim class
?>