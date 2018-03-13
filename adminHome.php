
<!DOCTYPE HTML>
<html>
	<head>
		<?php
		$page = 0;
		
		require_once __DIR__.'/dataValidation.php';
		?>
		
		<title>Admin Home</title>
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	    <script src="https://code.jquery.com/jquery.js"></script>
	    <script src="js/bootstrap.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
		<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		<!-- <link rel="stylesheet" href="/resources/demos/style.css" /> -->
		<link rel="stylesheet" href="css/prismaStyle.css" />

		
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
	        			<h4>Welcome, Dr. <?php echo $docName ?>. Please 
	        			indicate which doctor's risk scores you would like
	        			to view.</font></h4>
	        		<br />
	        		<p>Search Doctors: <input type='text'></input></p>
	        		<a>Advanced Search</a>
	        		<br />
	        		</div>
	        		<br>
	        		<div id='here_table' align='center'> 
						
						<table style='width: 50%'>
	        
							<tr style='background-color: #0f1e3e; text-align: center;'>
	        				<th ><p style='font-size: 16pt'>Doctor</p></th>
	        				</tr>

	        			<?php
	        				$go_to_page = '';
	        				$user = '';
					  		$i = 0;
					  							  		
							for($i=0;$i<count($patient_detail1);$i++){
									//echo "i is:".$i;

								$PtID  =  $patient_detail1[$i]['patientId'];
								$story =  $patient_detail1[$i]['story1'];
								$go_to_page = 'tableviewReview.php';
								$user = 'docid';
								/*
								$url2 = $urlPath."getRiskAssessment?doctorId=".$docID
        							."&patientId=".$PtID."&riskAssessmentType=1";
        						
        						$prev_percentages = $curl->getData($url2);
        						$prev_percentages = json_decode($prev_percentages,true);
								
								if ( isset( $prev_percentages['0'] ) ) {
									if ($prev_percentages['0']['numAttempts'] > 0) {
										$go_to_page = "modelResults_v3.php";
										$user = 'user';
									}
									else {
										$go_to_page = 'firstTry.php';
										$user = 'docid';
									}
								}*/
																
								if ($i%2 == 0) {
									echo '<tr style="background-color: #081021;">';
								}
								else {
									echo '<tr style="background-color: #0f1e3e;">';
								}
								
								if ($i%2 == 0) {
									echo '<td id="patDesc"><label id="des'
										.$i.'"><a href='.$go_to_page.'?id='.'5923>'
										.'Dr. Rajend'.'</a></label></td>';
								}
								else {
									echo '<td id="patDesc"><label id="des'
										.$i.'"><a href='.$go_to_page.'?id='.'raj>'
										.'Dr. Rajendra'.'</a></label></td>';
								}
								
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