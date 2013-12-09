<?php

class Perfil extends CI_Controller {

    function Perfil() {
        parent::__construct();

        $this->load->model("orgao/orgao_model");
    }

    function estados() {

        $this->layout->layout('layout_portal');

        $this->layout->view("orgao/perfil/estados_view", $dados); 
    }
    
    function cidades($est) {

        //$param['order'] = "com.nm_estado ASC";
        $param['st_status'] = "Ativo";
        $param['nm_estado'] = $est;
        $dados["dados"] = $this->orgao_model->selecionarCidades($param);
        
        debug($dados);

        $this->layout->layout('layout_perfil');

        $this->layout->view("orgao/perfil/porestado_view", $dados);
    }

}
/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */