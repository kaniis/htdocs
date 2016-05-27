<!DOCTYPE html>
	<head><title>Sign In!</title></head>
	<body>
		<br />
		<form action="login.php" method="post">
			Name: <br />
			<input type="text" name="name"><br /><br />
			Password: <br />
			<input type="text" name="pass"><br /><br />
			<br />
			<input type="submit" value="Log In" name="submit">
		</form>

<?php
	
if (isset($_POST['submit'])) 
{
	if(strlen($_POST['name']) == 0 || strlen($_POST['pass']) == 0)
	{
		echo 'Please fill in both fields';
	}
	else 
	{
		
		$user = [$_POST['name'], $_POST['pass']];
 
		echo '<br />' . 'Welcome ' . $user[0] . ' your password is ' . $user[1] . '<br />';
		

		require '../classes/mysql.php';
		$mysql = new database();
		$mysql->connectDb();
		
		$result = $mysql->fetchRows('users', 'name, pass', 'name' , $user[0]);

		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) 
			{ 
				echo 'name: ' . $row[0] . '<br />' . 'password: ' . $row[1];
			}
		}
		else 
		{
			echo 'Couldnt find the user';
		}
	}

}	

?>

	</body>
</html>