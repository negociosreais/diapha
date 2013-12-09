<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Status Class
 *
 * Habilita a criação de mensagens de status
 *
  */
class Status {

    var $flash_var = "status";
    var $tipos = array('info','alerta','erro','sucesso');

    function Status() {
        $this->CI = &get_instance();
        $this->CI->load->helper('status');

        log_message('debug','Backend: Status class loaded');
    }

    /**
     * Setar Mensagem do Status
     *
     * A mensagem constará até chamar o método $this->display()
     *
     * @access public
     * @param string $tipo Tipo da Mensagem
     * @param string $mensagem Corpo da Mensagem
     * @return bool
     */
    function set($tipo = NULL, $mensagem = NULL) {
        if ($tipo == NULL OR $mensagem == NULL) {
            return FALSE;
        }

        // Check its a valid type
        if (!in_array($tipo, $this->tipos) ) {
            log_message('error','Backend->Status->set: Tipo de Status Inválido: ' . $tipo);
        }

        // Fetch current flashdata from session
        $data = $this->_fetch();

        // Append our message to the end if not already created
        if(!array_key_exists($tipo,$data) OR !in_array($mensagem,$data[$tipo])) {
            $data[$tipo][] = $mensagem;

            // Save the data back into the session
            $this->CI->phpsession->save($this->flash_var, serialize($data), 'status');
        }
        return TRUE;
    }

    /**
     * Display status messages
     *
     * If no type has been given it will display every message,
     * otherwise it will only show and remove that certain type of
     * message
     *
     * @access 	public
     * @param 	string $type Error type to display
     * @param 	bool $print Output to screen
     * @return 	string
     */
    function display($tipo = NULL, $print = TRUE) {
        log_message('debug','Backend->Status->display: Mostra todas as mensagens do tipo: ' . $tipo);
        // Fetch messages
        $msgdata = $this->_fetch();

        // Output variable
        $output = "";

        if ($tipo == NULL) {
        // Display all messages
            foreach ( $msgdata as $key => $mtype ) {
                $data['mensagens'] = $mtype;
                $data['tipo'] = $key;
                $output .= $this->CI->load->view('inc/status', $data, TRUE);
            }
        }
        else {
        // Only display messages of $type
            $data['mensagens'] = $msgdata[$tipo];
            $data['tipo'] = $tipo;
            $output =  $this->CI->load->view('inc/status', $data, TRUE);
        }

        // Remove messages
        $this->_remove($tipo);

        // Print/Return output
        if($print) {
            print $output;
            return;
        }
        return $output;
    }

    /**
     * Unset messages
     *
     * After a message has been shown remove it from
     * the session data.
     *
     * @access private
     * @param string $type Message type to remove
     */
    function _remove($tipo = NULL) {
        if($tipo == NULL) {
            // Unset all messages
            $this->CI->phpsession->clear($this->flash_var, 'status');
        }
        else {
        // Unset only messages with type $type
            $data = $this->_fetch();
            unset($data[$type]);
            $this->CI->phpsession->save($this->flash_var,serialize($data),'status');
        }
    }

    /**
     * Fetch flashstatus array from session
     *
     * @access private
     * @return array containing the flash data
     */
    function _fetch() {
        $data = $this->CI->phpsession->get($this->flash_var,'status');
        if (empty($data)) {
            return array();
        }
        else {
            return unserialize($data);
        }
    }
}

/* End of file Status.php */
/* Location: ./modules/status/libraries/Status.php */