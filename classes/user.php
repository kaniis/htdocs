<?php

class user{

	public function signUP($username, $pass, $passControl)
	{
		if($pass !== $passControl)
		{
			return 'The passwords do not match.';
		}

		if(!ctype_alnum(str_replace(array('-', '_'), '', $username)))
		{
			return 'This username contains forbidden characters. Please stick to alphanumerics, hyphens, and underscores.';
		}

		if(strlen(trim($username)) < 4 || strlen(trim($username)) > 32)
		{
			return 'Your username is either too short or too long. It has to consist of 4-32 characters.';
		}

		if(strlen(trim($pass)) < 4 || strlen(trim($pass)) > 32)
		{
			return 'This is not a valid password (too short or too long).';
		}

		$userRows = database::fetchRows('users', 'id', 'name', $username);

		if($userRows->num_rows != 1)
		{
			$user['name'] = trim($username);
			$user['password'] = trim($pass);
			database::addRow('users', $user);
			$_SESSION['user'] = $username;
			$_SESSION['loggedIn'] = true;
			router::redirect('u/' . $username);
		}
		else
		{
			return 'This username has already been taken.';
		}
	}

}

?>