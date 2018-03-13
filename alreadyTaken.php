<?php
	// Get doctor ID
	/* $docID = isset( htmlspecialchars( $_GET['docid'] ) )
	? htmlspecialchars( $_GET['docid'] ) 
	: htmlspecialchars( $_GET['user'] );
	// Get patient ID */
	
	require_once __DIR__.'/urlPath.php';
	require_once __DIR__.'/RestCurl.php';
	
	$docID = htmlspecialchars( $_GET['docid'] );
    $ptID = htmlspecialchars( $_GET['ptID'] );

	$pagesUrl = $urlPath.'getPageComplete?doctorId='.$docID.'&patientId='.$ptID;
	$pagesComplete = $curl->getData( $pagesUrl );
	$pagesComplete = json_decode( $pagesComplete, true );
	//$pagesComplete = json_encode( $pagesComplete );
	
	if ( $pagesComplete == null ) {
		echo 'docID = '.$docID;
		echo 'ptID = '.$ptID;
		echo 'NULL';
	}
	else if ( $pagesComplete == ( $page - 1 ) ) {
		// Continue
	}
	else {
		switch ( $page ) {
			case 0:
				header( 'Location: firstTry.php?ptID='.$ptID.'&docid='.$docID );
				//header( 'Location: tableviewAdmin.php?id='.$docID );
				break;
				
			case 1:
				header( 'Location: modelResults_v3.php?ptID='.$ptID.'&user='.$docID );
			
				break;
				
			case 2:
				header( 'Location: reviewResults.php?ptID='.$ptID.'&user='.$docID );
			
				break;
				
			case 3:
				header( 'Location: recommendations.php?ptID='.$ptID.'&user='.$docID );
			
				break;
				
			case 4:
				header( 'Location: reviewPatient.php?ptID='.$ptID.'&docid='.$docID );
			
				break;
				
			default:
				header( 'Location: reviewPatient.php?ptID='.$ptID.'&docid='.$docID );
				
				break;
		}
	}
?>