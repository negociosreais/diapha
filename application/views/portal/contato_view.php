<script>

    $(document).ready(function(){

        /**
         * Mascaras
         */
        $("input[name*='telefone']").setMask({ mask: '(99) 9999-9999 / (99) 9999-9999 / (99) 9999-9999'});
        $("input[name*='celular']").setMask({ mask: '(99) 9999-9999 / (99) 9999-9999 / (99) 9999-9999'});


    });
</script>

<div class="grid_24">

    <div class="caixa">

        <h1 class="tituloCaixa">CONTATO</h1>

        <? showStatus(); ?>

        <fieldset class="form espaco">

            <form name="contato" action="<?= site_url("portal/enviar_mensagem"); ?>" enctype="multipart/form-dplano" method="POST"  >

                <table width="100%">

                    <tr>
                        <td width="250"><label>Nome: *</label></td>
                        <td>

                            <input name="nome" type="text" size="80" />

                        </td>
                    </tr>
                    <tr>
                        <td><label>Empresa: </label></td>
                        <td>

                            <input name="empresa" type="text" size="80" />

                        </td>
                    </tr>
                    <tr>
                        <td><label>Telefone: </label></td>
                        <td>

                            <input name="telefone" type="text" size="80" maxlength="50" />

                        </td>
                    </tr>
                    <tr>
                        <td><label>Celular: </label></td>
                        <td>

                            <input type="text" name="celular" size="80" />

                        </td>
                    </tr>
                    <tr>
                        <td><label>E-mail: *</label></td>
                        <td>

                            <input type="text" name="email" size="80" />

                        </td>
                    </tr>
                    <tr>
                        <td><label>Assunto:</label></td>
                        <td>

                            <input type="text" name="assunto" size="80" />

                        </td>
                    </tr>
                    <tr>
                        <td><label>Mensagem: *</label></td>
                        <td>
                            <textarea name="mensagem" cols="77" rows="5"></textarea>
                        </td>

                    </tr>

                    <tr><td></td></tr>

                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="btn_enviar" value="Enviar" class="btn btn-info" />

                            <input type="reset" name="btn_limpar" value="Limpar" class="btn btn-info" />
                        </td>
                    </tr>
                    <tr><td></td></tr>

                </table>

            </form>

        </fieldset>

    </div>

</div>

