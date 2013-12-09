<?
$view = $_GET['view'];
$meusrelatos = $_GET['meusrelatos'];
$intervalo = $_GET['intervalo'];


if ($cidade == ""):

    $this->load->library('facebook');
    $facebook = new Facebook(array(
                'appId' => FB_APPID,
                'secret' => FB_SECRET,
            ));

    $user = $facebook->getUser();

    if ($user) :
        try {
            $profile_user = $facebook->api('/me');
        } catch (FacebookApiException $e) {
            error_log($e);
            $user = null;
        }

        $cidade = $profile_user['location']['name'];
    else:
        if (perfil() == 'orgao'):
            $cidade = usuario('com_cidade') . " - " . usuario('com_estado');
        elseif (perfil() == 'vendedor'):
            $cidade = usuario('ven_cidade') . " - " . usuario('ven_estado');
        else:
            $cidade = "Brasilia - Brasil";
        endif;
    endif;

endif;
?>

<style>

    .caixa {
        min-height: 300px;
    }

</style>

<div class="grid_24">

    <div class="caixa">

        <h1 class="tituloCaixa">
            Escolha o estado
        </h1>

        <ul class="breadcrumb">
            <li><a href="<?= site_url(''); ?>">Home</a> <span class="divider">/</span></li>
            <li class="active">Estados</li>
        </ul>

        <div class="cidades">
            <ul class="listaColunas">
                <?
                $estados = unserialize(UF);
                $total = count($estados);
                $por_coluna = (int) $total / 4;

                $i = 0;
                foreach ($estados as $key => $val):
                    if ($val == ''):
                        continue;
                    endif;

                    $i++;
                    if ($i == $por_coluna):
                        $i = 1;
                        ?>
                    </ul>
                    <ul class='listaColunas'>
                        <?
                    endif;
                    ?>
                    <li>
                        <a href="<?= site_url('cidades/' . $key); ?>"><?= $val; ?></a>
                    </li>
                    <?
                endforeach;
                ?>
            </ul>
        </div>

    </div>


</div>

<script type="text/javascript">
    
    $(document).ready(function() {
        $("#btnBuscarCategorias").click(function() {
            updateMap();
        });
        
        $('.btn').tooltip()
    });

    function mostrarCategorias() {
        
        $('#modalCategorias').modal();
        
    }

</script>