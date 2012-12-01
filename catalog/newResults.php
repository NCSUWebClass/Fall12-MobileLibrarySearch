<?php
	session_start();
	$request = $_GET['request'];
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $request);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_USERAGENT, "NCSU Libraries Mobilib2 Test");
	$response = curl_exec($ch);
	curl_close($ch);
	$_SESSION['response'] = $response;
	//echo "<h1>NEWRESULTS.PHP......</h1>";
	header("Location: results.php");

?>