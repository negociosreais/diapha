<script type="text/javascript" src="<?= base_url() . TEMPLATE; ?>/js/jquery.qtip-1.0.0-rc3.min.js"></script>

<script>
    $(document).ready(function() {
        
        // ToolTip
        $("a, img, button, input, select, span").each(function() {
            if ($(this).attr("title") != null && $(this).attr("title") != ""){
                $(this).tipTip({maxWidth: "auto", edgeOffset: 10});
            }
        });
        
        //setInterval('carregarNotificacoes()', 20000);
        
        // Mostrar mais
        $("#mostrarMaisNotificacoes").click(function() {
            
            $(this).html("<div class='center'><img src='<?= base_url() . TEMPLATE . '/img/ajax-loader.gif'; ?>' /></div>");
            
            limitNotificacoes = limitNotificacoes + 2;
            carregarNotificacoes();
            
            $('body').animate({
                scrollTop: $(this).offset().top - 300
            }, 1000);
            
        });
        
        $(".notificacoes tr").mouseover(function() {
            $(this).removeClass("alterna"); 
        });
                           
    });
    
    function lido(id_notificacao) {
    
        $.post('<?= site_url('notificacao/lido') ?>',
        { id_notificacao: id_notificacao},

        function(data) {
            qtdNotificacoes();
        });
    
    }
    
    function qtdNotificacoes() {
    
        $.post('<?= site_url('notificacao/qtd_notificacoes') ?>',
        { },

        function(data) {
            $("#qtdNotificacoes").html(data);
        });
    
    }
    
    
    
</script>


<h1 class="tituloCaixa">NOTIFICAÇÕES </h1>

<div id="qtdNotificacoes" class="badge badge-important" style="position: absolute; margin-top: -32px; margin-left: 190px" title="Notificações não lidas">
    <?= $nao_lidas; ?>
</div>

<div class="caixa">


    <table width="100%" class="lista notificacoes">

        <?
        if (count($notificacoes) > 0) :

            foreach ($notificacoes as $notificacao) :

                $datahora = explode(" ", $notificacao['datahora_cadastro']);

                $lido = "";
                if ($notificacao['st_lido'] == '0'):
                    $lido = 'onmouseover="lido(\'' . $notificacao[id_notificacao] . '\')" class="alterna"';
                endif;

                if (isset($notificacao['ds_notificacao'])):
                    ?>

                    <tr <?= $lido; ?>>

                        <td colspan="2">
                            <a href="<?= site_url($notificacao['ds_url']); ?>">
                                <?= $notificacao['ds_notificacao']; ?>
                            </a>
                            <br>
                            <span class="legenda"><i><?= formata_data_extenso(formataDate($datahora[0], "-")); ?> às <?= $datahora[1]; ?></i></span>


                        </td>

                    </tr>

                    <?
                else:
                    ?>

                    <tr <?= $lido; ?>>

                        <td width="30">

                            <a href="<?= site_url($notificacao['ds_url']); ?>">
                                <div class="img img-polaroid" style="background: #ffffff url('<?= $notificacao['imagem']; ?>') no-repeat center;background-size: 30px;height: 30px; width: 30px; ">
                                    &nbsp;
                                </div> 
                            </a>
                        </td>
                        <td>
                            <a href="<?= site_url($notificacao['ds_url']); ?>">
                                <b><?= $notificacao['titulo']; ?></b> <?= $notificacao['texto']; ?>
                            </a>
                            <br>
                            <span class="legenda"><i><?= formata_data_extenso(formataDate($datahora[0], "-")); ?> às <?= $datahora[1]; ?></i></span>


                        </td>

                    </tr>

                <?
                endif;
            endforeach;

        endif;
        ?>
        <tr class="trBranco">
            <td colspan="3">
                <button id="mostrarMaisNotificacoes" class="btn btn-success cemPorcento">MOSTRAR MAIS</button>
            </td>
        </tr>

    </table>

</div>
