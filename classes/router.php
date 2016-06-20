<?php

class router{

	public static function redirect($url)
	{
		header('location: /' . $url);
		exit();
	}

	public static function createUserUrl($userName)
	{
		$url = '';

		if(strpos($_SERVER['REQUEST_URI'], '/u/') !== false)
		{
			$url = $url;
		}
		else
		{
			$url .= '/u/';
		}

		$url =  $url . $userName;
		return $url;
	}

}

?>