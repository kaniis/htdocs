<?php

echo	'<form method="post" action="', $_SERVER['REQUEST_URI'], '">
		<input type="text" name="username" placeholder="Username"></br>
		<input type="password" name="pass1" placeholder="Password"></br>
		<input type="password" name="pass2" placeholder="Repeat password"></br>
		<input type="submit" name="signup"/>
	</form>';

if(isset($_POST['signup']))
{
	require 'classes/user.php';
	$user = new user();
	echo $user->signUp($_POST['username'], $_POST['pass1'], $_POST['pass2']);
}

?>