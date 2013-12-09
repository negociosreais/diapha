<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Set Flash Message
 *
 * Set a new flash message for the system
 *
 * @param string $type Message type, either info,sucess,error,warning
 * @param string $message Message
 * @return bool
 */
if( ! function_exists('flashMsg'))
{
	function flashMsg($tipo = NULL, $mensagem = NULL)
	{
		$obj = &get_instance();
                
		$ok = $obj->status->set($tipo, $mensagem);
	}
}

/**
 * Display status messages
 *
 * If no type has been given it will display every message,
 * otherwise it will only show and remove that certain type of
 * message
 *
 * @param string $type Error type to display
 * @return string
 */
if( ! function_exists('showStatus'))
{
	function showStatus($tipo = NULL, $print = TRUE)
	{
		$obj = &get_instance();
		return $obj->status->display($tipo, $print);
	}
}
/* End of file status_helper.php */
/* Location: ./modules/status/helpers/status_helper.php */