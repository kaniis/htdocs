<?php

session_start();

require '../classes/mysql.php';
require '../classes/router.php';

database::connectDb();
$result = database::fetchRows('users', 'name, fav_civ, tag',  'name', $_GET['user']);
$userRow = $result->fetch_row();

if($userRow == null)
{
	$_SESSION['notFound'] = '';
	router::redirect('');
}

if(isset($_POST['edit']))
{
	$target = array('name', 'place');
	$changeTo = array('John', 'Mongolia');
	database::updateRow('users', $target, $changeTo, 'id', 5);
}

if(isset($_GET['edit']))
{
	echo '<form method="post" action="/u/', $userRow[0] ,'">';
}

if($userRow[1] != 0)
{
	$favRow = database::idToValue('civilization', 'name', $userRow[1]);
	if($favRow != null)
	{
		if(file_exists('../images/' . $favRow[0] .'.jpg'))
		{
			echo '<img src="/images/'.$favRow[0].'.jpg"></img><br/>';
		}
		elseif(file_exists('../images/' . $favRow[0].'.png'))
		{
			echo '<img src="/images/'.$favRow[0].'.png"></img><br/>';
		}

		if(isset($_GET['edit']))
		{
			echo 'Favourite civ:<select name="FavCiv">';
			$result = database::fetchRows('civilization', 'name');
			$i = 1;

			while($civRow = $result->fetch_row())
			{
				
				echo '<option name="', $i++,'">', $civRow[0], '</option>';
			}

			echo '</select><br/>';
		}
		else
		{
			echo 'Favourite civ: ' , $favRow[0] . '<br/>';
		}
	}
}

echo $userRow[0],' <em>', $userRow[2],'</em><br/>';

if(isset($_GET['edit']))
{
	echo '<input type="submit" value="Edit" name="edit"></form>';
	echo '<a href="/u/', $userRow[0],'">cancel</a>';
}
else
{
	echo '<a href="/u/', $userRow[0], '/edit">Edit profile</a>';
}

?>