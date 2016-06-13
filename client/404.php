<?php

if(isset($_SESSION['pageNotFound']))
{
	echo 'This page was not found...<br/>';
	unset($_SESSION['pageNotFound']);
}

if(isset($_SESSION['queryNotFound']))
{
	echo 'No match found...<br/>';
	unset($_SESSION['queryNotFound']);
}

?>