<script>

    $(document).ready(function() {
        
        carregarEquipe();
        
        setInterval('carregarEquipe()', 30000);
        
    });
    
    /**
     * Carregar ultimos acessos
     */
    function carregarEquipe() {
              
        $.post('<?= site_url('portlets/equipe') ?>',
        { },

        function(data) {

            $("#equipe").html(data);

        });
    }
    
    
    
</script>

<div id="equipe">

</div>