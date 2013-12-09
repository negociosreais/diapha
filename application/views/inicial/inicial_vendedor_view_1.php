<div>
    <div class="vendedor box-branco" style="display:table-cell">

        <? showStatus(); ?>

        <div class="creditos">
            <div class="col-1 box-branco">
                
                <div><b>Créditos para Anúncio:</b></div>
                <div>
                    Créditos: <span class="creditos"><?= ($qt_anuncio != '') ? $qt_anuncio : '0'; ?></span>
                    
                    <div style="float: right">
                        <a href="<?= site_url('ata/assinatura/planos/Anuncio'); ?>" title="Adicionar Créditos" class="botao">
                            Contratar
                        </a>
                    </div>
                </div>

            </div>

            <div class="col-2 box-branco">
                
                <div><b>Créditos Destaque Portal ARP:</b></div>
                <div>
                    Créditos: <span class="creditos"><?= ($qt_adwords != '') ? $qt_adwords : '0'; ?></span> 
                    <div style="float: right">
                        <a href="<?= site_url('ata/assinatura/planos/Adwords'); ?>" title="Adicionar Créditos" class="botao">
                            Contratar
                        </a>
                    </div>
                </div>

            </div>

            <div class="col-3 box-branco">
                
                <div><b>Créditos para Leads:</b></div>
                <div>
                    Créditos: <span class="creditos"><?= ($qt_leads != '') ? $qt_leads : '0'; ?></span>
                    <div style="float: right">
                        <a href="<?= site_url('ata/assinatura/planos/Leads'); ?>" title="Adicionar Créditos" class="botao">
                            Contratar
                        </a>
                    </div>
                </div>

            </div>
        </div>


        <!-- Coluna 1 -->

        <div class="col-1">

            <div class="acessos box-branco">

                <h2>Últimos Leads</h2>

                <table width="100%">

                    <tr>
                        <td>
                            <table width="100%" class="lista">
                                <tr>
                                    <th align="left">Produto</th>
                                    <th align="left">Marca</th>
                                    <th align="left" width="100">Data-Hora</th>
                                    <th align="left">Órgão</th>
                                    <th align="left" width="50">&nbsp;</th>

                                </tr>

                                <?
                                if (count($acessos) > 0) :

                                    foreach ($acessos as $acesso) :
                                        ?>

                                        <tr>
                                            <td>
                                                <?= $acesso['nm_produto']; ?>
                                            </td>
                                            <td>
                                                <?= $acesso['nm_marca']; ?>
                                            </td>
                                            <td>
                                                <?= formataDate($acesso['dt_acesso'], '-') . " - " . $acesso['hr_acesso']; ?>
                                            </td>
                                            <td valign="middle" align="left">
                                                <?= $acesso['nm_orgao']; ?>
                                            </td>
                                            <td>
                                                <a href="<?= site_url('produto_acesso/detalhes/' . $acesso ['id_acesso']); ?>">
                                                    + detalhes
                                                </a>
                                            </td>

                                        </tr>
                                        <?
                                    endforeach;

                                else :
                                    ?>

                                    <tr>
                                        <td colspan="7">
                                            <span class='legenda'>Nenhum acesso até o momento!</span>
                                        </td>
                                    </tr>

                                <? endif; ?>

                                <tr>
                                    <td colspan="7" align="right">
                                        <a href="<?= site_url("produto_acesso/listar"); ?>">
                                            Todos
                                        </a>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                </table>

            </div>

        </div>

        <!-- Coluna 2 -->

        <div class="col-2">

            <div class="produtos box-branco">

                <h2>Últimos Produtos
                    <div align="right" style="float:right">

                        <a href="<?= site_url('produto/cadastrar'); ?>" alt="Anunciar novo Produto" title="Anunciar novo Produto">
                            <img src="<?= base_url() ?>template/img/icons/add.png" width="16" height="16" border="0" />
                        </a>

                    </div>

                </h2>

                <table width="100%">

                    <tr>
                        <td>
                            <table width="100%" class="lista">
                                <tr>
                                    <th align="center" width="100"></th>

                                    <th align="left">Produto</th>
                                    <th align="left">Marca</th>
                                    <th align="left">Anunciado até</th>
                                    <th align="left" width="25">&nbsp;</th>

                                </tr>

                                <?
                                if (count($produtos) > 0) :

                                    foreach ($produtos as $produto) :
                                        ?>

                                        <tr>
                                            <td>
                                                <img src="<?= base_url() ?>arquivos/produtos/t_<?= $produto['nm_imagem'] ?>" />
                                            </td>

                                            <td>
                                                <?= $produto['nm_produto']; ?>
                                            </td>
                                            <td>
                                                <?= $produto['nm_marca']; ?>
                                            </td>
                                            <td>
                                                <?= formataDate($produto['dt_anunciado'], "-"); ?>
                                            </td>
                                            <td valign="middle" align="center">

                                                <a href="<?= site_url('produto/' . $produto['id_produto'] . '/editar'); ?>" alt="Editar Produto" title="Editar Produto">
                                                    <img src="<?= base_url() ?>template/img/icons/page_edit.png" width="16" height="16" border="0" />
                                                </a>

                                            </td>

                                        </tr>
                                        <?
                                    endforeach;

                                else :
                                    ?>

                                    <tr>
                                        <td colspan="7">
                                            <span class='legenda'>Nenhum produto cadastrado no momento!</span>
                                        </td>
                                    </tr>

                                <? endif; ?>

                                <tr>
                                    <td colspan="7" align="right">
                                        <a href="<?= site_url("produto/listar"); ?>">
                                            Todos
                                        </a>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                </table>

            </div>


        </div>

    </div>
</div>
