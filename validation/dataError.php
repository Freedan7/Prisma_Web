<!DOCTYPE HTML>
<html>
	<head>
		<?php
			$error = $_GET['errType'];
			$errTxt = 'Problem accessing or posting data';
			
			if ( $error === 'docIdErr' ) {
				$errTxt = 'Doctor ID is invalid';
			}
			else if ( $error === 'patIdErr' ) {
				$errTxt = 'Patient ID is invalid';
			}
			else if ( $error === 'nullErr' ) {
				$errTxt = 'Some data is missing or invalid. You may be getting ' 
				.'this message because your internet is down. Alternatively, the'
				.' Idealist database may be down or undergoing maintenance.';
			}
			else if ( $error === 'rangeErr' ) {
				$errTxt = 'Some data is outside of the accepted range';
			}
			else if ( $error === 'formErr' ) {
				$errTxt = 'One or more of the entered fields was invalid. '
					.'Please return to the previous form and try again.';
			}
			else {
				//continue
			}
			
			// For debugging purposes
			//echo $error;
		?>
		<title>Error</title>
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	    <script src="https://code.jquery.com/jquery.js"></script>
	    <script   src="https://code.jquery.com/jquery-3.1.0.min.js"   integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s="   crossorigin="anonymous"></script>
	    <script src="../js/bootstrap.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<link rel="stylesheet" href="../css/prismaStyle.css" />
		<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
		<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		<style>
			html {
				height: 100%;
			}
		</style>
		<script>
			/*
			Error types:
			
			One or more data elements are in an invalid format
			One or more data elements are null
			One or more data elements are outside of the accepted range
			*/
			var errLog = "<?php echo "$errTxt "?>";
			
			$( document ).ready ( function () { 
				$('#errorLabel').text( 'Error: ' + errLog );
			});
			
			
			function prevPage () {
				window.history.back();
			}
		</script>
	</head>
    <body >
    	<nav class='navbar navbar-default navbar-static-top'>
		  <div class='container'>
			<div class='navbar-header'>
			</div>
			<h1 id='header' style='text-align: center'>Idealist Platform</h1>
			<br>
		  </div>
		</nav>
	    
    	<br />
	    
	    <div id='envelope' class='container' align='center'>
	    	<br />
	    	<div class='envelope-text'>
    			<div id='error' class='alert alert-error'>
					<label id='errorLabel'>Error</label>
				</div>
			</div>
			<button class='btn btn-large btn-primary' role='button' onclick='prevPage();'>
				Return to previous page
			</button>
			<br />
			<br />
		</div>
         
    </body>
</html>
