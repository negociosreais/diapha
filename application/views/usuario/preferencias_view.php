<div class="grid_24">

    <? showStatus(); ?>
    <div class="caixa">

        <h1 class="tituloCaixa">Preferências</h1>

        <p>
            <img src="<?= base_url() . TEMPLATE; ?>/img/check.png" align="left" width="80" style="margin-right: 20px" />
            Para que possamos ajuda-lo, é necessário selecionar abaixo as categorias de ocorrências às quais seu órgão é responsável ou tem interesse de acompanhar.
            Com esses dados você poderá responder informando as providências dadas a cada relato que surgir. Poderá também ter acesso a relatórios e gráficos
            detalhados, complementando assim o seu trabalho. Juntos iremos fazer da nossa cidade um lugar ainda melhor pra se viver.
        </p>

        <fieldset class="form">

            <form name="preferencias" id="preferencias" action="<?=site_url('usuario/atualizar_preferencias'); ?>" method="POST" >
                
                <input type="hidden" name="id_usuario" id="id_usuario" value="<?= $dado['id_usuario']; ?>" />

                <!-- Dados pessoais -->
                <fieldset>

                    <table>

                        <tr>
                            <td>

                                <?
                                checkbox("id_categoria", $cbo_categorias, '3', $marcados);
                                ?>

                            </td>
                        </tr>

                        <tr><td></td></tr>

                        <tr>
                            <td style="padding: 8px">
                                <input type="submit" name="btn_gravar" value="Gravar" class="btn btn-info btn-large" />

                                <input type="button" name="btn_cancelar" value="Cancelar" onclick="history.back()"  class="btn btn-info btn-large" />        
                            </td>
                        </tr>

                    </table>

                </fieldset>

            </form>

        </fieldset>

    </div>
</div>