<div class="grid_24">

    <div class="caixa">

        <table width="100%" class="espacada" style="margin: 0 auto;">
            <tbody>

                <?
                if (!isset($_GET['msg'])):
                    ?>

                    <tr>
                        <td colspan="2">

                            <div id="erro">Desculpe! Você não possui acesso a esta funcionalidade. Dúvidas, entre em contato com o administrador do sistema.</div>

                        </td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td align="center" colspan="2">
                            <a href="javascript:history.back()">Voltar</a>
                        </td>
                    </tr>

                    <?
                else:
                    ?>

                    <tr>
                        <td colspan="2">

                            <?= $_GET['msg']; ?>

                        </td>
                    </tr>

                <?
                endif;
                ?>

            </tbody>
        </table>
    </div>

</div>