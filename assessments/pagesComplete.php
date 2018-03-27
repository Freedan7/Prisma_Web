<?php
	require_once dirname(__DIR__).'/urlPath.php';
	require_once dirname(__DIR__).'/RestCurl.php';
	
	$docID = htmlspecialchars( $_GET['docID'] );
    $ptID = htmlspecialchars( $_GET['ptID'] );

	$pagesUrl = $urlPath.'getPageComplete?doctorId='.$docID.'&patientId='.$ptID;
	$pagesComplete = $curl->getData( $pagesUrl );
	$pagesComplete = json_decode( $pagesComplete, true );
	
	if ( $pagesComplete == null ) {
		// Continue
	}
	else if ( $pagesComplete == ( $page - 1 ) ) {
		// Continue
	}
	else {
		switch ( $pagesComplete ) {
			case 0:
				header( 'Location: ../assessments/firstTry.php?ptID='.$ptID.'&docID='.$docID );
				//header( 'Location: tableviewAdmin.php?id='.$docID );
				break;
				
			case 1:
				header( 'Location: ../assessments/modelResults_v3.php?ptID='.$ptID.'&docID='.$docID );
			
				break;
				
			case 2:
				header( 'Location: ../assessments/reviewResults.php?ptID='.$ptID.'&docID='.$docID );

				break;
				
			case 3:
				header( 'Location: ../assessments/recommendations.php?ptID='.$ptID.'&docID='.$docID );
			
				break;
				
			case 4:
				header( 'Location: ../assessments/reviewPatient.php?ptID='.$ptID.'&docID='.$docID );
			
				break;
				
			default:
				header( 'Location: ../assessments/reviewPatient.php?ptID='.$ptID.'&docID='.$docID );
				
				break;
		}
	}
?>