<?php
	
	include 'urlPath.php';
	include 'RestCurl.php';	

	if(isset($_POST['login'])){
			$username=$_POST['id'];
			$password=$_POST['pass'];
			
			$url = $urlPath."login?user=".$username."&password=".$password;
			$loginInfo = $curl->getData($url);
			$loginInfo = json_decode( $loginInfo, true );
			
			if ( $loginInfo['id'] == null ) {
				echo 'Username or password does not match our records';
			}
			else if ( $loginInfo['role'] != 'Administrator' ) {
				echo 10;
				
				// Start a session, set admin to "False"
				session_start();
				$_SESSION["docID"] = $username;
				$_SESSION["isAdmin"] = false;
			}
			else if ( $loginInfo['role'] == 'Administrator' ) {
				echo 11;
				
				// Start a session, set admin to "True"
				session_start();
				$_SESSION["docID"] = $username;
				$_SESSION["isAdmin"] = true;
			}
			else {
				echo 'Username or password does not match our records';
			}
		
	}else if(isset($_POST['usercheck'])){

		$username=$_POST['id'];
		$url = $urlPath."userCheck?user=".$username;
		echo $curl->getData($url);
		
	}
	else if(isset($_POST['answers'])){
		$ans=$_POST['res'];
		$ans=substr($ans, 0, -1);
		$array = explode(';', $ans);

		$i=0;
		$username=$array[1];		

		$doctor = array();
		
		$doctor['username']=$username;
		$doctor['questions']=array();
		
		for ($i=8; $i < 19 ; $i++) { 
			$doctor['questions'][$i - 8]=$array[$i];
		}
		$doctor['password']        = $array[2];
		$doctor['gender']          = $array[3];
		$doctor['age']             = $array[4];
		$doctor['currentRoles']    = $array[5];
		$doctor['speciality']      = $array[6];
		$doctor['experience'] 	   = $array[7];
		$doctor['fullName']	   	   = $array[0];
		$doctor['registerDate']	   = $array[19];
		
		if ( validate_input ($doctor['username'],
							 $doctor['fullName'], 
							 $doctor['experience']) != 1 ) {

			$errType = 'formErr';
			header( 'Location: dataError.php?errType='.htmlspecialchars( $errType ) );
		}
		else {
			$doctorJson = json_encode($doctor);
			print_r($doctorJson);
			
			$url = $urlPath."insertDoctorTestResults";
			echo $curl->postData($url, $doctorJson);
		}
		
		$doctorJson = json_encode($doctor);
		print_r($doctorJson);
			
		$url = $urlPath."insertDoctorTestResults";
		echo $curl->postData($url, $doctorJson);
	}
	else if(isset($_POST['dataset'])){
		$dataset = $_POST['dataset'];
		echo $dataset;
	}
	
	function validate_input ($username, $fullName, $experience) {
		$isValid = 1;
		
		// Check username syntax
		if (!preg_match("/^[a-zA-Z0-9 ]+$/",$username)) {
    		$fullNameErr = "Invalid username format";
    		$isValid = 0;
    	}
		
    	// Check full name syntax
    	if (!preg_match("/^[a-zA-Z ]+$/",$fullName)) {
    		$fullNameErr = "Invalid name format";
    		$isValid = 0;
    	}
    	
    	// Check experience syntax
    	if (!preg_match("/^([0-9]{1,2}){1}/", $experience)) {
    		$expErr = "Invalid experience format";
    		$isValid = 0;
    	}
    	
    	return $isValid;
	}
?>
