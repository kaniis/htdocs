<?php

class router{

	public static function redirect($url){
		header('location: /' . $url);
		exit();
	}

}

?>