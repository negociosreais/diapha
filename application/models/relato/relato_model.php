<?php

class Relato_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function selecionarRelatos($param) {

        $sql = "SELECT a.*,b.ds_icones, b.nm_categoria, b.nm_apelido,
                    (SELECT count(*) FROM apoio ap WHERE ap.id_relato = a.id_relato) as apoios
                    FROM relato a
                    LEFT JOIN relato_categoria b ON b.id_categoria = a.id_categoria
                    
                WHERE 1 = 1";


        if ($param['fb_email'] != ""):
            $sql .= " AND a.fb_email = '$param[fb_email]'";
        endif;

        if ($param['categoria']):
            $i = 0;
            foreach ($param['categoria'] as $categoria):
                $i++;
                if ($i > 1):
                    $categorias .= ",";
                endif;
                $categorias .= "'$categoria'";
            endforeach;

            $sql .= " AND b.nm_apelido IN ($categorias)";

        endif;

        if ($param['nm_categoria'] != ""):
            $sql .= " AND b.nm_categoria = '$param[nm_categoria]'";
        endif;
        
        if ($param['nm_apelido'] != ""):
            $sql .= " AND b.nm_apelido = '$param[nm_apelido]'";
        endif;
        
        if ($param['st_status'] != ""):
            $sql .= " AND a.st_status = '$param[st_status]'";
        endif;

        if ($param['categorias'] != ""):

            $sql .= " AND b.nm_apelido IN (";

            $arr = explode(',', $param['categorias']);
            $i = 0;
            foreach ($arr as $a):
                if ($a == ''):
                    continue;
                endif;

                $i++;
                if ($i > 1):
                    $sql .= ",";
                endif;
                $sql .= "'$a'";
            endforeach;

            $sql .= ")";

        endif;

        if ($param['swLat'] != '' && $param['neLat'] != ''):

            //Latitude BETWEEN $southwest_lat AND $northeast_lat AND Longitude BETWEEN $southwest_lng AND $northeast_lng
            $sql .= " AND (a.ds_latitude BETWEEN {$param[swLat]} AND  {$param[neLat]} AND a.ds_longitude BETWEEN {$param[swLng]} AND  {$param[neLng]})";
        endif;

        if ($param['cidade'] != ""):

            $sql .= " AND (";

            $arr = explode(' ', $param['cidade']);
            $i = 0;
            foreach ($arr as $a):
                
                $a = str_replace(",","",$a);
                // Provisório, pois o facebook retorna Brasil com Z.
                if ($a == "Brazil"):
                    $a = "Brasil";
                endif;
                
                $i++;
                if ($i > 1):
                    $sql .= " AND ";
                endif;
                $sql .= " (a.nm_cidade like '%$a%' OR a.nm_estado like '%$a%' OR a.nm_pais like '%$a%' OR a.nm_bairro like '%$a%')";
            endforeach;

            $sql .= ")";

        endif;

        if ($param['intervalo'] != ''):
            switch ($param['intervalo']):

                case "Hoje":
                    $sql .= " AND a.dt_cadastro = '" . date("Y-m-d") . "'";
                    break;

                case "Esta semana":
                    $data = calculaData(date('d/m/Y'), "-", "day", diaSemana(date('Y-m-d')));
                    $sql .= " AND a.dt_cadastro >= '" . formataDate($data, "/") . "'";
                    break;

                case "Este mês":
                    $sql .= " AND a.dt_cadastro >= '" . date('Y-m') . "-01'";
                    break;

                case "Este ano":
                    $sql .= " AND a.dt_cadastro >= '" . date('Y') . "-01-01'";
                    break;

            endswitch;
        endif;
        
        if ($param['ano'] != ""):
            $sql .= " AND a.dt_cadastro BETWEEN '" . $param['ano'] . "-01-01' AND '" . $param['ano'] . "-12-31' ";
        endif;

        if ($param['order'] != ''):
            $sql .= " ORDER BY " . $param['order'];
        else:
            $sql .= " ORDER BY a.dt_cadastro DESC,a.hr_cadastro DESC";
        endif;
        
        if ($param['limit'] != ''):
            $sql .= " LIMIT " . $param['limit'];
        endif;
        
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    function selecionarRelato($id) {

        $sql = "SELECT a.*,b.ds_icones, b.nm_categoria, b.nm_apelido
                    FROM relato a
                    LEFT JOIN relato_categoria b ON b.id_categoria = a.id_categoria
                    
                WHERE
                    a.id_relato = $id";

        $query = $this->db->query($sql);

        return $query->row_array();
    }

    function inserirRelato($dados) {

        $dados['dt_cadastro'] = date("Y-m-d");
        $dados['hr_cadastro'] = date("H:i:s");

        // Monto a query
        $sql = "INSERT INTO relato ( ";

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

    function atualizarRelato($dados) {

        $id_relato = $dados['id_relato'];

        // Monto a query
        $sql = "UPDATE relato SET ";

        // Campos
        foreach ($dados as $key => $val) :
            $i++;
            if ($i > 1)
                $sql .= ",";
            $val = addslashes($val);
            $sql .= "$key = '$val'";
        endforeach;

        $sql .= " WHERE id_relato = $id_relato";

        return $this->db->query($sql);
    }

    function deletarRelato($id) {

        $sql .= " UPDATE relato SET dt_exclusao = '" . date("Y-m-d") . "' WHERE id_categoria = $id";

        return $this->db->query($sql);
    }
    
    /**
     * Apoio
     */
    
    function selecionarApoio($id_relato, $id_usuario) {

        $sql = "SELECT *
                    FROM apoio a
                    
                WHERE
                    a.id_relato = $id_relato AND a.id_usuario = $id_usuario";

        $query = $this->db->query($sql);

        return $query->row_array();
    }
    
    function inserirApoio($dados) {

        $dados['datahora_cadastro'] = date("Y-m-d H:i:s");

        // Monto a query
        $sql = "INSERT INTO apoio ( ";

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

}

//fim class
?>