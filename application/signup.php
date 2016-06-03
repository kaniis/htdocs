<form method="post" action="signup.php">
Username: <input type="text" name="username"/></br>
Password: <input type="password" name="pass1"/></br>
Repeat password: <input type="password" name="pass2"/></br>
<input type="submit" name="signup"/>
</form>

<?php

if(isset($_POST['signup']))
{
	require '../classes/mysql.php';
	database::connectDb();
	require '../classes/user.php';
	$user = new user();
	echo $user->signUp($_POST['username'], $_POST['pass1'], $_POST['pass2']);
}

?>