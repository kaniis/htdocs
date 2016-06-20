<?php

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

echo 	'<div class="content">
		<p class="title">Select a generation mode.</p>
		<p class="text">';
echo 	'<form method="post" action="/RandomGame">
		<select name="mode">
			<option selected disabled>Select a mode</option>
			<option value="0">Unique civs</option>
			<option value="1">Allow duplicates</option>
		</select>
		<input type="submit" name="randomMode" value="Set">
	</form>';

if(isset($_POST['randomMode']) && isset($_POST['mode']))
{
	$_SESSION['mode'] = $_POST['mode'];
	$_SESSION['randomMode'] = '';
}

if(isset($_SESSION['mode']))
{
	$randomMode = array('Unique civs only', 'Duplicate civs allowed');
	echo 'Mode: ', $randomMode[$_SESSION['mode']], '<br/>';
}

echo '</p></div>';

echo '<div class="content">
		<p class="title">Results</p>
		<p class="text">';

if(isset($_SESSION['randomMode']))
{

	if($_SESSION['mode'] == 0)
	{
		$civs = randUniCiv();
	}
	elseif($_SESSION['mode'] == 1)
	{
		$civs = randDupCiv();
	}

	echo '<a href="/?randGame=true">Reroll</a><br/><br/>';

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

	echo '</p></div>';
}

?>