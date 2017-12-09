<?php
/*
Replace Characters on MySQL
Author     Mark Villa
Date 			2017
Website    http://www.markvilla.org
Copyright  2017 Mark Villa.

Simple code that grabs table data and replaces characters depending on the regex parameters.
I needed to replace certain characters  to allow PHP to send JSON data properly.
Just replace the query and the field you need to to search into.
*/
define('DB_SERVER', '');
define('DB_USER', '');
define('DB_PASSWORD', '');
define('DB_NAME', '');
$link = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME) or die('There was a problem connecting to the database.');
$query = "SELECT * FROM vocabulary";
$result = $link->query($query);
$fetchedresult = $result->fetch_all(MYSQLI_ASSOC);
for ($i = 0; $i < count($fetchedresult); $i++) {
	if (!preg_match('/^[a-zA-Z0-9 ,;.:\-\[\]\"\(\)\/\?]+$/', $fetchedresult[$i]['definition'])) {
		$before[] = $fetchedresult[$i];
		$fetchedresult[$i]['definition'] = preg_replace("/[^a-zA-Z0-9 ,;.:\-\[\]\"\(\)\/\?]/", ' ',$fetchedresult[$i]['definition']);
		$after[] = $fetchedresult[$i];

	}
}
for ($i = 0; $i < count($after); $i++) {
	$id = $after[$i]['id'];
	$definition = $after[$i]['definition'];
	echo ($id . "	" . $definition . "<br>");
	$query2 = "UPDATE vocabulary SET definition = '$definition' WHERE id = '$id'";
	$result2 = $link->query($query2);
}
$result->close();
$result2->close();
$link->close();
?>
