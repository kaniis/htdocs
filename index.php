<?php

session_start();

require 'classes/mysql.php';
database::connectDb();

require 'client/404.php';

$result = database::fetchRows('civilization', 'name, leader, id');
while($resultRow = $result->fetch_row())
{
	echo $resultRow[0], ' - ', $resultRow[1];
	$unique = database::fetchRows('uniques', 'name, description, type', 'civ_id', $resultRow[2]);
	while($uniquesRow = $unique->fetch_row())
	{
		echo '<br/>', $uniquesRow[0],' (', $uniquesRow[2], '):<br/>', $uniquesRow[1];
	}
	echo '<br/><br/>';
}

$result = database::fetchRows('users', 'name, fav_civ, tag');
while($resultRow = $result->fetch_row())
{
	$civ = database::idToValue('civilization', 'name', $resultRow[1]) ;
	echo $resultRow[0], '<br/>', $civ[0], '<br/>', $resultRow[2];
	echo '<br/><br/>';
}
?>