<?php

class Convite_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function selecionarConvite($param) {

        $sql = "SELECT
                        *
                FROM convite c
                WHERE 1 = 1";
        
        if ($param['cd_convite'] != ''):
            $sql .= " AND c.cd_convite = '".$param['cd_convite']."'";
        endif;

        $q = $this->db->query($sql);

        return $q->row_array();
    }
    
    function selecionarConvites($param) {

        $sql = "SELECT
                        con.*, r.id_entidade, r.entidade,
                        v.nm_empresa,
                        c.nm_orgao,
                        u.nm_usuario
                        
                FROM convite con
                LEFT JOIN usuario u ON u.id_usuario = con.id_usuario
                LEFT JOIN relacionamento r ON r.id_usuario = con.id_usuario AND (r.entidade = 'vendedor' OR r.entidade = 'orgao') AND r.st_aceito = 1 AND r.dt_exclusao is null
                LEFT JOIN vendedor v ON v.id_vendedor = r.id_entidade AND r.entidade = 'vendedor' AND v.dt_exclusao is null
                LEFT JOIN orgao c ON c.id_orgao = r.id_entidade AND r.entidade = 'orgao' AND c.dt_exclusao is null
                WHERE 1 = 1";
        
        if ($param['st_aceito'] != ''):
            $sql .= " AND con.st_aceito = '".$param['st_aceito']."'";
        endif;
        
        if ($param['cd_convite'] != ''):
            $sql .= " AND con.cd_convite = '".$param['cd_convite']."'";
        endif;
        
        if ($param['ds_email'] != ''):
            $sql .= " AND con.ds_email = '".$param['ds_email']."'";
        endif;
        
        $q = $this->db->query($sql);

        return $q->result_array();
    }
    
    function inserirConvite($dado) {

        $dado['cd_convite'] = md5(date("Y-m-d H:i:s") . $dado['x']);
        
        unset($dado['x']);
        
        // Monto a query
        $sql = "INSERT INTO convite ( ";

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
            $sql .= "'$val'";
        endforeach;

        $sql .= ")";

        $this->db->query($sql);

        return $dado['cd_convite'];
    }

    function atualizarStatusConvite($cd_convite) {

        $sql = "UPDATE convite SET st_aceito = 1 WHERE cd_convite = '$cd_convite'";

        return $this->db->query($sql);
        
    }
    
    function atualizarUsuarioConvidado($cd_convite, $id_usuario) {

        $sql = "UPDATE convite SET id_usuario_convidado = $id_usuario WHERE cd_convite = '$cd_convite'";

        return $this->db->query($sql);
        
    }

}

//fim class
?>