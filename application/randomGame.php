<?php
require '../classes/mysql.php';
$mysql = new database();
$mysql->connectDb();

$civ1 = rand(1, 2);
$civ2 = rand(1, 2);
while($civ2 === $civ1)
{
	$civ2 = rand(1,2);
}
$civs = array($civ1, $civ2);
$player = 1;

foreach($civs as $key => $value)
{
	$results = $mysql->fetchRows('civilization', 'name', 'id', $value);
	$resultsRow = $results->fetch_row();
	echo 'Player ', $player, ': ', $resultsRow[0], '<br/>';
	$player++;
}

$victories = array('time', 'domination', 'science', 'diplomatic', 'culture');
echo 'Victory type: ', $victories[rand(0,4)], ' victory<br/>';

$difficulties = array('settler', 'chieftain', 'warlord', 'prince', 'king', 'emperor', 'immortal', 'deity');
echo 'Difficulty level: ', $difficulties[rand(0,7)], '<br/>';

$maps = array('Earth', 'continents', 'pangea', 'archipelago', 'fractal');
echo 'Map type: ', $maps[rand(0,4)], '<br/>';

$paces = array('quick', 'standard', 'epic', 'marathon');
echo 'Game pace: ', $paces[rand(0,3)];
?>