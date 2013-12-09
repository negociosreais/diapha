<script>

    $(document).ready(function() {

        $('#produtos a').tooltip({
            track: true,
            delay: 0,
            showURL: false,
            showBody: " - ",
            fade: 250
        });
        
        $('.maisDetalhes').nyroModal({
            type: 'iframe',
            height: 500,
            width: 960,
            resizable: true,
            autoSizable: true,
            titleFromIframe: true
        });
                    
  

    });

</script>

<div class="grid_19">

    <div class="caixa table-cell">

        <?
        if ($destaques) :
            ?>
            <div class="quadro">

                <?
                $i = 0;
                foreach ($destaques as $dado) :
                    $i++;
                    if ($i == 1)
                        echo "<ul>";

                    $title = "<b>Especificação: </b><br>" . str_replace("\n", "<br>", $dado['ds_especificacao']);
                    $title = str_replace('"', "'", $title);
                    ?>

                    <li>

                        <a class="discreto nyroModal maisDetalhes" href="<?= site_url('produto/detalhes/' . $dado['id_produto']); ?>" title="<?= $title; ?>">

                            <div class="img">
                                <img src="<?= base_url() . 'arquivos/produtos/t_' . $dado['nm_imagem']; ?>" />
                            </div>

                            <h1 class="produto"><?= $dado['nm_produto']; ?></h1>
                            <span>

                                <b>Quantidade: </b> <?= $dado['nr_quantidade']; ?> <br>
                                <b>Preço Unit.: </b> R$ <?= $dado['nr_valor_unit']; ?> <br>

                                + detalhes

                            </span>

                        </a>

                    </li>

                    <?
                    if ($i == 4):
                        echo "</ul>";
                        $i = 0;
                    endif;

                endforeach;
                ?>
            </div>
            <?
        endif;
        ?>

    </div>

</div>