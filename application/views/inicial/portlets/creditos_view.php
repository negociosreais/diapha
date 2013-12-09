<?
if (checa_permissao_perfil(array('gestor', 'colaborador'), true)):
    ?>

    <script>

        $(document).ready(function() {
                       
                       
        });

    </script>

    <div class="grid_9" style="position: absolute;">

        <div class="creditos">
            <b>Destaque</b><br>
            <span class="numero"><?= ($qt_destaque != '') ? $qt_destaque : '0'; ?> crédito(s)</span>
            <button class="btn btn-success" onclick="window.location.href='<?= site_url('ata/assinatura/planos/Adwords'); ?>'">Contrate</button>
        </div>

        <?
        if ($qt_leads > 0):
            ?>
            <div class="creditos">
                <b>Oportunidade</b><br>
                <span class="numero"><?= ($qt_leads != '') ? $qt_leads : '0'; ?> crédito(s)</span>
                <button class="btn btn-success" onclick="window.location.href='<?= site_url('ata/assinatura/planos/Leads'); ?>'">Contrate</button>
            </div>
            <?
        endif;
        ?>

        <?
        if ($qt_anuncio > 0):
            ?>
            <div class="creditos">
                <b>Anúncio</b><br>
                <span class="numero"><?= ($qt_anuncio != '') ? $qt_anuncio : '0'; ?> crédito(s)</span>
                <!--<button class="btn btn-success" onclick="window.location.href='<?= site_url('ata/assinatura/planos/Anuncio'); ?>'">Contrate</button>-->
            </div>
            <?
        endif;
        ?>

        <div class="creditos">
            <b>Plano de Serviços</b><br>
            <span id="numero4">
                <button class="btn btn-success" onclick="window.location.href='<?= site_url('contratacao/planos'); ?>'">Contrate</button>
            </span>
        </div>
    </div>

    <?
endif;
?>