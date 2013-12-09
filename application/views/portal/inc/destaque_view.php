<?
if ($destaques):
    foreach ($destaques as $produto):
        ?>
        <div  class="produto">

            <a class="discreto" href="<?= site_url('produto/detalhes/' . $produto['id_produto']); ?>" alt="<?= $produto['nm_produto']; ?>" title="<?= $produto['nm_produto']; ?>">

                <img src="<?= base_url() ?>arquivos/produtos/t_<?= $produto['nm_imagem'] ?>" align="left" />

                <?= substr($produto['nm_produto'], 0, 35); ?>...<br>

            </a>
            <a href="<?= site_url('produto/detalhes/' . $produto['id_produto']); ?>" alt="<?= $produto['nm_produto']; ?>" title="<?= $produto['nm_produto']; ?>">
                R$ <?= $produto['nr_valor_unit']; ?>
            </a>

        </div>

        <?
    endforeach;
endif;
?>
