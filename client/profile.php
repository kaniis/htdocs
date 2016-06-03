<?php

session_start();

require '../classes/mysql.php';
require '../classes/router.php';

database::connectDb();
$result = database::fetchRows('users', 'name, fav_civ, tag',  'name', $_GET['user']);

$userRow = $result->fetch_row();
if($userRow != null)
{
	echo $userRow[0],' <em>',$userRow[2],'</em><br/>';	
}
else
{
	$_SESSION['notFound'] = '';
	router::redirect('');
}

if($userRow[1] != 0)
{
	$civRow = database::idToValue('civilization', 'name', $userRow[1]);
	if($civRow != null)
	{
		echo 'Favourite civ: ' , $civRow[0];
		echo '<img src="/images/'.$civRow[0].'.jpg"></img>';
	}
}

?>