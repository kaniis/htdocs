<form method="post" action="signup.php">
Username: <input type="text" name="username"/></br>
E-mail: <input type="email" name="mail"/></br>
Password: <input type="password" name="pass1"/></br>
Repeat password: <input type="password" name="pass2"/></br>
<input type="submit" name="signup"/>
</form>

<?php

if(isset($_POST['signup']))
{
	require '../classes/mysql.php';
	$mysql = new database();
	$mysql->connectDb();
	$userRows = $mysql->fetchRows('users', 'id', 'name', $_POST['username']);
	if($userRows->num_rows === 0)
	{
		echo 'not taken';
	}

}

?>