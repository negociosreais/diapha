<?php
/**
 * Esta classe confere o login do usuario, identidade e a senha
 * gravando os dados na session
 * @author  Secao de Informatica DCEM - LOURIVAL
 * @since 20.11.08
 * @package models
 */
class Logon_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * @method principal() M�todo que chama a aplicacao
     * @author
     * @since 20.11.08
     */
    function principal() {
        $this->load->model("tools_model");
        $this->load->model("busca_model");
        $this->load->View ( 'admin/excluirPessoa_view' );
    }

    /**
     * @method criaSession() M�todo que cria session do usuario
     * @author
     * @param $idt $senha Identidade e a senha
     * @since 19/11/2008
     */
    function criaSession($dados_form = '') {
        global $_SESSION;

        @session_start();
        // declarando pois da erro sem isso

        if( $dados_form['senha']  == ""  )  return false;

        // Busca o militar pela identidade somente se for ativo
        $dados_form['senhaMd5']  =  base64_encode(md5($dados_form['senha'],true));

        $resultSet = $this->db->query( "SELECT cd_usuario,ds_login
								from  cadunico.tb_cdu_usuario
								WHERE  ds_login='$dados_form[usuario]' 
								and  ds_senha='$dados_form[senhaMd5]' 
                " );



        $rsverif   =  $resultSet->row_array();


        // confere se houve retorno da consulta no banco
        if ($rsverif['CD_USUARIO'] > 0) {

            $_SESSION['logado']['CD_USUARIO']								= 	$rsverif["CD_USUARIO"];
            $_SESSION['logado']['DS_LOGIN']									= strtoupper( $rsverif['DS_LOGIN'] );
            $_SESSION['logado']['DS_USUARIO_LABEL']					= strtoupper( $rsverif['DS_LOGIN'] ) . ' - '  . $rsverif["CD_USUARIO"] ;


            unset($resultArea,$rsverif);
            return TRUE;

        }

        return false;

    }

    /**
     * @method recuperaSession() M�todo recupera a sessao do usuario.
     * @author
     * @since 20.11.08
     * @return Boolean
     */

    function recuperaSession() {
        if ($_SESSION['logado']['ds_login'])
            return TRUE;
        else
            return FALSE;
    }


    function validaForm() {
        if ($this->criaSession ( $_REQUEST)) {
            return TRUE;
        } else {
            if($_REQUEST['senha'])  $erro ['mensagem'] = "Login ou Senha inv�lido";
            $this->load->view ( 'login/login', $erro );
            return FALSE;
        }
    }

    function selecionaUsuario($login, $tipo = 'usuario') {

        $sql = "select * from $tipo where nm_login = '".$login."' and st_status = 'Ativo'
                and dt_exclusao is null";

        $q = $this->db->query($sql);

        return $q->row_array();

    }

    function selecionaUsuarioEmail($tipo = 'usuario', $email = '') {

        $sql = "select * from $tipo where ds_email = '".$email."' and st_status = 'Ativo' and dt_exclusao is null";

        $q = $this->db->query($sql);

        return $q->row_array();

    }

    function atualizarSenhaUsuario($email, $senha, $tipo) {

        $senhac = base64_encode(md5($senha,true));

        $sql = "UPDATE $tipo SET ds_senha = '$senhac' WHERE ds_email = '$email' AND dt_exclusao is null";

        return $this->db->query($sql);

    }

}

//fim class
?>