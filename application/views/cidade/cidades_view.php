<?
$view = $_GET['view'];
$meusrelatos = $_GET['meusrelatos'];
$intervalo = $_GET['intervalo'];
?>

<style>

    .caixa {
        min-height: 300px;
    }

</style>

<div class="grid_24">

    <div class="caixa">

        <h1 class="tituloCaixa">
            Cidades / <?= $uf; ?>
        </h1>


        <ul class="breadcrumb">
            <li><a href="<?= site_url(''); ?>">Home</a> <span class="divider">/</span></li>
            <li><a href="<?= site_url('estados'); ?>">Estados</a> <span class="divider">/</span></li>
            <li class="active"><?= $uf; ?></li>
        </ul>

        <?
        if (!in_array($uf, array('DF', 'AC', 'RO', 'RR'))):
            $alfabeto = unserialize(ALFABETO);
            ?>
            <div class="pagination" align="center">
                <ul>
                    <?
                    foreach ($alfabeto as $a):
                        ?>
                        <li <?= ($letra == $a) ? "class='active'" : ""; ?>><a href="<?= site_url('cidades/' . $uf . '/' . $a); ?>" ><?= $a; ?></a></li>
                        <?
                    endforeach;
                    ?>
                </ul>
            </div>
            <?
        endif;
        ?>

        <div class="cidades">
            <ul class="listaColunas">
                <?
                $total = count($cidades);
                $por_coluna = (int) $total / 4;

                $i = 0;

                foreach ($cidades as $cidade):

                    $i++;
                    if ($i >= $por_coluna):
                        $i = 1;
                        ?>
                    </ul>
                    <ul class='listaColunas'>
                        <?
                    endif;
                    ?>
                    <li>
                        <a href="<?= site_url('relatos/cidade/' . $cidade['nome'] . " " . $uf); ?>"><?= $cidade['nome']; ?></a>
                    </li>
                    <?
                endforeach;
                ?>
            </ul>
        </div>

    </div>


</div>