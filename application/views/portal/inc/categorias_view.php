
<div class="clear"></div>

<div class="container_24 menuRodapeCategorias">

    <div class="rodape">
        <div class="grid_24">
            <div class="menuRodape">

                <?
                if ($categorias):

                    $total = count($categorias);
                    $por_coluna = ceil($total / 6);;

                    foreach ($categorias as $categoria):
                        $i++;

                        $nm_categoria = str_replace(" ","_",retira_acentos($categoria['nm_categoria']))."_".$categoria['id_categoria'];

                        if ($i == 1):
                            echo "<ul>";
                        endif;
                        ?>

                        <li><a href="<?= site_url('produtos/' . $nm_categoria); ?>"><?= $categoria['nm_categoria']; ?></a></li>

                        <?
                        if ($i == $por_coluna):
                            echo "</ul>";
                            $i = 0;
                        endif;

                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </div>

</div>