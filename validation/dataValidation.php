<?php
	session_start();
	
	if ( isset( $_SESSION["docID"])) {
		if ( $_SESSION["isAdmin"] == true ) {
			// Continue
		}
		else if ( $_SESSION["docID"] != htmlspecialchars( $_GET['docID'] ) ) {
			header( 'Location: index.html' );
		}
	}
	else {
		header( 'Location: index.html' );
	}

	require_once dirname(__DIR__).'/urlPath.php';
	require_once dirname(__DIR__).'/RestCurl.php';
	
	switch ( $page ) {
		// If user logged in as an Admin
		case 11:
			$docID = htmlspecialchars( $_GET['docID'] );
			
			$url = $urlPath.'patientsAdmin?doctorId='.$docID;
			$patient_detail = $curl->getData($url);
			$patient_detail1 = json_decode($patient_detail,true);
						
			if ( $patient_detail1 === null ) {
				$errType = 'nullErr';
				header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
				break;
			}
			else {
				//continue
			}
			
			$url2 = $urlPath."getUserRole?doctorId=".$docID;
			$userInfo = $curl->getData($url2);
			$userInfo = json_decode( $userInfo, true );
			
			$docName = $userInfo['name'];
			
			break;
			
		// List of patients
		case 0:			
			ini_set('max_execution_time', 300);
			$docID = htmlspecialchars( $_GET['docID'] );
			
			$url = $urlPath.'patients?doctorId='.$docID;
			$patient_detail = $curl->getData($url);
			$patient_detail1 = json_decode($patient_detail,true);
						
			if ( $patient_detail1 === null ) {
				$errType = 'nullErr';
				header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
				break;
			}
			else {
				//continue
			}
			
			$url2 = $urlPath."getUserRole?doctorId=".$docID;
			$userInfo = $curl->getData($url2);
			$userInfo = json_decode( $userInfo, true );
			
			$docName = $userInfo['name'];
						
			break;
			
	// Initial Risk Assessment
		case 1:
			ini_set('max_execution_time', 300);
        	$docID = htmlspecialchars( $_GET['docID'] );
        	$ptID = htmlspecialchars( $_GET['ptID'] );
			
        	$url = $urlPath.'patientDetails?doctorId='.$docID.'&patientId='.$ptID;
        	
			$patient_details = $curl->getData($url);
			$patient_details1 = json_decode($patient_details,true);
			
			if ( $patient_details1 === null ) {
				$errType = 'nullErr';
				header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
				break;
			}
			else {
				// continue
			}

			$story1 =$patient_details1['story1'];
			$story2 =$patient_details1['story2'];
			$docName=$patient_details1['doctorName'];
			
			$labels=$patient_details1['labels'];
			$labels = json_encode($labels);
			
			break;
		
	// Computer Algorithm Scores
		case 2:
			$ptID = htmlspecialchars( $_GET['ptID'] );
			$docID = htmlspecialchars( $_GET['docID'] );
			$i = 0;
						
			$url = $urlPath.'patientPrediction?doctorId='.$docID.'&patientId='.$ptID;
			$patient_details = $curl->getData($url);
			$patient_details = json_decode($patient_details,true);
			
			if ( $patient_details === null ) {
				$errType = 'nullErr';
				header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
				break;
			}
			else {
				//continue
			}
			
			$patient_details_encoded = json_encode($patient_details);					
			
			$url2 = $urlPath.'mortality?patientId='.$ptID;
			$mortality_risk = $curl->getData($url2);
			$mortality_risk = json_decode($mortality_risk,true);
			
			if ( $mortality_risk === null ) {
				$errType = 'nullErr';
				header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
				break;
			}
			else {
				//continue
			}
			
			$mortality_risk = $mortality_risk['mort_status_30d'];
			
			/*for ($i = 0; $i < 4; $i++) {
				echo string implode ($mortality_risk[$i]);
			}*/
			
			for ( $i = 0; $i < 8; $i++ ) {
				if ( ($patient_details[$i]['riskScore'] * 100) < 0 ) {
					$errType = 'rangeErr';
					header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
					break;
				}
				else if ( ($patient_details[$i]['riskScore'] * 100) > 100 ) {
					$errType = 'rangeErr';
					header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
					break;
				}
				else if ( $patient_details[$i]['riskScore'] == null ) {
					$errType = 'nullErr';
					header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
					break;
				}
			}
			
			break;
			
	// Final Risk Assessment
		case 3:
			ini_set('max_execution_time', 300);
			$ptID = htmlspecialchars( $_GET['ptID'] );
			$docID = htmlspecialchars( $_GET['docID'] );
			$i = 0;
		
		// Patient Details
            $url = $urlPath.'patientDetails?doctorId='.$docID.'&patientId='.$ptID;
            $patient_details = $curl->getData($url);
            $patient_details1 = json_decode($patient_details,true);
            
            if ( $patient_details1 === null ) {
				$errType = 'nullErr';
				header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
				break;
			}
			else {
				//continue
			}
            
            $story1 =$patient_details1['story1'];
            $story2 =$patient_details1['story2'];
            $docName=$patient_details1['doctorName'];
            
            $labels = $patient_details1['labels'];
            $labels = json_encode($labels);
            $net_decisions=count($patient_details1['labels']);
            
        // Patient Prediction
            $url2 = $urlPath.'patientPrediction?doctorId='.$docID.'&patientId='
            	.$ptID;
            
            
			$risk_details = $curl->getData($url2);
            $risk_details = json_decode($risk_details,true);
            
            if ( $risk_details === null ) {
            	$errType = 'nullErr';
				header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
				break;
            }
            else {
            	//continue
            }
            
        // Previous percentages from first risk assessment
			$url3 = $urlPath.'getRiskAssessment?doctorId='.$docID
            	.'&patientId='.$ptID.'&riskAssessmentType=1';
            
            $prev_percentages = $curl->getData($url3);
            $prev_percentages = json_decode($prev_percentages,true);
            
            if ( $prev_percentages === null ) {
            	$errType = 'nullErr';
				header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
				break;
            }
            else {
            	if ( $prev_percentages[0]['rifle7'] > 100 
            	  || $prev_percentages[0]['rifle7'] < 0) {
            		$errType = 'rangeErr';
					header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
					break;
            	}
            	else if ( $prev_percentages[0]['icu'] > 100 
            		   || $prev_percentages[0]['icu'] < 0) {
            		$errType = 'rangeErr';
					header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
					break;
            	}
            	else if ( $prev_percentages[0]['ventilator'] > 100 
            		   || $prev_percentages[0]['ventilator'] < 0) {
            		$errType = 'rangeErr';
					header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
					break;
            	}
            	else if ( $prev_percentages[0]['cardiovascular'] > 100 
            		   || $prev_percentages[0]['cardiovascular'] < 0) {
            		$errType = 'rangeErr';
					header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
					break;
            	}
            	else if ( $prev_percentages[0]['sepsis'] > 100 
            		   || $prev_percentages[0]['sepsis'] < 0) {
            		$errType = 'rangeErr';
					header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
					break;
            	}
            	else if ( $prev_percentages[0]['neurological'] > 100 
            		   || $prev_percentages[0]['neurological'] < 0) {
            		$errType = 'rangeErr';
					header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
					break;
            	}
            	else if ( $prev_percentages[0]['venous'] > 100 
            		   || $prev_percentages[0]['venous'] < 0) {
            		$errType = 'rangeErr';
					header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
					break;
            	}
            	else if ( $prev_percentages[0]['wound'] > 100 
            		   || $prev_percentages[0]['wound'] < 0) {
            		$errType = 'rangeErr';
					header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
					break;
            	}
            	else {
            		//continue
            	}
            }
            
            $prev_percentages = json_encode($prev_percentages);
            
        // Previous percentages and number of attempts from second assessment
            $url4 = $urlPath.'getRiskAssessment?doctorId='.$docID
            	.'&patientId='.$ptID.'&riskAssessmentType=2';
            
            $new_percentages = $curl->getData($url4);
            $new_percentages = json_decode($new_percentages,true);
            
            if ( $new_percentages === null ) {
            	$errType = 'nullErr';
				header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
				break;
            }
            else {
            	//continue
            }
        
        //Get mortality risk
        $url5 = $urlPath.'mortality?patientId='.$ptID;
			$mortality_risk = $curl->getData($url5);
			$mortality_risk = json_decode($mortality_risk,true);
			
			if ( $mortality_risk === null ) {
				$errType = 'nullErr';
				header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
				break;
			}
			else {
				//continue
			}
			
			$mortality_risk = $mortality_risk['mort_status_30d'];
        
        // Set the number of attempts
            if ( isset( $new_percentages['0'] ) ) {
            	$num_attempts = $new_percentages['0']['numAttempts'];
            	$num_attempts++;
            }
            else {
            	$num_attempts = 1;
            }
            
            break;
        
    // For recommendations
        case 4:
        	ini_set('max_execution_time', 300);
			$ptID = htmlspecialchars( $_GET['ptID'] );
			$user = htmlspecialchars( $_GET['docID'] );
			
			break;
	
	// For Last Screen
		case 5:
			$docID = htmlspecialchars( $_GET['docID'] );
			
			break;
	
	//For Patient Review
		case 6:
			ini_set('max_execution_time', 300);
        	$docID = htmlspecialchars( $_GET['docID'] );
        	$ptID = htmlspecialchars( $_GET['ptID'] );
			
        	$url = $urlPath.'patientDetails?doctorId='.$docID.'&patientId='.$ptID;
        	
			$patient_details = $curl->getData($url);
			$patient_details1 = json_decode($patient_details,true);
			
			if ( $patient_details1 === null ) {
				$errType = 'nullErr';
				header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
				break;
			}
			else {
				// continue
			}

			$docName=$patient_details1['doctorName'];
			
			$labels=$patient_details1['labels'];
			$labels = json_encode($labels);
			
			// Previous percentages from first risk assessment
			$initial_percentages_url = $urlPath.'getRiskAssessment?doctorId='.$docID
    		 	.'&patientId='.$ptID.'&riskAssessmentType=1';
    		 
    		 $initial_percentages = $curl->getData($initial_percentages_url);
    		 $initial_percentages = json_decode($initial_percentages,true);
    		 
    		 if ( $initial_percentages === null ) {
    		 	$errType = 'nullErr';
				header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
				break;
    		 }
    		 else {
    		 	if ( $initial_percentages[0]['rifle7'] > 100 
    		 	  || $initial_percentages[0]['rifle7'] < 0) {
    		 		$errType = 'rangeErr';
					header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
					break;
    		 	}
    		 	else if ( $initial_percentages[0]['icu'] > 100 
    		 		   || $initial_percentages[0]['icu'] < 0) {
    		 		$errType = 'rangeErr';
					header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
					break;
    		 	}
    		 	else if ( $initial_percentages[0]['ventilator'] > 100 
    		 		   || $initial_percentages[0]['ventilator'] < 0) {
    		 		$errType = 'rangeErr';
					header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
					break;
    		 	}
    		 	else if ( $initial_percentages[0]['cardiovascular'] > 100 
    		 		   || $initial_percentages[0]['cardiovascular'] < 0) {
    		 		$errType = 'rangeErr';
					header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
					break;
    		 	}
    		 	else if ( $initial_percentages[0]['sepsis'] > 100 
    		 		   || $initial_percentages[0]['sepsis'] < 0) {
    		 		$errType = 'rangeErr';
					header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
					break;
    		 	}
    		 	else if ( $initial_percentages[0]['neurological'] > 100 
    		 		   || $initial_percentages[0]['neurological'] < 0) {
    		 		$errType = 'rangeErr';
					header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
					break;
    		 	}
    		 	else if ( $initial_percentages[0]['venous'] > 100 
    		 		   || $initial_percentages[0]['venous'] < 0) {
    		 		$errType = 'rangeErr';
					header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
					break;
    		 	}
    		 	else if ( $initial_percentages[0]['wound'] > 100 
    		 		   || $initial_percentages[0]['wound'] < 0) {
    		 		$errType = 'rangeErr';
					header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
					break;
    		 	}
    		 	else {
    		 		//continue
    		 	}
    		 }
    		        
    		 $initial_percentages = json_encode($initial_percentages);
    		 
		// Percentages from final risk assessment
			$final_percentages_url = $urlPath.'getRiskAssessment?doctorId='.$docID
		     	.'&patientId='.$ptID.'&riskAssessmentType=2';
		     
		     $final_percentages = $curl->getData($final_percentages_url);
		     $final_percentages = json_decode($final_percentages,true);
		     
		     if ( $final_percentages === null ) {
		     	$errType = 'nullErr';
				header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
				break;
		     }
		     else {
		     	if ( $final_percentages[0]['rifle7'] > 100 
		     	  || $final_percentages[0]['rifle7'] < 0) {
		     		$errType = 'rangeErr';
					header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
					break;
		     	}
		     	else if ( $final_percentages[0]['icu'] > 100 
		     		   || $final_percentages[0]['icu'] < 0) {
		     		$errType = 'rangeErr';
					header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
					break;
		     	}
		     	else if ( $final_percentages[0]['ventilator'] > 100 
		     		   || $final_percentages[0]['ventilator'] < 0) {
		     		$errType = 'rangeErr';
					header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
					break;
		     	}
		     	else if ( $final_percentages[0]['cardiovascular'] > 100 
		     		   || $final_percentages[0]['cardiovascular'] < 0) {
		     		$errType = 'rangeErr';
					header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
					break;
		     	}
		     	else if ( $final_percentages[0]['sepsis'] > 100 
		     		   || $final_percentages[0]['sepsis'] < 0) {
		     		$errType = 'rangeErr';
					header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
					break;
		     	}
		     	else if ( $final_percentages[0]['neurological'] > 100 
		     		   || $final_percentages[0]['neurological'] < 0) {
		     		$errType = 'rangeErr';
					header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
					break;
		     	}
		     	else if ( $final_percentages[0]['venous'] > 100 
		     		   || $final_percentages[0]['venous'] < 0) {
		     		$errType = 'rangeErr';
					header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
					break;
		     	}
		     	else if ( $final_percentages[0]['wound'] > 100 
		     		   || $final_percentages[0]['wound'] < 0) {
		     		$errType = 'rangeErr';
					header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
					break;
		     	}
		     	else {
		     		//continue
		     	}
		     }
		            
		     $final_percentages = json_encode($final_percentages);
			
			//For computer predictions
			$url2 = $urlPath.'patientPrediction?doctorId='.$docID.'&patientId='.$ptID;
			$patient_details = $curl->getData($url2);
			$patient_details2 = json_decode($patient_details,true);
			
			if ( $patient_details2 === null ) {
				$errType = 'nullErr';
				header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
				break;
			}
			else {
				//continue
			}
			
			for ( $i = 0; $i < 8; $i++ ) {
				if ( ($patient_details2[$i]['riskScore'] * 100) < 0 ) {
					$errType = 'rangeErr';
					header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
					break;
				}
				else if ( ($patient_details2[$i]['riskScore'] * 100) > 100 ) {
					$errType = 'rangeErr';
					header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
					break;
				}
			}
			
			$url3 = $urlPath.'mortality?patientId='.$ptID;
			$mortality_risk = $curl->getData($url3);
			$mortality_risk = json_decode($mortality_risk,true);
			
			if ( $mortality_risk === null ) {
				$errType = 'nullErr';
				header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
				break;
			}
			else {
				//continue
			}
			
			$mortality_risk = $mortality_risk['mort_status_30d'];
			
			break;
			
	// Go to error page if no cases are met
		default:
			header( 'Location: dataError.php?errType=default' );
			
			break;
	}
?>