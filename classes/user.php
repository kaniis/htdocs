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

		if(strlen($username) < 4 || strlen($username) > 32)
		{
			return 'Your username is either too short or too long. It has to consist of 4-32 characters.';
		}

		if(strlen($pass) < 4 || strlen($pass) > 32)
		{
			return 'This is not a valid password (too short or too long).';
		}

		$userRows = database::fetchRows('users', 'id', 'name', $username);
		if($userRows->num_rows === 1)
		{
			return 'This username has already been taken.';
		}

		else
		{
			$user['name'] = $username;
			$user['password'] = $pass;
			database::addRow('users', $user);
			require 'router.php';
			router::redirect('index.php');
		}
	}

}

?>