<?php
session_start();

if (usuario('nm_login') != ''):
    $_SESSION['username'] = strtolower(usuario('nm_login')); // Must be already set
endif;


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/loose.dtd" >

<html>
    <head>
        <title>Seja bem vindo Rafael</title>

        <link type="text/css" rel="stylesheet" media="all" href="<?= base_url(); ?>/chat/css/chat.css" />

    </head>
    <body>

        <script type="text/javascript" src="<?= base_url(); ?>/chat/js/chat.js"></script>

    </body>
</html>