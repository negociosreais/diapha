<?php

class Usuario_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function selecionarUsuario($param) {

        $sql = "SELECT
                        u.*,
                        r.id_entidade, r.entidade, r.relacao, r.st_aceito,
                        c.id_orgao,
                        c.nm_orgao,
                        c.cd_confirmacao as com_confirmacao,
                        c.nm_foto as com_logo,
                        c.st_status as st_orgao,
                        c.nm_cidade as com_cidade,
                        c.nm_estado as com_estado,
                        c.dt_acesso_inicio,
                        c.dt_acesso_fim
                FROM usuario u
                
                LEFT JOIN relacionamento r ON r.id_usuario = u.id_usuario AND r.entidade = 'orgao' AND r.st_aceito = 1
                LEFT JOIN orgao c ON c.id_orgao = r.id_entidade AND r.entidade = 'orgao'
                WHERE u.dt_exclusao is null AND c.dt_exclusao is null";

        if ($param['id_usuario'] != ''):
            $sql .= " AND u.id_usuario = '" . $param['id_usuario'] . "'";
        endif;
        if ($param['nm_login'] != ''):
            $sql .= " AND u.nm_login = '" . $param['nm_login'] . "'";
        endif;
        if ($param['ds_senha'] != ''):
            $sql .= " AND u.ds_senha = '" . $param['ds_senha'] . "'";
        endif;
        if ($param['ds_email'] != ''):
            $sql .= " AND u.ds_email = '" . $param['ds_email'] . "'";
        endif;
        if ($param['st_status'] != ''):
            $sql .= " AND u.st_status = '$param[st_status]'";
        endif;
        if ($param['email_facebook'] != ''):
            $sql .= " AND u.email_facebook = '$param[email_facebook]'";
        endif;

        $q = $this->db->query($sql);

        return $q->row_array();
    }

    function selecionarUsuarios($param) {

        $sql = "SELECT
                        u.*, r.id_entidade, r.entidade, r.relacao, r.st_aceito, r.dt_cadastro,
                        c.id_orgao,
                        c.nm_orgao,
                        c.cd_confirmacao as com_confirmacao
                FROM usuario u
                
                LEFT JOIN relacionamento r ON r.id_usuario = u.id_usuario AND r.entidade = 'orgao' AND r.st_aceito = 1 AND r.dt_exclusao is null
                LEFT JOIN orgao c ON c.id_orgao = r.id_entidade AND r.entidade = 'orgao' AND c.dt_exclusao is null
                WHERE u.dt_exclusao is null";

        if ($param['nm_login'] != ''):
            $sql .= " AND u.nm_login = '" . $param['nm_login'] . "'";
        endif;
        if ($param['ds_email'] != ''):
            $sql .= " AND u.ds_email = '" . $param['ds_email'] . "'";
        endif;
        if ($param['entidade']):
            $sql .= " AND r.entidade = '{$param[entidade]}'";
        endif;
        if ($param['id_entidade']):
            $sql .= " AND r.id_entidade = '{$param[id_entidade]}'";
        endif;
        if ($param['atendimento_online']):
            $sql .= " AND atendimento_online = '{$param[atendimento_online]}'";
        endif;
        if ($param['tipos'] != ""):
            $sql .= " AND u.tp_usuario IN ({$param[tipos]})";
        endif;
        if ($param['busca'] != ""):
            $sql .= " AND (u.nm_login like '%" . $param['busca'] . "%'
                      OR u.nm_usuario like '%" . $param['busca'] . "%' 
                      OR u.ds_email like '%" . $param['busca'] . "%')";
        endif;

        $sql .= " ORDER BY u.datahora_cadastro DESC";

        $q = $this->db->query($sql);

        return $q->result_array();
    }

    function selecionarEquipe($param) {

        $sql = "SELECT
                        u.*,
                        r.id_entidade, r.entidade, r.relacao, r.st_aceito
                FROM usuario u
                INNER JOIN relacionamento r ON r.id_usuario = u.id_usuario AND r.entidade = 'orgao' AND r.st_aceito = 1 AND r.dt_exclusao is null
                WHERE u.dt_exclusao is null AND u.st_status = 'Ativo'";


        if ($param['entidade'] != ''):
            $sql .= " AND r.entidade = '" . $param['entidade'] . "'";
        endif;

        if ($param['id_entidade'] != ''):
            $sql .= " AND r.id_entidade = '" . $param['id_entidade'] . "'";
        endif;

        if ($param['st_status'] != ''):
            $sql .= " AND u.st_status = '" . $param['st_status'] . "'";
        endif;

        $q = $this->db->query($sql);

        return $q->result_array();
    }

    function inserirUsuario($dados) {

        // Pego os dados do usuário
        $dado['nm_usuario'] = $dados['nm_usuario'];
        $dado['dt_nascimento'] = formataDate($dados['dt_nascimento'], "/");
        $dado['ds_sexo'] = $dados['ds_sexo'];
        $dado['nr_telefone'] = $dados['nr_telefone'];
        $dado['nr_celular'] = $dados['nr_celular'];
        $dado['ds_email'] = $dados['ds_email'];
        $dado['tp_usuario'] = $dados['tp_usuario'];
        $dado['nm_login'] = $dados['nm_login'];
        $dado['ds_senha'] = base64_encode(md5($dados['ds_senha'], true));
        $dado['st_status'] = (isset($dados['st_status'])) ? $dados['st_status'] : "Ativo";
        $dado['datahora_cadastro'] = date("Y-m-d H:i:s");
        $dado['email_facebook'] = $dados['email_facebook'];
        $dado['fb_user'] = $dados['fb_user'];
        
        // Monto a query
        $sql = "INSERT INTO usuario ( ";

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

    function atualizarUsuario($dados) {

        $id_usuario = $dados['id_usuario'];

        // Pego os dados do usuário
        $dado['nm_usuario'] = $dados['nm_usuario'];
        $dado['dt_nascimento'] = formataDate($dados['dt_nascimento'], "/");
        $dado['ds_sexo'] = $dados['ds_sexo'];
        $dado['nr_telefone'] = $dados['nr_telefone'];
        $dado['nr_celular'] = $dados['nr_celular'];
        $dado['ds_email'] = $dados['ds_email'];
        $dado['nm_login'] = $dados['nm_login'];
        $dado['st_status'] = $dados['st_status'];
        $dado['st_receber_email'] = (isset($dados['st_receber_email'])) ? 1 : 0;
        if ($dados['nm_foto'] != ''):
            $dado['nm_foto'] = $dados['nm_foto'];
        endif;

        // Trato os dados necessários
        if ($dados['ds_senha'] != ""):
            $dado['ds_senha'] = base64_encode(md5($dados['ds_senha'], true));
        endif;

        // Monto a query
        $sql = "UPDATE usuario SET ";

        // Campos
        foreach ($dado as $key => $val) :
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

        $sql .= " WHERE id_usuario = $id_usuario";

        return $this->db->query($sql);
    }

    function atualizarAtendimentoOnline($dados) {

        $id_usuario = $dados['id_usuario'];

        unset($dados['id_usuario']);

        // Monto a query
        $sql = "UPDATE usuario SET ";

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

        $sql .= " WHERE id_usuario = $id_usuario";


        return $this->db->query($sql);
    }

    function selecionarUsuarioEmail($email = '') {

        $sql = "select * from usuario where ds_email = '" . $email . "' and st_status = 'Ativo' and dt_exclusao is null";

        $q = $this->db->query($sql);

        return $q->row_array();
    }

    function atualizarSenhaUsuario($email, $senha) {

        $senhac = base64_encode(md5($senha, true));

        $sql = "UPDATE usuario SET ds_senha = '$senhac' WHERE ds_email = '$email' AND dt_exclusao is null";

        return $this->db->query($sql);
    }

    function atualizarReceberEmail($id) {

        $sql = "UPDATE usuario SET st_receber_email = 0 WHERE id_usuario = '$id'";

        return $this->db->query($sql);
    }
    
    function atualizarEmailFacebook($id, $email) {

        $sql = "UPDATE usuario SET email_facebook = '$email' WHERE id_usuario = '$id'";

        return $this->db->query($sql);
    }
    
    function atualizarPreferencias($id, $preferencias) {

        $sql = "UPDATE usuario SET ds_preferencias = '$preferencias' WHERE id_usuario = '$id'";

        return $this->db->query($sql);
    }

    function deletarUsuario($id) {

        $sql .= " UPDATE usuario SET dt_exclusao = '" . date("Y-m-d") . "' WHERE id_usuario = $id";

        return $this->db->query($sql);
    }

    function criarRelacionamentosOrgao() {

        $sql = "SELECT *
                    FROM orgao c";

        $query = $this->db->query($sql);
        $orgaoes = $query->result_array();

        if ($orgaoes):
            foreach ($orgaoes as $orgao):

                if ($orgao['id_usuario'] == ''):
                    continue;
                endif;

                // vamos inserir o usuaário
                $dt_exclusao = ($orgao['dt_exclusao'] == '') ? "NULL" : "'$orgao[dt_exclusao]'";

                $sql = "INSERT INTO relacionamento (id_usuario, id_entidade, entidade, relacao, st_aceito, dt_exclusao )";
                $sql .= " VALUES ('$orgao[id_usuario]','$orgao[id_orgao]','orgao', 'gestor',1, $dt_exclusao)";

                echo $sql . "<br>";
                $this->db->query($sql);

            endforeach;
        endif;
    }

    function usuarioOnline() {

        $ip = $_SERVER['REMOTE_ADDR'];

        $datahora = date("Y-m-d H:i:s", time("Y-m-d H:i:s"));
        $timestamp = time();

        // Se for operador ou admin vamos verificar se estão disponíveis para atendimento online
        if (checa_permissao(array('admin', 'operador'), true)):
            $status = usuario('atendimento_online');
        else:
            $status = '1';
        endif;

        // Selecionamos o usuário
        $query = $this->db->query("SELECT * FROM usuario_online WHERE id_usuario = '" . usuario('id_usuario') . "'");

        if ($query->result_array()) :

            $this->db->query("UPDATE usuario_online SET time='" . $datahora . "',status='" . $status . "' WHERE id_usuario = '" . usuario('id_usuario') . "'");

        elseif (usuario('id_usuario') != '') :

            $sql = "INSERT usuario_online (id_usuario, ip ,time, status) VALUES ('" . usuario('id_usuario') . "','$ip','$datahora' ,'" . $status . "')";

            $this->db->query($sql);

        endif;

        $tempmins = ($tempmins) ? $tempmins : 10;

        $sql = "DELETE FROM usuario_online WHERE time < '" . date("Y-m-d G:i:s", $timestamp - ($tempmins * 60)) . "'";

        $this->db->query($sql);
    }

    function selecionarUsuarioOnline($id_usuario) {

        // Selecionamos o usuário
        $query = $this->db->query("SELECT * FROM usuario_online WHERE id_usuario = '$id_usuario'");

        return $query->result_array();
    }

    function selecionarUsuariosOnline($param) {

        $sql = "SELECT u.*, uo.*, c.nm_orgao, r.* 
                FROM usuario_online uo
                LEFT JOIN usuario u ON u.id_usuario = uo.id_usuario
                LEFT JOIN relacionamento r ON r.id_usuario = u.id_usuario AND r.entidade = 'orgao' AND r.st_aceito = 1
                LEFT JOIN orgao c ON c.id_orgao = r.id_entidade AND r.entidade = 'orgao'
                WHERE 1 = 1 AND status = 1";

        if ($param['tp_usuarios'] != ''):
            $sql .= " AND u.tp_usuario IN ({$param[tp_usuarios]})";
        endif;


        // Selecionamos o usuário
        $query = $this->db->query($sql);

        return $query->result_array();
    }

    function deletarUsuarioOnline($id_usuario) {

        $sql = "DELETE FROM usuario_online WHERE id_usuario = {$id_usuario}";

        return $this->db->query($sql);
    }

}

//fim class
?>