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
			router::redirect('Search');
		}

		foreach($searchIds as $key => $value)
		{
			$result = database::fetchRows('civilization', 'name, leader, id', 'id', $value);
			while($resultRow = $result->fetch_row())
			{
				echo '<div class="content">
						<p class="text">';
							require 'client/404.php';
				echo			'<form method="post" action="' . $_SERVER['REQUEST_URI'] . '">
								<input type="text" name="query" placeholder="Search civ">
								<input type="submit" name="homeSearch" value="Search">
							</form>
							<a href="/Search">Show all</a>
						</p>
					</div>';
				echo '<div class="content">
					<p class="text">';
				echo $resultRow[0], ' - ', $resultRow[1];
				$unique = database::fetchRows('uniques', 'name, description, type', 'civ_id', $resultRow[2]);
				while($uniquesRow = $unique->fetch_row())
				{
					echo '<br/>', $uniquesRow[0],' (', $uniquesRow[2], '):<br/>', $uniquesRow[1];
				}
				echo '</p></div>';
			}
		}

	}
	else
	{
		$_SESSION['queryNotFound'] = true;
		router::redirect('Search');
	}
}
else
{
	echo '<div class="content">
			<p class="text">';
				require 'client/404.php';
	echo			'<form method="post" action="' . $_SERVER['REQUEST_URI'] . '">
					<input type="text" name="query" placeholder="Search civ">
					<input type="submit" name="homeSearch" value="Search">
				</form>
			</p>
		</div>';

	$result = database::fetchRows('civilization', 'name, leader, id');
	while($resultRow = $result->fetch_row())
	{
		echo '<div class="content">
			<p class="text">';
		echo $resultRow[0], ' - ', $resultRow[1];
		$unique = database::fetchRows('uniques', 'name, description, type', 'civ_id', $resultRow[2]);
		while($uniquesRow = $unique->fetch_row())
		{
			echo '<br/>', $uniquesRow[0],' (', $uniquesRow[2], '):<br/>', $uniquesRow[1];
		}
		echo '</p></div>';
	}
}



?>