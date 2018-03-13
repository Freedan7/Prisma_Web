<?php
	require_once __DIR__.'/urlPath.php';
	require_once __DIR__.'/RestCurl.php';
	
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
		header( 'Location: dataError.php?errType='.htmlspecialchars( $errType ) );
	}
			
	if ( $_SESSION["isAdmin"] != true ) {
		header( 'Location: tableview.php?id='.$docID );
	}
	else if ( $_SESSION["isAdmin"] == true ) {
		header( 'Location: tableviewAdmin.php?id='.$_SESSION["adminID"] );
	}
	else {
		$errType = 'nullErr';
		header( 'Location: dataError.php?errType='.htmlspecialchars( $errType ) );
	}
?>