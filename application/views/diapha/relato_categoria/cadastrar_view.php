<div class="grid_19">


    <div class="caixa">
        <h1 class="tituloCaixa">CADASTRAR CATEGORIA</h1>
        <? showStatus(); ?>

        <fieldset class="form espaco">

            <form name="cadastrar_categoria" action="<?= site_url("relato/categoria/inserir"); ?>" enctype="multipart/form-data" method="POST"  >

                <table width="100%">

                    <tr>
                        <td width="170"><label>Nome: *</label></td>
                        <td>

                            <input name="nm_categoria" type="text" size="80" />

                        </td>
                    </tr>

                    <tr>
                        <td width="170"><label>Apelido: *</label></td>
                        <td>

                            <input name="nm_apelido" type="text" size="80" placeholder="Somente letras minúsculas e sem espaço ou caractéres especiais." />

                        </td>
                    </tr>

                    <tr>
                        <td width="170"><label>Icone vermelho: *</label></td>
                        <td>

                            <input name="ico_vermelho" type="file" />

                        </td>
                    </tr>

                    <tr>
                        <td width="170"><label>Icone amarelo: *</label></td>
                        <td>

                            <input name="ico_amarelo" type="file" />

                        </td>
                    </tr>

                    <tr>
                        <td width="170"><label>Icone verde: *</label></td>
                        <td>

                            <input name="ico_verde" type="file" />

                        </td>
                    </tr>

                    <tr>
                        <td><label>Status: *</label></td>
                        <td>
                            <? $cbo_status = array("Ativo" => "Ativo", "Inativo" => "Inativo"); ?>
                            <?= form_dropdown('st_status', $cbo_status, NULL, 'id="st_status"') ?>
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