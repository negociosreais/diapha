<style type="text/css">
    .caixa {
        height: 200px;
    }
</style>

<div class="grid_12">

    

    <div class="caixa">
        
        <h1 class="tituloCaixa">Cadastro confirmado com sucesso</h1>

        <p>
            <img src="<?= base_url() . TEMPLATE; ?>/img/ok.png" border="0" align="left"  style="margin: 10px" height="100"/> </p>
        <h2>Seja bem vindo!</h2>
        <p>O Portal ARP agradece sua confiança. Por medida de segurança é necessário autenticação no portal. Utilize seu login ao lado e desfrute de todos os nosso serviços. </p>
        
    </div>
</div>

<script>

    $(document).ready(function() {
        $("input[name=login]").focus();
    });

</script>

<div class="grid_12">
    
    <div class="caixa">
        
        <h1 class="tituloCaixa">Acesse</h1>

        <fieldset class="form">

            <form name="login" method="post" action="<?= site_url('login/autenticar'); ?>">

                <input type="hidden" name="url" value="<?= $_GET['url']; ?>" />


                <table class="espacada" width="100%">
                    <tbody>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>

                        <tr>
                            <td width="80">

                                <label>
                                    Usuário:
                                </label>
                            </td>
                            <td align="left">
                                <input type="text" name="login" size="30" tabindex="1" />
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
                                    <input name="senha" size="30"  tabindex="2" type="password" />
                                </div>
                            </td>
                        </tr>
                        <tr><td></td></tr>
                        <tr>
                            <td>

                            </td>
                            <td align="left">
                                <input type="submit" value="Entrar" name="btnlogar" tabindex="3" class="btn btn-success">
                                |
                                <a href="<?= site_url('login/esqueci_senha'); ?>">Esqueci minha senha</a>
                                <?= showStatus(); ?>
                            </td>
                        </tr>
                        <tr><td></td></tr>

                    </tbody>
                </table>


            </form>

        </fieldset>

    </div>

</div>




