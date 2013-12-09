<script>
    
    var limitNotificacoes = 8;

    $(document).ready(function() { 
        
        
        carregarTela();
   
        carregarOportunidades();
        
        carregarNotificacoes();
        
        // Desabilitado *****
        /*$( "#avisoProdutos" ).dialog({
            autoOpen: false,
            width: 850,
            modal: true,
            position: 'center',
            buttons: {
                
            },
            close: function() {
                
                if ($("input[name=ck_aviso_produtos]").is(':checked') == true){
                    
                    var date = new Date();
                    var saida;
                    date.setTime(date.getTime() + (24 * 60 * 60 * 1000));
                    $.cookie('aviso_produtos_<?=usuario('id_usuario'); ?>', saida, { path: '/', expires: date });
                    
                }
                
            }
        });*/
        
    });
    

    
    /**
     * Carregar ultimos acessos
     */
    function carregarUltimosAcessos() {
              
        $.post('<?= site_url('portlets/ultimos_acessos') ?>',
        { },

        function(data) {

            $("#ultimos_acessos").html(data);

        });
    }
    
    /**
     * Oportunidades
     */
    function carregarOportunidades() {
              
        $.post('<?= site_url('portlets/oportunidades') ?>',
        { },

        function(data) {

            $("#oportunidades").html(data);
            
            carregarDiapha();

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

    <li data-id="numero3" data-text="Próximo">
        <h2>Perfil</h2>
        <p>Acesse, Edite informações do seu perfil.</p>
    </li>
    <li data-id="numero4" data-text="Próximo">
        <h2>Plano de serviços</h2>
        <p>Conheça e Contrate nossos Serviços.</p>
    </li>
    <li data-id="numero5" data-text="Próximo" class="custom">
        <h2>Documentos</h2>
        <p>Insira seus arquivos: ARP, DOU e Pregão.</p>
    </li>
    <li data-id="numero6" data-text="Próximo" data-options="tipLocation:top;tipAnimation:fade">
        <h2>Produtos</h2>
        <p>Cadastre, visualize seus produtos.</p>
    </li>
    <li data-id="numero7" data-text="Próximo" data-options="tipLocation:top right;">
        <h2>Relatório de acesso</h2>
        <p>Suas oportunidades de venda.</p>
    </li>
    <li data-id="numero8" data-text="Próximo">
        <h2>Convide</h2>
        <p>Integre sua equipe dentro do portal.</p>
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
        <h2>Oportunidades de licitação</h2>
        <p>Responda com uma proposta antes que expire o tempo e aumenta sua conversão.</p>
    </li>
    <li data-id="numero16" data-text="Próximo">
        <h2>Oportunidades de compra qualificada</h2>
        <p>O órgão quer aderir (Comprar) seu produto.</p>
    </li>
    <li data-id="numero17" data-text="Próximo">
        <h2>Oportunidades de compra</h2>
        <p>O órgão está na busca de um produto similar ao seu, ligue e dimensione a oportunidade.</p>
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
<?
// Se nunca tiver contratado ou testado algum serviço
if (!$servicos):
    ?>
    <div class="divFlutuante">
        <a href="<?= site_url('teste_gratis'); ?>">
            <img src="<?= base_url() . TEMPLATE; ?>/img/testeGratis.png" height="150" />
        </a>
    </div>
    <?
endif;
?>

<div class="divTur" title="Precisa de ajuda? Clique aqui para fazer um Tour pelo Portal ARP e conhece-lo melhor.">
    <a href="javascript:void(0)">
        &nbsp;
    </a>
</div>

<!-- FINAL DIV FLUTUANTE -->



<?= showStatus(); ?>

<!-- Notificações -->
<?
if (checa_permissao_servico("1", false) && !checa_permissao_servico("9", false)):
    ?>
    <!--<div class="alert" style="margin-left: 5px">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <h3>Clipping de Licitações</h3>
        <b>Atenção!</b> Já está disponível o serviço de <b>Clipping de Licitações</b> do PortalARP, 
        <a href="<?= site_url('clipping/configurar_interesses'); ?>">clique aqui</a> para ativá-lo agora mesmo.
    </div>-->
    <?
endif;
?>

<?
if (!$categorias):
    ?>
    <div class="grid_19">
        <div class="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <h3>Atualize seu cadastro!</h3>
            Identificamos que as informações referentes ao segmento de sua empresa estão desatualizadas. 
            <a href="<?= site_url('vendedor/' . usuario('id_vendedor') . "/editar"); ?>">Clique aqui</a> para atualizar seus dados, isso ajudará o Portal ARP a identificar mais oportunidades para você.
        </div>
    </div>

    <div class="clear"></div>
    <?
endif;
?>

<div id="diapha" class="grid_13"></div>

<div id="notificacoes" class="grid_6"></div>

<div class="clear"></div>

<div id="oportunidades"></div>

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

<!-- POPUPS -->

<?
if (!$produtos):
    ?>
    <!--<div id="avisoProdutos" class="center">
        <img src="<?= base_url() . TEMPLATE; ?>/img/banner-produtos/1.jpg" /><br>

        <img src="<?= base_url() . TEMPLATE; ?>/img/banner-produtos/2.jpg" /><a href="<?= site_url('ata/listar'); ?>"><img src="<?= base_url() . TEMPLATE; ?>/img/banner-produtos/3.jpg" /></a><a href="<?= site_url('produto/listar'); ?>"><img src="<?= base_url() . TEMPLATE; ?>/img/banner-produtos/4.jpg" /></a><a href="<?= site_url('produto_acesso/listar'); ?>"><img src="<?= base_url() . TEMPLATE; ?>/img/banner-produtos/5.jpg" /></a>

        <p class="left">
            <span class="legenda">
                <input type="checkbox" name="ck_aviso_produtos" value="1" />
                Não exibir esta mensagem novamente.
                
            </span>
        </p>
    </div>
    <script>
        $(document).ready(function() {

            if (!$.cookie('aviso_produtos_<?=usuario('id_usuario'); ?>')){
                $("#avisoProdutos").dialog('open');
            }
                        
        });
    </script>-->
    <?
endif;
?>