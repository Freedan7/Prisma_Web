
<!DOCTYPE HTML>
<html>
	<head>
	<?php
		$page = 1;
		
		// If dataValidation received null values, redirect to error page
		/*function error_found () {
		  		$errType = 'nullErr';
				header( 'Location: dataError.php?errType='.htmlspecialchars( $errType ) );
		}
		set_error_handler('error_found');*/
		
		require_once __DIR__.'/pagesComplete.php';
		require_once __DIR__.'/dataValidation.php';
		require_once __DIR__.'/patientDetails.php';
	?>
		
		<meta charset='UTF-8'>
		<title>What do you think?</title>
	    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    	<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    	<script src='https://code.jquery.com/jquery-1.9.1.js'></script>
    	<link href='css/bootstrap.min.css' rel='stylesheet' media='screen'>
    	<link href='css/prismaStyle.css' rel='stylesheet'>
    	<script src='js/bootstrap.min.js'></script>
    	<link href='css/bootstrap-responsive.css' rel='stylesheet' media='screen'>
    	<script src='https://d3js.org/d3.v3.min.js'></script>

			<script>
				var docid = '<?php echo "$docID"?>';
                var patientid = '<?php echo "$ptID"?>';
								
				// When the user clicks anywhere outside of a modal, close it
				window.onclick = function(event) {
				    if ( event.target === document.getElementById( 'modelWindow' ) ) {
				        $( '#modelWindow' ).modal( 'hide' );
				        console.log( 'Clicked Outside' );
				    }
				}
				
				/**
				 * @summary Switches between tabs
				 *
				 * This function determines which tab was clicked on, and uses 
				 * this information to ensure that only the selected tab is visible.
				 *
				 * @listens target: tab clicked.
				 *
				 * @return type none.
				 */
				function switchTabs( tabClicked ) {
					var i;
					
					for ( i = 1; i <= 4; i++ ) {
						if ( i !== tabClicked ) {
							$( document.getElementById( 'tab-content' + i ) ).hide();
						}
					}
					
					$( document.getElementById ( 'tab-content' + tabClicked ) ).show();
				}
				
				/**
				 * @summary Passes data to be sent to server
				 *
				 * This function utilizes an XMLHttpRequest to send data to a
				 * remote server. The data is based on input from an
				 * adjustable pie chart.
				 *
				 * @returns type none.
				 */
				function submit() {
					var xmlhttp = new XMLHttpRequest();
					var dataset = getDataset();
										
					window.location.href = 'Assessment1.php?'
						+ '&docId=' + docid
						+ '&patientId=' + patientid
						+ '&rifle7=' + dataset[0].pred
						+ '&icu=' + dataset[1].pred
						+ '&ventilator=' + dataset[2].pred
						+ '&cardiovascular=' + dataset[3].pred
						+ '&sepsis=' + dataset[4].pred
						+ '&neurological=' + dataset[5].pred
						+ '&venous=' + dataset[6].pred
						+ '&wound=' + dataset[7].pred;
					}
			</script>
		</head>
    <body>
    	<nav class='navbar navbar-default navbar-static-top'>
		  	<div class='container'>
				<div class='navbar-header'>
				</div>
				<h1 id='header' style='text-align: center'>Idealist Platform</h1>
				<br />
		  		</div>
		</nav>
    	
    	<!--Modal for patient details-->
    	<div class='modal fade' id='modelWindow' role='dialog'>
			<div id ='patDetailsModal' class='modal-dialog modal-sm vertical-align-center'>
				<div class='modal-content'>
					<div class='modal-header'>
						<button type='button' class='close' data-dismiss='modal'>&times;</button>
                		<h4 class='modal-title'>Patient Details</h4>
					</div>
					<div id='story-body' class='modal-body'>
						<p>
						<?php echo $patientDetailsTextFull; ?>
						</p>
					</div>
					<div class='modal-footer'>
						<button type='button' data-dismiss='modal' class='btn btn-primary'>Close</button>
					</div>
				</div>
			</div>
		</div>
    	
    	<!--Old Modal for patient details
    	<div class='modal fade' id='modelWindow' role='dialog'>
			<div class='modal-dialog modal-sm vertical-align-center'>
				<div class='modal-content'>
					<div class='modal-header'>
						<button type='button' class='close' data-dismiss='modal'>&times;</button>
                		<h4 class='modal-title'>Patient Details</h4>
					</div>
					<div id='story-body' class='modal-body'>
						<?php
							file_put_contents('story1', $story1);
							file_put_contents('story2', $story2);
						?>
						<div class= 'style12'>
							<p>
								<?php 
									echo $story1;	
								?>
							</p>
			
							<p>
								<?php
									echo $story2;
								?>
							</p>
						</div>
					</div>
					<div class='modal-footer'>
						<button type='button' data-dismiss='modal' class='btn btn-primary'>Close</button>
					</div>
				</div>
			</div>
		</div>
    	-->
    	<div id='envelope' class='container' align='center' >
    		<!--
	        <br />
	        <p class='envelope-text'>
	        	Choose from 0 ('no chance') to 100 ('certainty') the patient's 
	        	risk of developing each complication by adjusting the chart slices below.
	        	<a name='patientDetails' data-toggle='modal' data-target='#modelWindow'>
	        		Click here for patient details.
	        	</a>
	        </p>
	        -->
	        
	        <!-- Old button
	        <br />
	        <button name='patientDetails' class='btn btn-primary' data-toggle='modal'
	        	data-target='#modelWindow'>Click For Patient Details</button> 
	        <br />
			<br />
	        -->
	        <br />
	        <p id='directions' class='envelope-text'>
	        	Choose from 0 ('no chance') to 100 ('certainty') the patient's 
	        	risk of developing each complication by adjusting the chart slices above.
	        	Click on the patient details button for more info.
	        </p>
	        <br />
	        
	        <button class='btn btn-primary' name='patientDetails' data-toggle='modal' data-target='#modelWindow'>PATIENT DETAILS</button>
			<div class='chart-envelope'>
                <div id='chart'></div>
            </div>
                <script src='pieChart.js'></script>
                <script>
                    var js_labels = <?php echo $labels?>;
                    var complicationPerc = [];
                    var i;
                    
                    for (i = 0; i < 8; i++) {
                    	complicationPerc[i] = -1;
                    }
                    
                    console.log(js_labels);
                    generatechart(js_labels, complicationPerc);
                </script>
                <button id='submit-btn' name='submit' class='btn btn-primary' 
                	onclick='submit()'>SUBMIT</button>
                <br />
                <br />
        </div>
		<div class='tTip' style='color: #fff'>
			<div id='tTipLabel'></div>
			<div id='tTipPercent'></div>
		</div>
		<script src='js/chartTooltip.js' type='text/JavaScript'></script>
    </body>
</html>
