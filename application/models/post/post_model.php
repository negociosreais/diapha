<?php

class Post_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function selecionarPosts($busca) {

        $sql = "SELECT p.*, rel.*, 
                       c.nm_logo as logo_orgao, 
                       v.nm_logo as logo_vendedor,
                       c.nm_orgao,
                       v.nm_empresa,
                       u.nm_usuario,
                       p.id_usuario as usuario_post,
                       (SELECT count(*) FROM post_comentario pc WHERE pc.id_post = p.id_post AND pc.dt_exclusao is null) as qt_comentarios ";
                 
        if ($busca['id_usuario_seguidor'] != ""):
            $sql .= ", (SELECT count(*) FROM relacionamento rel2 WHERE 
                                                                    rel2.id_entidade = p.id_post
                                                                    AND rel2.entidade = 'post'
                                                                    AND rel2.relacao = 'seguidor'
                                                                    AND rel2.id_usuario = $busca[id_usuario_seguidor]
                                                                    AND rel2.dt_exclusao is null) as seguidor ";
        endif;
        
        $sql .= "FROM post p
                    LEFT JOIN relacionamento rel ON rel.id_usuario = p.id_usuario AND rel.id_entidade = p.id_empresa
                    LEFT JOIN orgao c ON c.id_orgao = rel.id_entidade AND rel.entidade = 'orgao'
                    LEFT JOIN vendedor v ON v.id_vendedor = rel.id_entidade AND rel.entidade = 'vendedor'
                    LEFT JOIN usuario u ON u.id_usuario = p.id_usuario
                WHERE p.dt_exclusao is null";

        if ($busca['id_post'] != ""):
            $sql .= " AND p.id_post = '$busca[id_post]'";
        endif;
        
        if ($busca['id_usuario'] != ""):
            $sql .= " AND p.id_usuario = '$busca[id_usuario]'";
        endif;
        
        if ($busca['id_seguidor'] != ""):
            $sql .= " AND 0 < (SELECT count(*) FROM relacionamento rel2 WHERE 
                                                                    rel2.id_entidade = p.id_post
                                                                    AND rel2.entidade = 'post'
                                                                    AND rel2.relacao = 'seguidor'
                                                                    AND rel2.id_usuario = $busca[id_seguidor]
                                                                    AND rel2.dt_exclusao is null)";
        endif;

        if ($busca['order'] != ''):
            $sql .= " ORDER BY " . $busca['order'];
        endif;
        
        if ($busca['limit'] != ''):
            $sql .= " LIMIT " . $busca['limit'];
        endif;
        
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    function selecionarPost($id) {

        $sql = "SELECT *
                    FROM post p
                    
                WHERE
                    p.id_post = $id
                    AND p.dt_exclusao is null";

        $query = $this->db->query($sql);

        return $query->row_array();
    }
    
    function selecionarSeguidores($id) {
        
        $sql = "SELECT p.*, rel.*, u.*
                FROM post p
                    INNER JOIN relacionamento rel ON rel.id_entidade = p.id_post
                                                    AND rel.entidade = 'post'
                                                    AND rel.relacao = 'seguidor'
                                                    AND rel.dt_exclusao is null
                    INNER JOIN usuario u ON u.id_usuario = rel.id_usuario
                    
                 WHERE p.dt_exclusao is null AND p.id_post = $id";
        
        $query = $this->db->query($sql);

        return $query->result_array();
        
    }

    function inserirPost($dados) {

        // Retiro os dados desnecessários
        unset($dados['btn_gravar']);
        $dados['datahora_cadastro'] = date("Y-m-d H:i:s");
        
        // Trato os dados necessários
        // Monto a query
        $sql = "INSERT INTO post ( ";

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

    function atualizarPost($dados) {

        $id_post = $dados['id_post'];

        // Retiro os dados desnecessários
        unset($dados['btn_gravar']);
        unset($dados['id_post']);

        // Monto a query
        $sql = "UPDATE post SET ";

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

        $sql .= " WHERE id_post = $id_post";

        return $this->db->query($sql);
    }

    function deletarPost($id, $id_usuario) {

        if ($id_usuario == ''):
            $id_usuario = usuario('id_usuario');
        endif;
        
        $sql .= " UPDATE post SET dt_exclusao = '" . date("Y-m-d") . "', user_exclusao = " . $id_usuario . " WHERE id_post = $id";

        return $this->db->query($sql);
    }

    // Comentários
    function inserirComentario($dados) {

        // Retiro os dados desnecessários
        unset($dados['btn_gravar']);
        $dados['datahora_cadastro'] = date("Y-m-d H:i:s");

        // Trato os dados necessários
        // Monto a query
        $sql = "INSERT INTO post_comentario ( ";

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
    
    function selecionarComentarios($busca) {

        $sql = "SELECT cp.*, rel.id_entidade, rel.entidade, rel.relacao, 
                       c.nm_logo as logo_orgao, 
                       v.nm_logo as logo_vendedor,
                       c.nm_orgao,
                       v.nm_empresa,
                       u.nm_usuario,
                       u.nm_foto
                    FROM post_comentario cp
                    LEFT JOIN relacionamento rel ON rel.id_usuario = cp.id_usuario AND rel.id_entidade = cp.id_empresa
                    LEFT JOIN orgao c ON c.id_orgao = rel.id_entidade AND rel.entidade = 'orgao'
                    LEFT JOIN vendedor v ON v.id_vendedor = rel.id_entidade AND rel.entidade = 'vendedor'
                    LEFT JOIN usuario u ON u.id_usuario = cp.id_usuario
                WHERE cp.dt_exclusao is null";

        if ($busca['id_post'] != ""):
            $sql .= " AND cp.id_post = '$busca[id_post]'";
        endif;

        if ($busca['order'] != ''):
            $sql .= " ORDER BY " . $busca['order'];
        endif;

        $query = $this->db->query($sql);

        return $query->result_array();
    }
    
    function selecionarComentario($busca) {

        $sql = "SELECT cp.*, rel.id_entidade, rel.entidade, rel.relacao, 
                       c.nm_logo as logo_orgao, 
                       v.nm_logo as logo_vendedor,
                       c.nm_orgao,
                       v.nm_empresa,
                       u.nm_usuario,
                       u.nm_foto
                    FROM post_comentario cp
                    LEFT JOIN relacionamento rel ON rel.id_usuario = cp.id_usuario AND rel.id_entidade = cp.id_empresa
                    LEFT JOIN orgao c ON c.id_orgao = rel.id_entidade
                    LEFT JOIN vendedor v ON v.id_vendedor = rel.id_entidade
                    LEFT JOIN usuario u ON u.id_usuario = cp.id_usuario
                WHERE cp.dt_exclusao is null";

        if ($busca['id_comentario'] != ""):
            $sql .= " AND cp.id_comentario = '$busca[id_comentario]'";
        endif;
        
        if ($busca['id_usuario'] != ""):
            $sql .= " AND cp.id_usuario = '$busca[id_usuario]'";
        endif;

        if ($busca['order'] != ''):
            $sql .= " ORDER BY " . $busca['order'];
        endif;

        $query = $this->db->query($sql);

        return $query->row_array();
    }
    
    function deletarComentario($id, $id_usuario) {

        if ($id_usuario == ''):
            $id_usuario = usuario('id_usuario');
        endif;
        
        $sql .= " UPDATE post_comentario SET dt_exclusao = '" . date("Y-m-d") . "', user_exclusao = " . $id_usuario . " WHERE id_comentario = $id";

        return $this->db->query($sql);
    }
    

}

//fim class
?>