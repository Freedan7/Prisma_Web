<?php
	
	require_once __DIR__.'/RestCurl.php';
	
	$urlPath = "http://localhost:8081/PrismaRestWS/rest/WebService/";
	$docID=5923;
    $ptID=826;

	$url = $urlPath.'patientDetails?doctorId='.$docID.'&patientId='.$ptID;
        	
	$patient_details = $curl->getData($url);
	$patient_details1 = json_decode($patient_details,true);	
	
	echo("Database debugging file");
	echo($patient_details1);
?>