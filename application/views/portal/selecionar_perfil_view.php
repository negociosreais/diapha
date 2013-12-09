<script>

    $(document).ready(function(){
   
        $("input[name=nm_representante]").val(parent.$("input[name=nm_representante]").val());
        $("input[name=ds_email]").val(parent.$("input[name=ds_email]").val());
        $("input[name=nm_cidade]").val(parent.$("select[name=nm_cidade]").val());
        $("input[name=nm_estado]").val(parent.$("select[name=nm_estado]").val());
   
    });

</script>

<div class="grid_24">

    <div class="caixa">

        <h1 class="tituloCaixa">Qual o seu perfil ?</h1>

        <div class="caixa box-branco floatLeft"  style="width: 410px; padding: 10px;background:#f5f5f5;text-align: center;margin-left: 33px">
            <h2>Cidadão</h2>

            <p style="height:80px">
                Sou cidadão e quero acompanhar os relatos de ocorrências na minha cidade e cobrar providências dos órgãos responsáveis.
            </p>

            <form action="<?= site_url('usuario/cadastrar'); ?>" method="POST">

                <input type="hidden" name="nm_representante" />
                <input type="hidden" name="ds_email" />
                <input type="hidden" name="nm_cidade" />
                <input type="hidden" name="nm_estado" />

                <input type="submit" value="Cadastrar" class="btn btn-info btn-large" title="Se você é cidadão selecione esta opção." />
            </form>
        </div>
        
        <div class="caixa box-branco floatLeft" style="width: 410px; margin: 0 22px 0 22px; padding: 10px;background:#f5f5f5;text-align: center">
            <h2>Órgão ou empresa pública</h2>

            <p style="height:80px">
                Sou órgão público e tenho interesse de monitorar as ocorrências que são de minha responsabilidade para que sejam tomadas as devidas providências.
            </p>

            <form action="<?= site_url('orgao/cadastrar'); ?>" method="POST">

                <input type="hidden" name="nm_representante" />
                <input type="hidden" name="ds_email" />
                <input type="hidden" name="nm_cidade" />
                <input type="hidden" name="nm_estado" />

                <input type="submit" value="Cadastrar" class="btn btn-success btn-large" title="Se você é órgão público selecione esta opção."/>
            </form>
        </div>
        
        <div class="clear"></div>
        <br><br>
    </div>

</div>

