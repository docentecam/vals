<?php
	function connect()
	{
		$connexio=@mysqli_connect("localhost","root","","ddb99266");
		if (!$connexio)
		{	die("Error al conectar");	}
		mysqli_set_charset($connexio, "utf8");
		mysqli_query($connexio,"SET lc_time_names = 'ca_ES'");
		return($connexio);
	}
	function disconnect($connexio)
	{ mysqli_close($connexio);}
	function close()
	{	session_destroy();}

	function replaceFromHtml($jsonArray)
 {
 	$normalChars = str_replace(array("'",'"',"\\n"), array("\'",'\"',"\r\n"),$jsonArray);
 	return $normalChars;
 }
 function replaceFromBBDD($jsonArray)
 {
 	$normalChars = htmlspecialchars($jsonArray);
 	$normalChars = str_replace(array('&quot;', '&amp;', '&lt;', '&gt;'), array('"', "&", "<", ">"), $normalChars);
 	$normalChars = str_replace(array('"'), array('\"'), $normalChars);
 	$normalChars = str_replace(array("\r\n", "\r", "\n"),"\\n" ,$normalChars);
 	return $normalChars;
 }
?>