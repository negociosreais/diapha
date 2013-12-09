<script>

    $(document).ready(function() {

        /**
         * Menu accordion
         */
        //slides the element with class "menu_body" when paragraph with class "menu_head" is clicked
        $("#firstpane p.menu_head").click(function()
        {
            $(this).next("div.menu_body").slideToggle(300).siblings("div.menu_body").slideUp("slow");
            $(this).siblings();
        });
        //slides the element with class "menu_body" when mouse is over the paragraph
        $("#secondpane p.menu_head").mouseover(function()
        {
            $(this).css({backgroundImage:"url(<?= base_url() . TEMPLATE ?>'/img/down.png)"}).next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
            $(this).siblings().css({backgroundImage:"url(<?= base_url() . TEMPLATE ?>'/img/left.png)"});
        });

        /**
         * Links Categorias
         */

        $(".categorias a").click(function(){
            
            $("input[name=id_categoria_pai]").val($(this).attr('id'));
            
            $("input[name=busca]").val('');

            buscar_produtos();

        });


    });


</script>

<h1 class="tituloCaixa">CATEGORIAS</h1>

<div class="categorias">

    <div id="firstpane" class="menu_list"> <!--Code for menu starts here-->


        <?
        if ($categorias):

            foreach ($categorias as $categoria):

                $param['status'] = "Ativo";
                $param['id_categoria_pai'] = $categoria['id_categoria'];
                $filhas = $this->categoria_model->selecionarCategorias($param);

                $mais = ($filhas) ? "<img src='".base_url().TEMPLATE."/img/setaDireita.png' />" : "";
                ?>

                <p class="menu_head">

                    <a href="<?=site_url('produto/catalogo')."?id_categoria=".$categoria['id_categoria']; ?>" ><?= $categoria['nm_categoria']; ?></a>

                    <span style="float:right"><?= $mais; ?></span>

                </p>


                <?
                if ($filhas) {
                    echo '<div class="menu_body">';
                    foreach ($filhas as $filha):
                        ?>
                        <a href="<?=site_url('produto/catalogo')."?id_categoria=".$filha['id_categoria']; ?>" ><?= $filha['nm_categoria']; ?></a>
                        <?
                    endforeach;
                    echo '</div>';
                }
            endforeach;
        endif;
        ?>

    </div>

</div>