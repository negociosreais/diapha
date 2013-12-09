<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------


if (!function_exists('myhelper')) {

    function exibe_confirmacao($msg, $tipo) {

        $ci = & get_instance();

        if ($tipo == 'info') {

            echo "<div id='div_info'>$msg</div>";
        } elseif ($tipo == 'alert') {

            echo "<div id='div_alert'>$msg</div>";
        } elseif ($tipo == 'erro') {

            echo "<div id='div_erro'>$msg</div>";
        } else {
            echo "<div>$msg</div>";
        }
    }

    // ------------------------------------------------------------------------
    //--------------------------------------------------------------------------------
    //Formata DATA
    //--------------------------------------------------------------------------------

    function formataDate($date, $separator) {
        if ($date != '') {
            $date = explode($separator, $date);
            if ($separator == "-")
                $separator02 = "/";
            else
                $separator02 = "-";

            $date2 = $date[2] . $separator02 . $date[1] . $separator02 . $date[0];

            return $date2;
        }
    }

    //--------------------------------------------------------------------------------
    //Retorna DATA Anterior
    //--------------------------------------------------------------------------------

    function retornaDataAnterior() {

        $mes = date('m');
        $ano = date('Y');

        //PEGO O MES ANTERIOR
        if (date('m') == 1)
            $mesAnterior = 12; else
            $mesAnterior = $mes - 1;

        //SE FOR SEGUNDA-FEIRA, PEGO A DATA DA SEXTA ANTERIOR( 3 dias atraz ),
        if (date('N') == '1') {

            $data = gmdate("d/m/Y", time() - (3600 * 81));

            //SE FOR O DIA 1� DO MES PEGO O ULTIMO DIA DO MES ANTERIOR
        } else if (date('d') == 1) {

            $ultimodia = cal_days_in_month(CAL_GREGORIAN, $mesAnterior, $ano);
            $data = $ultimodia . "/" . $mesAnterior . "/" . $ano;

            //SE N�O PEGO O DIA ANTERIOR
        } else {
            $data = gmdate("d/m/Y", time() - (3600 * 27));
        }

        return $data;
    }

    /**
     * Retorna o dia da semana
     * @param type $data (Y-m-d)
     * @return type 
     */
    function diaSemana($data) {
        $ano = substr("$data", 0, 4);
        $mes = substr("$data", 5, -3);
        $dia = substr("$data", 8, 9);

        $diasemana = date("w", mktime(0, 0, 0, $mes, $dia, $ano));

        return $diasemana;
    }

    /**
     * Retorna início e fim da semana 
     * @param type $data (Y-m-d)
     */
    function semana($data) {

        $dia = diaSemana($data);

        $retorno['dt_inicio'] = formataDate(calculaData(formataDate($data, "-"), "-", "day", $dia), "/");
        $retorno['dt_fim'] = formataDate(calculaData(formataDate($data, "-"), "+", "day", 6 - $dia), "/");

        return $retorno;
    }

    //--------------------------------------------------------------------------------
    //Calcula DATA - Soma ou Subtrai dia, mes ou ano
    //--------------------------------------------------------------------------------

    function calculaData($date, $operation, $where = FALSE, $quant, $return_format = FALSE) {

        // Separa dia, m�s e ano
        list($day, $month, $year) = split("/", $date);

        // Determina a opera��o (Soma ou Subtra��o)
        ($operation == "sub" || $operation == "-") ? $op = "-" : $op = '+';

        // Determina aonde ser� efetuada a opera��o (dia, m�s, ano)
        if ($where == "day")
            $sum_day = $op . "$quant";
        if ($where == "month")
            $sum_month = $op . "$quant";
        if ($where == "year")
            $sum_year = $op . "$quant";


        // Gera o timestamp
        $date = mktime(0, 0, 0, $month + $sum_month, $day + $sum_day, $year + $sum_year);

        // Retorna o timestamp ou extended
        ($return_format == "timestamp" || $return_format == "ts") ? $date = $date : $date = date("d/m/Y", "$date");

        // Retorna a data
        return $date;
    }

    //--------------------------------------------------------------------------------
    //Entra com um numero e retorna o dia da semana abreviado
    //--------------------------------------------------------------------------------
    function nomeDiaSemana($dia) {

        switch ($dia) {
            case '1':
                return 'Seg.';
                break;
            case '2':
                return 'Ter.';
                break;
            case '3':
                return 'Qua.';
                break;
            case '4':
                return 'Qui.';
                break;
            case '5':
                return 'Sex.';
                break;
            case '6':
                return 'Sab.';
                break;
        }
    }

    function retira_acentos($texto) {
        $array1 = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
            , "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç");
        $array2 = array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
            , "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C");
        return str_replace($array1, $array2, $texto);
    }

    function retira_caracteres_especiais($string) {

        $string = str_replace("..", " ", $string);
        $string = str_replace(",", " ", $string);
        $string = str_replace("\n", " ", $string);
        $string = str_replace("(", " ", $string);
        $string = str_replace(")", " ", $string);
        $string = str_replace("{", " ", $string);
        $string = str_replace("}", " ", $string);
        $string = str_replace("[", " ", $string);
        $string = str_replace("]", " ", $string);
        $string = str_replace('"', " ", $string);
        $string = str_replace("'", " ", $string);
        $string = str_replace("*", " ", $string);
        $string = str_replace("&", " ", $string);
        $string = str_replace("!", " ", $string);
        $string = str_replace("?", " ", $string);
        $string = str_replace("<", " ", $string);
        $string = str_replace(">", " ", $string);
        $string = str_replace("#", " ", $string);
        $string = str_replace("+", " ", $string);
        $string = str_replace("=", " ", $string);
        $string = str_replace(";", " ", $string);
        $string = str_replace("_", " ", $string);
        $string = str_replace("-", " ", $string);
        $string = str_replace(".", "", $string);
        $string = str_replace("/", "", $string);

        return $string;
    }

    function formata_data_extenso($strDate) {

        $nomeMes = array(1 => 'Janeiro', 'Fevereiro', 'Mar�o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');

        $exp = explode("/", $strDate);

        $dia = $exp['0'];
        $mes = (int) $exp['1'];
        $ano = $exp['2'];

        // Formato a ser retornado
        return $dia . ' de ' . $nomeMes[$mes] . ' de ' . $ano;
    }

    function formatCPFCNPJ($string) {
        $output = ereg_replace("[' '-./ t]", '', $string);
        $size = (strlen($output) - 2);
        if ($size != 9 && $size != 12)
            return false;
        $mask = ($size == 9) ? '###.###.###-##' : '##.###.###/####-##';
        $index = -1;
        for ($i = 0; $i < strlen($mask); $i++):
            if ($mask[$i] == '#')
                $mask[$i] = $output[++$index];
        endfor;
        return $mask;
    }

    /**
     * Funcao: validaCNPJ($cnpj)
     * Sinopse: Verifica se o valor passado é um CNPJ válido
     * Retorno: Booleano
     * Autor: Gabriel Fróes - www.codigofonte.com.br
     */
    function validaCNPJ($cnpj) {
        if (strlen($cnpj) <> 18)
            return 0;
        $soma1 = ($cnpj[0] * 5) +
                ($cnpj[1] * 4) +
                ($cnpj[3] * 3) +
                ($cnpj[4] * 2) +
                ($cnpj[5] * 9) +
                ($cnpj[7] * 8) +
                ($cnpj[8] * 7) +
                ($cnpj[9] * 6) +
                ($cnpj[11] * 5) +
                ($cnpj[12] * 4) +
                ($cnpj[13] * 3) +
                ($cnpj[14] * 2);
        $resto = $soma1 % 11;
        $digito1 = $resto < 2 ? 0 : 11 - $resto;
        $soma2 = ($cnpj[0] * 6) +
                ($cnpj[1] * 5) +
                ($cnpj[3] * 4) +
                ($cnpj[4] * 3) +
                ($cnpj[5] * 2) +
                ($cnpj[7] * 9) +
                ($cnpj[8] * 8) +
                ($cnpj[9] * 7) +
                ($cnpj[11] * 6) +
                ($cnpj[12] * 5) +
                ($cnpj[13] * 4) +
                ($cnpj[14] * 3) +
                ($cnpj[16] * 2);
        $resto = $soma2 % 11;
        $digito2 = $resto < 2 ? 0 : 11 - $resto;
        return (($cnpj[16] == $digito1) && ($cnpj[17] == $digito2));
    }

    /**
     * Valida CPF
     * @param type $cpf
     * @return type boolean
     */
    function validaCPF($cpf) { // Verifiva se o número digitado contém todos os digitos
        $cpf = str_pad(ereg_replace('[^0-9]', '', $cpf), 11, '0', STR_PAD_LEFT);

        // Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
        if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999') {
            return false;
        } else {   // Calcula os números para verificar se o CPF é verdadeiro
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }

                $d = ((10 * $d) % 11) % 10;

                if ($cpf{$c} != $d) {
                    return false;
                }
            }

            return true;
        }
    }

    /**
     *
     * @param type $inicio (Y-m-d H:i:s)
     * @param type $fim (Y-m-d H:i:s)
     */
    function diffDataHora($inicial, $final) {

        // data e hora inicial
        $exp_i = explode(" ", $inicial);
        list($ano, $mes, $dia) = split("-", $exp_i[0]);
        list($h, $min, $s) = split(":", $exp_i[1]);
        $data_inicial = mktime($h, $min, $s, $mes, $dia, $ano);

        // data e hora final = 23/11/2006 - 10:23:15
        $exp_f = explode(" ", $final);
        list($ano, $mes, $dia) = split("-", $exp_f[0]);
        list($h, $min, $s) = split(":", $exp_f[1]);
        $data_final = mktime($h, $min, $s, $mes, $dia, $ano);

        $segundos = $data_final - $data_inicial;

        $horas = floor($segundos / 3600);
        $segundos -= $horas * 3600;
        $minutos = floor($segundos / 60);
        $segundos -= $minutos * 60;

        $horas = (strlen($horas) == 1) ? "0" . $horas : $horas;
        $minutos = (strlen($minutos) == 1) ? "0" . $minutos : $minutos;
        $segundos = (strlen($segundos) == 1) ? "0" . $segundos : $segundos;

        return "$horas:$minutos:$segundos";
    }

    function arr2url($arr) {

        foreach ($arr as $key => $val):

            if (is_array($val)):
                foreach ($val as $s):
                    foreach ($s as $k => $v):
                        $i++;
                        if ($i > 1):
                            $retorno .= "&";
                        endif;

                        $retorno .= $k . "=" . $v;
                    endforeach;
                endforeach;
                continue;
            endif;

            $i++;
            if ($i > 1):
                $retorno .= "&";
            endif;

            $retorno .= $key . "=" . $val;
        endforeach;

        return $retorno;
    }

    function somaHora($hora1, $hora2) {

        $h1 = explode(":", $hora1);
        $h2 = explode(":", $hora2);

        $segundo = $h1[2] + $h2[2];
        $minuto = $h1[1] + $h2[1];
        $horas = $h1[0] + $h2[0];
        $dia = 0;

        if ($segundo > 59) {

            $segundodif = $segundo - 60;
            $segundo = $segundodif;
            $minuto = $minuto + 1;
        }

        if ($minuto > 59) {

            $minutodif = $minuto - 60;
            $minuto = $minutodif;
            $horas = $horas + 1;
        }

        if (strlen($horas) == 1) {

            $horas = "0" . $horas;
        }

        if (strlen($minuto) == 1) {

            $minuto = "0" . $minuto;
        }

        if (strlen($segundo) == 1) {

            $segundo = "0" . $segundo;
        }

        return $horas . ":" . $minuto . ":" . $segundo;
    }

    function horaMinuto($horas) {

        list($hora, $minuto) = split(":", $horas);

        $minutos = $hora * 60;
        $minutos = $minutos + $minuto;

        return $minutos;
    }

    function minutoHora($minutos) {

        $d = $minutos / 60;

        $exp = explode(".", $d);

        $hora = $exp[0];
        $minuto = ($exp[1] != '') ? ($exp[1] / 100) * 60 : "00";

        if (strlen($hora) == 1):
            $hora = "0" . $hora;
        endif;

        if (strlen($minuto) == 1):
            $minuto = "0" . $minuto;
        endif;

        return $hora . ":" . $minuto;
    }

    function to_url($t) {

        $p = strtr($t, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ", "aaaaeeiooouucAAAAEEIOOOUUC");
        $url = ereg_replace('[^a-zA-Z0-9_.]', '', $p);
        $url = strtolower($url);

        return $url; // acentuacao_em_arquivos.doc
    }

    /**
     * Arrendondar valores decimais
     * @param type $numero
     * @param type $decimais
     * @return type integer
     */
    function arredondar($numero, $decimais) {
        $fator = pow(10, $decimais);
        return (round($numero * $fator) / $fator);
    }

    /**
     * Checkbox em colunas
     * @param type $dados (lista de dados)
     * @param type $colunas (quantidade de colunas)
     */
    function checkbox($campo, $dados, $colunas, $marcados) {

        $t = count($dados);
        $por_coluna = ceil($t / $colunas);
        foreach ($dados as $key => $val):
            $i++;
            $j++;

            $checked = "";
            if ($marcados):
                foreach ($marcados as $marcado):
                    if ($key == $marcado):
                        $checked = 'checked="true"';
                        break;
                    endif;
                endforeach;
            endif;

            if ($i == 1):
                echo '<ul class="listaColunas">';
            endif;

            echo '<li class="btn"><label><input type="checkbox" name="' . $campo . '[]" value="' . $key . '" ' . $checked . ' />' . $val . '</label></li>';

            if ($i == $por_coluna || $j == $t):
                echo '</ul>';
                $i = 0;
            endif;
        endforeach;
    }

}

/* End of file combo_helper.php */
/* Location: ./system/helpers/form_helper.php */
?>