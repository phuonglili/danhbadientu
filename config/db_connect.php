<?php

//connect to the database
$conn = mysqli_connect('localhost','root','','project2');

// check connection
if (!$conn) {
	echo 'Connection error: ' . mysqli_connect_error();
}




// try {
// 	$pdo = new PDO('mysql:host=localhost;port=3306;dbname=example', 'khanh', 'Duykhanh2001');
// 	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
// 	die("Connect Fail");
// 	$e->getMessage();
// }