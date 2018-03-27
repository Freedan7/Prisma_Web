<!DOCTYPE HTML>
<html>
	<?php
		$page = 3;
		
		// If dataValidation received null values, redirect to error page
		function error_found () {
		  		$errType = 'nullErr';
				header( 'Location: ../validation/dataError.php?errType='.htmlspecialchars( $errType ) );
		}
		set_error_handler('error_found');
		
		require_once dirname(__DIR__).'/assessments/pagesComplete.php';
		require_once dirname(__DIR__).'/validation/dataValidation.php';
		require_once dirname(__DIR__).'/assessments/patientDetails.php';
	?>
	
	<head>
		<meta charset='UTF-8'>
		<title>Let's Review</title>
		<meta name='viewport' content='width=device-width, initial-scale=1.0'>
    	<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    	<script src='https://code.jquery.com/jquery-1.9.1.js'></script>
    	<link href='../css/bootstrap.min.css' rel='stylesheet' media='screen'>
    	<link href='../css/prismaStyle.css' rel='stylesheet'>
    	<script src='../js/bootstrap.min.js'></script>
    	<link href='../css/bootstrap-responsive.css' rel='stylesheet' media='screen'>
    	<script src='https://d3js.org/d3.v3.min.js'></script>
		
		<script>			
			var risk_details = <?php echo json_encode($risk_details)?>;
			var startTimeScrn=0;
			var endTimeScrn=0
			var noReview=0;
			$(function() {
				startTimeScrn=Date.now();
			});
		    
		    var mortRisk = '<?php echo "$mortality_risk"?>';
            var docid = '<?php echo "$docID"?>';
            var patientid = '<?php echo "$ptID"?>';
			
			// When the user clicks anywhere outside of a modal, close it
			window.onclick = function(event) {
			    if ( event.target === document.getElementById( 'storyBoard' ) ) {
			        $( '#storyBoard' ).modal( 'hide' );
			        console.log( 'Clicked Outside' );
			    }
			    else if ( event.target === document.getElementById( 'modelWindow' ) ) {
			        $( '#modelWindow' ).modal( 'hide' );
			        console.log( 'Clicked Outside' );
			    }
			    else if ( event.target === document.getElementById( 'lastChance' ) ) {
			        $( '#lastChance' ).modal( 'hide' );
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
			 * This function takes the user to the page Assessment2.php, which 
			 * populates a database with data. The data is based on input from 
			 * an adjustable pie chart.
			 *
			 * @returns type none.
			 */
			function submit() {
					var dataset = getDataset();
					var numAttempts = <?php echo $num_attempts ?>;
										
					window.location.href = '../submission/Assessment2.php?'
						+ '&docId=' + docid
						+ '&patientId=' + patientid
						+ '&rifle7=' + dataset[0].pred
						+ '&icu=' + dataset[1].pred
						+ '&ventilator=' + dataset[2].pred
						+ '&cardiovascular=' + dataset[3].pred
						+ '&sepsis=' + dataset[4].pred
						+ '&neurological=' + dataset[5].pred
						+ '&venous=' + dataset[6].pred
						+ '&wound=' + dataset[7].pred
						+ '&numAttempts=' + numAttempts;
						
						console.log('Results submitted');
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
		
		<!-- Additional Scores Modal -->
		<div class='modal fade' id='lastChance' role='dialog'>
			<div class='modal-dialog modal-sm vertical-align-center'>
				<div class='modal-content'>
					<div class='modal-header'>
						<button type='button' class='close' data-dismiss='modal'>&times;</button>
		            	<h4>Are You Sure?</h4>
					</div>
					<div id='story-body' class='modal-body'>
						<div id='error'class='alert alert-error'>
							<label id='errorLabel'>Once this assessment is submitted, 
							you will no longer be able to retake it. Are you sure you
							wish to proceed?</label>
						</div>
					
						<table align='center' style='width: 20%;'>
							<tr>
								<td style='padding-right: 25px;'>
									<button class='btn btn-primary' onclick='submit()'>YES</button>
								</td>
								<td align='right' style='padding-left: 25px;'>
									<button type='button' data-dismiss='modal' class='btn btn-primary'>NO</button>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
		
		<!--Modal for patient details-->
    	<div class='modal fade' id='storyBoard' role='dialog'>
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
    	
        <div id='envelope' class='container' align='center'>
            <div id='reviewResults'align='center'>
            	<!--<p class='envelope-text'>
            		<br />
            	 	After reviewing the computer algorithm's calculated risk scores
            	 	 please reevaluate your initial risk assessment by adjusting the 
            	 	 chart slices below.
            	 	<a id='story' data-toggle='modal' data-target='#storyBoard'>
	        			Click here for patient details.
	        		</a>
	        		<br />
            	</p>-->
            	
            	<!-- Old Button
                <br />
                <br />
                	<button id='story' class='btn btn-primary' data-toggle='modal'
	        	data-target='#storyBoard'>Review Patient</button>
                <br />
                <br />
                -->

				<!-- Modal for computer scores -->
				<div class='modal fade' id='modelWindow' role='dialog'>
					<div class='modal-dialog modal-sm vertical-align-center'>
						<div class='modal-content'>
							<div class='modal-header'>
								<button type='button' class='close' data-dismiss='modal'>&times;</button>
								<h4 class='modal-title'>Computer algorithm's risk scores:</h4>
							</div>
							<div id='ptable-body' class='modal-body'>
								<div id='mortality-risk-modal'>
									Mortality Risk:
									<div id='mortality-num'></div>
								</div>
								<div class='modal-chart'>
									<div class='predictionChart' id='predictionChart'></div>
								</div>
        						<script src='../charts/predictionChart.js'></script>
								<script>
									console.log(mortRisk);
									generatechart(risk_details, mortRisk, 2);
								</script>
							</div>
							<div class='modal-footer'>
								<button type='button' data-dismiss='modal' class='btn btn-primary'>Close</button>
							</div>
						</div>
					</div>
				</div>
				
				<div>
					<br />
					<p id='directions' class='envelope-text'>
            			After reviewing the computer algorithm's calculated risk scores
            			 please reevaluate your initial risk assessment by adjusting the 
            			 chart slices below. Click on the patient details button for more 
            			 info.
            		</p>
            		<br />
				</div>
				
				<div id='chart-overlay' type='button' data-toggle='modal' data-target='#modelWindow'>
					<div class='predictionChartThumb' id='predictionChart'></div>
					<script src='../charts/predictionChartThumb.js'></script>
					<script>
						generatechart_thumb(risk_details, mortRisk);
					</script>
				</div>
				
				<button class='btn btn-primary' id='story' data-toggle='modal' data-target='#storyBoard'>PATIENT DETAILS</button>
				
				<br />
				<br />
					<div class='chart-envelope'>
                    	<div id='chart'></div>
                    </div>
                    <script src='../charts/pieChart.js'></script>
                    <script>
                        var js_labels = <?php echo $labels?>;
                        var prev_percentages = <?php echo $prev_percentages?>;
                        
                        var complicationPerc = [];
						var i;
						
						console.log( prev_percentages[0] );
						
						// Set complications to previous prediction's values
						complicationPerc[0] = prev_percentages[0].rifle7;
						complicationPerc[1] = prev_percentages[0].icu;
						complicationPerc[2] = prev_percentages[0].ventilator;
						complicationPerc[3] = prev_percentages[0].cardiovascular;
						complicationPerc[4] = prev_percentages[0].sepsis;
						complicationPerc[5] = prev_percentages[0].neurological;
						complicationPerc[6] = prev_percentages[0].venous;
						complicationPerc[7] = prev_percentages[0].wound;
						
                        generatechart(js_labels, complicationPerc);
                    </script>
                    <button id='submit-btn' name='submit' class='btn btn-primary' 
                	data-toggle='modal' data-target='#lastChance'>SUBMIT</button>
            </div>
            <br />
        </div>
        <div class='tTip' style='color: #fff'>
			<div id='tTipLabel'></div>
			<div id='tTipPercent'></div>
		</div>
		<script src='../js/chartTooltip.js' type='text/JavaScript'></script>
    </body>
</html>
