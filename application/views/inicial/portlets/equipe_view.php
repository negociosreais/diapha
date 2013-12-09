<script>

    $(document).ready(function() {
    
        
        // ToolTip
        $("a, img, button, input, select").each(function() {
            if ($(this).attr("title") != null && $(this).attr("title") != ""){
                $(this).tipTip({maxWidth: "auto", edgeOffset: 10});
            }
        });
    
        $("input[name=convite_email]").focus(function() {
            if ($(this).val() == "Digite o e-mail"){
                $(this).val(''); 
            }
        });
        
        // Modal perfil convite
        $( "#perfilConvite" ).dialog({
            autoOpen: false,
            width: 600,
            modal: true,
            buttons: {
                
            },
            close: function() {
                
            }
        });
        
        $(".botaoConvite").click(function(){
            
            $("input[name=ds_email]").val($("input[name=convite_email]").val());
            
            $("#perfilConvite").dialog('open'); 
        });
        
        /**
         * Enviar convite
         */
        $("input[name=botaoSelecionar]").click(function() {
            
            $("input[name=perfil]").val($(this).attr('id'));
            
            carregarTela();
                
            var dados = $("form[name=formConvite]").serialize(); 
                
            $.ajax({
                type: "POST",
                url: "<?= site_url('enviar_convite') ?>",
                data: dados,
                success: function(retorno){
                        
                    if ($.trim(retorno) == 'true'){
                            
                        carregarMensagem('Seu convite foi enviado com sucesso!', 5000);
                        
                        $("#perfilConvite").dialog('close');
                        
                        $('input[name=convite_email]').val('');
                            
                    } else {
                            
                        carregarMensagem('Desculpe! Não foi possível enviar o convite. <br>Verifique se o e-mail foi digitado corretamento e tente novamente', 10000);
                        
                    }
                        
                }
            }); 
        });
        
        $('#menu_equipe').popover('toggle')
    
    }); 

</script>

<div id="perfilConvite" title="Selecione o perfil">

    <p>Selecione o perfil o qual você deseja que o novo usuário tenha. 
        Esse perfil determinará o nível de acesso que o mesmo terá em relação à sua empresa.</p>

    <form name="formConvite" method='POST' onsubmit="return false">

        <input type="hidden" name="id_usuario" value="<?= usuario('id_usuario'); ?>" />
        <input type="hidden" name="perfil" value="" />
        <input type="hidden" name="ds_email" value="" />

        <table width="100%" class="perfis">
            <tr>
                <th width="200">
                    Editor
                </th>
                <th width="200">
                    Colaborador
                </th>
                <th width="200">
                    Gestor
                </th>
            </tr>
            <tr>
                <td>
                    Possui acesso limitado, somente cadastra produtos e serviços.
                </td>
                <td>
                    Possui nível de acesso intermediário, cadastra produtos e serviços, visualiza leads, faz contratação de planos, etc.
                </td>
                <td>
                    Possui acesso total ao perfil da empresa.
                </td>
            </tr>
            <tr>
                <td>
                    <input type="button" value="Selecionar" name="botaoSelecionar" id="editor" class="cemPorcento btn btn-success" />
                </td>
                <td>
                    <input type="button" value="Selecionar" name="botaoSelecionar" id="colaborador" class="cemPorcento btn btn-success" />
                </td>
                <td>
                    <input type="button" value="Selecionar" name="botaoSelecionar" id="gestor" class="cemPorcento btn btn-success" />
                </td>
            </tr>
        </table>

    </form>

</div>

<h1 class="tituloCaixa">EQUIPE</h1>
<div class="caixa boxEquipe">

    <?
    if (checa_permissao_perfil(array('gestor'), true)):
        ?>

        <div class="convite">
            <label class="floatLeft">Convide um colaborador</label>
            <span id="numero8">
                <input type="text" name="convite_email" value="Digite o e-mail" class="campo" />
            </span>
            <button class="btn btn-warning botaoConvite" title="Clique aqui para enviar um convite">
                <img src="<?= base_url() . TEMPLATE; ?>/img/icoMail.png" />
            </button>
        </div>

        <?
    endif;
    ?>


    <?
    foreach ($usuarios as $usuario):

        if ($this->usuario_model->selecionarUsuarioOnline($usuario['id_usuario'])):
            $classDisponibilidade = "iconeUsuarioOnline";
        else:
            $classDisponibilidade = "iconeUsuarioOffline";
        endif;
        ?>

        <div class="foto">

            <?
            if ($usuario['nm_foto'] != ''):
                ?>
                <img src="<?= base_url(); ?>/arquivos/usuarios/<?= $usuario['nm_foto']; ?>" height="40" class="img-polaroid" />
                <?
            else:
                ?>
                <img src="<?= base_url() . TEMPLATE; ?>/img/foto.png" height="40" class="img-polaroid" />
            <?
            endif;
            ?>

        </div>
        <div class="texto">

            <div class="nome">

                <div class="btn-group">

                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" style="padding: 0;-webkit-box-shadow: none;box-shadow: none;" title="">
                        <span class="<?= $classDisponibilidade; ?>"></span>
                        <span id="numero9"><?= substr($usuario['nm_usuario'], 0, 16); ?></span>
                    </a>

                    <ul class="dropdown-menu">
                        <li><a href="javascript:chatWith('<?= $usuario['nm_login']; ?>')" title="Clique para iniciar a conversa"><i class="icon-comment"></i>Bate papo</a></li>
                    </ul>
                </div>
            </div>
            <div class="perfil"><?= $usuario['relacao']; ?></div>
            <div class="telefone"><?= $usuario['nr_celular']; ?></div>
        </div>

        <div class="clear"></div>

        <?
    endforeach;
    ?>

</div>

<?
/* if (perfil() == 'vendedor'):
  ?>

  <div class="converseEquipe">
  <img src="<?= base_url() . TEMPLATE; ?>/img/gizConverseEquipe.png" />
  </div>

  <?
  elseif (perfil() == 'orgao'):
  ?>

  <div class="converseEquipeOrgao">
  <img src="<?= base_url() . TEMPLATE; ?>/img/gizConverseEquipe.png" />
  </div>

  <?
  endif;
 */
?>

