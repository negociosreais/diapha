<?
if (checa_permissao_perfil(array('gestor', 'colaborador'), true)):
    ?>

    <script>
        // Alternar cor das linhas das listas
        alterarCorLinhas();
                
        // Alterar cor da linha quando passar o mouse em cima
        alterarCorLinhasMouse();
    </script>

    <div class="grid_19">

        <h1 class="tituloCaixa">OPORTUNIDADES</h1>
        <div class="caixa">

            <table width="100%" class="lista">

                <?
                if (count($acessos) > 0) :

                    foreach ($acessos as $acesso) :
                        ?>

                        <tr>
                            <td width="50">
                                <img src="<?= base_url() . TEMPLATE; ?>/img/foto.png" />
                            </td>
                            <td>
                                <b><?= $acesso['nm_produto']; ?>&nbsp;-&nbsp;<?= $acesso['nm_marca']; ?></b>
                                <br>
                                acessado em <?= formataDate($acesso['dt_acesso'], '-') . " às " . $acesso['hr_acesso']; ?>
                                por 
                                <b><?= $acesso['nm_orgao']; ?></b>
                            </td>

                            <td width="30">
                                <a href="<?= site_url('produto_acesso/detalhes/' . $acesso ['id_acesso']); ?>" title="Mais detalhes">
                                    <img src="<?= base_url() . TEMPLATE; ?>/img/icones/plus.png" />
                                </a>
                            </td>

                        </tr>
                        <?
                    endforeach;

                else :
                    ?>

                    <tr>
                        <td colspan="7">
                            <span class='legenda'>Nenhum acesso até o momento!</span>
                        </td>
                    </tr>

                <? endif; ?>

                <tr>
                    <td colspan="7" class="right">
                        <a href="<?= site_url("produto_acesso/listar"); ?>">
                            Ver todos
                        </a>
                    </td>
                </tr>
            </table>

        </div>

    </div>

    <?
else:
    ?>
    <div class="grid_19">
        <h1 class="tituloCaixa">SEJA BEM VINDO!</h1>
        <div class="caixa">
            <br >
            <ul>
                <li>
                    <a href="<?=site_url('ata/cadastrar'); ?>">1 - Cadastre sua ata ou portfólio.</a>
                </li>
                <li>
                    <a href="<?=site_url('produto/cadastrar'); ?>">2 - Cadastre seus produtos.</a>
                </li>
            </ul>
        </div>
    </div>

<?
endif;
?>