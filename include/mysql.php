<?php
$config = parse_ini_file("{$_SERVER['DOCUMENT_ROOT']}/config.ini");
$etcPath = $config['etc_directory'];
include "$etcPath/db-connect.php";

$connection = $con; // hack for homepage

$connection->select_db('babynamesdb');
