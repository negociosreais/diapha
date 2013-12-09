<script>
$(document).ready(function(){
   
   $(".botaoEncontre").click(function() {
      $("form[name=formBuscaProduto]").submit(); 
   });
   
});
</script>

<div class="boxEncontre" >
    <form name="formBuscaProduto" action="<?=site_url('produto/catalogo'); ?>" method="GET">
        <input type="text" class="buscaProduto" name="busca_produto" value="" />
        <button class="btn btn-success botaoEncontre">
            <img src="<?=base_url() . TEMPLATE; ?>/img/icoBusca.png" height="30" />
            Encontre
        </button>
    </form>
</div>