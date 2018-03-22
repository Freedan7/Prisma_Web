<?php
	include 'urlPath.php';
	include 'RestCurl.php';

	//$con=mysqli_connect("10.227.80.158","root","","medical");
	
	if(isset($_GET['attempt1'])){
		// Check connection
		$username=$_GET['docID'];
		$ptID=$_GET['id'];
		$outcomes=json_decode($_GET['docPredict']);
		$time=$_GET['time'];
        $i=1;
        $outcomeResultArr = array();
        foreach ($outcome as $outcomes) {
            $outcomeResultArr[$i-1]['username']= $username;
            $outcomeResultArr[$i-1]['patientId']= $ptID;
            $outcomeResultArr[$i-1]['outcomeId']= $i;
            $outcomeResultArr[$i-1]['attempt1']= $outcome;
            $outcomeResultArr[$i-1]['attempt2']= null;
            $i=$i+1;
        }
        $outcomeResult1 = json_encode($outcomeResultArr);
        $url = $urlPath."insertOutcomeResult";
        echo $curl->postData($url,$outcomeResult1);
        header( 'Location: modelResults_v3.php?ptID='.$ptID.'&docID='.$username);

	}
	else if(isset($_GET['attempt2'])){
        // Check connection
        $username=$_GET['docID'];
        $ptID=$_GET['id'];
        $attempts=$_GET['docPredict'];
        $time=$_GET['time'];
        $i=1;
        $outcomeResultArr = array();
        foreach ($outcome as $outcomes) {
            $outcomeResultArr[$i-1]['username']= $username;
            $outcomeResultArr[$i-1]['patientId']= $ptID;
            $outcomeResultArr[$i-1]['outcomeId']= $i;
            $outcomeResultArr[$i-1]['attempt1']= null;
            $outcomeResultArr[$i-1]['attempt2']= $outcome;
            $i=$i+1;
        }
        $outcomeResult1 = json_encode($outcomeResultArr);
        $url = $urlPath."insertOutcomeResult";
        echo $curl->postData($url,$outcomeResult1);
//        header( 'Location: LastScreen.php?id='.$username.'&scrnID=2');
        header( 'Location: recommendations.php?ptID='.$ptID.'&docID='.$username);
    }
	else if(isset($_GET['submit'])) {
		$docID = $_GET['docID'];
		$ptID = $_GET['ptID'];
	
	    $payload = json_decode($_GET['payload']);
        $url = $urlPath."insertOutcomeRank";
        echo $curl->postData($url, $_GET['payload']);
        
		$pagesUrl = $urlPath.'insertPageComplete?doctorId='.$docID.'&patientId='.$ptID.'&pagesComplete=2';
		echo $curl->postData( $pagesUrl );
        
        header( 'Location: reviewResults.php?ptID='.$ptID.'&docID='.$docID );

    }else if(isset($_GET['feedback'])){
		$username=$_GET['docID'];
		$ptID=$_GET['id'];
		$outcome=$_GET['outcome'];
		$time=$_GET['time'];
		$features=$_GET['features'];
		$noReview=$_GET['noReview'];
		file_put_contents("screen1_".$outcome, $features.";".$time.";".$noReview);
		header( 'Location: reviewResults.php?ptID='.$ptID.'&docID='.$username.'&outcome='.$outcome );
	
	}
	else if(isset($_GET['recoNeg'])){
			$ptID=$_GET['id'];
			$docID=$_GET['docID'];
						
			$recoNegArr = array();
			$recoNegArr['username']= $docID;
			$recoNegArr['patientId']= $ptID;
			$recoNegArr['reco']= 'no';
			$recoNegArrJson = json_encode($recoNegArr);
			$url = $urlPath."insertRecoTakenTable";
			echo $curl->postData($url, $recoNegArrJson);

			//mysqli_query($con,"insert into recoTakenTable values('".$ptID."','".$username."','no')");
			$time=$_GET['time'];			

			$outcomestats = array();
			$outcomestats['username']= $docID;
			$outcomestats['patientId']= $ptID;
			$outcomestats['outcomeId']= -1;
			$outcomestats['timeScreen1']= $time;
			$outcomestats['timeScreen2']= -1;
			$outcomestats['click1']= -1;
			$outcomestats['click2']= -1;
			$outcomestatsJson = json_encode($outcomestats);
			$url = $urlPath."insertOutcomeStats";
			echo $curl->postData($url, $outcomestatsJson);

			//mysqli_query($con,"insert into outcomeStats values('".$username."','".$ptID."',-1,".$time.",-1,-1,-1)");

			$url = $urlPath."noOfAttempt?user=".$docID;
			$noOfAttempt1 = $curl->getData($url);
			$noOfAttempt1 = json_decode($noOfAttempt1,true);
			$noOfAttempt=intval($noOfAttempt1);

			$pagesUrl = $urlPath.'insertPageComplete?doctorId='.$docID.'&patientId='.$ptID.'&pagesComplete=4';
			echo $curl->postData( $pagesUrl );
			
	        header( 'Location: LastScreen.php?docID='.$docID.'&scrnID=2');
	}
	else if(isset($_GET['recoPos'])){
			$ptID=$_GET['id'];
			$docID=$_GET['docID'];
			$i = 1;
			
			// Get and store data from first 
			$recoPosArr = array();
			$recoPosArr['username']= $docID;
			$recoPosArr['patientId']= $ptID;
			$recoPosArr['reco']= 'yes';
			$recoPosArrJson = json_encode($recoPosArr);
			$url = $urlPath."insertRecoTakenTable";
			echo $curl->postData($url, $recoPosArrJson);
			
			// Get and store doctor interventions
			$recoTemp=$_GET['recos'];
			$recos=substr($recoTemp, 0, -1);
			$recos=explode(";", $recos);
			
			$docInterventions = array();
			
			$docInterventions['docId'] = $docID;
			$docInterventions['patientId'] = $ptID;
			$docInterventions['reco1'] = $recos[0];
			$docInterventions['reco2'] = $recos[1];
			$docInterventions['reco3'] = $recos[2];
			$docInterventions['reco4'] = $recos[3];
			$docInterventions['reco5'] = $recos[4];
			$docInterventions['reco6'] = $recos[5];
			$docInterventions['reco7'] = $recos[6];
			$docInterventions['reco8'] = $recos[7];
			$docInterventions['reco9'] = $recos[8];
			$docInterventions['reco10'] = $recos[9];
			$docInterventions['reco11'] = $recos[10];
			$docInterventions['recoOther'] = $recos[11];
			
			$interventionsJson = json_encode($docInterventions);
			print_r($interventionsJson);
			
			$url = $urlPath."docInterventions";
			echo $curl->postData($url, $interventionsJson);
			
			// Get and store doctor mitigations
			$caseTemp=$_GET['cases'];
			$time=$_GET['time'];
			$cases=substr($caseTemp, 0, -1);
			$cases=explode(";", $cases);
			
			$docMitigations = array();
			
			$docMitigations['docId'] = $docID;
			$docMitigations[ 'patientId' ] = $ptID;
			$docMitigations[ 'mitigation1' ] = $cases[0];
			$docMitigations[ 'mitigation2' ] = $cases[1];
			$docMitigations[ 'mitigation3' ] = $cases[2];
			$docMitigations[ 'mitigation4' ] = $cases[3];
			$docMitigations[ 'mitigation5' ] = $cases[4];
			$docMitigations[ 'mitigation6' ] = $cases[5];
			$docMitigations[ 'mitigation7' ] = $cases[6];
			$docMitigations[ 'mitigation8' ] = $cases[7];
			
			$mitigationsJson = json_encode($docMitigations);
			print_r($mitigationsJson);
			
			$url = $urlPath."docMitigations";
			echo $curl->postData($url, $mitigationsJson);
			
			$pagesUrl = $urlPath.'insertPageComplete?doctorId='.$docID.'&patientId='.$ptID.'&pagesComplete=4';
			echo $curl->postData( $pagesUrl );
			
			header( 'Location: LastScreen.php?docID='.$docID.'&scrnID=2');
	}
	else if(isset($_GET['continue'])){
		$docID = htmlspecialchars( $_GET['docID'] );
		
		$url = $urlPath."getUserRole?doctorId=".$docID;
		$userInfo = $curl->getData($url);
		$userInfo = json_decode( $userInfo, true );
		
		session_start();
		
		if ( $userInfo['registered'] == false ) {
			$errType = 'nullErr';
			header( 'Location: dataError.php?errType='.htmlspecialchars( $errType ) );
		}
				
		if ( $_SESSION["isAdmin"] != true ) {
			header( 'Location: tableview.php?docID='.$docID );
		}
		else if ( $_SESSION["isAdmin"] == true ) {
			header( 'Location: tableviewAdmin.php?docID='.$_SESSION["docID"] );
		}
		else {
			$errType = 'nullErr';
			header( 'Location: dataError.php?errType='.htmlspecialchars( $errType ) );
		}
	}
	else {
		
		$username=$_GET['docID'];
		$ptID=$_GET['id'];
		$outcome=$_GET['outcome'];
		$time=$_GET['time'];
		$attempt2=$_GET['attempt'];
		$noReview=$_GET['noReview'];
		$outcome_next=$outcome+1;

		$url = $urlPath."reviewResults?outcomeID=".$outcome_next;
		$getoutcome = $curl->getData($url);
		$getoutcome = json_decode($getoutcome,true);
		$outcomeHold=$getoutcome['outcome'];

		file_put_contents("screen2_".$outcome, $attempt2.";".$time.";".$noReview);
		if($outcomeHold==""){
			
			$string=file_get_contents("firstTry");
			$firstArr=explode(";", $string);

			$url = $urlPath."noOfAttempt?user=".$username;
			$noOfAttempt1 = $curl->getData($url);
			$noOfAttempt1 = json_decode($noOfAttempt1,true);
			$noOfAttempt=intval($noOfAttempt1)+1;

			//$result = mysqli_query($con,"select count(attempt) attempt from indexPatient where user='".$username."'");
			//$row=mysqli_fetch_array($result);
			//$noOfAttempt=$row['attempt'];
			//$noOfAttempt=$noOfAttempt+1;
			//echo "insert into indexPatient values('".$username."','".$ptID."',".$noOfAttempt.",".$firstArr[1].")";
			$idxPatient = array();
			$idxPatient['user']= $username;
			$idxPatient['patientId']= $ptID;
			$idxPatient['noAttempt']= $noOfAttempt;
			$idxPatient['timeScreen']= $firstArr[1];
			$idxPatient1 = json_encode($idxPatient);
			//print_r($doctorJson);
			$url = $urlPath."insertIndexPatient";
			echo $curl->postData($url, $idxPatient1);

			//mysqli_query($con,"insert into indexPatient values('".$username."','".$ptID."',".$noOfAttempt.",".$firstArr[1].")");
			$firstAttempts=explode(",", $firstArr[0]);
			for ($i=1; $i <= $outcome ; $i++) { 
				$screen1String=file_get_contents("screen1_".$i);
				$screen2String=file_get_contents("screen2_".$i);
				
				$screen1Arr=explode(";", $screen1String);
				$screen2Arr=explode(";", $screen2String);
				$features=substr($screen1Arr[0], 0, -1);
				$featureArr=explode(":", $features);
				
				$outcomeRank1 = array();
				$j=1;
				foreach ($featureArr as $feature) {
					if($featureArr!=""){
						$outcomeRank1[$j-1]['user']= $username;
						$outcomeRank1[$j-1]['patientId']= $ptID;
						$outcomeRank1[$j-1]['outcomeId']= $i;
						$outcomeRank1[$j-1]['feature']= $feature;
						$j=$j+1;
					}
				}

				$outcomeRank2 = json_encode($outcomeRank1);
				$url = $urlPath."insertOutcomeRank";
				echo $curl->postData($url, $outcomeRank2);
				
				$j=1;
				$outcomeResultArr[$j-1]['username']= $username;
				$outcomeResultArr[$j-1]['patientId']= $ptID;
				$outcomeResultArr[$j-1]['outcomeId']= $i;
				$outcomeResultArr[$j-1]['attempt1']= $firstAttempts[$i-1];
				$outcomeResultArr[$j-1]['attempt2']= $screen2Arr[0];
				$outcomeResult1 = json_encode($outcomeResultArr);
				$url = $urlPath."insertOutcomeResult";
				echo $curl->postData($url, $outcomeResult1);

				//mysqli_query($con,"insert into outcomeResult values('".$username."','".$ptID."',".$i.",".$firstAttempts[$i-1].",".$screen2Arr[0].")");

				$outcomestats1 = array();
				$outcomestats1['username']= $username;
				$outcomestats1['patientId']= $ptID;
				$outcomestats1['outcomeId']= $i;
				$outcomestats1['timeScreen1']= $screen1Arr[1];
				$outcomestats1['timeScreen2']= $screen2Arr[1];
				$outcomestats1['click1']= $screen1Arr[2];
				$outcomestats1['click2']= $screen1Arr[2];
				$outcomestatsJson1 = json_encode($outcomestats1);
				$url = $urlPath."insertOutcomeStats";
				echo $curl->postData($url, $outcomestatsJson1);
				//mysqli_query($con,"insert into outcomeStats values('".$username."','".$ptID."',".$i.",".$screen1Arr[1].",".$screen2Arr[1].",".$screen1Arr[2].",".$screen2Arr[2].")");	
				
				unlink("screen1_".$i);
				unlink("screen2_".$i);
			}

			$url = $urlPath."deleteidList";
			echo $curl->deleteData($url, $ptID);
			
			//mysqli_query($con,"delete from idList where id='".$ptID."'");
			unlink("firstTry");
			unlink("story1");
			unlink("story2");
			// echo("bishal");
			header( 'Location: recommendations.php?ptID='.$ptID.'&docID='.$username);
			
		}else{
			//echo $outcome_next;
			header( 'Location: modelResults_v2.php?ptID='.$ptID.'&docID='.$username.'&outcome='.$outcome_next );
		}
	}
	
	// header('location: login.php')
	// mysqli_close($con);
?>