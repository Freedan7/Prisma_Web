<?php
	include 'urlPath.php';
	include 'RestCurl.php';
	
	$docID = $_GET['docId'];
	$ptID = $_GET['patientId'];
	$rifle7 = $_GET['rifle7'];
	$icu = $_GET['icu'];
	$ventilator = $_GET['ventilator'];
	$cardiovascular = $_GET['cardiovascular'];
	$sepsis = $_GET['sepsis'];
	$neurological = $_GET['neurological'];
	$venous = $_GET['venous'];
	$wound = $_GET['wound'];
	$numAttempts = $_GET['numAttempts'];

	// Input values
	$riskassessment = array();
	$riskassessment['docId'] = $docID;
	$riskassessment['patientId'] = $ptID;
	$riskassessment['rifle7'] = $rifle7;
	$riskassessment['icu'] = $icu;
	$riskassessment['ventilator'] = $ventilator;
	$riskassessment['cardiovascular'] = $cardiovascular;
	$riskassessment['sepsis'] = $sepsis;
	$riskassessment['neurological'] = $neurological;
	$riskassessment['venous'] = $venous;
	$riskassessment['wound'] = $wound;
	$riskassessment['numAttempts'] = $numAttempts;

	$riskassessmentJson1 = json_encode($riskassessment);
	$url = $urlPath."finalRiskAssessment";
	echo $curl->postData($url, $riskassessmentJson1);
	
	$pagesUrl = $urlPath.'insertPageComplete?doctorId='.$docID.'&patientId='.$ptID.'&pagesComplete=3';
	echo $curl->postData( $pagesUrl );
	
	header( 'Location: recommendations.php?ptID='.$ptID.'&docID='.$docID );
?>