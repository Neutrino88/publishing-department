<?php
    // Подключение к бд
	$connection = mysqli_connect('localhost', 'root', '');
	$select_db = mysqli_select_db($connection, 'publishing_db');
?>