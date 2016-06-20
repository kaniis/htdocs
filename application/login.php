<?php

if (isset($_POST['submit'])) 
{
	if(strlen($_POST['name']) == 0 || strlen($_POST['pass']) == 0)
	{
		echo '<p style="display: inline;">Please fill in both fields</p>';
	}
	else 
	{

		$user = [$_POST['name'], $_POST['pass']];
		$result = database::fetchRows('users', 'name, password', 'name' , $user[0]);

		if($result->num_rows > 0)
		{
			$userRow = $result->fetch_assoc();

			$db_name = $userRow['name'];
			$db_pass = $userRow['password'];

			if ($db_pass == $user[1])
			{
				$_SESSION['user'] = $userRow['name'];
				$_SESSION['loggedIn'] = true;
			}
			else
			{
				echo '<br />' . '<p style="display: inline;">Incorrect username or password</p>';
			}

		}
		else 
		{
			echo '<p style="display: inline;">Incorrect username or password</p>';
		}
	}
}

if(isset($_GET['logOut']))
{
	unset($_SESSION['loggedIn']);
	unset($_SESSION['user']);
	router::redirect($_SESSION['lastPage']);
}
elseif(isset($_SESSION['loggedIn']))
{
	$_SESSION['lastPage'] = trim($_SERVER['REQUEST_URI'], '/');
	echo '<a href="/?logOut=true">Log out</a>';
}

else
{
	echo '	<form style="display: inline;" action="' . $_SERVER['REQUEST_URI'] . '" method="post">
			<input type="text" name="name" placeholder="Username">
			<input type="password" name="pass" placeholder="Password">
			<input type="submit" value="Log In" name="submit">
		</form>';
}

?>

	</body>
</html>