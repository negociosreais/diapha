<script type="text/javascript">

    $(document).ready(function(){

        //Validação
        $("form[name=nao_encontrei]").validate({
            
            rules: {
                produto: {
                    required: true
                },
                quantidade: {
                    required: true
                },
                categoria: {
                    required: true
                }
            },
            messages: {
                produto: "Preencha o campo PRODUTO OU SERVIÇO",
                quantidade: "Preencha o campo QUANTIDADE",
                categoria: "Preencha o campo SEGMENTO"
            },
            errorLabelContainer: $("div.error")
        });
        
    });
        
</script>

<div class="grid_24">

    <h1 class="tituloCaixa">NÃO ENCONTROU O QUE PROCURA?</h1>

    <? showStatus(); ?>
    <div class="caixa">

        <fieldset class="form espaco">

            <form name="nao_encontrei" action="<?= site_url("portal/nao_encontrei"); ?>" method="POST"  >

                <table width="100%">
                    <tr>
                        <td colspan="2">
                            <?=$resposta; ?>
                            <p>
                                Não encontrou o que procura? 
                                <br>Envie uma relação, dos produtos ou serviços, que necessita para ajudarmos você! 
                                <br>Para agilizar o processo, por favor, informe a especificação técnica e a quantidade do produto/serviço.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td width="170"><label>Produto ou Serviço: *</label></td>
                        <td>

                            <input name="produto" type="text" size="80" class="required" />

                        </td>
                    </tr>
                    <tr>
                        <td width="170"><label>Quantidade: *</label></td>
                        <td>

                            <input name="quantidade" type="text" size="5" class="required" />

                        </td>
                    </tr>
                    <tr>
                        <td width="170"><label>Especificação Técnica:</label></td>
                        <td>

                            <textarea name="especificacao" cols="79" rows="5"></textarea>

                        </td>
                    </tr>
                    <tr>
                        <td><label>Segmento: *</label></td>
                        <td>

                            <?= form_dropdown('categoria', $cbo_categorias, NULL, 'id="categoria" class="required"', true) ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            
                        </td>
                        <td>
                            <div class="error"></div>    
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="btn_enviar" value="Enviar" class="btn btn-success" />

                            <input type="reset" name="btn_cancelar" value="Cancelar" class="btn btn-success" onclick="history.back()" />
                        </td>
                    </tr>

                    <tr>
                        <td>                          
                        </td>
                        <td>
                            Obs.: * campos obrigatórios.
                        </td>
                    </tr>

                </table>

            </form>

        </fieldset>

    </div>

</div>

