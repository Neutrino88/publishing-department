<?php
	session_start();
	session_destroy();
	
	$redirect_time = 1;
	echo "<SCRIPT> window.setTimeout(\"document.location = '../login/';\", $redirect_time); </SCRIPT>";
?>