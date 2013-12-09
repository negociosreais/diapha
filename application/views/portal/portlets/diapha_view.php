<script>
    // Alternar cor das linhas das listas
    alterarCorLinhas();
    
    // Alterar cor da linha quando passar o mouse em cima
    alterarCorLinhasMouse();
</script>

<div class="grid_19">

    <h1 class="tituloCaixa">DIAPHA</h1>
    <div class="caixa">

        <table width="100%" class="lista">

            <tr>
                <td>
                    <img src="<?= base_url() . TEMPLATE; ?>/img/foto.png" />
                </td>
                <td>
                    <b>Tribunal Superior do Trabalho</b> acessado em <?= formataDate($acesso['dt_acesso'], '-') . " às " . $acesso['hr_acesso']; ?>
                </td>

                <td>
                    <a href="<?= site_url('produto_acesso/detalhes/' . $acesso ['id_acesso']); ?>" title="Mais detalhes">
                        <img src="<?= base_url() . TEMPLATE; ?>/img/icones/plus.png" />
                    </a>
                </td>

            </tr>

        </table>

    </div>

</div>