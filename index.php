<?php

session_start();

require 'classes/mysql.php';
database::connectDb();

if(isset($_GET['logOut']))
{
	unset($_SESSION['loggedIn']);
	unset($_SESSION['user']);
	require 'classes/router.php';
	router::redirect('');
}

require 'client/404.php';

?>

<form method="post" action="/">
	<input type="text" name="query" placeholder="Search civ">
	<input type="submit" name="homeSearch" value="Search">
</form>

<?php

if(isset($_POST['homeSearch']))
{
	if(strlen($_POST['query']) > 2)
	{
		$condition = array('name', 'leader', 'culture');
		$result = database::searchRows('civilization', 'id', $condition, $_POST['query']);
		$searchIds = array();
		while($resultRow = $result->fetch_row())
		{
			$searchIds[] = $resultRow['0'];
		}

		$result = database::searchRows('uniques', 'civ_id', 'name', $_POST['query']);
		while($resultRow = $result->fetch_row())
		{
			$searchIds[] = $resultRow['0'];
		}

		$searchIds = array_unique($searchIds);
		if($searchIds[0] == '')
		{
			$_SESSION['queryNotFound'] = true;
			require 'classes/router.php';
			router::redirect('');
		}

		foreach($searchIds as $key => $value)
		{
			$result = database::fetchRows('civilization', 'name, leader, id', 'id', $value);
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
		}

		echo '<a href="/">Show all</a>';
	}
	else
	{
		$_SESSION['queryNotFound'] = true;
		require 'classes/router.php';
		router::redirect('');
	}
}
else
{
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
}

?>