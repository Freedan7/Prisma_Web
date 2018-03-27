
<!DOCTYPE HTML>
<html>
	<head>
	<?php
		$page = 0;
		
		// If dataValidation received null values, redirect to error page
		function error_found () {
		  		$errType = 'nullErr';
				header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
		}
		set_error_handler('error_found');
		
		require_once dirname(__DIR__).'/validation/dataValidation.php';
	?>
		
		<title>Patient List</title>
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	    <script src="https://code.jquery.com/jquery.js"></script>
	    <script src="../js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
		<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		<link rel="stylesheet" href="../css/prismaStyle.css" />
		
		<style> 
			{
				width: 65%;
				background-image: linear-gradient(to right, #00FF00 0%,#FFFF00 25%,#FFA500 75%, #FF0000 100%);
				margin: 0 auto;
			}
			
			#bar
			{
				width:80%;
				padding:5px;
				padding-top:2px;
				text-align:center; 
			}
			
			#submit{
				color: #ffffff;
				background-color: #0044cc;
			}
			
			a {
				color: #d0d5d9;
			}
			
			a:hover, a:focus {
				red;
			}
			
			table {
				color: #d0d5d9;
				font-size: 16pt;
				border-color: #d0d5d9;
    			border-style: solid;
    			border-width: 2px;
				outline-color: black;
				padding:10px;
				padding-bottom: 20px;
				width: 90%;
			}
			
			th,
			td {
				color: #d0d5d9;
				font-size: 20pt;
				border-color: #d0d5d9;
    			border-style : solid;
    			border-width: 2px;
				outline-color: black;
				padding:10px;
				padding-bottom: 20px;
			}
			
			@media only screen and (max-width: 960px) {
				table {
					width: 95%;
				}
				th {
					font-size: 16pt;
				}
			}
			
		</style>
		<script type='text/javascript'>
        $('document').ready(function() {
            // $("body").append("<p>The page just loaded!</p>");
            $('#here_table').on('click',function(evt){



            });
        });
    </script>


	</head>
    <body>
    	<nav class='navbar navbar-default navbar-static-top'>
		  	<div class='container'>
				<div class='navbar-header'>
				</div>
				<h1 id='header' style='text-align: center'>Idealist Platform</h1>
				<br>
		  		</div>
		</nav>
    	
    	<br />
    	<div id='envelope' class=container align='center' >
    				<br>
	        		<div id = 'patientlist'>
	        			<h4>Dr. <?php echo $docName ?>, you will be operating on the following patients today: </font></h4>
	        		</div>
	        		<br>
	        		<div id='here_table' align='center'> 
						
						<table>
	        
							<tr style='background-color: #0f1e3e; text-align: center;'>
	        				<th ><p style='font-size: 16pt'>Patient</p></th>
	        				<th ><p style='font-size: 16pt'>Description</p></th>
	        				</tr>

	        			<?php
	        				$go_to_page = '../assessments/firstTry.php';
	        				$user = 'docID';
	        				$patientName = 'Missing';
					  		$i = 0;
					  							  		
							for($i=0;$i<count($patient_detail1);$i++){
								$ptID  =  $patient_detail1[$i]['patientId'];
								$patientAge = round($patient_detail1[$i]['featureValueMap']['age'], 0);
								$patientSex = strtolower($patient_detail1[$i]['featureValueMap']['sex']);
								$patientRace = strtolower($patient_detail1[$i]['featureValueMap']['race']);
								$cci = $patient_detail1[$i]['featureValueMap']['cci'];
								
								// Age missing?
								if ( $patientAge == 'missing' ) {
									$patientAge = 'unknown age';
								}
								
								// If race = other, adjust text accordingly.
								if ( $patientRace == 'Other' ) {
									$patientRace = '';
									$patientSex = $patientSex.' of Other race';
								}
								else if  ( $patientRace == 'missing' ) {
									$patientRace = '';
									$patientSex = $patientSex.' of unknown race';
								}
								
								if ($patient_detail1[$i]['patientName'] != '') {
									$patientName  =  $patient_detail1[$i]['patientName'];
								}
								else {
									$patientName  =  $patient_detail1[$i]['patientId'];
								}
								
								$ptID  =  $patient_detail1[$i]['patientId'];

								$story =  'Your patient is a(n) '.$patientAge.' year old '.$patientRace
											.' '.$patientSex.' with a Charlson comorbidity'
											.' index of '.$cci.'.';
																
								if ($i%2 == 0) {
									echo '<tr style="background-color: #081021;">';
								}
								else {
									echo '<tr style="background-color: #0f1e3e;">';
								}
						
								echo '<td width="20%" id="patIDs"><label id="ID'
									.$i.'"><a href='.$go_to_page.'?ptID='.$ptID.'&'.$user.'='.$docID.'>'
									.$patientName.'</a></label></td>';							
								echo '<td width="80%" id="patDesc"><label id="des'
									.$i.'"><a href='.$go_to_page.'?ptID='.$ptID.'&'.$user.'='.$docID.'>'
									.$story.'</a></label></td>';
								//$i +=1;
								echo "</tr>";
							}
						?>
						</table>
				<!-- More Patients
						<br />
						<button class='btn btn-primary'>MORE PATIENTS</button>
						<br />
						<br />
						<table>
							<tr style='background-color: #0f1e3e; text-align: center;'>
	        				<th ><p style='font-size: 16pt'>Patient IDs</p></th>
	        				<th ><p style='font-size: 16pt'>Description</p></th>
	        				</tr>
						</table>
				-->
	        		</div>
	         <br />
	    </div>
	    <br />
	    </body>