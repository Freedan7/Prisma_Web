<!DOCTYPE HTML>
<html>
	<?php
		$page = 6;
		
		// If dataValidation received null values, redirect to error page
		function error_found () {
		  		$errType = 'nullErr';
				header( 'Location: dataError.php?errType='.htmlspecialchars( $errType ) );
		}
		set_error_handler('error_found');
			
		require_once __DIR__.'/dataValidation.php';
	?>
	
	<head>
		<meta charset='UTF-8'>
		<title>Review Patient</title>
		<meta name='viewport' content='width=device-width, initial-scale=1.0'>
    	<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    	<script src='https://code.jquery.com/jquery-1.9.1.js'></script>
    	<link href='css/bootstrap.min.css' rel='stylesheet' media='screen'>
    	<link href='css/prismaStyle.css' rel='stylesheet'>
    	<script src='js/bootstrap.min.js'></script>
    	<link href='css/bootstrap-responsive.css' rel='stylesheet' media='screen'>
    	<script src='https://d3js.org/d3.v3.min.js'></script>
    	
    	<script>
    		//Temporary
    		function reset () {
    			var docID = '<?php echo "$docID"?>';
    			var ptID = '<?php echo "$ptID"?>';
    			
    			window.location.href = 'resetPagesComplete.php?ptID='+ptID+'&docID='+docID;
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
				
				for ( i = 1; i <= 3; i++ ) {
					if ( i !== tabClicked ) {
						$( document.getElementById( 'tab-content' + i ) ).hide();
					}
				}
				
				$( document.getElementById ( 'tab-content' + tabClicked ) ).show();
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
		
		<br />
    	<div id='envelope' class=container align='center' >
    		<br />
    		<p class='envelope-text'>Reset pages complete to 0 for this patient (Temporary Feature for Testing):</p>
    		<br />
    		<button id='resetPatient' name='reset' class='btn btn-primary' 
                	onclick='reset()'>RESET PATIENT</button>
    		<hr />
    		<p class='envelope-text'>Review patient predictions</p>
    		<br />
    		<div class='tabs'>
				<div class='tabs envelope-text'>
					<!-- Label for Initial Assessment -->
					<input type='radio' name='tabs' id='tab1' onclick='switchTabs(1)' checked>
					<label for='tab1'>
						<span id='tab1Label'>Initial Assessment</span>
					</label>
					
					<!-- Label for Computer Predictions -->
					<input type='radio' name='tabs' id='tab2' onclick='switchTabs(2)'>
					<label for='tab2'>
						<span id='tab2Label'>Computer Predictions</span>
					</label>
					
					<!-- Label for Final Assessment -->
					<input type='radio' name='tabs' id='tab3' onclick='switchTabs(3)'>
					<label for='tab3'>
						<span id='tab2Label'>Final Assessment</span>
					</label>
				</div>
				
				<br />
				
				<!-- Tab content for Initial Assessment -->
				<div id='tab-content1' class='tab-content'>
					<p>Your initial prediction of patient risk:</p>
					<br />
					<div class='chart-envelope'>
            		    <div id='chart'></div>
            		</div>
            	    <script src='reviewCharts/pieChartStatic.js'></script>
            	    <script>
            	        var js_labels = <?php echo $labels?>;
            	        var initial_percentages = <?php echo $initial_percentages?>;
            	        var complicationPerc = [];
            	        var i;
            	        
            	        // Set complications to previous prediction's values
						complicationPerc[0] = initial_percentages[0].rifle7;
						complicationPerc[1] = initial_percentages[0].icu;
						complicationPerc[2] = initial_percentages[0].ventilator;
						complicationPerc[3] = initial_percentages[0].cardiovascular;
						complicationPerc[4] = initial_percentages[0].sepsis;
						complicationPerc[5] = initial_percentages[0].neurological;
						complicationPerc[6] = initial_percentages[0].venous;
						complicationPerc[7] = initial_percentages[0].wound;
            	        
            	        console.log(js_labels);
            	        generatechart1( js_labels, complicationPerc );
            	    </script>
				</div>
				
				<!-- Tab content for Computer Prediction -->
				<div id='tab-content2' class='tab-content' hidden>
					<p>The computer's prediction of patient risk:</p>
					<br />
					<div class='predictionChart'></div>
					<script src='reviewCharts/predictionChartReview.js'></script>
					<script>
						var patient_details2 = <?php echo json_encode($patient_details2)?>;
						var mortRisk = '<?php echo "$mortality_risk"?>';
						
						console.log( patient_details2 );
					    generatechart2( patient_details2, mortRisk, 2 );
					</script>
				</div>
				
				<!-- Tab content for Computer Prediction -->
				<div id='tab-content3' class='tab-content' hidden>
					<p>Your final prediction of patient risk:</p>
					<br />
					<div class='chart-envelope'>
						<div id='chart2'></div>
					</div>
					<script src='reviewCharts/pieChartStatic2.js'></script>
					<script>
                        var final_percentages = <?php echo $final_percentages?>;
                        
                        var complicationPerc2 = [];
						var i;
						
						console.log( final_percentages[0] );
						
						// Set complications to previous prediction's values
						complicationPerc2[0] = final_percentages[0].rifle7;
						complicationPerc2[1] = final_percentages[0].icu;
						complicationPerc2[2] = final_percentages[0].ventilator;
						complicationPerc2[3] = final_percentages[0].cardiovascular;
						complicationPerc2[4] = final_percentages[0].sepsis;
						complicationPerc2[5] = final_percentages[0].neurological;
						complicationPerc2[6] = final_percentages[0].venous;
						complicationPerc2[7] = final_percentages[0].wound;
						
                        generatechart3( js_labels, complicationPerc2 );
					</script>
				</div>
				
			</div>
    		<br />
    	</div>
		<br />
        <div class='tTip' style='color: #fff'>
			<div id='tTipLabel'></div>
			<div id='tTipPercent'></div>
		</div>
		<script src='js/chartTooltip.js' type='text/JavaScript'></script>
    </body>
</html>