<?php

class Inicial extends CI_Controller {

    function Inicial() {
        parent::__construct();

        checa_logado();
    }

    function index() {
        //error_reporting(E_ALL);
        switch (perfil()) {

            case 'admin':
                $this->usuario();
                break;
            case 'orgao':
                $this->orgao();
                break;
            case 'cidadao':
                redirect('');
                break;
        }
        
    }

    function usuario() {

        $this->layout->view("inicial/inicial_view", $dados);

    }

    function orgao() {
        
        $dados['id_orgao'] = usuario('id_orgao');
        
        $this->load->model("orgao/orgao_model");
        
        $orgao = $this->orgao_model->selecionarOrgao($dados['id_orgao']);

        $this->layout->view("inicial/inicial_orgao_view", $dados);

    }
   

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
?>
