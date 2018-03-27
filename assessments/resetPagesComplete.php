<?php
	require_once dirname(__DIR__).'/urlPath.php';
	require_once dirname(__DIR__).'/RestCurl.php';
	
	$docID = htmlspecialchars( $_GET['docID'] );
    $ptID = htmlspecialchars( $_GET['ptID'] );

	$pagesUrl = $urlPath.'getPageComplete?doctorId='.$docID.'&patientId='.$ptID;
	$pagesComplete = $curl->getData( $pagesUrl );
	$pagesComplete = json_decode( $pagesComplete, true );

	// Print pages complete
	
	echo 'Current pages complete: '.$pagesComplete;
	
	// Reset pages complete to 0
	
	$pagesUrl = $urlPath.'insertPageComplete?doctorId='.$docID.'&patientId='.$ptID.'&pagesComplete=0';
	echo $curl->postData( $pagesUrl );
	
	echo 'Pages complete reset to zero.';
	
	session_start();
		
	if ( $userInfo['registered'] == false ) {
		$errType = 'nullErr';
		header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
	}
			
	if ( $_SESSION["isAdmin"] != true ) {
		header( 'Location: ../landingPages/tableview.php?docID='.$docID );
	}
	else if ( $_SESSION["isAdmin"] == true ) {
		header( 'Location: ../landingPages/tableviewAdmin.php?docID='.$_SESSION["docID"] );
	}
	else {
		$errType = 'nullErr';
		header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
	}
?>