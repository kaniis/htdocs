<?php

require 'classes/mysql.php';
require 'classes/elements.php';
require 'classes/router.php';
database::connectDb();
session_start();

?>

<! DOCTYPE html>
<html>

	<head>

		<title>Main Page</title>

		<link rel="stylesheet" type="text/css" href="/style/main.css" />

		<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500' rel='stylesheet' type='text/css'>
	</head>

	<body>

		<div id="info">
			<ul>
				<li style="float: right">
					<?php
						require 'application/login.php';
					?>
				</li>
				<li style="float: left">
					<?php
						if(isset($_SESSION['loggedIn']))
						{
							$url = router::createUserUrl($_SESSION['user']);
							echo '<a href="', $url ,'">', $_SESSION['user'], '</a>';
						}
						else
						{
							echo '<a href="/SignUp">Sign up!</a>';
						}
					?>
				</li>
			</ul>
		</div>
		<div id="picture">
			<img src="/images/extras/civvscreen.jpg" />
		</div>
		<div id="menu">
			<div style="position: fixed; bottom: 3px; width: 180px">
				<p style=" font-size: 10px; text-align: center;">Made by: Kaan Akbaba & Rens Kievit</p>
			</div>
			<ul>
				<li><a href="/">Main Page</a></li>
				<li><a href="/Search">Search</a></li>
				<li><a href="/RandomGame">Random Game</a></li>
				<li><a href="/AdminPanel">Administrator</a></li>
			</ul>
		</div>
		<div id="main">
			<?php
				require 'core.php';
			?>
		</div>

		<?php

		if(isset($_SESSION['loggedIn']))
		{
			echo elements::userButton($_SESSION['user']);
		}

		?>
		
	</body>

</html>