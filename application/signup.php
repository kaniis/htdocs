<form method="post" action="signup.php">
Username: <input type="text" name="username"/></br>
Password: <input type="password" name="pass1"/></br>
Repeat password: <input type="password" name="pass2"/></br>
<input type="submit" name="signup"/>
</form>

<?php

if(isset($_POST['signup']))
{
	$error = 0;
	require '../classes/mysql.php';
	$mysql = new database();
	$mysql->connectDb();
	$userRows = $mysql->fetchRows('users', 'id', 'name', $_POST['username']);
	if($userRows->num_rows !== 0)
	{
		$error = 1;
		echo 'This username has already been taken.';
	}

	if($_POST['pass1'] !== $_POST['pass2'] && $error !== 1)
	{
		$error = 1;
		echo 'The passwords do not match.';
	}

	if((strlen($_POST['username']) < 4 || strlen($_POST['username']) > 32) && $error !== 1)
	{
		$error = 1;
		echo 'Your username is either too short or too long. It has to consist of 4-32 characters.';
	}

	if((strlen($_POST['pass1']) < 4 || strlen($_POST['pass1']) > 32) && $error !== 1)
	{
		$error = 1;
		echo 'This is not a valid password (too short or too long).';
	}

	if(!preg_match('/[a-zA-Z0-9-_]*/', $_POST['username']) && $error !== 1)
	{
		$error = 1;
		echo 'This username contains forbidden characters. Please stick to alphanumerics, hyphens, and underscores.';
	}
	elseif($error !== 1)
	{
		$user['name'] = $_POST['username'];
		$user['password'] = $_POST['pass1'];
		$mysql->addRow('users', $user);
	}
	else
	{
		echo '<br/>Account could not be created.';
	}

}

?>