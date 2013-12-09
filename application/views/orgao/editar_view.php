<script>
    
    $(document).ready(function(){
        
        /**
         * Mascaras
         */
        $("input[name*='telefone']").setMask({ mask: '(99) 9999-9999 / (99) 9999-9999 / (99) 9999-9999'});
        $("input[name*='celular']").setMask({ mask: '(99) 9999-9999 / (99) 9999-9999 / (99) 9999-9999'});
        $("input[name*='fax']").setMask({ mask: '(99) 9999-9999 / (99) 9999-9999 / (99) 9999-9999'});
        $("input[name*='cep']").setMask({ mask: '99.999-999'});
        
        /**
         * Ajax
         */
        $("input[name=nm_login]").bind('blur',function(){

            $.post('<?= site_url('orgao/checa_existe_login') ?>',
            { nm_login: $(this).val(), id: $("input[name=id_orgao]").val() },

            function(data) {
                $("#div_usuario").html(data);
                if (data.length == 1){
                    $("input[name=nm_login]").focus();
                }
            });

        });
        
        $("input[name=ds_email]").bind('blur',function(){

            $.post('<?= site_url('orgao/checa_existe_email') ?>',
            { ds_email: $(this).val(), id: $("input[name=id_orgao]").val() },

            function(data) {
                $("#div_email").html(data);
                if (data.length == 1){
                    $("input[name=ds_email]").focus();
                }
            });
        });
        
        // Vamos preencher o combo cidades
        $.post('<?= site_url('cidade/combo') ?>',
        { uf: "<?= $dado['nm_estado']; ?>", nome: "<?= $dado['nm_cidade']; ?>" },

        function(data) {
                
            $("select[name=nm_cidade]").html(data);
                
        });
        
        $("select[name=nm_estado]").bind('change',function(){

            $.post('<?= site_url('cidade/combo') ?>',
            { uf: $(this).val(), nome: "<?= $dado['nm_cidade']; ?>" },

            function(data) {
                
                $("select[name=nm_cidade]").html(data);
                
            });
        });
        
        //Validação
        $("#form_orgao").validate({
            
            rules: {
                    
            },
            messages: {
                nm_orgao: "Preencha o campo NOME DO ÓRGÃO",
                nr_telefone: "Preencha o campo TELEFONE",
                nm_cidade: "Preencha o campo CIDADE",
                nm_estado: "Preencha o campo ESTADO"
            },
            
            errorLabelContainer: $("#form_orgao div.error"),
        
            submitHandler: function(form){  

                form.submit();

            }
        });
        
    });

</script>

<div class="grid_24">


    <div class="caixa">

        <h1 class="tituloCaixa">Dados do Órgão Público</h1>
        <? showStatus(); ?>

        <fieldset class="form espaco">

            <form name="form_orgao" id="form_orgao" action="atualizar" method="POST" >

                <input type="hidden" name="id_orgao" value="<?= $dado['id_orgao']; ?>" />

                <table width="100%">

                    <tr>
                        <td width="250"><label>Nome do Órgão: * </label></td>
                        <td width="300">

                            <input name="nm_orgao" id="nm_orgao" type="text" size="80" value="<?= $dado['nm_orgao']; ?>" class="required" />

                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><label>Endereço:</label></td>
                        <td>
                            <input name="ds_endereco" type="text" size="80" value="<?= $dado['ds_endereco']; ?>" />
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><label>Cep:</label></td>
                        <td>

                            <input name="nr_cep" type="text" size="80" value="<?= $dado['nr_cep']; ?>" />

                        </td>
                        <td></td>
                    </tr>

                    <tr>
                        <td><label>Estado: *</label></td>
                        <td>
                            <?
                            $cbo_estado = unserialize(UF);
                            ?>
                            <?= form_dropdown('nm_estado', $cbo_estado, $dado['nm_estado'], 'id="nm_estado" class="required"') ?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><label>Cidade: *</label></td>
                        <td>
                            <select name="nm_cidade"></select>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><label>Telefone: *</label></td>
                        <td>

                            <input type="text" name="nr_telefone" id="nr_telefone" size="80" value="<?= $dado['nr_telefone']; ?>" class="required" />

                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><label>Fax:</label></td>
                        <td>

                            <input type="text" name="nr_fax" size="80" value="<?= $dado['nr_fax']; ?>" />

                        </td>
                        <td></td>
                    </tr>
                    <?
                    if (checa_permissao(array('admin', 'operador'), true)):
                        ?>
                        <tr>
                            <td><label>Status:</label></td>
                            <td>
                                <? $cbo_status = array("Ativo" => "Ativo", "Inativo" => "Inativo"); ?>
                                <?= form_dropdown('st_status', $cbo_status, $dado['st_status'], 'id="st_status"') ?>
                            </td>
                            <td></td>
                        </tr>


                        <tr>
                            <td>
                                <label><b>Permissão de acesso:</b></label>
                            </td>
                            <td colspan="2">

                            </td>
                        </tr> 

                        <tr>
                            <td>
                                <label>Período:</label>
                            </td>
                            <td>

                                <input type="text" name="dt_acesso_inicio" size="10" value="<?= formataDate($dado['dt_acesso_inicio'], "-"); ?>" />

                                à

                                <input type="text" name="dt_acesso_fim" size="10" value="<?= formataDate($dado['dt_acesso_fim'], "-"); ?>" />

                            </td>
                            <td></td>
                        </tr> 
                        <?
                    endif;
                    ?>
                    <tr>
                        <td></td>
                        <td>
                            <div class="error"></div>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="btn_gravar" value="Gravar" class="btn btn-info" />

                            <input type="button" name="btn_cancelar" value="Cancelar" onclick="history.back()" class="btn btn-info" />
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <div class="alert alert-info">* Campos obrigatórios</div>
                        </td>
                        <td></td>
                    </tr>
                </table>

            </form>

        </fieldset>

    </div>

</div>