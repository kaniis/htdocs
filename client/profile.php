<?php

if($userRow == null)
{
	$_SESSION['pageNotFound'] = '';
	router::redirect('');
}

if(isset($_POST['edit']))
{
	$target = array();
	$changeTo = array();

	if(isset($_POST['favCiv']))
	{
		$target[] = 'fav_civ';
		$changeTo[] = $_POST['favCiv'];
	}

	if(isset($_POST['tag']))
	{
		$target[] = 'tag';
		$changeTo[] = $_POST['tag'];
	}

	database::updateRow('users', $target, $changeTo, 'id', $userRow['id']);
	
	$result = database::fetchRows('users', 'id, admin, name, fav_civ, tag',  'name', $_GET['user']);
	$userRow = $result->fetch_assoc();
}

$userStatus = array('Default user', 'Admin');

if(isset($_GET['edit']) && isset($_SESSION['user']))
{	

	$result = database::fetchRows('users', 'admin', 'name', $_SESSION['user']);
	$currentUserRow = $result->fetch_assoc();
	if(!($_SESSION['user'] == $userRow['name'] || ($currentUserRow['admin'] > 0 && (($userRow['admin'] == 1 && $userRow['name'] == $_SESSION['user']) || ($userRow['admin'] == 0)))))
	{
		router::redirect('u/' . $userRow['name']);
	}

	echo '<form method="post" action="/u/', $userRow['name'], '">';
	echo '<input type="text" name="tag" placeholder="Personal tag" value="', $userRow['tag'],'"><br/>';

}
elseif(isset($_GET['edit']) && !isset($_SESSION['user']))
{
	router::redirect('u/' . $userRow['name']);
}
else
{
	echo ' <em>', $userRow['tag'],'</em><br/>';
}

if($userRow['fav_civ'] != 0 || isset($_GET['edit']))
{
	$favRow = database::idToValue('civilization', 'name', $userRow['fav_civ']);

	if(isset($_GET['edit']))
	{
		echo 'Favourite civ:<select name="favCiv"><option disabled selected>Select a civ</option>';
		$result = database::fetchRows('civilization', 'name');
		$i = 17;

		while($civRow = $result->fetch_row())
		{
			echo '<option value="', $i++,'">', $civRow[0], '</option>';
		}

		echo '</select><br/>';
	}
	else
	{
		echo 'Favourite civ: ' , $favRow[0] . '<br/>';
	}
}

if(isset($_GET['edit']))
{
	echo '<input type="submit" value="Edit" name="edit"></form>';
	echo '<a href="/u/', $userRow['name'],'">cancel</a>';
}
else
{
	echo $userStatus[$userRow['admin']], '<br/>';
	if(isset($_SESSION['user']))
	{
		$result = database::fetchRows('users', 'admin', 'name', $_SESSION['user']);
		$currentUserRow = $result->fetch_assoc();

		if($_SESSION['user'] == $userRow['name'] || ($currentUserRow['admin'] > 0 && (($userRow['admin'] == 1 && $userRow['name'] == $_SESSION['user']) || ($userRow['admin'] == 0))))
		{
			echo '<a href="/u/', $userRow['name'], '/edit">Edit profile</a>';
		}
	}
}

?>