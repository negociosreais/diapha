<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('moeda')) {

    function moeda2float($valor) {


        $valor = str_replace(".", "", $valor);
        $valor = strtr($valor, ",", ".");

        return $valor;
    }

    function float2moeda($valor, $dec = '2') {

        $valor = strtr($valor, ".", ",");

        if ($dec == '2'):
            if (substr($valor, strlen($valor) - 2, 1) != ','):
                if (substr($valor, strlen($valor) - 3, 1) != ',') :
                    $valor = $valor . ",00";
                endif;
            else :
                $valor = $valor . "0";
            endif;
        endif;

        if ($dec == '1'):
            if (substr($valor, strlen($valor) - 1, 1) != ','):
                if (substr($valor, strlen($valor) - 2, 1) != ',') :
                    $valor = $valor . ",0";
                endif;
            endif;
        endif;

        return $valor;
    }

    function calcParcelaJuros($valor_total, $parcelas, $juros=0) {

        if ($juros == 0) {
            for ($i = 1; $i < ($parcelas + 1); $i++) {
                $string = number_format($valor_total / $parcelas, 2, ",", ".");
            }
            return $string;
        } else {
            $I = $juros / 100.00;
            $valor_parcela = $valor_total * $I * pow((1 + $I), $parcelas) / (pow((1 + $I), $parcelas) - 1);
            $string = number_format($valor_parcela, 2, ",", ".");

            return $string;
        }
    }

    function calcJurosCompostos($principal, $taxa, $meses) {

        $taxa = 0.04; // 3%
        
        $anterior = 0.0;

        for ($i = 1; $i <= $meses; $i++) {
            $montante = $principal * pow((1 + $taxa), $i);
            $juros = $montante - $principal - $anterior;

            $anterior += $juros;

            echo "Mês: " . $i . " - Montante: "
            . $montante . " - Juros: " . $juros . "<br>";
        }
        
        die;

        $taxa = $taxa / 100;

        $montante = $principal * pow((1 + $taxa), $meses);
        $juros = $montante - $principal;

        return $juros;
    }
    
    function calcDescontoCheque($data, $total, $taxa, $parcelas) {
        
        $taxa = $taxa / 100;
        $valor_parcela = $total / $parcelas;
        for ($i = 0; $i <= $parcelas;$i++):
            
            $data_parcela = calculaData($data,"+", "month",$i);
            $dias = diffDatasDia($data,$data_parcela);
            
            $juros = (($valor_parcela * $taxa) / 30) * $dias;
            $soma += $juros;
            
            //echo $dias." - ".$data_parcela." - ".$valor_parcela." - ".$juros."<br>";
            
        endfor;
        
        return $soma;
        
    }

}


/* End of file array_helper.php */
/* Location: ./system/helpers/array_helper.php */