<div class="box-branco twitter">

    <h1>Twitter</h1>

    <?

    echo '<ol>';
    foreach($xml->channel->item as $node) {

        printf('<li><a href="%s">%s</a><br><span class="data">%s</span></li>',
                $node->link, $node->title, $node->pubDate);
    }
    echo '</ol>';

?>

    </div>