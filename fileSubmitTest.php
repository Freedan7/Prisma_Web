<?php
	require_once __DIR__.'/RestCurl.php';
	
	$urlPath = "http://localhost:8081/PrismaRestWS/rest/WebService/";
	
	$targetFile = $_FILES["fileToUpload"]["name"];
	
	$url = $urlPath.'insertDoctorAgreement';
	
	echo $curl->postData($url,$targetFile);
?>