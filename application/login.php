<!DOCTYPE html>
	<head><title>Sign In!</title></head>
	<body>

<?php

session_start();

if (isset($_POST['submit'])) 
{
	if(strlen($_POST['name']) == 0 || strlen($_POST['pass']) == 0)
	{
		echo 'Please fill in both fields';
	}
	else 
	{

		$user = [$_POST['name'], $_POST['pass']];

		require '../classes/mysql.php';

		database::connectDb();
		$result = database::fetchRows('users', 'name, password', 'name' , $user[0]);

		if($result->num_rows > 0)
		{
			$userRow = $result->fetch_assoc();

			echo 'name: ' . $userRow['name'] . '<br />' . 'password: ' . $userRow['password'];
			$db_name = $userRow['name'];
			$db_pass = $userRow['password'];

			if ($db_pass == $user[1])
			{
				echo '<br />' . 'You are now logged in!<br/>';
				$_SESSION['user'] = $userRow['name'];
				$_SESSION['loggedIn'] = true;
			}
			else
			{
				echo '<br />' . 'Your username or password is incorrect';
			}

		}
		else 
		{
			echo 'Couldn\'t find the user';
		}
	}
}

if(isset($_SESSION['loggedIn']))
{
	echo '<a href="/?logOut=true">Log out</a>';
}
else
{
	echo '	<form action="login.php" method="post">
			Name: <br />
			<input type="text" name="name"><br /><br />
			Password: <br />
			<input type="text" name="pass"><br /><br />
			<br />
			<input type="submit" value="Log In" name="submit">
		</form>';
}

?>

	</body>
</html>