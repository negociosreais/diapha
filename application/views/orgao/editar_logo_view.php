<?
$this->load->view("inc/componentes/crop");
?>

<script type="text/javascript">

    $(function(){

        $('#cropbox').Jcrop({
            aspectRatio: 1,
            onSelect: updateCoords
        });

    });

    function updateCoords(c)
    {
        $('#x').val(c.x);
        $('#y').val(c.y);
        $('#w').val(c.w);
        $('#h').val(c.h);
        
    };

    function checkCoords()
    {
        if (parseInt($('#w').val())) return true;
        alert('Por favor, clique sobre a imagem e arraste para selecionar uma área.');
        return false;
    };

</script>

<?= showStatus(); ?>

<div class="grid_24">

    <? showStatus(); ?>
    <div class="caixa">

        <h1 class="tituloCaixa">Atualizando imagem de perfil</h1>

        <?
        if ($nm_foto != ''):
            ?>

            <fieldset class="form">

                <form name="form_add_logo" id="form_add_logo" method="POST" enctype="multipart/form-data" onsubmit="return checkCoords();" >

                    <input type="hidden" id="x" name="x" />
                    <input type="hidden" id="y" name="y" />
                    <input type="hidden" id="w" name="w" />
                    <input type="hidden" id="h" name="h" />

                    <input type="hidden" name="id_orgao" value="<?= $id_orgao; ?>" />
                    <input type="hidden" name="nm_foto" value="<?= $nm_foto; ?>" />

                    <fieldset>

                        <table>

                            <tr>
                                <td><p>Clique sobre a imagem e arraste para selecionar uma área para recorta-la:</p>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label class="floatLeft"><img src="<?= base_url(); ?>arquivos/diapha/<?= $nm_foto; ?>" id="cropbox" /></label>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label class="floatLeft"><input type="submit" name="btnUploadLogo" value="Gravar alterações" class="btn btn-success" /></label>
                                </td>
                            </tr>

                        </table>

                    </fieldset>

                </form>

            </fieldset>

            <?
        else:
            ?>

            <form name="form_add_logo" id="form_add_logo" method="POST" enctype="multipart/form-data" >
                <input type="hidden" name="id_orgao" value="<?= $id_orgao; ?>" />

                <fieldset>
                    <label>Selecione uma imagem:</label>
                    <input name="nm_foto" id="nm_foto" type="file" size="30" />
                    
                    <br>
                    <button type="submit" class="btn btn-success btn-large">Enviar</button>
                </fieldset>
            </form>

        <?
        endif;
        ?>

    </div>
</div>