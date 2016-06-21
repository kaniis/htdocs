<?php

echo	'<form method="post" action="', $_SERVER['REQUEST_URI'], '">
		<input id="form" type="text" name="username" placeholder="Username"></br>
		<input id="form" type="password" name="pass1" placeholder="Password"></br>
		<input id="form" type="password" name="pass2" placeholder="Repeat password"></br>
		<input id="form" type="submit" name="signup"/>
	</form>';

if(isset($_POST['signup']))
{
	require 'classes/user.php';
	$user = new user();
	echo $user->signUp($_POST['username'], $_POST['pass1'], $_POST['pass2']);
}

?>