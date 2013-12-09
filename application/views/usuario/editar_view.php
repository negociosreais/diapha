<script type="text/javascript">

    $(document).ready(function(){

        /**
         * Mascaras
         */
        $("input[name*='telefone']").setMask({ mask: '(99) 9999-9999 / (99) 9999-9999 / (99) 9999-9999'});
        $("input[name*='celular']").setMask({ mask: '(99) 9999-9999 / (99) 9999-9999 / (99) 9999-9999'});
        $("input[name*='cep']").setMask({ mask: '99.999-999'});
        
        /**
         * Ajax
         */
        $("input[name=nm_login]").bind('blur',function(){

            if ($(this).val() != '') {

                $.post('<?= site_url('usuario/checa_existe_login') ?>',
                { nm_login: $(this).val(), id_usuario: $('#id_usuario').val() },

                function(data) {
                    $("#div_usuario").html(data);
                    if (data.length > 5)
                        $("input[name=nm_login]").focus();
                });

            }

        });

        $("input[name=ds_email]").bind('blur',function(){

            if ($(this).val() != '') {

                $.post('<?= site_url('usuario/checa_existe_email') ?>',
                { ds_email: $(this).val(), id_usuario: $('#id_usuario').val() },

                function(data) {
                    $("#div_email").html(data);
                    if (data.length > 5)
                        $("input[name=ds_email]").focus();
                });

            }

        });
        
        //Validação
        $("#form_usuario").validate({
            
            rules: {
                ds_email: {
                    required: true,
                    email: true
                },
                email_confirmacao: {
                    equalTo: "#ds_email"
                }
            },
            messages: {
                nm_usuario: "Preencha o campo NOME",
                nr_telefone: "Preencha o campo TELEFONE",
                nm_login: "Preencha o campo USUÁRIO",
                concordo: "É necessário aceitar os TEMOS DE SERVIÇO",
                ds_email: "Informe o E-MAIL corretamente",
                email_confirmacao: "E-MAIL DE CONFIRMAÇÃO não confere"
            },
            
            errorLabelContainer: $("#form_usuario div.error"),
        
            submitHandler: function(form){  

                carregarMensagem('Registros sendo gravados. Aguarde um instante por favor!', 2000);
                
                var dados = $( form ).serialize(); 
                
                $.ajax({
                    type: "POST",
                    url: "<?= site_url('usuario/atualizar') ?>",
                    data: dados,
                    success: function(retorno){
                        
                        setTimeout($.unblockUI, 5000);
                        
                        if ($.trim(retorno) == 'true'){
                            
                            carregarMensagem('Dados atualizados com sucesso! Aguarde, você está sendo redirecionado...',5000);
                            
                            history.back();
                        
                        } else {
                            
                            carregarMensagem('Desculpe! Não foi possível realizar as atualizações.',5000);
                            
                        }
                        
                    }
                }); 

            }
        });
  
    });

</script>

<div class="grid_24">

    
    <? showStatus(); ?>
    <div class="caixa">
        
        <h1 class="tituloCaixa">Meus dados</h1>

        <fieldset class="form">

            <form name="form_usuario" id="form_usuario" method="POST" >

                <input type="hidden" name="id_usuario" id="id_usuario" value="<?= $dado['id_usuario']; ?>" />

                <!-- Dados pessoais -->
                <fieldset>

                    <table>

                          <tr>
                            <td width="250"><label>Nome: * </label></td>
                            <td width="300">

                                <input name="nm_usuario" id="nm_usuario" type="text" size="80" class="required" value="<?= $dado['nm_usuario']; ?>" />

                            </td>
                            <td></td>
                        </tr>

                        <tr>
                            <td><label>Telefone:</label></td>
                            <td>

                                <input type="text" name="nr_telefone" size="80" value="<?= $dado['nr_telefone']; ?>" />

                            </td>
                            <td></td>
                        </tr>

                        <tr>
                            <td><label>Celular:</label></td>
                            <td>

                                <input type="text" name="nr_celular" size="80" value="<?= $dado['nr_celular']; ?>" />

                            </td>
                            <td></td>
                        </tr>

                        <tr>
                            <td><label>E-mail: *</label></td>
                            <td>
                                <input name="ds_email" id="ds_email" type="text" size="80" class="required" value="<?= $dado['ds_email']; ?>" />
                                <div id="div_email"></div>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><label>Confirme o E-mail: *</label></td>
                            <td>
                                <input name="email_confirmacao" id="email_confirmacao" type="text" size="80" class="required" value="<?= $dado['ds_email']; ?>" />
                                <div id="div_email_2"></div>
                            </td>
                            <td></td>
                        </tr>

                        <tr>
                            <td><label>
                                    Usuário: *
                                </label></td>
                            <td>
                                <input name="nm_login" id="nm_login" type="text" size="80" class="required" value="<?= $dado['nm_login']; ?>"/>
                                <div id="div_usuario"></div>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><label>Senha:</label></td>
                            <td><input name="ds_senha" id="ds_senha" type="password" size="80" /></td>
                            <td></td>
                        </tr>
                        <?
                        if (checa_permissao(array('admin'), true)):
                            ?>
                            <tr>
                                <td><label>Status:</label></td>
                                <td>
                                    <? $cbo_status = array("Ativo" => "Ativo", "Inativo" => "Inativo"); ?>
                                    <?= form_dropdown('st_status', $cbo_status, $dado['st_status'], 'id="st_status"') ?>
                                </td>
                                <td></td>
                            </tr>

                            <?
                        else:
                            ?>
                            <input type="hidden" name="st_status" value="Ativo" />
                        <?
                        endif;
                        ?>

                        <tr>
                            <td>
                                <label>
                                    Receber notificações por e-mail:
                                </label>
                            </td>
                            <td>
                                <input type="checkbox" name="st_receber_email" value="1" <?=($dado['st_receber_email'] == 1) ? "checked='checked'":"";?> />
                                
                            </td>
                            <td></td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <div class="error"></div>
                            </td>
                            <td></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>
                                <input type="submit" name="btn_gravar" value="Gravar" class="btn btn-info btn-large" />

                                <input type="button" name="btn_cancelar" value="Cancelar" onclick="history.back()"  class="btn btn-info btn-large" />        
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                            </td>
                            <td>
                                <div class="alert alert-info">* Campos obrigatórios</div>
                            </td>
                            <td></td>
                        </tr>

                    </table>

                </fieldset>

            </form>

        </fieldset>

    </div>
</div>