<?php
/**
 * Este Classe Extende Controller. Devido a necessidades do sucem e para
 * melhorar o Codigo e orientecao objeto todos os controller da aplicacao
 * Extendem agora de MY_Controller e nao do CI_Controller 
 */
class MY_Controller extends Controller {
	var $oculta = '';
	function MY_Controller() {
	
		parent::Controller ();	
		// define o formato de date e time no Oracle
		//$this->db->query("ALTER SESSION set DATE_FORMAT = 'DD/MM/YYYY'");
		$this->db->query("ALTER SESSION set NLS_DATE_FORMAT = 'DD/MM/YYYY hh24:mi:ss'");
		// charset default para o sistem
		@ini_set('default_charset','iso-8859-1');
		$this->load->helper ( array ('form', 'url' ) );
	}
	/**
	 * Metodo resposavel por:
	 * - Verifica se usu�rio esta logado
	 * - Chama o Topo e o Menu
	 * - Carrega a View
	 * - Ou caso usuario nao logado remete para tela de Login
	 * @method loadView()
	 * @since 27.12.2008
	 * @author Sgt Lemoel
	 * @param $view
	 */
	function loadView($view) {
		$data = array ();
		
		if ($this->db->simple_query() == FALSE)
			{
				$erro ['mensagem'] = "Banco de Dados do DGP fora do Ar ou Problemas de conexão.";				
				$this->load->View( 'login/login_views', $erro );
								
			} elseif ($this->session_model->recuperaSession ()) {
			
			
			if(!$this->session->userdata ['idt']) { // nao logado
				$this->load->View( 'login/login_views', $erro );
				return ;				
			}
			
			$parts = explode ( '&', $_SERVER ['QUERY_STRING'] );
			// se passou controle deveremos checar se o idlogado tem permissao
			// para o  link
			$this->load->View ( 'admin/menu' );
			// antes de testar nao vamos restringir
			$this->oculta = '';
			
					$this->load->View ( $view );
		
		} else {
			$this->load->library ( 'validation' );
			$this->load->helper ( array ('form', 'url' ) );
			$this->load->view ( 'login/login_views' );
		}
	}
	/**
	 * 
	 * @since 27.12.2008
	 * @author Sgt Lemoel
	 * @param 
	 */
	function checa_link($c, $view = '') {
		$retorno = false;
		// todos poderam ver a principal view
		#
		$partsQstring = explode("/", $view);
		$sizeOfParts = sizeof($partsQstring);
		
		$view = ($sizeOfParts ==1) ? $partsQstring[0] : $partsQstring[(int)$sizeOfParts -1];
		if ($view == 'inc/principal_view')
			return true;
		
		$resultado = $this->db->query ( "select C.LINK, REL.TELA  LISTAVIEWS
				 from MENUS C
				 LEFT JOIN REL_MENU_USUARIO REL ON REL.ID_MENU=C.ID_MENU
				 WHERE 
				  REL.ID_USUARIO='" . $this->session->userdata ['idt'] . "'
				  AND  C.LINK LIKE '%" . str_replace ( '?', '', $c ) . "%' 
				  ORDER BY REL.TELA DESC " );
		//jsRestringirPagina 
		$rs = $resultado->result_array ();
		@$rowLink 		 	= '';
		@$concatenadas 		= '';
		foreach($rs as $key => $row){
		     @$rowLink 			=  $row['LINK'];
			 @$concatenadas 	.=  "  " .$row['LISTAVIEWS'];
		}
		// se 1 vamos restringir a pagina
		$this->oculta = (!empty($concatenadas) && eregi(trim($view) , trim($concatenadas))) ? ' style="display:block" ' : ' style="display:none"';
		$retorno = (isset($rowLink)) ? true : false;
		return $retorno;
	}
}
?>