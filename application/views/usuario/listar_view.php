<div class="grid_19">


    <div class="caixa">

        <h1 class="tituloCaixa">USUÁRIOS</h1>
        <? showStatus(); ?>

        <table width="100%">

            <tr>
                <td colspan="7">
                    <fieldset class="form well">
                        <form name="busca" action="<?= site_url('usuario/listar'); ?>" method="GET">

                            <input type="hidden" name="e" value="<?= $_GET['e']; ?>" />

                            <table width="100%">
                                <tr>
                                    <td>
                                        <input type="text" name="busca" size="60" />
                                        <button name="btn_buscar" class="btn btn-success btn-large">Buscar</button>
                                        Ex.: nome, login ou e-mail
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </fieldset>
                </td>
            </tr>

            <tr>
                <td>
                    <table width="100%" class="lista">

                        <?
                        if (count($dados) > 0) :

                            foreach ($dados as $dado) :

                                $datahora = explode(" ", $dado['datahora_cadastro']);
                                $dt_cadastro = formataDate($datahora[0], "-");
                                $hr_cadastro = substr($datahora[1], 0, 5);
                                ?>

                                <tr>
                                    <td width="50">
                                        <a href="<?= site_url('usuario/editar_foto'); ?>?id_usuario=<?= $dado['id_usuario']; ?>" id="botaoAddFoto" title="Clique para a editar a foto do usuário.">
                                            <?
                                            if ($dado['fb_user'] != ''):
                                                ?>
                                                <img src="https://graph.facebook.com/<?= $dado['fb_user']; ?>/picture?width=50&height=50" class="img-polaroid" />
                                                <?
                                            elseif ($dado['nm_foto'] != ''):
                                                ?>
                                                <img src="<?= base_url() . "arquivos/usuarios/" . $dado['nm_foto']; ?>" height="50" class="img-polaroid" />
                                                <?
                                            else:
                                                ?>

                                                <img src="<?= base_url() . TEMPLATE . "/img/foto.jpg" ?>" class="img-polaroid" />
                                            <?
                                            endif;
                                            ?>
                                        </a>
                                    </td>
                                    <td>
                                        <b><?= $dado['nm_usuario']; ?></b>
                                        <?= ($dado['nm_cargo'] != '') ? "(" . $dado['nm_cargo'] . ")" : ""; ?> 
                                        - usuário desde <?= formata_data_extenso($dt_cadastro) . " " . $hr_cadastro; ?> <br>
                                        <?= $dado['nm_empresa'] . $dado['nm_orgao']; ?>
                                    </td>
                                    <td width="25" align="center">

                                        <a href="<?= site_url('usuario/' . $dado['id_usuario'] . '/editar'); ?>" alert="Editar" title="Editar">
                                            <img src="<?= base_url() . TEMPLATE ?>/img/icones/edit.png" border="0" title="Editar" />
                                        </a>

                                    </td>
                                    <td width="25" align="center">

                                        <a href="javascript:confirmaApagar('<?= site_url('usuario/' . $dado['id_usuario'] . '/deletar'); ?>')" alert="Excluir" title="Excluir">
                                            <img src="<?= base_url() . TEMPLATE ?>/img/icones/delete.png" border="0" title="Excluir" />
                                        </a>

                                    </td>

                                </tr>
                                <?
                            endforeach;

                        else :
                            ?>

                            <tr>
                                <td>
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
