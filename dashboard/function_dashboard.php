<?php

function clear_variable_post_get($link,$namevariablel)
{
	$namevariablel = mysqli_real_escape_string($link,$namevariablel);
	//echo "<br>namevariablel = ".$namevariablel;
	$namevariablel = addslashes($namevariablel);
	//echo "<br>namevariablel = ".$namevariablel;
	$namevariablel=strip_tags($namevariablel);

	$return = $namevariablel;
	//echo "<br>return = ".$return;
	return $return;
}


?>