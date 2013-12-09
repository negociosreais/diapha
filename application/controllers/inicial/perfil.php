<?php

class Perfil extends CI_Controller {

    function Perfil() {
        parent::__construct();

        checa_logado();
    }

    function vendedor() {

        if ($_GET['c'] == ''):
            redirect('sem_acesso');
            die;
        endif;

        $this->load->model("vendedor/vendedor_model");

        $vendedor = $this->vendedor_model->selecionarVendedor($_GET['c']);

        $this->layout->view("inicial/inicial_vendedor_view", $dados);
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
?>
