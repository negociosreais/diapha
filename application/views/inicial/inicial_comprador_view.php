<script>
    
    var limitNotificacoes = 8;

    $(document).ready(function() {
        
        carregarTela();
        
        carregarNotificacoes();
   
        carregarProdutosInteresse();
        
        carregarDiapha();
        
        carregarOportunidades();
        
        
   
    });
    
    /**
     * Carregar ultimos acessos
     */
    function carregarProdutosInteresse() {
              
        $.post('<?= site_url('portlets/produtos_interesse') ?>',
        { },

        function(data) {

            $("#produtos_interesse").html(data);

        });
    }
    
    /**
     * Carregar diapha
     */
    var limitPost = 2;
    var limitPostInteresse = 2;
    var s = $("#tabs").tabs('option','selected');
    function carregarDiapha() {
              
        $.post('<?= site_url('portlets/diapha') ?>',
        { limit: limitPost, limit_interesse: limitPostInteresse},

        function(data) {
            
            if ($("#tabs")[0]){
                s = $("#tabs").tabs( "option", "selected" );
            }

            $("#diapha").html(data);

            $("#tabs").tabs('select',s);

        });
    }
    
    /**
     * Oportunidades
     */
    function carregarOportunidades() {
              
        $.post('<?= site_url('portlets/ep') ?>',
        { },

        function(data) {

            $("#oportunidades").html(data);

        });
    }
    
    /**
     * Carregar notificações
     */
    
    function carregarNotificacoes() {
        
              
        $.post('<?= site_url('portlets/notificacoes') ?>',
        { limit: limitNotificacoes},

        function(data) {
            
            $("#notificacoes").html(data);

        });
    }

</script>

<?= showStatus(); ?>

<div class="grid_19">
    <div class="alert">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <h3>Termos de Referência</h3>
        <b>Atenção!</b> Já está disponível o serviço que irá lhe auxiliar na confecção de seus <b>Termos de Referência</b>, 
        <a href="<?= site_url('termo_referencia/listar'); ?>">clique aqui</a> insira o documento e compartilhe para que empresas do segmento possam te auxiliar.
    </div>
</div>

<div class="clear"></div>

<div id="diapha" class="grid_13"></div>

<div id="notificacoes" class="grid_6"></div>

<div class="clear"></div>

<div id="oportunidades"></div>


<!-- Tip Content -->
<ol id="joyRideTipContent">
    <li data-id="numero1" data-text="Próximo">
        <h2>Foto</h2>
        <p>Insira sua foto de perfil.</p>
    </li>
    <li data-id="numero20" data-text="Próximo">
        <h2>Site</h2>
        <p>Vá para home do Portal.</p>
    </li>
    <li data-id="numero21" data-text="Próximo">
        <h2>Pesquise por produtos</h2>
        <p>Encontre os produtos que nescessita.</p>
    </li>
    <li data-id="numero3" data-text="Próximo">
        <h2>Perfil</h2>
        <p>Acesse, Edite informações do seu perfil.</p>
    </li>
    <li data-id="numero8" data-text="Próximo">
        <h2>Convide</h2>
        <p>Integre sua equipe dentro do Portal.</p>
    </li>
    <li data-id="numero9" data-text="Próximo">
        <h2>Bate-papo</h2>
        <p>Converse com a sua equipe.</p>
    </li>
    <li data-id="numero10" data-text="Próximo">
        <h2>Diapha</h2>
        <p>Seu canal de transparência.</p>
    </li>
    <li data-id="numero11" data-text="Próximo">
        <h2>Publique</h2>
        <p>Insira  sua necessidade ou fale sobre seus produtos e serviços.</p>
    </li>
    <li data-id="numero12" data-text="Próximo">
        <h2>Veja publicações</h2>
        <p>Acompanhe os posts em tempo real.</p>
    </li>
    <li data-id="numero13" data-text="Próximo">
        <h2>Seguindo</h2>
        <p>Acompanhe o que segue.</p>
    </li>
    <li data-id="numero14" data-text="Próximo">
        <h2>Comente</h2>
        <p>Responda se julgar necessário.</p>
    </li>
    <li data-id="numero15" data-text="Próximo">
        <h2>Estimativas de preço</h2>
        <p>Informe a especificação do produto que deseja fazer uma estimativa de preço.</p>
    </li>
    <li data-id="numero18" data-text="Próximo">
        <h2>Redes sociais</h2>
        <p>Veja o que as redes falam sobre nós.</p>
    </li>
    <li data-id="numero19" data-text="Próximo">
        <h2>Dispositivos móveis</h2>
        <p>Baixe os App do Portal.</p>
    </li>
    <li data-id="numero2" data-text="Finalizar">
        <h2>Contato</h2>
        <p>Ficou com dúvidas, contate-nos.</p>
    </li>

</ol>


<!-- DIV FLUTUANTE -->

<div class="divTur" title="Precisa de ajuda? Clique aqui para fazer um Tour pelo Portal ARP e conhece-lo melhor.">
    <a href="javascript:void(0)">
        &nbsp;
    </a>
</div>

<!-- FINAL DIV FLUTUANTE -->

<?
$this->load->view('inc/componentes/tur');
?>

<script type="text/javascript">
    
    $(".divTur").click(function() {
        $(window).joyride(); 
    });
    
    // ToolTip
    $(".divTur").each(function() {
        if ($(this).attr("title") != ''){
            $(this).tipTip({maxWidth: "auto", edgeOffset: 10});
        }
    });
    
</script>

