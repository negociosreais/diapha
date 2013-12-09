<div class="grid_24">

    <? showStatus(); ?>
    <div class="caixa">

        <h1 class="tituloCaixa">Convide sua equipe para colaborar</h1>


        <p>
            <img src="<?= base_url() . TEMPLATE; ?>/img/equipe.png" align="left" style="margin-right: 20px" />
            Convide sua equipe para colaborar com seu trabalho. Eles também poderão responder as ocorrências recebidas.
        </p>

        <form name="convidar" id="convidar" action="<?= site_url('enviar_convite'); ?>" method="POST" >

            <input type="hidden" name="id_usuario" id="id_usuario" value="<?= usuario('id_usuario'); ?>" />

            <p>
                Digite o endereço de e-mail de seus colaboradores separando cada um com vírgula (,):<br>
                <textarea cols="120" rows="5" name="ds_email" placeholder="Ex.: joao@exemplo.com, maria@exemplo.com, paulo@exemplo.com"></textarea>
            </p>

            <p>
                <input type="submit" name="btn_gravar" value="Enviar convite" class="btn btn-info" />

                <input type="button" name="btn_cancelar" value="Cancelar" onclick="history.back()"  class="btn btn-info" />        
            </p>


        </form>

    </div>

</div>