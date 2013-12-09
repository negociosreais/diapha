<?php

class Grafico extends CI_Controller {

    function Grafico() {
        parent::__construct();

        $this->load->model("relato/relato_model");
        $this->load->model("relato_categoria/relato_categoria_model");
    }

    function por_categoria() {

        $this->load->view("diapha/graficos/por_categoria_view");
    }

    function por_categoria_json() {

        $dados['cidade'] = usuario('cidade');
        $dados['intervalo'] = $_REQUEST['intervalo'];

        $param = $dados;

        if (usuario('categorias') != ''):
            $categorias = explode(',', usuario('categorias'));
        else:
            $cats = $this->relato_categoria_model->selecionarCategorias();
            foreach ($cats as $cat):
                $categorias[] = $cat['nm_apelido'];
            endforeach;
        endif;

        $retorno = array();
        $j = 0;
        foreach ($categorias as $categoria):

            if ($categoria == ''):
                continue;
            endif;

            $p['nm_apelido'] = $categoria;
            $c = $this->relato_categoria_model->selecionarCategorias($p);
            $retorno['categories'][$j] = $c[0]['nm_categoria'];

            $param['nm_apelido'] = $categoria;
            for ($i = 0; $i <= 2; $i++):

                $param['st_status'] = "$i";
                $relatos = $this->relato_model->selecionarRelatos($param);

                switch ($i):
                    case 0:
                        $name = "Enviado";
                        $color = "red";
                        break;
                    case 1:
                        $name = "Em analise";
                        $color = "orange";
                        break;
                    case 2:
                        $name = "Respondido";
                        $color = "green";
                        break;
                endswitch;

                $retorno['series'][$i]['name'] = $name;
                $retorno['series'][$i]['color'] = $color;
                $retorno['series'][$i]['data'][] = count($relatos);

            endfor;

            $j++;
        endforeach;


        echo json_encode($retorno);
    }

    function por_ano() {

        $this->load->view("diapha/graficos/por_ano_view");
    }

    function por_ano_json() {

        $dados['cidade'] = usuario('cidade');

        $param = $dados;

        if (usuario('categorias') != ''):
            $categorias = explode(',', usuario('categorias'));
        else:
            $cats = $this->relato_categoria_model->selecionarCategorias();
            foreach ($cats as $cat):
                $categorias[] = $cat['nm_apelido'];
            endforeach;
        endif;

        $ano_inicio = date("Y") - 2;

        $retorno = array();
        $j = 0;
        for ($ano = $ano_inicio; $ano <= date("Y"); $ano++):

            $retorno['categories'][$j] = $ano;

            $i = 0;
            foreach ($categorias as $categoria):

                if ($categoria == '')
                    continue;

                $p['nm_apelido'] = $categoria;
                $c = $this->relato_categoria_model->selecionarCategorias($p);

                $param['nm_apelido'] = $categoria;
                $param['ano'] = $ano;
                $relatos = $this->relato_model->selecionarRelatos($param);

                $retorno['series'][$i]['name'] = $c[0]['nm_categoria'];
                $retorno['series'][$i]['data'][] = count($relatos);

                $i++;

            endforeach;

            $j++;
        endfor;

        echo json_encode($retorno);
    }

}

/* End of file welcome.php */
        /* Location: ./system/application/controllers/welcome.php */






        