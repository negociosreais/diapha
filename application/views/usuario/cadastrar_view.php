<?
if (!$_GET['cd']):
    $tp_usuario = "cidadao";
endif;

$nm_usuario = $profile_user['name'];
$ds_email = $profile_user['email'];
if ($profile_user['birthday'] != ''):
    $dt_nascimento = date('d/m/Y', strtotime($profile_user['birthday']));
endif;
$ds_sexo = ($profile_user['gender'] == 'male') ? "Masculino" : "Feminino";
?>


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
                { nm_login: $(this).val() },

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
                { ds_email: $(this).val() },

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
                },
                ds_senha: {
                    required: true,
                    minlength: 4
                }
            },
            messages: {
                nm_usuario: "Preencha o campo NOME",
                nr_telefone: "Preencha o campo TELEFONE",
                nm_login: "Preencha o campo USUÁRIO",
                ds_senha: "O campo SENHA deve conter ao menos 4 caractéres",
                concordo: "É necessário aceitar os TEMOS DE SERVIÇO",
                ds_email: "Informe o E-MAIL corretamente",
                email_confirmacao: "E-MAIL DE CONFIRMAÇÃO não confere"
            },
            
            errorLabelContainer: $("#form_usuario div.error"),
        
            submitHandler: function(form){  

                $.blockUI({ 
                    message: "Registros sendo gravados. Aguarde um instante por favor!",
                    css: { 
                        border: 'none', 
                        padding: '15px', 
                        backgroundColor: '#000', 
                        '-webkit-border-radius': '10px', 
                        '-moz-border-radius': '10px', 
                        opacity: .5, 
                        color: '#fff' 
                    } 
                });
                
                setTimeout($.unblockUI, 2000); 
                
                var dados = $( form ).serialize(); 
                
                $.ajax({
                    type: "POST",
                    url: "<?= site_url('usuario/inserir') ?>",
                    data: dados,
                    success: function(retorno){
                        
                        setTimeout($.unblockUI, 5000);
                        
                        if ($.trim(retorno) == 'true'){
                            
                            $.blockUI({ 
                                message: "Cadastro efetuado com sucesso! Aguarde, você está sendo redirecionado...",
                                css: { 
                                    border: 'none', 
                                    padding: '15px', 
                                    backgroundColor: '#000', 
                                    '-webkit-border-radius': '10px', 
                                    '-moz-border-radius': '10px', 
                                    opacity: .5, 
                                    color: '#fff' 
                                } 
                            });
                        
                            setTimeout($.unblockUI, 5000);
                            
                            window.location.href="<?= site_url('portal/confirma_cadastro') ?>";
                        
                        } else {
                            
                            $.blockUI({ 
                                message: "Desculpe! Não foi possível realizar o cadastro.",
                                css: { 
                                    border: 'none', 
                                    padding: '15px', 
                                    backgroundColor: '#000', 
                                    '-webkit-border-radius': '10px', 
                                    '-moz-border-radius': '10px', 
                                    opacity: .5, 
                                    color: '#fff' 
                                } 
                            });
                        
                            setTimeout($.unblockUI, 2000);
                            
                        }
                        
                    }
                }); 

            }
        });
  
    });

</script>

<div id="termoModal" class="modal container hide fade" tabindex="-1" >
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3>Termo de uso</h3>
    </div>
    <div class="modal-body" style="padding: 40px;max-height: 300px">
    </div>
    <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn">Fechar</button>
    </div>
</div>

<div class="grid_24">


    <? showStatus(); ?>
    <div class="caixa">

        <h1 class="tituloCaixa">
            Faça parte do Diapha.<br><br>
            <span style="font-size: 20px;">Ajude a tornar sua cidade ainda mais transparente.</span>
        </h1>

        <fieldset class="form">

            <form name="form_usuario" id="form_usuario" action="" method="POST" >

                <input type="hidden" name="assinatura" value="<?= $assinatura; ?>" />
                <input type="hidden" name="id_plano" value="<?= $id_plano; ?>" />
                <input type="hidden" name="s" value="<?= $s; ?>" />
                <input type="hidden" name="cd_convite" value="<?= $_GET['cd']; ?>" />
                <input type="hidden" name="tp_usuario" value="<?= $tp_usuario; ?>" />
                <input type="hidden" name="email_facebook" value="<?= $ds_email; ?>" />
                <input type="hidden" name="fb_user" value="<?= $fb_user; ?>" />


                <!-- Dados pessoais -->
                <fieldset>

                    <table width="100%">

                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td width="250"><label>Nome: * </label></td>
                            <td width="400">

                                <input name="nm_usuario" id="nm_usuario" type="text" size="80" class="required" value="<?= $nm_usuario; ?>" />

                            </td>
                            <td></td>
                        </tr>

                        <tr>
                            <td><label>Sexo: * </label></td>
                            <td>
                                <? $cbo_sexo = array("Masculino" => "Masculino", "Feminino" => "Feminino"); ?>
                                <?= form_dropdown('ds_sexo', $cbo_sexo, $ds_sexo, 'id="ds_sexo"') ?>
                            </td>
                            <td></td>
                        </tr>

                        <tr>
                            <td width="150"><label>Data de nascimento: * </label></td>
                            <td>

                                <input name="dt_nascimento" id="dt_nascimento" type="text" size="80" class="required" value="<?= $dt_nascimento; ?>" />

                            </td>
                            <td></td>
                        </tr>

                        <tr>
                            <td><label>Telefone:</label></td>
                            <td>

                                <input type="text" name="nr_telefone" size="80" />

                            </td>
                            <td></td>
                        </tr>

                        <tr>
                            <td><label>Celular:</label></td>
                            <td>

                                <input type="text" name="nr_celular" size="80" />

                            </td>
                            <td></td>
                        </tr>

                        <?
                        if ($ds_email != ''):
                            ?>

                            <tr>
                                <td><label>E-mail: </label></td>
                                <td>
                                    <label class="floatLeft"><?= $ds_email; ?></label>
                                    <input name="ds_email" id="ds_email" type="hidden" size="80" value="<?= $ds_email; ?>" />
                                </td>
                                <td></td>
                            </tr>

                            <?
                        else:
                            ?>

                            <tr>
                                <td><label>E-mail: *</label></td>
                                <td>
                                    <input name="ds_email" id="ds_email" type="text" size="80" class="required" value="" />
                                    <div id="div_email"></div>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><label>Confirme o E-mail: *</label></td>
                                <td>
                                    <input name="email_confirmacao" id="email_confirmacao" type="text" size="80" class="required" />
                                    <div id="div_email_2"></div>
                                </td>
                                <td></td>
                            </tr>

                        <?
                        endif;
                        ?>

                        <tr>
                            <td>
                                <label>
                                    Usuário: *
                                </label>
                            </td>
                            <td>
                                <input name="nm_login" id="nm_login" type="text" size="80" class="required"/>
                                <div id="div_usuario"></div>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><label>Senha: *</label></td>
                            <td><input name="ds_senha" id="ds_senha" type="password" size="80" class="required" /></td>
                            <td></td>
                        </tr>
                        <?
                        if (checa_permissao(array('admin'), true)):
                            ?>
                            <tr>
                                <td><label>Status:</label></td>
                                <td>
                                    <? $cbo_status = array("Ativo" => "Ativo", "Inativo" => "Inativo"); ?>
                                    <?= form_dropdown('st_status', $cbo_status, NULL, 'id="st_status"') ?>
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
                            <td></td>
                            <td>
                                <label class="floatLeft">
                                    <a href="javascript:void(0)" id="btnTermoUso">Termo de uso.</a> Li e concordo com os termos.
                                    <input type="checkbox" name="concordo" value="checkbox" class="required" />
                                </label>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <div class="error"></div>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>

                            </td>
                            <td>
                                <input type="submit" value="Cadastre-se" class="btn btn-primary btn-large" />
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>

                            </td>
                            <td>
                                <label class="floatLeft">Já se cadastrou no Diapha ou no Portal ARP ? <a href="<?= site_url('login'); ?>">Entrar</a></label>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>

                            </td>
                            <td>
                                <div class="alert alert-info">* Campos obrigatórios.</div>
                            </td>
                            <td></td>
                        </tr>

                    </table>

                </fieldset>




            </form>

        </fieldset>

    </div>

</div>


<script>

    $(document).ready(function() {
   
        $('#btnTermoUso').click(function(){
            
            // create the backdrop and wait for next modal to be triggered
            //$('body').modalmanager('loading');
            
            $('#termoModal').modal('show');
            
            $.post('<?= site_url('portal/termos_servico'); ?>',
            {},
            function(data){
                $('#termoModal .modal-body').html(data);
            });
 
        });
 
    });

</script>