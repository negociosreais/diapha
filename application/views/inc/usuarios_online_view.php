<script>

    $(document).ready(function() {
        
        carregarUsuariosOnline();
        
        setInterval('carregarUsuariosOnline()', 10000);
        
    });
    
    /**
     * Carregar ultimos acessos
     */
    function carregarUsuariosOnline() {
              
        $.post('<?= site_url('portlets/usuarios_online') ?>',
        { },

        function(data) {

            $("#usuarios_online").html(data);

        });
    }
    
</script>

<div id="usuarios_online">

</div>