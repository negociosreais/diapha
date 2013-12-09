<div class="grid_24">

    <h1 class="tituloCaixa">ÓRGÃOS PÚBLICOS</h1>

    <div class="caixa">
        
        <p>Selecione o estado:</p>

        <div  class="lista-alfabetica">
            <ul>
                <?
                $estados = unserialize(UF);

                foreach ($estados as $key => $val):

                    $i++;
                    if ($i > 9):
                        $i = 1;
                        echo "</ul><ul>";
                    endif;

                    echo "<li><a href='" . site_url('orgaos/' . $key) . "'>{$val}</a></li>";
                    
                endforeach;
                ?>
            </ul>
        </div>

    </div>

</div>