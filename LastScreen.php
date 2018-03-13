
<!DOCTYPE HTML>
<html>
	<head>
	<?php
		$page = 5;
		
		// If dataValidation received null values, redirect to error page
		function error_found () {
		  		$errType = 'nullErr';
				header( 'Location: dataError.php?errType='.htmlspecialchars( $errType ) );
		}
		set_error_handler('error_found');
		
		require_once __DIR__.'/dataValidation.php';
	?>
		
		<meta charset='UTF-8'>
		<title>Assessment Complete</title>
	    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    	<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    	<script src='https://code.jquery.com/jquery-1.9.1.js'></script>
    	<link href='css/bootstrap.min.css' rel='stylesheet' media='screen'>
    	<link href='css/prismaStyle.css' rel='stylesheet'>
    	<script src='js/bootstrap.min.js'></script>
    	<link href='css/bootstrap-responsive.css' rel='stylesheet' media='screen'>
    	<script src='http://d3js.org/d3.v3.min.js'></script>
    	
		<style>
			html {
				height: 100%;
			}
		</style>

		<script>
			function submit(){
				
				var link='<?php  echo "submit.php?continue=true&docID=$docID"?>';

				 window.location.href = link;
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
    	<div id='envelope' class='container' align='center' >
	        
	        <br />
	       	<p class='envelope-text'>
				Thanks for participating in the study. For more information 
				about PrismaP labs, visit <a href='https://prismap.medicine.ufl.edu'>
				our website</a>.
				<br />
				<br />
				Click "Continue" to view other patients, or click "Log Off" to exit to the 
				login screen. Have a Nice Day!
	       	</p>
	       	<br />
			<table align='center' style='width: 20%;'>
            	<tr>
	        		<td style='padding-right: 25px;'>
	        			<button class='btn btn-primary' type='button' id='continue' onclick='submit();'>Continue</button>
	        		</td>
	        		<td align='right' style='padding-left: 25px;'>
	        			<button class='btn btn-primary' type='button' id='logoff' onclick ='window.location.href="index.html"'>LogOff</button>
	        		</td>
	        	</tr>
            </table>
			
	        <br /> 
	        <br />
        </div> 
         
    </body>
</html>
