<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once APPPATH.'config/database.php';

//$banco = $db['default']['dbdriver'];
//echo $banco;



if (!function_exists('debug')) {

    function debug($array) {

        echo "<pre>";
        print_r($array);
        exit;

    }

}


/* End of file array_helper.php */
/* Location: ./system/helpers/array_helper.php */