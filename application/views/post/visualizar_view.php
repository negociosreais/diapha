<script type="text/javascript" src="<?= base_url() . TEMPLATE; ?>/js/jquery.qtip-1.0.0-rc3.min.js"></script>

<script>
    $(document).ready(function() {
        
        $( "#tabs" ).tabs();
        
        // ToolTip
        $("a, img, button, input, select, span").each(function() {
            if ($(this).attr("title") != null && $(this).attr("title") != ""){
                $(this).tipTip({maxWidth: "auto", edgeOffset: 10});
            }
        });
                           
        // Opções sobre o POST
        $('.opcoes_post').each(function()
        {
            var id_post = $(this).attr('id');
            $(this).qtip(
            {
                content: '<a href="javascript:void(0)" onclick="excluirPost('+id_post+')">Excluir</a>',
                position: 'bottomRight',
                hide: {
                    when: 'mouseout',
                    fixed: true
                },
                style: {
                    padding: '3px 10px'
                }
            });
        });
        
        // Opções sobre o comentário
        $('.opcoes_comentario').each(function()
        {
            var id_comentario = $(this).attr('id');
            $(this).qtip(
            {
                content: '<a href="javascript:void(0)" onclick="excluirComentario('+id_comentario+')">Excluir</a>',
                position: 'bottomRight',
                hide: {
                    when: 'mouseout',
                    fixed: true
                },
                style: {
                    padding: '3px 10px'
                }
            });
        });
        
        // Limpar campo de mensagem
        $("#ds_post").focus(function() {
           
            if ($(this).val() == "Digite aqui sua mensagem"){
                $(this).val('');
            }
           
        });
        
        $("#btnDiaphe").click(function() {
            
<?
// Passamos o ID do serviço para verificar se tem acesso a este serviço
checa_permissao_servico("1", true, true);
?>

            if ($("#ds_post").val() != ''){
                $("#form_diaphe").submit();
            }
            
        });
        
        // Mostrar comentar
        $("tr[id^=trComentar]").hide();
        
         
        // Contador de caracteres
        var contador;
        var qtdCaracteres;
        $("#ds_post, textarea[name^=ds_comentario]").keydown(function() {
            contador = 280;
            qtdCaracteres = $(this).val().length;
            $(this).siblings('.contadorCaracteres').html(contador - qtdCaracteres);
        });
        
        $("#ds_post, textarea[name^=ds_comentario]").keyup(function() {
            contador = 280;
            qtdCaracteres = $(this).val().length;
            $(this).siblings('.contadorCaracteres').html(contador - qtdCaracteres);
        });
        
        $("#ds_post[maxlength], textarea[name^=ds_comentario][maxlength]").keypress(function(event){
            var key = event.which;
 
            //todas as teclas incluindo enter
            if(key >= 33 || key == 13) {
                var maxLength = $(this).attr("maxlength");
                var length = this.value.length;
                if(length >= maxLength) {
                    event.preventDefault();
                }
            }
        });
        
                           
    });
    
    function comentar(id_post) {
        
        if ($("#ds_comentario_" + id_post).val() != "") {
            
            var ds_comentario = $("#ds_comentario_" + id_post).val();
            
        } else if ($("#ds_comentario_seguindo_" + id_post).val() != "") {
            
            var ds_comentario = $("#ds_comentario_seguindo_" + id_post).val();
            
        }
        
        if (ds_comentario){
            
            $.ajax({
                type: "POST",
                url: "<?= site_url('post/comentar') ?>",
                data: "id_post=" + id_post + "&ds_comentario=" + ds_comentario,
                success: function(retorno){
                        
                    setTimeout($.unblockUI, 5000);
                        
                    if ($.trim(retorno) == 'true'){
                            
                        carregarTela('Cadastro efetuado com sucesso! Aguarde, você está sendo redirecionado...');
                        setTimeout($.unblockUI, 5000);
                        
                        window.location.reload();
                            
                    } else {
                            
                        carregarTela('Desculpe! Não foi possível realizar o cadastro.');
                        
                        setTimeout($.unblockUI, 2000);
                            
                    }
                        
                }
            }); 
        
        }
    }
    
    function mostrarComentar(id_post) {
    
        $("#trComentar-" + id_post).show();
        $("#trComentar-seguindo-" + id_post).show();
    }
    
    function seguirInformacao(id_post) {
        
        $.post('<?= site_url('post/seguir') ?>',
        { id_post: id_post },

        function(data) {
            if (data == "deletou") {
                $("#seguir-" + id_post).html('Seguir [+] | ');
            } else if(data == 'true') {
                $("#seguir-" + id_post).html('Seguir [-] | ');
            }
            
            window.location.reload();
            
        });
        
    }
    
    function excluirPost(id_post) {
        
        if (confirm("Tem certeza que deseja excluir esta publicação ?")) {
        
            $.post('<?= site_url('post/deletar') ?>',
            { id_post: id_post },

            function(data) {
            
                window.location.reload();
            
            });
        
        }
        
    }
    
    function excluirComentario(id_comentario) {
        
        if (confirm("Tem certeza que deseja excluir este comentário ?")) {
        
            $.post('<?= site_url('post/deletar_comentario') ?>',
            { id_comentario: id_comentario },

            function(data) {
            
                window.location.reload();
            
            });
        
        }
        
    }
                            
   
</script>

<div id="diapha" class="grid_19">

    <h1 class="tituloCaixa">Visualizando post no Diapha
        <img src="<?= base_url() . TEMPLATE; ?>/img/help.png" title="O Diapha é um canal de comunicação entre Órgãos e Empresas." class="icoHelp floatRight" />
    </h1>
    <div class="caixa">

        <table width="100%" class="lista diapha">

            <?
            if (count($posts) > 0) :

                foreach ($posts as $post) :

                    $datahora = explode(" ", $post['datahora_cadastro']);

                    $nm_empresa = "";
                    if ($post['entidade'] == "vendedor"):
                        $nm_empresa = $post['nm_empresa'];
                    elseif ($post['entidade'] == "orgao"):
                        $nm_empresa = $post['nm_orgao'];
                    else:
                        $nm_empresa = "Portal ARP";
                    endif;

                    $param['id_post'] = $post['id_post'];
                    $param['order'] = "datahora_cadastro ASC";
                    $comentarios = $this->post_model->selecionarComentarios($param);
                    $total_comentarios = count($comentarios);

                    // Verificar se é seguidor
                    $param['id_entidade'] = $post['id_post'];
                    $param['entidade'] = 'post';
                    $param['id_usuario'] = usuario('id_usuario');
                    $param['relacao'] = $post['seguidor'];
                    $rel = $this->relacionamento_model->selecionarRelacionamento($param);

                    // Verificar se dono do post
                    $opcoes = "";
                    if ($post['id_usuario'] == usuario('id_usuario') || checa_permissao(array('admin', 'operador'), true)):
                        $opcoes = "opcoes_post";
                    endif;
                    ?>


                    <tr class="trBranco <?= $opcoes; ?>" id="<?= $post['id_post']; ?>">
                        <td width="50" class="top">
                            <?
                            // se vendedor
                            if ($post['entidade'] == 'vendedor'):
                                if ($post['logo_vendedor'] != ''):
                                    $logo = base_url() . "/arquivos/logos/" . $post['logo_vendedor'];
                                else:
                                    $logo = base_url() . TEMPLATE . "/img/logoEmpresaP.jpg";
                                endif;
                            endif;

                            // se orgao
                            if ($post['entidade'] == 'orgao'):
                                if ($post['logo_orgao'] != ''):
                                    $logo = base_url() . "/arquivos/logos/" . $post['logo_orgao'];
                                else:
                                    $logo = base_url() . TEMPLATE . "/img/logoGovernoP.jpg";
                                endif;
                            endif;

                            // se usuário
                            if ($post['entidade'] == ''):
                                $logo = base_url() . TEMPLATE . "/img/logo_parte.png";
                            endif;

                            if ($logo != ''):
                                ?>
                                <img src="<?= $logo; ?>" class="logoEmpresa img-polaroid" />
                                <?
                            else:
                                ?>
                                <img src="<?= $logo; ?>" class="logoEmpresa img-polaroid" />
                            <?
                            endif;
                            ?>
                        </td>
                        <td>
                            <b class="nomeEmpresa">

                                <?= $nm_empresa; ?>
                            </b>
                            <?
                            if (checa_permissao(array('admin', 'operador'), true)):
                                echo " (" . $post['nm_usuario'] . ")";
                            endif;
                            ?>

                            <br>

                            <?= nl2br($post['ds_post']); ?><br>
                            <span class="legenda"><i>publicado em <?= formata_data_extenso(formataDate($datahora[0], "-")); ?> às <?= $datahora[1]; ?></i></span>
                            <!--<a href="<?= base_url(); ?>/arquivos/estimativa/<?= $post['arquivo_estimativa']; ?>" target="_blank">
                                Arquivo em anexo
                            </a>-->
                        </td>

                    </tr>

                    <!-- COMENTÁRIOS -->

                    <tr class="trInterna">
                        <td colspan="3">
                            <table width="100%" class="comentarios">
                                <tr class="trBranco">
                                    <td colspan="2">
                                        <div class="floatLeft">
                                            <i><b><?= $total_comentarios; ?></b> comentários.</i>
                                        </div>
                                        <div class="floatRight">
                                            <a href="javascript:void(0)" id="seguir-<?= $post['id_post']; ?>" onclick="seguirInformacao('<?= $post['id_post']; ?>')">
                                                <?
                                                if ($rel):
                                                    echo "Seguir [-] | ";
                                                else:
                                                    echo "Seguir [+] | ";
                                                endif;
                                                ?>
                                            </a>
                                            <span id="numero14">
                                                <a href="javascript:void(0)" name="comentar" onclick="mostrarComentar('<?= $post['id_post']; ?>')">Comentar</a>
                                            </span>
                                        </div>
                                    </td>
                                </tr>

                                <!-- ENVIAR COMENTÁRIO -->

                                <tr id="trComentar-<?= $post['id_post']; ?>" class="trBranco">
                                    <td colspan="2">
                                        <div class="diaphe">

                                            <div class="textoEsquerda">
                                                <textarea name="ds_comentario" id="ds_comentario_<?= $post['id_post']; ?>" class="comentario" maxlength="280" style="width: 580px !important"></textarea>
                                                <span class="contadorCaracteres">280</span>
                                            </div>
                                            <div class="opcoesDireita">
                                                <input type="button" name="btnComentar" onclick="comentar('<?= $post['id_post']; ?>')" value="Comentar" class="btn btn-success" />
                                            </div>

                                        </div>
                                    </td>
                                </tr>
                                <?
                                $total_comentarios = 0;
                                if ($comentarios):

                                    foreach ($comentarios as $comentario):

                                        $datahora = explode(" ", $comentario['datahora_cadastro']);

                                        // Verificar se dono do post
                                        $opcoes = "";
                                        if ($comentario['id_usuario'] == usuario('id_usuario') || checa_permissao(array('admin', 'operador'), true)):
                                            $opcoes = "opcoes_comentario";
                                        endif;
                                        ?>
                                        <tr class="trBranco <?= $opcoes; ?>" id="<?= $comentario['id_comentario']; ?>">
                                            <td width="70" class="top">
                                                <?
                                                $nm_usuario = "";
                                                // se vendedor
                                                if ($comentario['entidade'] == 'vendedor'):
                                                    $nm_usuario = $comentario['nm_empresa'];
                                                    if ($comentario['logo_vendedor'] != ''):
                                                        $logo = base_url() . "/arquivos/logos/" . $comentario['logo_vendedor'];
                                                    else:
                                                        $logo = base_url() . TEMPLATE . "/img/logoEmpresaP.jpg";
                                                    endif;
                                                endif;

                                                // se orgao
                                                if ($comentario['entidade'] == 'orgao'):
                                                    $nm_usuario = $comentario['nm_orgao'];
                                                    if ($comentario['logo_orgao'] != ''):
                                                        $logo = base_url() . "/arquivos/logos/" . $comentario['logo_orgao'];
                                                    else:
                                                        $logo = base_url() . TEMPLATE . "/img/logoGovernoP.jpg";
                                                    endif;
                                                endif;

                                                // se usuário
                                                if ($comentario['entidade'] == ''):
                                                    $nm_usuario = "Portal ARP";
                                                    $logo = base_url() . TEMPLATE . "/img/logo_parte.png";
                                                endif;
                                                ?>

                                                <img src="<?= base_url() . TEMPLATE; ?>/img/filho.png" />

                                                <?
                                                if ($logo != ''):
                                                    ?>
                                                    <img src="<?= $logo; ?>" class="logoOrgaoPP img-polaroid" />
                                                    <?
                                                else:
                                                    ?>
                                                    <img src="<?= $logo; ?>" class="logoOrgaoPP img-polaroid" />
                                                <?
                                                endif;
                                                ?>
                                            </td>
                                            <td>
                                                <b class="nomeEmpresa">
                                                    <?= $nm_usuario ?> 
                                                </b>

                                                <?
                                                if (checa_permissao(array('admin', 'operador'), true)):
                                                    echo " (" . $comentario['nm_usuario'] . ")";
                                                endif;
                                                ?>    
                                                : 

                                                </b>

                                                <?= nl2br($comentario['ds_comentario']); ?>
                                                <br>
                                                <span class="legenda"><i>enviado em <?= formata_data_extenso(formataDate($datahora[0], "-")); ?> às <?= $datahora[1]; ?></i></span>
                                            </td>
                                        </tr>
                                        <?
                                    endforeach;
                                endif;
                                ?>

                            </table>
                        </td>
                    </tr>


                    <?
                endforeach;

            endif;



            if (count($posts) == 0):
                ?>
                <tr class="trBranco">
                    <td colspan="3">
                        Nenhuma publicação até o momento.
                    </td>
                </tr>
                <?
            endif;
            ?>

        </table>

    </div>

</div>

