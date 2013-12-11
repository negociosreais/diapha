<?php

class Diapha extends CI_Controller {

    function Diapha() {
        parent::__construct();

        //$this->load->model("cidade/cidade_model");
    }

    function relatos($c, $m) {

        if (checa_permissao(array('orgao', 'cidadao'), true)):

            if (usuario('categorias') == ''):
                redirect('usuario/preferencias');
            endif;

            if (perfil() == 'cidadao'):
                if ($c == "" && $m == "" && $_GET['view'] == ""):
                    redirect('?view=feed');
                endif;
            endif;
        endif;

        if ($_GET['meusrelatos'] == "1"):
            if (!checa_logado(false)):
                redirect(site_url('login?url=?meusrelatos=1&view=' . $_GET['view']));
            endif;
        elseif ($_GET['minhaspropostas'] == "1"):
            if (!checa_logado(false)):
                redirect(site_url('login?url=?minhaspropostas=1&view=' . $_GET['view']));
            endif;
        endif;

        if ($_GET['view'] == 'feed'):
            $this->feed($c, $m);
        elseif ($_GET['view'] == 'propostas'):
            $this->propostas($c, $m);
        elseif ($_GET['view'] == 'telacheia'):
            $this->telacheia($c, $m);
        else:
            $this->mapa($c, $m);
        endif;
    }

    function mapa($c, $m) {

        $this->load->model('relato_categoria/relato_categoria_model');

        $dados['pagina'] = "relatos";

        if ($c == "categoria"):
            $param['categorias'] = $m;
            $dados['categorias'] = $m;
        elseif ($c == "cidade"):
            $param['cidade'] = $m;
            $dados['cidade'] = $m;
        endif;

        // Se nenhuma categoria for submetida vamos verificar na sessão as anteriores
        if ($param['categorias'] == ''):
            $dados['categorias'] = usuario('categorias');
        endif;

        $param['status'] = "Ativo";
        $categorias = $this->relato_categoria_model->selecionarCategorias($param);
        if ($categorias):
            foreach ($categorias as $categoria) :
                if ($categoria['id_categoria'] == $id)
                    continue;
                $dados['cbo_categorias'][$categoria[nm_apelido]] = $categoria['nm_categoria'];
            endforeach;
        endif;

        if ($_GET['meusrelatos'] == '1'):
            $dados['pagina'] = "meusrelatos";
            $dados['fb_email'] = usuario('email_facebook');
        endif;

        $this->layout->layout("layout_inicio");

        $this->layout->view("diapha/mapa_view", $dados);
    }

    function telacheia($c, $m) {

        $this->load->model('relato_categoria/relato_categoria_model');

        $dados['pagina'] = "relatos";

        if ($c == "categoria"):
            $param['categorias'] = $m;
            $dados['categorias'] = $m;
        elseif ($c == "cidade"):
            $param['cidade'] = $m;
            $dados['cidade'] = $m;
        endif;

        // Se nenhuma categoria for submetida vamos verificar na sessão as anteriores
        if ($param['categorias'] == ''):
            $dados['categorias'] = usuario('categorias');
        endif;

        $param['status'] = "Ativo";
        $categorias = $this->relato_categoria_model->selecionarCategorias($param);
        if ($categorias):
            foreach ($categorias as $categoria) :
                if ($categoria['id_categoria'] == $id)
                    continue;
                $dados['cbo_categorias'][$categoria[nm_apelido]] = $categoria['nm_categoria'];
            endforeach;
        endif;

        if ($_GET['meusrelatos'] == '1'):
            $dados['pagina'] = "meusrelatos";
            $dados['fb_email'] = usuario('email_facebook');
        endif;

        $this->layout->layout("layout_vazio");

        $this->layout->view("diapha/telacheia_view", $dados);
    }

    function feed($c, $m) {

        checa_logado();

        $this->load->model('relato/relato_model');
        $this->load->model('orgao/orgao_model');
        $this->load->model('relato_categoria/relato_categoria_model');
        $this->load->model("tools/tools_model");

        $param = $_GET;
        $dados['pagina'] = "relatos";

        // Aqui vamos setar em sessão as categorias selecionar se for o caso
        if ($_GET['categoria']):
            $i = 0;
            foreach ($_GET['categoria'] as $c):
                $i++;
                if ($i > 1):
                    $categorias .= ",";
                endif;
                $categorias .= $c;
            endforeach;
            usuario('categorias', $categorias);
        endif;

        if ($c == "categoria"):
            $param['categorias'] = $m;
            $dados['categorias'] = $m;
        elseif ($c == "cidade"):
            $param['cidade'] = $m;
            $dados['cidade'] = $m;
        endif;

        // Se nenhuma categoria for submetida vamos verificar na sessão as anteriores
        if ($param['categorias'] == ''):
            $param['categorias'] = usuario('categorias');
        endif;

        $dados['total_geral'] = count($this->relato_model->selecionarRelatos($param));
        
        $param['id_usuario'] = usuario('id_usuario');
        $dados['total_usuario'] = count($this->relato_model->selecionarRelatos($param));
        
        if ($_GET['meusrelatos'] == '1'):
            $dados['pagina'] = "meusrelatos";
        else:
            unset($param['id_usuario']);
        endif;
        
        $param['limit'] = '0,5';
        $param['st_status'] = $_GET['status'];
        $dados['relatos'] = $this->relato_model->selecionarRelatos($param);

        $param['status'] = "Ativo";
        $categorias = $this->relato_categoria_model->selecionarCategorias($param);
        if ($categorias):
            foreach ($categorias as $categoria) :
                if ($categoria['id_categoria'] == $id)
                    continue;
                $dados['cbo_categorias'][$categoria[nm_apelido]] = $categoria['nm_categoria'];
            endforeach;
        endif;

        // Vamos pegar a quantidade de relatos do usuário logado de acordo com o status
        $param['id_usuario'] = usuario('id_usuario');

        // Total
        unset($param['limit']);
        unset($param['st_status']);
        
        // Não respondidos
        //$param['st_status'] = "0";
        //$dados['nao_respondido'] = count($this->relato_model->selecionarRelatos($param));

        // Em análise
        //$param['st_status'] = "1";
        //$dados['em_analise'] = count($this->relato_model->selecionarRelatos($param));

        // Resolvido
        //$param['st_status'] = "2";
        //$dados['resolvido'] = count($this->relato_model->selecionarRelatos($param));

        $this->layout->layout("layout_portal");

        $this->layout->view("diapha/feed_view", $dados);
    }
    
    function propostas($c, $m) {

        checa_logado();
        
        $this->load->model('relato/relato_model');
        $this->load->model('proposta/proposta_model');
        $this->load->model('orgao/orgao_model');
        $this->load->model("tools/tools_model");

        $param = $_GET;
        $data['pagina'] = "propostas";

        $data['total_geral'] = count($this->relato_model->selecionarRelatos($param));
        
        $param['id_usuario'] = usuario('id_usuario');
        $data['total_usuario'] = count($this->relato_model->selecionarRelatos($param));
        
        if ($_GET['minhaspropostas'] == '1'):
            $data['pagina'] = "minhaspropostas";
            $param['id_usuario'] = usuario('id_usuario');
        else:
            unset($param['id_usuario']);
        endif;

        $param['limit'] = '0,5';
        $data['propostas'] = $this->proposta_model->selecionarPropostas($param);
        //echo count($dados['propostas']);
        //exit();
        //$param['status'] = "Ativo";
        
        // Vamos pegar a quantidade de relatos do usuário logado de acordo com o status
        
        // Total
        /*unset($param['limit']);
        unset($param['st_status']);
        $dados['total'] = count($this->proposta_model->selecionarPropostas($param));

        // Não respondidos
        $param['st_status'] = "0";
        $dados['nao_respondido'] = count($this->proposta_model->selecionarPropostas($param));

        // Em análise
        $param['st_status'] = "1";
        $dados['em_analise'] = count($this->proposta_model->selecionarPropostas($param));

        // Resolvido
        $param['st_status'] = "2";
        $dados['resolvido'] = count($this->proposta_model->selecionarPropostas($param));
*/
        $this->layout->layout("layout_portal");

        $this->layout->view("diapha/propostas_view", $data);
    }

    function lista_adicionar_ajax() {

        $this->load->model('relato/relato_model');
        $this->load->model('orgao/orgao_model');
        $this->load->model('relato_categoria/relato_categoria_model');
        $this->load->model("tools/tools_model");

        $param = $_GET;
        $param['cidade'] = usuario('cidade');
        $param['categorias'] = usuario('categorias');

        if ($_GET['meusrelatos'] == '1'):
            $dados['pagina'] = "meusrelatos";
            $param['fb_email'] = usuario('email_facebook');
        endif;

        $param['limit'] = $_GET['i'] . ",3";
        $relatos = $this->relato_model->selecionarRelatos($param);

        /**
         * Fazer o loop para criar as novas linhas
         */
        if ($relatos):
            foreach ($relatos as $relato):

                $endereco = $relato['ds_endereco'] . ", " . $relato['nm_bairro'] . ", " . $relato['nm_cidade'] . ", " . $relato['nm_estado'];

                if ($relato['st_status'] == 0):
                    $status = '<span class="status nao-respondido">Não respondido</span>';
                elseif ($relato['st_status'] == 1):
                    $status = '<span class="status em-analise">Em análise</span>';
                else:
                    $status = '<span class="status respondido">Respondido</span>';
                endif;
                ?>

                <div class="feed">
                    <div class="feed-img-user">
                        <img class='img-polaroid fb-img' src='https://graph.facebook.com/<?= $relato['fb_user'] ?>/picture' height='60' align='left' />
                    </div>

                    <div class="feed-arrow">
                    </div>

                    <div class="feed-content caixa">

                        <div class="feed-header">
                            <span class="feed-name-user"><b><?= $relato['fb_name']; ?></b></span>

                            <span class="feed-date">
                                <img src="<?= base_url() . TEMPLATE; ?>/img/icones/icon-relogio.png" />
                                <?= formata_data_extenso(formataDate($relato['dt_cadastro'], "-")); ?> às <?= substr($relato['hr_cadastro'], 0, 5) ?>.
                            </span>
                            <span class="feed-status"><?= $status; ?></span>
                        </div>

                        <div class="clear"></div>

                        <div class="feed-middle">

                            <p>
                                <b><?= $relato['nm_categoria']; ?></b><br>

                                <?= $relato['ds_relato']; ?>

                                <br>
                                <?
                                if ($relato['nm_foto'] != ''):
                                    ?>

                                    <a class="fancybox-effects-c" href="<?= base_url(); ?>/arquivos/diapha/<?= $relato['nm_foto']; ?>" title="<?= $relato['ds_relato']; ?>">

                                        <img src="<?= base_url(); ?>/arquivos/diapha/<?= $relato['nm_foto']; ?>" alt="" style="max-width: 675px;max-height: 400px"/>

                                    </a>

                                    <?
                                endif;
                                ?>
                            </p>

                            <div class="feed-location">
                                <img src="<?= base_url() . TEMPLATE; ?>/img/icones/icon-map-marcador.png" />
                                <?= $endereco; ?>
                            </div>

                        </div>

                        <div class="feed-footer">

                            <div style="float: left">

                                <?
                                /*
                                 * Mudança de status
                                 */
                                if ($relato['st_status'] == '0' || $relato['st_status'] == '1'):

                                    if ((in_array($relato['nm_apelido'], $arr) && checa_permissao(array('orgao'), true)) || $relato['fb_email'] == usuario('email_facebook')):

                                        if ($relato['st_status'] == '0'):
                                            ?>
                                            <button class="btn btn-warning" onclick="mostrarStatus(1, '<?= $relato[id_relato]; ?>')">Marcar em análise</button>
                                            <?
                                        elseif ($relato['st_status'] == '1'):
                                            ?>
                                            <button class="btn btn-success" onclick="mostrarStatus(2, '<?= $relato[id_relato]; ?>')">Marcar como resolvido</button>
                                            <?
                                        endif;

                                    endif;
                                endif;
                                ?>

                                <a href="<?= site_url('relato/' . $relato['nm_apelido'] . '/detalhes?id=' . $relato['id_relato']); ?>" class="btn" title="Ver mais detalhes do relato">+</a>


                            </div>


                            <div style="float:right">

                                <a href="javascript: void(0);" style="padding: 6px 10px;width: 20px" class="btn btn-primary" onclick="window.open('http://www.facebook.com/sharer.php?s=100&p[url]=<?= site_url('relato/' . $relato['nm_apelido'] . '/detalhes?id=' . $relato['id_relato']); ?>&p[images][0]=<?= base_url(); ?>/arquivos/diapha/<?= $relato['nm_foto']; ?>&p[title]=<?= $relato['ds_relato']; ?>&p[summary]=<?= $relato['ds_relato']; ?>','Compartilhando Diapha', 'toolbar=0, status=0, width=650, height=450');">
                                    <img src="<?= base_url() . TEMPLATE; ?>/img/icones/icon-facebook.png" />
                                </a>

                                <a href="javascript: void(0);" style="padding: 6px 10px;width: 20px" class="btn btn-twitter" onclick="window.open('http://twitter.com/share?text=Diapha: <?= $relato['ds_relato']; ?>. Local: <?= $endereco; ?>&url=<?= site_url('relato/' . $relato['nm_apelido'] . '/detalhes?id=' . $relato['id_relato']); ?>&counturl=<?= site_url('relato/' . $relato['nm_apelido'] . '/detalhes?id=' . $relato['id_relato']); ?>','Compartilhando Diapha', 'toolbar=0, status=0, width=650, height=450');">
                                    <img src="<?= base_url() . TEMPLATE; ?>/img/icones/icon-tw.png" /> 
                                </a>

                            </div>

                        </div>

                        <div class="feed-historic">
                            <?
                            $preferencias = unserialize(usuario('ds_preferencias'));

                            $arr = explode(",", $preferencias['categorias']);

                            $historico = unserialize($relato['ds_historico']);

                            /**
                             * Histórico
                             */
                            if ($historico):

                                foreach ($historico as $h):

                                    // Se for órgão que respondeu
                                    if ($h['nm_orgao'] != ''):
                                        $nome = $h['nm_orgao'];

                                        $orgao = $this->orgao_model->selecionarOrgao($h['id_orgao']);
                                        if ($orgao['nm_logo'] != ''):
                                            $foto = base_url() . "/arquivos/orgao/" . $orgao['nm_logo'];
                                        else:
                                            $foto = base_url() . TEMPLATE . "/img/semImagemP.jpg";
                                        endif;

                                    // Se for o próprio usuário que respondeu
                                    elseif ($h['email_facebook'] != ''):
                                        $nome = $relato['fb_name'];
                                        $foto = "https://graph.facebook.com/" . $relato['fb_user'] . "/picture";
                                    endif;

                                    if ($h['st_status'] == '1'):
                                        $msg = "alterou o status para <b>Em análise</b>.<br>";
                                    elseif ($h['st_status'] == '2'):
                                        $msg = "alterou o status para <b>Respondido</b>.<br>";
                                    endif;
                                    ?>

                                    <div class="reply">
                                        <div class="col-1">
                                            <img class='img-polaroid fb-img' src='<?= $foto; ?>' height='40' align='left' />
                                        </div>

                                        <div class="col-2">
                                            <span>
                                                <b><?= $nome; ?></b>
                                                <?= $msg; ?>
                                            </span>
                                            <span style="font-size: 10px;">
                                                <?= formata_data_extenso(formataDate($h['dt_alteracao'], "-")); ?> às <?= substr($h['hr_alteracao'], 0, 5) ?>.
                                            </span>
                                            <br>
                                            <div class="reply-msg"><?= $h['ds_mensagem']; ?></div>
                                        </div>
                                    </div>
                                    <div class="clear"></div>

                                    <?
                                endforeach;

                            endif;
                            ?>

                        </div>


                        <div class="fb-comments">

                            <!-- Facebook comments -->
                            <div id="fb-root"></div>
                            <script>(function(d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0];
                                if (d.getElementById(id)) return;
                                js = d.createElement(s); js.id = id;
                                js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1&appId=<?= FB_APPID ?>";
                                fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));</script>

                            <div class="fb-comments" data-href="<?= site_url('relato/' . $relato['nm_apelido'] . '/detalhes?id=' . $relato['id_relato']); ?>" data-width="710" data-num-posts="10"></div>

                        </div>

                    </div>
                </div>

                <div class="clear"></div>

                <?
            endforeach;
        else:
            echo '0';
        endif;
    }

}

/* End of file welcome.php */
        /* Location: ./system/application/controllers/welcome.php */






       