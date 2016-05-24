<?php
require '../classes/mysql.php';
$mysql = new database();
$mysql->connectDb();

function randDupCiv()
{
	$mapSize = [2, 4, 6, 8, 10, 14];
	$size = $mapSize[rand(0, 5)];
	$civs = [];
	for($i = 0; $i < $size; $i++)
	{

		$civs[] = rand(1, 14);

	}
	return $civs;
}

function randUniCiv($db)
{
	$mapSize = [2, 4, 6, 8, 10, 14];
	$size = $mapSize[rand(0, 5)];
	$civList = [];
	$civRows = $db->fetchRows('civilization', 'id');
	while($civ = $civRows->fetch_assoc())
	{
		$civList[] = $civ['id'];
	}

	$civs = [];
	for($i = 0; $i < $size; $i++)
	{
		$civId = rand(0, count($civList) - 1);
		$civs[] = $civList[$civId];
		unset($civList[$civId]);
		$civList = array_values($civList);
	}

	return $civs;
}

$civs = randUniCiv($mysql);

$player = 1;

foreach($civs as $key => $value)
{
	$results = $mysql->fetchRows('civilization', 'name', 'id', $value);
	$resultsRow = $results->fetch_row();
	echo 'Player ', $player++, ': ', $resultsRow[0], '<br/>';
}

$victories = ['time', 'domination', 'science', 'diplomatic', 'culture'];
echo 'Victory type: ', $victories[rand(0,4)], ' victory<br/>';

$difficulties = ['settler', 'chieftain', 'warlord', 'prince', 'king', 'emperor', 'immortal', 'deity'];
echo 'Difficulty level: ', $difficulties[rand(0,7)], '<br/>';

$maps = ['Earth', 'continents', 'pangea', 'archipelago', 'fractal'];
echo 'Map type: ', $maps[rand(0,4)], '<br/>';

$paces = ['quick', 'standard', 'epic', 'marathon'];
echo 'Game pace: ', $paces[rand(0,3)];
?>