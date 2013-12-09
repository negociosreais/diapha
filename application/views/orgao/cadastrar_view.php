<?
$nm_usuario = ($profile_user['name'] != '') ? $profile_user['name'] : $_POST['nm_representante'];
$ds_email = $_POST['ds_email'];
if ($profile_user['birthday']):
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
        $("input[name*='fax']").setMask({ mask: '(99) 9999-9999 / (99) 9999-9999 / (99) 9999-9999'});
        $("input[name*='cep']").setMask({ mask: '99.999-999'});
        
        /**
         * Passo a passo
         */
        $("#form_orgao").formToWizard({ submitButton: 'SaveAccount' });

        /**
         * Ajax
         */
        $("input[name=nm_login]").bind('blur',function(){

            if ($(this).val() != '') {

                $.post('<?= site_url('usuario/checa_existe_login') ?>',
                { nm_login: $(this).val() },

                function(data) {
                    $("#div_usuario").html(data);
                    if (data.length > 1)
                        $("input[name=nm_login]").focus();
                });

            }

        });
        
        // Vamos preencher o combo cidades
        $.post('<?= site_url('cidade/combo') ?>',
        { uf: "<?= $_POST['nm_estado']; ?>", nome: "<?= $_POST['nm_cidade']; ?>" },

        function(data) {
                
            $("select[name=nm_cidade]").html(data);
                
        });
        
        $("select[name=nm_estado]").bind('change',function(){

            $.post('<?= site_url('cidade/combo') ?>',
            { uf: $(this).val(), nome: "<?= $_POST['nm_cidade']; ?>" },

            function(data) {
                
                $("select[name=nm_cidade]").html(data);
                
            });
        });

        $("input[name=ds_email]").bind('blur',function(){

            if ($(this).val() != '') {

                $.post('<?= site_url('usuario/checa_existe_email') ?>',
                { ds_email: $(this).val() },

                function(data) {
                    $("#div_email").html(data);
                    if (data.length > 1)
                        $("input[name=ds_email]").focus();
                });

            }

        });
        
        // Limpa e-mail
        $("input[name^=convite_email]").focus(function() {
            if ($(this).val() == 'E-mail do colaborador') {
                $(this).val('');
            }
        });
        
        //Validação
        $("#form_orgao").validate({
            
            rules: {
                ds_email: {
                    required: true,
                    email: true
                },
                dt_nascimento: {
                    required: true
                },
                ds_sexo: {
                    required: true
                },
                email_confirmacao: {
                    equalTo: "#ds_email"
                },
                ds_senha: {
                    required: true,
                    minlength: 4
                },
                nr_telefone: {
                    required: true,
                    telFixo: true
                }
            },
            messages: {
                nm_representante: "Preencha o campo NOME COMPLETO",
                dt_nascimento: "Preencha o campo DATA DE NASCIMENTO",
                ds_sexo: "Preencha o campo SEXO",
                nm_orgao: "Preencha o campo NOME DO ÓRGÃO",
                nr_telefone: "Preencha o campo TELEFONE FIXO corretamente",
                nm_cidade: "Preencha o campo CIDADE",
                nm_estado: "Selecione o ESTADO",
                nm_login: "Preencha o campo USUÁRIO",
                ds_senha: "O campo SENHA deve conter ao menos 4 caractéres",
                concordo: "É necessário aceitar os TEMOS DE SERVIÇO",
                ds_email: "Informe o E-MAIL corretamente",
                email_confirmacao: "E-MAIL DE CONFIRMAÇÃO não confere"
            },
            
            errorLabelContainer: $("#form_orgao div.error"),
        
            submitHandler: function(form){  

                carregarMensagem('Registros sendo gravados. Aguarde um instante por favor!');
                
                var dados = $( form ).serialize(); 
                
                $.ajax({
                    type: "POST",
                    url: "<?= site_url('orgao/inserir') ?>",
                    data: dados,
                    success: function(retorno){
                        
                        setTimeout($.unblockUI, 3000);
                        
                        if ($.trim(retorno) == 'true'){
                            
                            carregarMensagem('Cadastro efetuado com sucesso! Aguarde, você está sendo redirecionado...', 3000);
                            
                            window.location.href="<?= site_url('portal/confirma_cadastro') ?>";
                        
                        } else {
                            
                            carregarMensagem('Desculpe! Não foi possível realizar o cadastro. Verifique se os campos obrigatórios estão preenchidos e tente novamente.', 4000);
                        
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

        <h1 class="tituloCaixa">Seu cadastro está quase pronto.. são só alguns passos.</h1>

        <fieldset class="form espaco">

            <form name="form_orgao" id="form_orgao" action="inserir" method="POST" onsubmit="return false">

                <input type="hidden" name="url" value="<?= $_GET['url']; ?>">
                <input type="hidden" name="email_facebook" value="<?= $ds_email; ?>" />

                <!-- Dados da empresa -->
                <fieldset>
                    <legend>Dados do órgão</legend>

                    <table width="100%">

                        <tr>
                            <td width="170"><label>Nome do Órgão: * </label></td>
                            <td>

                                <input name="nm_orgao" type="text" size="80" class="required" value="<?= $_POST['nm_orgao']; ?>" />                

                            </td>
                        </tr>

                        <tr>
                            <td><label>Endereço:</label></td>
                            <td>
                                <input name="ds_endereco" type="text" size="80" />                
                            </td>
                        </tr>
                        <tr>
                            <td><label>Cep:</label></td>
                            <td>

                                <input name="nr_cep" type="text" size="20" />                

                            </td>
                        </tr>

                        <tr>
                            <td><label>Estado: *</label></td>
                            <td>
<? $cbo_estado = unserialize(UF); ?>
<?= form_dropdown('nm_estado', $cbo_estado, $_POST['nm_estado'], 'id="nm_estado" class="required"'); ?>                
                            </td>
                        </tr>
                        <tr>
                            <td><label>Cidade: *</label></td>
                            <td>
                                <select name="nm_cidade"></select>
                            </td>
                        </tr>
                        <tr>
                            <td><label>Telefone Fixo: *</label></td>
                            <td>
                                <input type="text" name="nr_telefone" size="50" class="required" />                
                            </td>
                        </tr>

                        <tr>
                            <td><label>Fax:</label></td>
                            <td>

                                <input type="text" name="nr_fax" size="50" />                
                            </td>
                        </tr>
                        <tr><td></td></tr>

                    </table>

                </fieldset>

                <!-- Dados pessoais -->
                <fieldset>
                    <legend>Dados de usuário</legend>

                    <table>
                        <tr>
                            <td width="170"><label>Nome completo: * </label></td>
                            <td>

                                <input name="nm_representante" id="nm_representante" type="text" value="<?= $nm_usuario; ?>" size="80" class="required" title="Preencha o campo NOME DO REPRESENTANTE" />

                            </td>
                        </tr>

                        <tr>
                            <td><label>Sexo: * </label></td>
                            <td>
<? $cbo_sexo = array("Masculino" => "Masculino", "Feminino" => "Feminino"); ?>
<?= form_dropdown('ds_sexo', $cbo_sexo, $ds_sexo, 'id="ds_sexo"') ?>
                            </td>
                        </tr>

                        <tr>
                            <td width="150"><label>Data de nascimento: * </label></td>
                            <td>

                                <input name="dt_nascimento" id="dt_nascimento" type="text" size="10" class="required" value="<?= $dt_nascimento; ?>" />

                            </td>
                        </tr>

                        <tr>
                            <td><label>Celular:</label></td>
                            <td>

                                <input type="text" name="nr_celular" size="50" />

                            </td>
                        </tr>

                        <tr>
                            <td><label>E-mail: *</label></td>
                            <td>
                                <input name="ds_email" id="ds_email" placeholder="E-mail institucional preferencialmente" type="text" size="80" class="required" value="<?= $ds_email; ?>" title="Preencha o campo E-MAIL corretamente." />
                                <div id="div_email"></div>
                            </td>
                        </tr>
                        <tr>
                            <td><label>Confirme o E-mail: *</label></td>
                            <td>
                                <input name="email_confirmacao" id="email_confirmacao" type="text" size="80" class="required" title="O campo e-mail de confirmação não confere." />
                                <div id="div_email_2"></div>
                            </td>
                        </tr>

                        <tr>
                            <td><label>
                                    Usuário: *
                                </label></td>
                            <td>
                                <input name="nm_login" id="nm_login" type="text" size="50" class="required" title="Preencha o campo USUÁRIO." />
                                <div id="div_usuario"></div>
                            </td>
                        </tr>
                        <tr>
                            <td><label>Senha: *</label></td>
                            <td><input name="ds_senha" id="ds_senha" type="password" size="50" class="required" title="Preencha o campo SENHA" /></td>
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
                        </tr>
                        <tr><td></td></tr>

                    </table>

                </fieldset>

                <!-- Convite -->
                <fieldset>
                    <legend>Convide outros colaboradores</legend>
                    <table width="100%">
                        <tr>
                            <td>
                                <label class="floatLeft">
                                    <input name="convite_email[]" type="text" size="50" value="E-mail do colaborador" />
                                    <input name="convite_perfil[]" type="hidden" value="Colaborador" />
                                </label>
                            </td>
                            <td rowspan="5" width="600">
                                <div>
                                    <h1>Convide colaboradores</h1>
                                    <p>Convide colaboradores para fazer parte da sua equipe.</p>

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="floatLeft">
                                    <input name="convite_email[]" type="text" size="50" value="E-mail do colaborador" />
                                    <input name="convite_perfil[]" type="hidden" value="Gestor" />
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="floatLeft">
                                    <input name="convite_email[]" type="text" size="50" value="E-mail do colaborador" />
                                    <input name="convite_perfil[]" type="hidden" value="Gestor" />
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="floatLeft">
                                    <input name="convite_email[]" type="text" size="50" value="E-mail do colaborador" />
                                    <input name="convite_perfil[]" type="hidden" value="Gestor" />
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="floatLeft">
                                    <input name="convite_email[]" type="text" size="50" value="E-mail do colaborador" />
                                    <input name="convite_perfil[]" type="hidden" value="Gestor" />
                                </label>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <p><label class="floatLeft">Obs.: Os campos acima são opcionais.</label></p>
                            </td>
                        </tr>
                    </table>
                </fieldset>
                <div class="error"></div>

                <div class="clear"></div>

                <p align="left"><input id="SaveAccount" type="submit" value="Concluir cadastro" class="btn btn-primary" /></p>

            </form>

        </fieldset>

    </div>

</div>


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


<script>

    $(document).ready(function() {
   
        $('#btnTermoUso').click(function(){
            
            // create the backdrop and wait for next modal to be triggered
            //$('body').modalmanager('loading');
            
            $('#termoModal').modal('show')  
            
            $.post('<?= site_url('portal/termos_servico'); ?>',
            {},
            function(data){
                $('#termoModal .modal-body').html(data);
            });
 
            
        });
 
        
   
    });


</script>