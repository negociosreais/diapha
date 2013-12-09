<script>

    $(document).ready(function() { 
        $.growlUI('', '<? foreach ($mensagens as $key => $val):
                            echo $val."<br>";
                          endforeach;
                       ?>'); 
                          
    }); 

</script>

<style>

    div.growlUI { 
        background: url(<?=base_url().TEMPLATE."/img/".$tipo.".png" ?>) no-repeat 10px 10px;
        padding: 10px 10px 5px 10px;
    }
    div.growlUI h1, div.growlUI h2 {
        color: white; padding: 10px 5px 5px 75px; text-align: left
    }

</style>

