<?php

/**
 *
 * @since Jun2010
 * @author Rafael
 * @return
 * @package models
 * */
class menu_model extends CI_Model {

    function __construct() {
        parent::__construct();

        $this->gerar_menu();
    }

    /**
     * Gerar Menu de acordo com as permiss�es do usuario
     * @method gerar_menu
     * @author  Rafael
     * @since 06-07-2010
     */
    function gerar_menu() {

        if ($this->checar_permissao("CESTA_VERDE",$_SESSION['profamilia']['usuario']['NO_LOGIN'])){

            echo "<li><a href='#'>CESTA VERDE</a>
                    <ul>
                        <li>
                            <a href='?c=cestaVerde&m=listar'>Relat�rio de Benefici�rios </a>
                        </li>
                    </ul>
                  </li>";

        }

        if ($this->checar_permissao("PAO_LEITE",$_SESSION['profamilia']['usuario']['NO_LOGIN'])){

            echo "<li><a href='#'>P�O E LEITE</a>
                    <ul>
                        <li>
                            <a href='?c=paoLeite&m=lancar'>Lan�ar Fornecimento/Distribui��o</a>
                        </li>";

            if ($this->checar_permissao("PAO_LEITE_INCONSISTENCIAS",$_SESSION['profamilia']['usuario']['NO_LOGIN']))
                echo "  <li>
                            <a href='?c=paoLeite&m=listar_inconsistencias'>Corrigir Inconsist�ncias</a>
                        </li>";

            echo "
                        <li>
                            <a href='?c=paoLeite&m=listar_memorandos'>Memorandos</a>
                        </li>
                        <li>
                            <a href='?c=paoLeite&m=listar_relatorio'>Relat�rio de Benefici�rios</a>
                        </li>
                    </ul>
                  </li>";

        }

        if ($this->checar_permissao("RELATORIOS",$_SESSION['profamilia']['usuario']['NO_LOGIN'])){

            echo "<li><a href='?c=busca&m=relatorio'>RELAT�RIOS</a>
                  </li>";

        }

    }

    /**
     * @method checar_permissao
     * @author Rafael Menezes
     * @since julho 2010
     * @param <string> $menu
     * @param <string> $usuario
     * @return <bool>
     */
    function checar_permissao($menu,$usuario) {
        $fd = fopen("permissoes.txt", "r");
        while (!feof($fd)) {
            $buffer = fgets($fd, 4096);
            $lines[] = $buffer;
        }
        fclose($fd);

        foreach ($lines as $line) {
            $m_exp = explode(" ",trim($line));

            if (in_array($menu,$m_exp) && in_array($usuario,$m_exp)){
                return true;
            }
        }

        return false;
    }

}
?>