<?php
	$ptID=$_GET['id'];
	
	require_once __DIR__.'/urlPath.php';
	require_once __DIR__.'/RestCurl.php';

	$url2 = $urlPath.'patientDetailsRaw?patientId='.$ptID;
	$patientDetailsRaw = $curl->getData($url2);
	$patientDetailsRaw = json_decode($patientDetailsRaw,true);
	$patientDetailsRaw = json_encode($patientDetailsRaw);
	
	echo $patientDetailsRaw;
?>