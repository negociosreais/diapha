<?php

class tools_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function preencher_combo_geral($campo1, $campo2, $tabela, $id = '', $where = '', $order = '') {

        // vamos tratar os  campos
        $partesCampos1 = explode(' ', str_replace('.', ' ', trim(str_replace(')', '', $campo1))));
        $partesCampos2 = explode(' ', str_replace('.', ' ', trim(str_replace(')', '', $campo2))));

        $soCampo1 = trim($partesCampos1 [(int) sizeof($partesCampos1) - 1]);
        $soCampo2 = trim($partesCampos2 [(int) sizeof($partesCampos2) - 1]);

        if (substr(strtoupper(trim($tabela)), 0, 4) != "FROM")
            $tabela = " FROM $tabela ";
        if (trim($where))
            $where = " WHERE  $where ";
        if (trim($order))
            $order = " ORDER BY  $order ";

        $sql = " SELECT $campo1, $campo2  $tabela  $where $order";

        $resultado = $this->db->query($sql);

        $resarray = $resultado->result_array();
        $combo = "";


        if (sizeof($resarray)) {

            foreach ($resarray as $key => $val) {


                if ($val[$soCampo1] != $lastone) {
                    $checkad = (trim($val[$soCampo1]) == $id) ? " SELECTED " : " ";
                    $combo .= "<option $checkad value='" . $val [$soCampo1] . "' > " . $val [$soCampo2] . " </option>";
                    $lastone = $val[$soCampo1];
                }
            }
        }

        return $combo;
    }

    function checkin($v1, $v2) {
        if ($v1 == $v2)
            return 'checked';
    }

    /**
     * Enviar e-mail
     */
    function enviar_email($dados) {

        if ($dados['anexo']['size'] > 0):
            $nome_arquivo = $this->upload_arquivo($dados['anexo'], 'arquivos/anexos', false);
        endif;

        $this->load->library('email');

        $config['protocol'] = 'sendmail';

        $config['mailpath'] = '/usr/sbin/sendmail';

        $config['charset'] = 'UTF-8';

        $config['wordwrap'] = TRUE;

        $config['mailtype'] = 'html';

        $this->email->initialize($config);

        $this->email->from($dados['de'], $dados['de_nome']);

        $this->email->to($dados['para']);
        //$this->email->to("rafaelmenezes86@gmail.com");

        $this->email->bcc($dados['copia_oculta']);

        $this->email->subject($dados['assunto']);

        /**
         * Vamos formatar a mensagem que vai no e-mail
         */
        $this->email->message($dados['msg']);

        /*
         * Vamos anexar um arquivo
         */
        if ($_FILES['anexo']['size'] > 0):
            $this->email->attach('./arquivos/anexos/' . $nome_arquivo);
        endif;

        if ($this->email->send()) :
            return true;
        else:
            return false;
        endif;
    }

    /**
     * Upload de arquivo
     */
    function upload_arquivo($file, $diretorio, $gera_nome = false, $nome) {

        // Primeiro vamos criar o diretorio caso não exista
        mkdir('./' . $diretorio, 0775);

        // Pega extensão do arquivo
        $exp = explode(".", $file["name"]);
        foreach ($exp as $e):
            $ext = $e;
        endforeach;

        if (!in_array(strtolower($ext), array('doc', 'xls', 'docx', 'xlsx', 'jpg', 'bmp', 'pdf', 'zip', 'rar', 'txt', 'jpeg', 'gif', 'ppt', 'rtf', 'odt', 'png')))
            $erro = "Tipo de arquivo não permitido.";

        // Gera um nome único para a imagem
        if ($nome == ''):
            if ($gera_nome == true) :
                $nome = md5(uniqid(time())) . "." . $ext;
            else :
                // Mantem o nome do documento
                $nome = str_replace(" ", "_", $file["name"]);
                $p_nome = $nome;
                while (file_exists("./" . $diretorio . "/" . $nome)) {
                    $i++;
                    $nome = $i . "_" . $p_nome;
                }
            endif;

            $nome = retira_acentos($nome);
        else:
            $nome = strtolower(str_replace(" ", "_", retira_acentos($nome))) . "." . $ext;
        endif;


        // Caminho de onde a imagem ficará
        $dir = "./" . $diretorio . "/" . $nome;

        // Faz o upload da imagem
        if (!isset($erro)):
            if (move_uploaded_file($file["tmp_name"], $dir)):

                return $nome;
            else :
                return "";
            endif;
        else:
            echo $erro;
            die;
        endif;
    }

    function upload_imagem($file, $diretorio, $maior, $menor) {

        $this->load->library("upload");

        // Primeiro vamos criar o diretorio caso não exista
        mkdir('./' . $diretorio, 0775);

        $handle = new Upload($file);

        // Então verificamos se o arquivo foi carregado corretamente
        if ($handle->uploaded) {
            
            // Definimos as configurações desejadas da imagem maior
            $handle->image_resize = true;
            $handle->image_ratio = true;
            $handle->image_x = $maior['x'];
            $handle->image_y = $maior['y'];
            $handle->image_watermark = 'watermark.png';
            $handle->image_watermark_x = -10;
            $handle->image_watermark_y = -10;
            $handle->file_name_body_add = "";
            $handle->mime_check = true;
            $handle->file_src_size = 2048576;


            // Definimos a pasta para onde a imagem maior será armazenada
            $handle->Process('./' . $diretorio . '/');

            $nome_da_imagem = $handle->file_dst_name;
            $nome_sem_ext = $handle->file_dst_name_body;
            $caminho = trim('./' . $diretorio . '/');
            $tumb = trim('./' . $diretorio . "/");

            // Aqui nós definimos nossas configurações de imagem do thumbs

            $handle->image_resize = true;
            $handle->image_ratio = true;
            $handle->image_x = $menor['x'];
            $handle->image_y = $menor['y'];
            $handle->image_contrast = 10;
            $handle->jpeg_quality = 70;
            //$handle->file_name_body_add = "_thumb";
            $handle->file_new_name_body = "t_" . $nome_sem_ext;

            // Definimos a pasta para onde a imagem thumbs será armazenada
            if (is_array($menor)):
                $handle->Process('./' . $diretorio . '/');
            endif;

            // Excluimos os arquivos temporarios
            $handle->Clean();

            // Em caso de sucesso no upload podemos fazer outras ações como insert em um banco de cados
            if ($handle->processed) :

                return trim($nome_da_imagem);

            else:
                return "";
            endif;
        }
    }

    function crop_imagem_old($dir, $file, $crop, $size) {

        $this->load->library("upload");

        $arquivo = "./" . $dir . $file;

        $handle = new Upload($arquivo);

        // Então verificamos se o arquivo foi carregado corretamente
        if ($handle->uploaded) {

            // Definimos as configurações desejadas da imagem maior
            $handle->file_new_name_body = 'cropado';
            $handle->image_resize = true;
            $handle->image_ratio_crop = true;
            $handle->image_crop = '20 20 20 20';
            $handle->image_y = $size['y'];
            $handle->image_x = $size['x'];

            // Definimos o local para onde a imagem vai
            $handle->process("./" . $dir);


            // Em caso de sucesso no upload podemos fazer outras ações como insert em um banco de cados
            if ($handle->processed) {

                // Excluimos os arquivos temporarios
                $handle->clean();

                $nome = trim($nome_da_imagem);
                return $nome;
            } else
                return "";
        }
    }

    function canvas_crop($dir, $file, $crop, $size) {

        $this->load->library("canvas");

        $arquivo = "./" . $dir . $file;

        $img = new canvas();

        $img->carrega($arquivo);

        $img->posicaoCrop($crop['x'], $crop['y']);

        return $img->redimensiona($crop['w'], $crop['h'], 'crop')->grava($arquivo);
    }

    function gira_imagem($file, $graus) {
        
        // Primeiro vamos alterar as permissões do arquivo
        chmod('./' . $file, 0775);

        $this->load->library("canvas");

        $arquivo = "./" . $file;

        $img = new canvas();

        $img->carrega($arquivo);
        
        $img->gira($graus);
        
        return $img->grava($arquivo);
    }

    function copiar_arquivos($origem, $destino) {

        //mkdir($destino, 0775);
        // COPIA UM ARQUIVO
        if (is_file($origem)) :
            copy($origem, $destino);
            chmod($destino, 0664);
            return chgrp($destino, "ubuntu");
        endif;

        // CRIA O DIRETÓRIO DE DESTINO
        if (!is_dir($destino)) :
            mkdir($destino, 0775);
            chgrp($destino, "ubuntu");
        //echo "DIRET&Oacute;RIO $destino CRIADO<br />";
        endif;

        // FAZ LOOP DENTRO DA PASTA
        $dir = dir($origem);
        while (false !== $entry = $dir->read()) :

            // PULA "." e ".."
            if ($entry == '.' || $entry == '..') :
                continue;
            endif;

            // COPIA TUDO DENTRO DOS DIRETÓRIOS
            if ($destino !== "$origem/$entry") :
                $this->copiar_arquivos("$origem/$entry", "$destino/$entry");
            //echo "COPIANDO $entry de $origem para $destino <br />";
            endif;
        endwhile;

        $dir->close();
        return true;
    }

}

?>