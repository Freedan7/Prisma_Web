<?php
	require_once dirname(__DIR__).'/urlPath.php';
	require_once dirname(__DIR__).'/RestCurl.php';
	
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
	$riskassessment['numAttempts'] = 1;

	$riskassessmentJson1 = json_encode( $riskassessment );
	$url = $urlPath.'initialRiskAssessment';
	echo $curl->postData( $url, $riskassessmentJson1 );
	
	$pagesUrl = $urlPath.'insertPageComplete?doctorId='.$docID.'&patientId='.$ptID.'&pagesComplete=1';
	echo $curl->postData( $pagesUrl );
	
	
	header( 'Location: ../assessments/modelResults_v3.php?ptID='.$ptID.'&docID='.$docID );
?>