<?php

if(isset($_SESSION['notFound']))
{
	echo 'This page was not found...<br/>';
	unset($_SESSION['notFound']);
}

?>