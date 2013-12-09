<div class="grid_24">

    <div class="caixa">

        <h1 class="tituloCaixa">Esqueci a Senha</h1>

        <fieldset class="form">

            <form name="login" method="post" action="esqueci_senha">

                <table width="100%">

                    <tr>
                        <td colspan="2">
                    <? showStatus(); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <p>Se você esqueceu sua senha preencha os campos abaixo e enviaremos uma nova senha para você.</p>
                        </td>
                    </tr>

                    <tr>
                        <td width="150">
                            <label>E-mail:</label>
                        </td>
                        <td>
                            <input type="text" name="ds_email" size="80" />
                            <input type="submit" name="botao" value="Enviar" class="btn btn-primary btn-large input-large" />
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                </table>

            </form>
        </fieldset>

    </div>
</div>
