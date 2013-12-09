<!-- Attach our CSS -->
<link rel="stylesheet" href="<?= base_url() . TEMPLATE; ?>/js/slideshow/orbit-1.2.3.css">

<!-- Attach necessary JS -->
<script type="text/javascript" src="<?= base_url() . TEMPLATE; ?>/js/slideshow/jquery.orbit-1.2.3.min.js"></script>	

<!--[if IE]>
     <style type="text/css">
         .timer { display: none !important; }
         div.caption { background:transparent; filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000,endColorstr=#99000000);zoom: 1; }
    </style>
<![endif]-->

<!-- Run the plugin -->
<script type="text/javascript">
    $(window).load(function() {
        $('#featured').orbit({
            animation: 'fade',                  // fade, horizontal-slide, vertical-slide, horizontal-push
            animationSpeed: 2000,                // how fast animtions are
            timer: true, 			 // true or false to have the timer
            advanceSpeed: 10000, 		 // if timer is enabled, time between transitions 
            pauseOnHover: false, 		 // if you hover pauses the slider
            startClockOnMouseOut: false, 	 // if clock should start on MouseOut
            startClockOnMouseOutAfter: 1000, 	 // how long after MouseOut should the timer start again
            directionalNav: false, 		 // manual advancing directional navs
            captions: true, 			 // do you want captions?
            captionAnimation: 'fade', 		 // fade, slideOpen, none
            captionAnimationSpeed: 800, 	 // if so how quickly should they animate in
            bullets: true,			 // true or false to activate the bullet navigation
            bulletThumbs: false,		         // thumbnails for the bullets
            bulletThumbLocation: '',		 // location from this file where thumbs will be
            afterSlideChange: function(){} 	 // empty function 
        });
    });
</script>

<div class="banner">



    <div id="featured"> 
        
        <a href="http://blog.portalarp.com.br/?p=193" target="_blank" title="Dilma edita nova regulamentação de registro de preço para licitações.">
            <div>
                <img src="<?= base_url() . TEMPLATE; ?>/img/banner/banner-menor-6.jpg" alt="Dilma edita nova regulamentação de registro de preço para licitações." />
            </div>
        </a>
        
        <a href="<?=site_url('portal/selecionar_perfil'); ?>" class="nyroModal" title="Cadastre-se agora mesmo e faça parte.">
            <div>
                <img src="<?= base_url() . TEMPLATE; ?>/img/banner/banner-menor-1.jpg" alt="Encontre produtos e atas. Se relacione com fornecedores e órgãos. Estimativas de preço. Equipe especializada em licitações. Cadastre-se agora." />
            </div>
        </a>
        
        <a href="<?=site_url('login?url=produto/catalogo'); ?>" target="_blank" title="Procure diretamente por produtos.">
            <div >
                <img src="<?= base_url() . TEMPLATE; ?>/img/banner/banner-menor-5.jpg" alt="Procure diretamente por produtos." />
            </div>
        </a>
        
        <a href="http://itunes.apple.com/br/app/portalarp/id528370959?mt=8" target="_blank" title="Baixe agora o aplicativo para seu IPhone ou IPad">
            <div >
                <img src="<?= base_url() . TEMPLATE; ?>/img/banner/banner-menor-3.jpg" alt="Registro de preço no seu celular IPhone, IPad e Android." />
            </div>
        </a>

        <a href="http://twitter.com/#!/portalarp" target="_blank" title="Siga-nos no Twitter">
            <div >
                <img src="<?= base_url() . TEMPLATE; ?>/img/banner/banner-menor-2.jpg" alt="Siga-nos nas redes sociais." />
            </div>
        </a>

    </div>


</div>