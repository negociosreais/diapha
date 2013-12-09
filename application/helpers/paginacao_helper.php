<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


if (!function_exists('paginacao')) {

    function paginacao($arr) {

        $total = count($arr['dados']);
        $dados = $arr['dados'];
        if (strlen($arr['params']) > 0):
            $arr['params'] = "&".$arr['params'];
        endif;

        $ci = & get_instance();

        $ci->load->library('pagination');

        $config['base_url'] = "";
        $config['total_rows'] = $total;
        $config['per_page'] = $arr['por_pagina'];
        $config['first_link'] = 'Primeira';
        $config['last_link'] = 'Ultima';
        $config['num_links'] = 10;
        $config['uri_segment'] = '';
        $config['first_link'] = 'Primeira';
        $config['last_link'] = 'Ultima';
        $config['next_link'] = 'Próxima >';
        $config['prev_link'] = '';
        $config['params'] = $arr['params'];

        $ci->pagination->initialize($config);



        $inicio = ($arr['inicio'] == 'undefined') ? 0:$arr['inicio'];
        $fim = $inicio + $arr['por_pagina'];
        if ($fim > $total)
            $fim = $total;

        $j = 0;
        for ($i = $inicio; $i < $fim; $i++) :
            $retorno[$j] = $dados[$i];
            $j++;
        endfor;

        return $retorno;
    }

}


/* End of file array_helper.php */
/* Location: ./system/helpers/array_helper.php */