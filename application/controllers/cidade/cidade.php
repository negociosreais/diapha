<?php

class Cidade extends CI_Controller {

    function Cidade() {
        parent::__construct();

        $this->load->model("cidade/cidade_model");
    }

    function combo() {

        if ($_POST['uf'] == ''):
            die;
        endif;

        $param['uf'] = $_POST['uf'];
        $cidades = $this->cidade_model->selecionarCidades($param);

        $retorno = "<option></option>";

        foreach ($cidades as $c) {
            $selected = '';
            if ($c['nome'] == $_POST['nome'])
                $selected = "  selected='selected' ";

            $retorno .= "<option value='" . $c['nome'] . "' $selected>" . $c['nome'] . "</option>";
        }

        $retorno .= "<option value='0'>Outra</option>";

        echo $retorno;
    }

    function estados() {

        $this->layout->layout("layout_portal");

        $this->layout->view("cidade/estados_view", $dados);
    }

    function cidades($uf, $letra) {

        $dados['uf'] = $uf;
        $dados['letra'] = ($letra == '') ? "A" : $letra;

        $param['uf'] = $uf;

        if (!in_array($param['uf'], array('DF', 'AC', 'RO', 'RR'))):
            $param['letra'] = $dados['letra'];
        endif;
        $dados['cidades'] = $this->cidade_model->selecionarCidades($param);

        $this->layout->layout("layout_portal");

        $this->layout->view("cidade/cidades_view", $dados);
    }

}

/* End of file welcome.php */
        /* Location: ./system/application/controllers/welcome.php */






        