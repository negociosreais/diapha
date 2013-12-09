<?
if (checa_permissao_perfil(array('gestor', 'colaborador'), true)):
    ?>

    <script>
                                                                    
        $(document).ready(function() {
                                    
            $( "#tabs" ).tabs();
                                                                       
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

        <h1 class="tituloCaixa">OPORTUNIDADES</h1>
        <div class="caixa">

            <div id="tabs">
                <ul>
                    <li><span id="numero15"><a href="#tabs-1" title="Oportunidades de licitação">Licitações</a></span></li>
                    <li><span id="numero16"><a href="#tabs-2" title="Oportunidades de compra qualificada">Compra Qualificada</a></span></li>
                    <li><span id="numero17"><a href="#tabs-3" title="Oportunidades de compra">Compra</a></span></li>
                    <li><span id=""><a href="#tabs-4" title="Ajude na confecção deste Termo de Referência">Termos de Referências</a></span></li>
                </ul>

                <div id="tabs-1">

                    <p><b>O que são:</b></p>
                    <p>
                        Oportunidades de licitações futuras enviadas pelos próprios Órgãos e Empresas Públicas.<br>
                        Estas oportunidades deverão ser respondidas com proposta orçamentária, e após o envio o Órgão poderá lhe convocar para o certame , como também para auxilia-lo na especificação do produto.
                    </p>

                    <table width="100%" class="lista">

                        <?
                        if (count($estimativas) > 0) :

                            foreach ($estimativas as $oportunidade) :

                                // verificar a quantidade de respostas e comentários
                                $param['id_vendedor'] = usuario('id_vendedor');
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

                                $datahora = explode(" ", $oportunidade['dt_cadastro']);

                                $tipo = ($oportunidade['id_acesso'] != '') ? "Oportunidade de Adesão" : "Oportunidade de Licitação";

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
                                        por 
                                        <b><?= $oportunidade['nm_orgao']; ?></b>
                                    </td>

                                    <td width="220" class="right">
                                        <?
                                        if ($oportunidade['id_estimativa'] != '' && $qtd_respostas == 0):
                                            ?>
                                            <a href="<?= site_url('ep/detalhes/' . $oportunidade['id_estimativa']); ?>" title="Mais detalhes">
                                                <input type="button" class=" btn btn-danger" value="Responder em <?= $tempo_restante; ?>" style="width:210px" />
                                            </a>
                                            <?
                                        elseif ($oportunidade['id_estimativa'] != ''):
                                            ?>
                                            <i><b><?= $qtd_comentarios; ?></b> comentários</i>
                                            <?
                                        elseif ($oportunidade['id_interesse'] != ''):
                                            ?>
                                            <img src="<?= base_url() . TEMPLATE; ?>/img/estrela.png" height="30" title="O órgão público tem interesse real em seu produto." />
                                            <?
                                        endif;
                                        ?>
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
                                                <img src="<?= base_url() . TEMPLATE; ?>/img/icones/plus.png" />
                                            </a>
                                            <?
                                        endif;
                                        ?>

                                        <?
                                        if ($oportunidade['id_interesse'] != ''):
                                            ?>
                                            <a href="<?= site_url('produto_interesse/detalhes/' . $oportunidade['id_interesse']); ?>" title="Mais detalhes">
                                                <img src="<?= base_url() . TEMPLATE; ?>/img/icones/plus.png" />
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
                                    <span class='legenda'>Nenhuma oportunidade até o momento!</span>
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

                <div id="tabs-2">

                    <p><b>O que são:</b></p>
                    <p>
                        Significa que o Órgão ou Empresa Pública acessou o seu produto e informou que está realmente interessado.
                    </p>


                    <table width="100%" class="lista">

                        <?
                        if (count($interesses) > 0) :

                            foreach ($interesses as $oportunidade) :

                                // verificar a quantidade de respostas e comentários
                                $param['id_vendedor'] = usuario('id_vendedor');
                                ?>

                                <tr>
                                    <td width="50">
                                        <?
                                        if ($oportunidade['nm_logo'] != ''):
                                            ?>
                                            <img src="<?= base_url(); ?>/arquivos/logos/<?= $oportunidade['nm_logo']; ?>" height="50"  class="img-polaroid"/>
                                            <?
                                        else:
                                            ?>
                                            <img src="<?= base_url() . TEMPLATE; ?>/img/logoGovernoP.jpg" class="img-polaroid" />
                                        <?
                                        endif;
                                        ?>
                                    </td>
                                    <td>
                                        <b><?= $oportunidade['nm_produto'] . " - " . $oportunidade['nm_marca']; ?></b>


                                        - Quantidade: <?= ($oportunidade['qtd_interesse']) ? $oportunidade['qtd_interesse'] : "Não informado"; ?>
                                        <br>
                                        informado em <?= formataDate($oportunidade['dt_interesse'], '-') . " às " . $oportunidade['hr_interesse']; ?>
                                        por 
                                        <b><?= $oportunidade['nm_orgao']; ?></b>
                                    </td>

                                    <td width="20">

                                        <a href="<?= site_url('produto_interesse/detalhes/' . $oportunidade['id_interesse']); ?>" title="Mais detalhes">
                                            <img src="<?= base_url() . TEMPLATE; ?>/img/icones/plus.png" />
                                        </a>

                                    </td>

                                </tr>
                                <?
                            endforeach;

                        else :
                            ?>

                            <tr>
                                <td colspan="7">
                                    <span class='legenda'>Nenhuma oportunidade até o momento!</span>
                                </td>
                            </tr>

                        <? endif; ?>

                        <tr>
                            <td colspan="7" class="right">
                                <a href="<?= site_url("produto_interesse/listar"); ?>">
                                    Ver todos
                                </a>
                            </td>
                        </tr>
                    </table>

                </div>

                <div id="tabs-3">

                    <p><b>O que são:</b></p>

                    <p>
                        Significa que o Órgão ou Empresa Pública acessou o seu produto e pode estar interessado.
                    </p>

                    <table width="100%" class="lista">

                        <?
                        if (count($acessos) > 0) :

                            foreach ($acessos as $oportunidade) :

                                // verificar a quantidade de respostas e comentários
                                $param['id_vendedor'] = usuario('id_vendedor');

                                $datahora = explode(" ", $oportunidade['dt_cadastro']);
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

                                        <b><?= $oportunidade['nm_produto'] . " - " . $oportunidade['nm_marca']; ?></b>
                                        <br>
                                        acessado em <?= formataDate($datahora[0], '-') . " às " . $datahora[1]; ?>
                                        por 
                                        <b><?= $oportunidade['nm_orgao']; ?></b>
                                    </td>

                                    <td width="20">

                                        <a href="<?= site_url('produto_acesso/detalhes/' . $oportunidade['id_acesso']); ?>" title="Mais detalhes">
                                            <img src="<?= base_url() . TEMPLATE; ?>/img/icones/plus.png" />
                                        </a>

                                    </td>

                                </tr>
                                <?
                            endforeach;

                        else :
                            ?>

                            <tr>
                                <td colspan="7">
                                    <span class='legenda'>Nenhuma oportunidade até o momento!</span>
                                </td>
                            </tr>

                        <? endif; ?>

                        <tr>
                            <td colspan="7" class="right">
                                <a href="<?= site_url("produto_acesso/listar"); ?>">
                                    Ver todos
                                </a>
                            </td>
                        </tr>
                    </table>

                </div>

                <div id="tabs-4">

                    <p><b>O que são:</b></p>
                    <p>
                       Aqui você encontra todos os convites dos órgãos para auxiliar na descrição do Termo de Referencia, acesse e auxilie-os, pois possivelmente este órgão esteja com dificuldades em descrever o Termo de Referência.
                    </p>

                    <table width="100%" class="lista">

                        <?
                        
                        if (count($documentos) > 0) :

                            foreach ($documentos as $documento) :

                                $datahora = explode(" ", $documento['dt_cadastro']);
                                ?>

                                <tr>
                                    <td width="50">
                                        <?
                                        if ($documento['nm_logo'] != ''):
                                            ?>
                                            <img src="<?= base_url(); ?>/arquivos/logos/<?= $documento['nm_logo']; ?>" height="50" class="img-polaroid" />
                                            <?
                                        else:
                                            ?>
                                            <img src="<?= base_url() . TEMPLATE; ?>/img/logoGovernoP.jpg" class="img-polaroid" />
                                        <?
                                        endif;
                                        ?>
                                    </td>
                                    <td>
                                        <b><?= $documento['nm_documento']; ?></b>

                                        <br>
                                        publicado em <?= formataDate($datahora[0], '-') . " às " . $datahora[1]; ?>
                                        por 
                                        <b><?= $documento['nm_orgao']; ?></b>
                                    </td>

                                    <td width="120" class="right">

                                        <a href="<?= site_url('termo_referencia/' . $documento['id_documento']); ?>/comentarios" title="Clique aqui e ajude na confecção deste Termo de ReferÊncia." target="_blank">
                                            <input type="button" class=" btn btn-success" value="Participar" />
                                        </a>
                                    </td>

                                </tr>
                                <?
                            endforeach;

                        else :
                            ?>

                            <tr>
                                <td colspan="7">
                                    <span class='legenda'>Nenhuma oportunidade até o momento!</span>
                                </td>
                            </tr>

                        <? endif; ?>

                        <!--<tr>
                            <td colspan="7" class="right">
                                <a href="<?= site_url("ep/listar"); ?>">
                                    Ver todos
                                </a>
                            </td>
                        </tr>-->
                    </table>

                </div>

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