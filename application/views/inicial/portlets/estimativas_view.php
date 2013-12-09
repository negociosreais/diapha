<?
if (checa_permissao_perfil(array('gestor', 'colaborador'), true)):
    ?>

    <script>
                                    
        $(document).ready(function() {
                                       
            // ToolTip
            $("a, img, button, input, select, span").each(function() {
                if ($(this).attr("title") != null && $(this).attr("title") != ""){
                    $(this).tipTip({maxWidth: "auto", edgeOffset: 10});
                }
            });
                                       
        });
                                    
        // Alternar cor das linhas das listas
        alterarCorLinhas();
                                                                
        // Alterar cor da linha quando passar o mouse em cima
        alterarCorLinhasMouse();
    </script>

    <div class="grid_19">

        <span id="numero15">
            <h1 class="tituloCaixa">ESTIMATIVAS DE PREÇO</h1>
        </span>
        <div class="caixa">

            <table width="100%" class="lista">

                <?
                if (count($oportunidades) > 0) :

                    foreach ($oportunidades as $oportunidade) :

                        $datahora = explode(" ", $oportunidade['dt_cadastro']);

                        $tipo = ($oportunidade['id_acesso'] != '') ? "Oportunidade de Adesão" : "Oportunidade de Licitação";

                        if ($oportunidade['id_estimativa'] != ''):
                            $ajuda = "Estas oportunidades deverão ser respondidas com proposta orçamentária, <br>e após o envio o Órgão poderá lhe convocar para o certame , como também para auxilia-lo na especificação do produto.";
                        else:
                            $ajuda = "Significa que o órgão público acessou o seu produto e pode estar interessado em aderir a sua ata.";
                        endif;

                        // vamos calcular o tempo restante
                        if ($oportunidade['id_estimativa'] != ''):
                            $data_prazo = calculaData(formataDate($datahora[0], "-"), "+", "day", "2");
                            $datahora_prazo = formataDate($data_prazo, "/") . " " . $datahora[1];
                            $tempo_restante = diffDataHora(date("Y-m-d H:i:s"), $datahora_prazo);

                            list($hora, $minuto, $segundo) = split(":", $tempo_restante);
                            if ($hora < 0):
                                $tempo_restante = "00:00:00";
                            endif;
                        endif;

                        // verificar a quantidade de respostas e comentários
                        $param['id_orgao'] = usuario('id_orgao');
                        $param['id_estimativa'] = $oportunidade['id_estimativa'];
                        $respostas = $this->estimativa_preco_model->selecionarRespostas($param);
                        $qtd_respostas = count($respostas);
                        $qtd_comentarios = 0;
                        if ($respostas):
                            foreach ($respostas as $resposta):
                                $param['id_estimativa_resposta'] = $resposta['id_estimativa_resposta'];
                                $comentarios = $this->estimativa_preco_model->selecionarComentarios($param);
                                $qtd_comentarios += count($comentarios);
                            endforeach;
                        endif;
                        
                        ?>

                        <tr>
                            <td width="50">
                                <?
                                if ($oportunidade['nm_logo'] != ''):
                                    ?>
                                    <img src="<?= base_url(); ?>/arquivos/logos/<?= $oportunidade['nm_logo']; ?>" height="50" class="img-polaroid" />
                                    <?
                                else:
                                    ?>
                                    <img src="<?= base_url() . TEMPLATE; ?>/img/logoGovernoP.jpg" class="img-polaroid" />
                                <?
                                endif;
                                ?>
                            </td>
                            <td>
                                <b><?= $oportunidade['produto']; ?></b>
                                <br>
                                <?= ($oportunidade['id_acesso'] != '') ? "acessado" : "solicitado"; ?> em <?= formataDate($datahora[0], '-') . " às " . $datahora[1]; ?>

                            </td>

                            <td width="280">
                                Tempo limite para resposta das empresas 
                                <b><i><?= $tempo_restante; ?></i></b><br>
                                <a href="<?= site_url('ep/detalhes/' . $oportunidade['id_estimativa']); ?>">
                                    <i><b><?= $oportunidade['qtd_respostas']; ?></b> respostas</i><br>
                                    <i><b><?= $qtd_comentarios; ?></b> comentário(s)</i>
                                </a>

                            </td>

                            <td width="20">
                                <?
                                if ($oportunidade['id_acesso'] != ''):
                                    ?>
                                    <a href="<?= site_url('produto_acesso/detalhes/' . $oportunidade['id_acesso']); ?>" title="Mais detalhes">
                                        <img src="<?= base_url() . TEMPLATE; ?>/img/icones/plus.png" />
                                    </a>
                                    <?
                                endif;
                                ?>

                                <?
                                if ($oportunidade['id_estimativa'] != ''):
                                    ?>
                                    <a href="<?= site_url('ep/detalhes/' . $oportunidade['id_estimativa']); ?>" title="Mais detalhes">
                                        <img src="<?= base_url() . TEMPLATE; ?>/img/icones/plus.png"/>
                                    </a>
                                    <?
                                endif;
                                ?>
                            </td>

                        </tr>
                        <?
                    endforeach;

                else :
                    ?>

                    <tr>
                        <td colspan="7">
                            <span class='legenda'>Nenhum registro até o momento!</span>
                        </td>
                    </tr>

                <? endif; ?>

                <tr>
                    <td colspan="7" class="right">
                        <a href="<?= site_url("ep/listar"); ?>">
                            Ver todos
                        </a>
                    </td>
                </tr>
            </table>

        </div>

    </div>

    <?
else:
    ?>
    <div class="grid_19">
        <h1 class="tituloCaixa">SEJA BEM VINDO!</h1>
        <div class="caixa">
            <br >
            <ul>
                <li>
                    <a href="<?= site_url('ata/cadastrar'); ?>">1 - Cadastre sua ata ou portfólio.</a>
                </li>
                <li>
                    <a href="<?= site_url('produto/cadastrar'); ?>">2 - Cadastre seus produtos.</a>
                </li>
            </ul>
        </div>
    </div>

<?
endif;
?>