<?
$icones = unserialize($dado['ds_icones']);
?>


<div class="grid_19">


    <div class="caixa">

        <h1 class="tituloCaixa">EDITAR CATEGORIA</h1>
        <? showStatus(); ?>

        <fieldset class="form espaco">

            <form name="cadastrar_categoria" action="<?= site_url("relato/categoria/atualizar"); ?>" enctype="multipart/form-data" method="POST"  >

                <input type="hidden" name="id_categoria" value="<?= $dado['id_categoria']; ?>" />

                <table width="100%">

                    <tr>
                        <td width="170"><label>Nome: *</label></td>
                        <td>

                            <input name="nm_categoria" type="text" size="80" value="<?= $dado['nm_categoria']; ?>" />

                        </td>
                    </tr>

                    <tr>
                        <td width="170"><label>Apelido: *</label></td>
                        <td>

                            <input name="nm_apelido" type="text" value="<?= $dado['nm_apelido']; ?>" size="80" placeholder="Somente letras minúsculas e sem espaço ou caractéres especiais." />

                        </td>
                    </tr>

                    <tr>
                        <td width="170"><label>Icone vermelho: *</label></td>
                        <td>

                            <input name="ico_vermelho" type="file" />
                            <img src="<?= base_url(); ?>/arquivos/diapha/ico/<?= $icones['vermelho']; ?>" border="0"/>

                        </td>
                    </tr>

                    <tr>
                        <td width="170"><label>Icone amarelo: *</label></td>
                        <td>

                            <input name="ico_amarelo" type="file" />
                            <img src="<?= base_url(); ?>/arquivos/diapha/ico/<?= $icones['amarelo']; ?>" border="0"/>

                        </td>
                    </tr>

                    <tr>
                        <td width="170"><label>Icone verde: *</label></td>
                        <td>

                            <input name="ico_verde" type="file" />
                            <img src="<?= base_url(); ?>/arquivos/diapha/ico/<?= $icones['verde']; ?>" border="0"/>

                        </td>
                    </tr>

                    <tr>
                        <td><label>Status: *</label></td>
                        <td>
                            <? $cbo_status = array("Ativo" => "Ativo", "Inativo" => "Inativo"); ?>
                            <?= form_dropdown('st_status', $cbo_status, $dado['st_status'], 'id="st_status"') ?>
                        </td>
                    </tr>


                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="btn_gravar" value="Gravar" class="btn btn-success" />

                            <input type="button" name="btn_cancelar" value="Cancelar" onclick="history.back()" class="btn btn-success" />                     
                        </td>
                    </tr>
                </table>

            </form>

        </fieldset>

    </div>

</div>