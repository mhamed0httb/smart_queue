<?php 

	define('HOST','localhost');
	define('USER','root');
	define('PASS','root');
	define('DB','smart_queue');
	
	$con = mysqli_connect(HOST,USER,PASS,DB) or die('unable to connect to db');

	?>