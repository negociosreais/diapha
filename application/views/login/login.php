<?
include_once('fb_connector.php');
?>

<script>

    $(document).ready(function() {
        $("input[name=login]").focus();
    });


</script>


<? showStatus(); ?>
<div class="grid_12">

    <div class="caixa" style="height: 350px">

        <h1 class="tituloCaixa">Criar novo cadastro</h1>

        <fieldset class="form">

            <table class="espacada" width="100% ">
                <tbody>

                    <tr>
                        <td>
                            <p>Para se cadastrar clique no botão abaixo e faça hoje mesmo parte da rede que colabora com a transparência em sua cidade:</p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding-left: 10px;text-align: center">

                            <a href="<?= $loginUrl; ?>" class="btn btn-primary btn-large input-xlarge">Cadastre-se com seu FACEBOOK</a>

                            <p>----------- OU -------------</p>

                            <a href="<?= site_url('portal/selecionar_perfil'); ?>" id="cadastreSe" class="btn btn-info btn-large input-xlarge">Cadastre-se</a>

                        </td>
                    </tr>

                </tbody>
            </table>

        </fieldset>

    </div>

</div>

<div class="grid_12">

    <div class="caixa" style="height: 350px">

        <h1 class="tituloCaixa">Já sou cadastrado</h1>



        <fieldset class="form">

            <form name="login" method="post" action="<?= site_url('login/autenticar'); ?>">

                <input type="hidden" name="url" value="<?= $_GET['url']; ?>" />

                <table class="espacada" width="100%">

                    <tbody>


                        <tr>
                            <td width="72">

                                <label>
                                    Usuário:
                                </label>
                            </td>
                            <td align="left">
                                <input type="text" name="login" size="30" tabindex="1" class="input-xlarge" style="width: 298px" />
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
                                    <input name="senha" size="30"  tabindex="2" type="password" class="input-xlarge" style="width: 298px" />
                                </div>
                            </td>
                        </tr>
                        <tr><td></td></tr>
                        <tr>
                            <td colspan="2" style="text-align: center">
                                
                                <input type="submit" class="btn btn-info btn-large input-xlarge" value="Entrar" style="width: 300px;height: 41px" />
                                
                                <p>----------- OU -------------</p>

                                <a href="<?= $loginUrl; ?>" class="btn btn-primary btn-large input-xlarge">Entre com seu FACEBRUK</a>
                                
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <a href="<?= site_url('login/esqueci_senha'); ?>">Esqueci minha senha</a>
                                <?= showStatus(); ?>
                            </td>
                        </tr>

                    </tbody>
                </table>


            </form>

        </fieldset>

    </div>

</div>



