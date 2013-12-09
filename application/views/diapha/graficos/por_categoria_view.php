<script type="text/javascript">
            
    var series;
    var categories;
    var options;
            
    options = {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Ocorrências por Categoria em <?= usuario('cidade'); ?>'
        },
        subtitle: {
            text: 'Fonte: diapha.com.br'
        },
        xAxis: {
            categories: [{}]
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Quantidade de ocorrências'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:1f} relato(s)</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: []
    };  
                        
            
    function requestData() 
    {
        $.ajax({
            url: '<?= site_url('grafico/por_categoria_json'); ?>',
            datatype: "json",
            success: function(data) 
            {
                        
                data = jQuery.parseJSON(data);
                options.xAxis['categories'] = data.categories;
                        
                $.each(data.series,function(n,s){
                            
                    options.series.push({
                        data: s['data'],
                        color: s['color'],
                        name: s['name']
                    });
                            
                });
                        
                        
                $(function () {
                    $('#container').highcharts(options);
                });
                        
            }
        });
    }
            
    requestData();
            

</script>


<div id="container" class="area-grafico" style="min-height: 300px; margin: 0 auto"></div>


