<?php

include_once('conexao.php');

$username = $_POST['username'];
$email    = $_POST['email'];

// Vamos fazer esta busca no banco pra evitar duplicidade de nomes.

$sql = "select * from chat where (chat.to = '" . mysql_real_escape_string($username) . "' AND recd = 0) order by id ASC";

$query = mysql_query($sql);
$num_rows = mysql_num_rows($query);

$i = 1;
while ($num_rows > 0) :

    $i++;

    $username = $_POST['username'] . $i;
    $sql = "select * from chat where (chat.to = '" . mysql_real_escape_string($username) . "' AND recd = 0) order by id ASC";

    $query = mysql_query($sql);
    $num_rows = mysql_num_rows($query);

endwhile;

session_start();

$_SESSION['username'] = $username;
$_SESSION['email'] = $email;

?>