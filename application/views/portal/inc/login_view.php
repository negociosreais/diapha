<?
if (!checa_logado(false)):
    ?>

    <script>

        function valida(){

            if ($("input[name=tipo]:checked").val() != '' &&
                $("input[name=login]").val() != '') {
                return true;
            } else {
                alert("Preencha todos os campos por favor.");
                return false;
            }
        }


    </script>
    <style type="text/css">
        <!--
        .style2 {
            font-size: 16px;
            font-weight: bold;
        }
        -->
    </style>



    <h1 class="acesse">Acesse</h1>

    <div align="center">

        <fieldset class="form">

            <form name="login" method="post" action="<?= site_url('login/autenticar'); ?>" onsubmit="return valida();">
                
                <input type="hidden" name="url" value="<?=$url; ?>" />

                <div>

                    <table width="90%" >
                        <tbody>
                            <tr>
                                <td width="80">
                                    <label>
                                        Usuário:
                                    </label>
                                </td>
                                <td align="left">
                                    <input type="text" name="login" size="18" tabindex="1" />
                                </td>
                            </tr>
                            <tr>
                                <td>

                                    <label>
                                        Senha:
                                    </label>

                                </td>
                                <td align="left">
                                    <div align="left">
                                        <input name="senha" size="18"  tabindex="2" type="password" />
                                    </div>

                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="2">
                                    <input type="submit" value="Entrar" name="btn"  tabindex="3" />
                                    <br>
                                    <a href="<?= site_url('login/esqueci_senha'); ?>" alt="Clique aqui caso tenha esquecido a sua senha." title="Clique aqui caso tenha esquecido a sua senha.">
                                        Esqueci a senha
                                    </a>
                                    <? showStatus(); ?>
                                </td>
                            </tr>

                        </tbody>
                    </table>

                </div>

            </form>

        </fieldset>

    </div>


    <div align="center">

        <fieldset class="form">

            <div>

                <table width="90%" class="espacada">
                    <tbody>
                        <tr>
                            <td align="center" colspan="2">
                                <span class="style2">Cadastre-se agora, é grátis.</span></td>
                        </tr>
                        <tr>
                            <td align="center" colspan="2">
                                <a href="<?= site_url('orgao/cadastrar'); ?>" alt="Clique aqui para se cadastrar caso seja Órgão Público interessado em aderir a Atas de Registro de Preço. "
                                   title="Clique aqui para se cadastrar caso seja Órgão Público interessado em aderir a Atas de Registro de Preço. ">
                                    ÓRGÃO
                                </a>
                                |
                                <a href="<?= site_url('vendedor/cadastrar'); ?>" alt="Clique aqui para se cadastrar caso seja Empresa detentora de Atas de Registro de Preço. "
                                   title="Clique aqui para se cadastrar caso seja Empresa detentora de Atas de Registro de Preço. ">
                                    EMPRESA
                                </a>

                            </td>
                        </tr>

                    </tbody>
                </table>

            </div>


        </fieldset>

    </div>


    <?
    
else:

    if (perfil() == "vendedor")
        $tipo = "Empresa";
    elseif (perfil() == "orgao")
        $tipo = "Órgão";
    else
        $tipo = perfil();
    ?>

    <h1>Seja Bem Vindo!</h1>

    <div align="center">

        <div>

            <table width="90%" class="espacada">
                <tbody>
                    <tr>
                        <td align="left" width="50">
                            <label>Usuário: </label>
                        </td>
                        <td align="left">
                            <?= usuario('nm_login'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left">
                            <label>Tipo: </label>
                        </td>
                        <td align="left">
                            <?= $tipo; ?>
                        </td>
                    </tr>

                    <tr>
                        <td align="right" colspan="2">

                            <?
                            if ($tipo == "Órgão"):
                                ?>
                                <a href="<?= site_url('orgao/' . usuario('id_orgao') . '/editar'); ?>" class="destaque" >Meus Dados | </a>
                                <?
                            else:
                                ?>
                                <a href="<?= site_url('restrito'); ?>" class="destaque" >Minha Conta | </a>
                            <?
                            endif;
                            ?>
                            <a href="<?= site_url('login/logoff'); ?>" class="destaque" >Sair</a>

                        </td>
                    </tr>


                </tbody>
            </table>

        </div>

    </div>

<?
endif;
?>