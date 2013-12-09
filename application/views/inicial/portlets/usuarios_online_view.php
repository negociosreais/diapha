
<div class="caixa">

    <h1 class="tituloCaixa">ONLINE</h1>

    <?
    if (checa_permissao_perfil(array('gestor'), true)):
        ?>

        <div class="convite">
            <label class="floatLeft">Convide um colaborador</label>
            <span id="numero8"><input type="text" name="convite_email" value="Digite o e-mail" class="campo" /></span>
            <input type="button" class="botaoConvite" value="" title="Clique aqui para enviar um convite"/>
        </div>

        <?
    endif;
    ?>


    <?
    if ($usuarios):
        foreach ($usuarios as $usuario):
            ?>

            <div class="foto">

                <?
                if ($usuario['fb_user'] != ''):
                    ?>
                    <img src="https://graph.facebook.com/<?= $usuario['fb_user']; ?>/picture?width=40&height=40" class="img-polaroid" />
                    <?
                elseif ($usuario['nm_foto'] != ''):
                    ?>
                    <img src="<?= base_url(); ?>/arquivos/usuario/<?= $usuario['nm_foto']; ?>" height="40" class="img-polaroid" />
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

                    <?= substr($usuario['nm_usuario'], 0, 16); ?>

                </div>
                <div class="perfil">
                    <?
                    if ($usuario['entidade'] == 'cidadao'):
                        echo $usuario['relacao'];
                    elseif ($usuario['entidade'] == 'orgao'):
                        echo substr($usuario['nm_orgao'], 0, 19) . "<br>";
                        echo $usuario['relacao'];
                    endif;
                    ?>
                </div>
            </div>

            <div class="clear"></div>

            <?
        endforeach;
    else:
        echo "Só você...";
    endif;
    ?>

</div>