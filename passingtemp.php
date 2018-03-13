<?php	
require_once __DIR__.'/urlPath.php';
require_once __DIR__.'/RestCurl.php';

$ans='professor farnsworth;farns;farns;Male;30 years or less;Attending Doctor;Surgery;40;0;0;0;1 in 10;10%;0;0;0;0;0;0;07/13/2013;';
$ans=substr($ans, 0, -1);
$array = explode(';', $ans);
//echo $ans; 
$i=0;
$username=$array[1];


$doctor = array();

$doctor['username']=$username;
//$array[11] = preg_replace("/[^0-9]/", "", $array[11] );
$doctor['questions']=array();

for ($i = 0; $i < 20; $i++) {
	print_r($array[$i]);
	print_r('<br />');
}

for ($i=8; $i < 18 ; $i++) { 
	$doctor['questions'][$i]=$array[$i];
}
$doctor['password']        = $array[2];
$doctor['gender']          = $array[3];
$doctor['age']             = $array[4];
$doctor['currentRoles']    = $array[5];
$doctor['speciality']      = $array[6];
$doctor['experience'] 	   = $array[7];
$doctor['fullName']	   	   = $array[0];
$doctor['registerDate']	   = $array[19];


if ( validate_input ($array,
					 $doctor['username'],
					 $doctor['fullName'], 
					 $doctor['experience']) != 1 ) {

	$errType = 'formErr';
	header( 'Location: dataError.php?errType='.htmlspecialchars( $errType ) );
}
else {
	$doctorJson = json_encode($doctor);
	
	$url = $urlPath."insertDoctorTestResults";
	echo $curl->postData($url, $doctorJson);
}

function validate_input (array $numbers, $username, $fullName, $experience) {
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
    	
    	for ($i=8; $i < 18 ; $i++) { 
			if ($i == 11 || $i == 12) {
				continue;
			}
			else if (!preg_match("/^[0-9]*$/", $numbers[$i])) {
    		$intErr = "Invalid integer format";
    		$isValid = 0;
    		}
		}
    	
    	return $isValid;
	}
	
	function console_log( $data ){
	  echo '<script>';
	  echo 'console.log('. json_encode( $data ) .')';
	  echo '</script>';
	}
	
?>