<?php

if(isset($_GET['user']))
{
	$result = database::fetchRows('users', 'id, admin, name, fav_civ, tag',  'name', $_GET['user']);
	$userRow = $result->fetch_assoc();

	echo '<div class="content">
		<p class="title">', $userRow['name'], '</p>
		<p class="text">';
	require 'client/profile.php';
	echo '</p></div>';
}
elseif(isset($_GET['signUp']))
{
	echo '<div class="content">
		<p class="title">Sign up</p>
		<p class="text">';
	require 'application/signup.php';
	echo '</p></div>';
}
elseif(isset($_GET['search']))
{
	require 'application/search.php';
}
elseif(isset($_GET['randGame']))
{
	require 'application/randomgame.php';
}
elseif(isset($_GET['admin']))
{
	require 'application/admin.php';
}
elseif(isset($_GET['sexiness']))
{
	echo '<div class="content">
			<p class="title">Welcome to heaven</p>
			<p class="text">Myfi yw Buddug, Brenhines y Celtiaid. Peidied neb â\'m tanbrisio i!</p>
			<div class="image"><img src="images/extras/boudicca.jpg"></div>
	</div>';
}
else
{
	require 'application/frontpage.php';
}

?>