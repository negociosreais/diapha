<script>

    $(document).ready(function(){
   
        $("input[name=nm_representante]").val(parent.$("input[name=nm_representante]").val());
        $("input[name=ds_email]").val(parent.$("input[name=ds_email]").val());
        $("input[name=nm_cidade]").val(parent.$("select[name=nm_cidade]").val());
        $("input[name=nm_estado]").val(parent.$("select[name=nm_estado]").val());
   
    });

</script>

<div class="grid_24 caixa center">

    <h1 class="tituloCaixa">Qual o seu perfil ?</h1>

    <div class="caixa box-branco floatLeft center" style="width: 260px; margin: 0 22px 0 22px; padding: 10px;">
        <h2>Órgão ou empresa pública</h2>

        <p style="height:100px">
            Estou a procura de atas e produtos para aderir.
        </p>

        <form action="<?= site_url('orgao/cadastrar'); ?>" method="POST">
            
            <input type="hidden" name="nm_representante" />
            <input type="hidden" name="ds_email" />
            <input type="hidden" name="nm_cidade" />
            <input type="hidden" name="nm_estado" />
            
            <input type="submit" value="Cadastrar" class="btn btn-success" />
        </form>
    </div>

    <div class="caixa box-branco floatLeft center"  style="width: 260px; padding: 10px; margin: 0 22px 0 0;background-color: #f5f5f5;">
        <h2>Empresa privada</h2>

        <p style="height:100px">
            Sou detentor de atas e desejo anuncia-las no portal.
        </p>

        <form action="<?= site_url('vendedor/cadastrar'); ?>" method="POST">
            
            <input type="hidden" name="nm_representante" />
            <input type="hidden" name="ds_email" />
            <input type="hidden" name="nm_cidade" />
            <input type="hidden" name="nm_estado" />
            
            <input type="submit" value="Cadastrar" class="btn btn-info" />
        </form>
    </div>
    
    <div class="caixa box-branco floatLeft center"  style="width: 260px; padding: 10px;">
        <h2>Cidadão</h2>

        <p style="height:100px">
            Sou cidadão e quero acompanhar o que acontece em meu país.
        </p>

        <form action="<?= site_url('usuario/cadastrar'); ?>" method="POST">
            
            <input type="hidden" name="nm_representante" />
            <input type="hidden" name="ds_email" />
            <input type="hidden" name="nm_cidade" />
            <input type="hidden" name="nm_estado" />
            
            <input type="submit" value="Cadastrar" class="btn btn-warning" />
        </form>
    </div>

</div>

