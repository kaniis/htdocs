<?php
require 'classes/mysql.php';
$mysql = new database;
$mysql->connectDb();

$result = $mysql->fetchRows('civilization', 'name, leader, id');
while($resultRow = $result->fetch_row())
{
	echo $resultRow[0], ' - ', $resultRow[1];
	$unique = $mysql->fetchRows('uniques', 'name, description, type', 'civ_id', $resultRow[2]);
	while($uniquesRow = $unique->fetch_row())
	{
		echo '<br/>', $uniquesRow[0],' (', $uniquesRow[2], '):<br/>', $uniquesRow[1];
	}
	echo '<br/><br/>';
}

$result = $mysql->fetchRows('users', 'name, fav_civ, tag');
while($resultRow = $result->fetch_row())
{
	$civ = $mysql->idToValue('civilization', 'name', $resultRow[1]) ;
	echo $resultRow[0], '<br/>', $civ[0], '<br/>', $resultRow[2];
	echo '<br/><br/>';
}
?>