<?php
require '../classes/mysql.php';
database::connectDb();

session_start();

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

function randUniCiv()
{
	$mapSize = [2, 4, 6, 8, 10, 14];
	$size = $mapSize[rand(0, 5)];
	$civList = [];
	$civRows = database::fetchRows('civilization', 'id');
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

?>

<form method="post" action="/application/randomgame.php">
	<select name="mode">
		<option selected disabled>Select a mode</option>
		<option value="0">Unique civs</option>
		<option value="1">Allow duplicates</option>
	</select>
	<input type="submit" name="randomMode" value="Set">
</form>

<?php

if(isset($_POST['randomMode']))
{
	$_SESSION['mode'] = $_POST['mode'];
	$_SESSION['randomMode'] = '';
}

if(isset($_SESSION['randomMode']))
{
	$randomMode = array('only uniques', 'allow duplicates');

	if($randomMode[$_SESSION['mode']] == 'only uniques')
	{
		$civs = randUniCiv();
	}
	elseif($randomMode[$_SESSION['mode']] == 'allow duplicates')
	{
		$civs = randDupCiv();
	}

	echo 'Mode: ', $randomMode[$_SESSION['mode'] ], '<br/>';
	echo '<a href="randomGame.php">Reroll</a><br/><br/>';

	$player = 1;

	foreach($civs as $key => $value)
	{
		$results = database::fetchRows('civilization', 'name', 'id', $value);
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
}
else
{
	echo 'Please select a mode.';
}
?>