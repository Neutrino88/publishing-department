<?php 
	session_start();
    $redirect_time = 0;

    // ЕСЛИ НЕТ СЕССИИ, ТО ПЕРЕНАПРАВЛЯЕМ НА login.php
	if (! isset($_SESSION['userId'])) 
  		echo "<SCRIPT> window.setTimeout(\"document.location = '../login/';\", $redirect_time); </SCRIPT>";
?>