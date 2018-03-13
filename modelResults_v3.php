<!DOCTYPE html>
<html lang='en'>
<?php
		$page = 2;
		
		// If dataValidation received null values, redirect to error page
		function error_found () {
		  		$errType = 'nullErr';
				header( 'Location: dataError.php?errType='.htmlspecialchars( $errType ) );
		}
		set_error_handler('error_found');
		
		require_once __DIR__.'/pagesComplete.php';
		require_once __DIR__.'/dataValidation.php';
?>

<head>
    <meta charset='UTF-8'>
    <title>Computer Algorithm Scores</title>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <script src='https://code.jquery.com/jquery-1.9.1.js'></script>
    <link href='css/bootstrap.min.css' rel='stylesheet' media='screen'>
    <link href='css/prismaStyle.css' rel='stylesheet'>
    <script src='js/bootstrap.min.js'></script>
    <link href='css/bootstrap-responsive.css' rel='stylesheet' media='screen'>
    <script src='https://d3js.org/d3.v3.min.js'></script>


    <script>
        var patient_details = <?php echo json_encode($patient_details)?>;
        var mortRisk = '<?php echo "$mortality_risk"?>';
        var user = '<?php echo "$docID"?>';
        var patientId = '<?php echo "$ptID"?>';
        var factorNum = [0, 0, 0, 0, 0, 0, 0, 0];
		
		// When the user clicks anywhere outside of a modal, close it
		window.onclick = function(event) {
		    if ( event.target === document.getElementById( 'additionalScores' ) ) {
		        $( '#additionalScores' ).modal( 'hide' );
		        console.log( 'Clicked Outside' );
		    }
		}
		
		/**
		 * @summary Sets an element of a global array to 1
		 *
		 * This function sets an element of the global array factorNum to 1 to
		 * indicate that the riskFactors at that index have been assessed.
		 *
		 * @global type $factorNum This is a global array storing ones and zeros.
		 *
		 * @param type $var index. This parameter is an integer which indicates
		 * the index of an array to access.
		 *
		 * @returns type none.
		 */
		function factorAssessed (index) {
			factorNum[index] = 1;
		}
		
		/**
		 * @summary Sets an element of a global array to 1
		 *
		 * This function sets an element of the global array factorNum to 1 to
		 * indicate that the riskFactors at that index have been assessed.
		 *
		 * @global type $factorNum This is a global array storing ones and zeros.
		 *
		 * @param type $var index. This parameter is an integer which indicates
		 * the index of an array to access.
		 *
		 * @returns type none.
		 */
		function checkFactors () {
			var factorsAssessed = 0;
			var i;
			
			for ( i = 0; i < 8; i++ ) {
				factorsAssessed += factorNum[i];
			}
				
			if ( factorsAssessed >= 3 ) {
				console.log( 'Factors Assessed!' );
				submit();
			}
			else {
				console.log ( factorsAssessed );
				$('#error').show();
				$('#errorLabel').text('Please assess the risk factors for at ' +
					'least three complications. These can be viewed by clicking' +
					' on the chart slices representing said complications.');
			}
		};
		
		/**
		 * @summary Saves risk factors
		 * 
		 * @returns type none.
		 */
		function saveFactors () {
			//
		}
		
        function submit() {
            console.log(dataset);
            var payload = [];
            var j=0;
            /*
            for(i=0;i<patient_details.length;i++){
                for(k=0;k<3;k++) {
                    if(dataset[i].topFactors[k].isinclude == true) {
                        payload[j] = {};
                        payload[j].user = user;
                        payload[j].patientId = patientId;
                        payload[j].outcomeId = i + 1;
                        payload[j].feature = patient_details[i].topFactors[k].var;
                        j++;
                    }
                }
            }*/
            window.location.href = 'submit.php?submit=true&payload='+JSON.stringify(payload)+'&docID='+user+'&ptID='+patientId;
        };
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

<!-- Data loaded -->
<div class='modal fade' id='loadStatus' role='dialog'>
	<div class='modal-dialog modal-sm vertical-align-center'>
		<div class='modal-content'>
			<div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal'>&times;</button>
            	<h4>Load Status</h4>
			</div>
			<div class='modal-body'>
				[Load Status]
			</div>
			<div class='modal-footer'>
				<button type='button' data-dismiss='modal' class='btn btn-primary'>Close</button>
			</div>
		</div>
	</div>
</div>
		
<!-- Risk Factors Modal -->
<div class='modal fade' id='riskFactorsModal' role='dialog'>
    <div class='modal-dialog modal-sm vertical-align-center'>
        <div class='modal-content' id='factor-modal-content'>
            <div class='modal-header'>
                <h4 class='modal-title'>Main factors affecting patient's
                risk of developing </h4>
                <br />
                <p>Please click on any factors you disagree with.</p>
            </div>
            <div class='modal-body'>
            	
            	<!--Placeholder for new tab system:-->
				<div id = prediction-table-container>
					<table id = prediction-table>
					</table>
				</div>
				
				<div id = decreasingRisk>
					<table id = decreasingTable>
						<thead>
						</thead>
					</table>
				</div>
            </div>
            <div class='modal-footer'>
                <button id='saveFactors' type='button' data-dismiss='modal'
                	class='btn btn-primary' onclick='saveFactors()'>Save</button>
            </div>
        </div>
    </div>
</div>

<div id='envelope' class='container' align='center'>
	
	<br />
	<p id='directions' class='envelope-text'>
        	The computer algorithms have calculated the following probability risk scores. 
        	Click on the Chart to view influencing features.
    </p>
    <br />
    
	<!--<button class='btn btn-primary' name='additionalScores' data-toggle='modal' data-target='#additionalScores'>ADDITIONAL SCORES</button>-->
    <div id='reviewFeatures'>
        <div id='error'class='alert alert-error' hidden>
			<label id='errorLabel'>Fill in the following information</label>
		</div>
        <div id='mortality-risk'>
			Mortality Risk:
			<div id='mortality-num'></div>
		</div>
        <div class='predictionChart'></div>
        <script src='predictionChart.js'></script>
        <button id='submit-btn' class='btn btn-primary' onclick='checkFactors()'>
        NEXT</button>
        <br />
        <br />
    </div>
</div>
<script>
	console.log( patient_details );
    generatechart( patient_details, mortRisk, 1 );
</script>
<div class='tTip' style='color: #fff'>
	<div id='tTipLabel'></div>
	<div id='tTipPercent'></div>
	<p style='font-size: 9pt;'>Click to view risk factors</p>
</div>
<script src='js/chartTooltip.js' type='text/JavaScript'></script>
</body>
</html>