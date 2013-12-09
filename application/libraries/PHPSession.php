<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of PHPSession
 *
 * @author Ivan
 */
class PHPSession {

    var $_flash = array();

    function PHPSession() {
        try {            
            session_start();
            $this->flashinit();
        } catch (Exception $e) {
            die('Caught exception: ' . $e->getMessage() . "\n");
        }


    }

    function save($var, $val, $namespace = 'default') {
        if ($var == null) {
            $_SESSION[$namespace] = $val;
        } else {
            $_SESSION[$namespace][$var] = $val;
        }
    }

    function get($var = null, $namespace = 'default') {
        if(isset($var))
            return isset($_SESSION[$namespace][$var]) ? $_SESSION[$namespace][$var] : null;
        else
            return isset($_SESSION[$namespace]) ? $_SESSION[$namespace] : null;
    }

    function clear($var = null, $namespace = 'default') {
        if(isset($var) && ($var !== null))
            unset($_SESSION[$namespace][$var]);
        else
            unset($_SESSION[$namespace]);
    }

    function flashinit() {
        $this->_flash = $this->get(null, 'flash');
        $this->clear(null, 'flash');
    }

    function flashsave($var, $val) {
        $this->save($var, $val, 'flash');
    }

    function flashget($var) {
        if (isset($this->_flash[$var])) {
            return $this->_flash[$var];
        } else {
            return null;
        }
    }
    function flashkeep($var = null) {
        if ($var != null) {
            $this->flashsave($var, $this->flashget($var));
        } else {
            $this->save(null, $this->_flash, 'flash');
        }
    }
}
?>

