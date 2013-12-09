<div class="grid_19">


    <div class="caixa">

        <h1 class="tituloCaixa">CATEGORIAS</h1>
        <? showStatus(); ?>

        <table width="100%">

            <tr>
                <td valign="bottom">
                    <a href="<?= site_url('relato/categoria/cadastrar'); ?>" class="btn btn-success">
                        Cadastrar Nova Categoria
                    </a>
                </td>
            </tr>

            <tr><td>&nbsp;<td></tr>

            <tr>
                <td>
                    <table width="100%" class="lista">
                        <tr>

                            <th align="left" width="120"></th>
                            <th align="left">Categoria</th>

                            <th align="left" width="50">Status</th>
                            <th align="left" width="25">&nbsp;</th>
                            <th align="left" width="25">&nbsp;</th>
                        </tr>

                        <?
                        if (count($dados) > 0) :

                            foreach ($dados as $dado) :
                                $class = "";
                                if ($dado['st_status'] == "Inativo"):
                                    $class = ' class="statusInativo"';
                                endif;

                                $icones = unserialize($dado['ds_icones']);
                                ?>

                                <tr <?= $class; ?>>

                                    <td valign="middle" align="center">

                                        <img src="<?= base_url(); ?>/arquivos/diapha/ico/<?= $icones['vermelho']; ?>" border="0"/>
                                        <img src="<?= base_url(); ?>/arquivos/diapha/ico/<?= $icones['amarelo']; ?>" border="0"/>
                                        <img src="<?= base_url(); ?>/arquivos/diapha/ico/<?= $icones['verde']; ?>" border="0"/>

                                    </td>
                                    <td>
                                        <?= $dado['nm_categoria']; ?>
                                    </td>

                                    <td align="center">
                                        <?= $dado['st_status']; ?>
                                    </td>



                                    <td valign="middle" align="center">

                                        <a href="<?= site_url('relato/categoria/' . $dado['id_categoria'] . '/editar'); ?>" alert="Editar" title="Editar">
                                            <img src="<?= base_url() . TEMPLATE ?>/img/icones/edit.png" border="0" title="Editar" />
                                        </a>

                                    </td>
                                    <td valign="middle" align="center">

                                        <a href="javascript:confirmaApagar('<?= site_url('relato/categoria/' . $dado['id_categoria'] . '/deletar'); ?>')" alert="Excluir" title="Excluir">
                                            <img src="<?= base_url() . TEMPLATE ?>/img/icones/delete.png" border="0" title="Excluir" />
                                        </a>

                                    </td>
                                </tr>
                                <?
                            endforeach;

                        else :
                            ?>

                            <tr>
                                <td colspan="5">
                                    <span class='legenda'>Nenhum registro!</span>
                                </td>
                            </tr>


                        <? endif; ?>
                    </table>

                </td>
            </tr>
            <tr>
                <td>
                    <div class="paginacao">
                        <?= $this->pagination->create_links(); ?>
                    </div>
                </td>
            </tr>


        </table>

    </div>

</div>