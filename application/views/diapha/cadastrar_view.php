<div class="grid_19">

    <h1 class="tituloCaixa">PUBLICAR DOCUMENTO</h1>
    <? showStatus(); ?>
    <div class="caixa">

        <fieldset class="form espaco">

            <form name="cadastrar_ata" action="<?= site_url("diapha/relato/inserir"); ?>" enctype="multipart/form-data" method="POST"  >


                <table width="100%">

                    <tr>
                        <td><label>Arquivo:</label></td>
                        <td>

                            <input type="file" name="foto" size="80" />

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