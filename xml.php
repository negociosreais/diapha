<!DOCTYPE HTML>
<html>
    <head>
        <title>PortalARP</title>
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.css" />
        <script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.js"></script>
        <script type="text/javascript" charset="utf-8" src="cordova-1.8.0.js"></script>
        <script>
	
            $(document).ready(function () {
                $("#conteudoArea").append("<ul></ul>");
                jQuery.ajax({
                    url: 'http://portalarp.com.br/portal/produto/gerar_json?id_categoria_pai=56',
                    dataType: 'jsonp',
                    crossDomain: true,
                    jsonp: false,
                    jsonpCallback: 'jsonFlickrFeed',
                    success: function (d) {
                        $('#title').text(d.id_produto);
 
                        var i, l = d.items.length, newLi, newItem;
 
                        $('<ul id="photoList"></ul>').appendTo('#main');
 
                        for (i = 0; i < l; i++) {
                            newLi = $('<li></li>');
                            newItem = d.items[i];
 
                            $('<h2>'+newItem.nm_produto+'</h2>').appendTo(newLi);
                            $('<h3>' + newItem.nm_marca + '</h3>').appendTo(newLi);
 
                            newLi.appendTo('#photoList');
 
                        }
                    }
                });
            });
	

        </script>

    </head>
    <body>

        <div id="main"></div>

    </body>
</html>