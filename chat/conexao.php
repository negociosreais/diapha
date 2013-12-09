<?php

define('DBPATH', 'dbportalarp.cfukval7ru3d.sa-east-1.rds.amazonaws.com');
define('DBUSER', 'desen');
define('DBPASS', 'ocit00');
define('DBNAME', 'portalarp_portalarp');

global $dbh;
$dbh = mysql_connect(DBPATH, DBUSER, DBPASS);
mysql_selectdb(DBNAME, $dbh);
?>
