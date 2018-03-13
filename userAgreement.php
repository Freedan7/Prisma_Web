<!DOCTYPE HTML>
<html>
	<head>
	<?php
	   	$doctorName = $_POST['fullName'];
	   	$doctorAnswers = $_POST['value'];
	?>
		<meta charset='UTF-8'>
		<title>User Agreement</title>
	    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    	<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    	<script src='https://code.jquery.com/jquery-1.9.1.js'></script>
    	<link href='css/bootstrap.min.css' rel='stylesheet' media='screen'>
    	<link href='css/prismaStyle.css' rel='stylesheet'>
    	<script src='js/bootstrap.min.js'></script>
    	<link href='css/bootstrap-responsive.css' rel='stylesheet' media='screen'>
    	<script src='http://d3js.org/d3.v3.min.js'></script>
		
		<script>
			var currentDate = new Date();
					
			var day = currentDate.getDate();
			var month = currentDate.getMonth()+1;
			var year = currentDate.getFullYear();
			
			if(day < 10) {
			    day = '0' + day;
			}
			
			if(month < 10) {
			    month = '0' + month;
			}
			
			var formattedDate = month + '/' + day + '/' + year;
			var fullName = '<?php echo "$doctorName" ?>';
			var result = '<?php echo "$doctorAnswers" ?>';
		    
		    /**
 			 * @summary This function enables or disables a text input
 			 *
 			 * This function checks whether or not a specific text input is 
 			 * checked, and toggles it if it is. Otherwise, the text input is
 			 * disabled.
 			 *
 			 * @returns type none.
 			 */
		    function changeEnable(){
                if($('input[name=reco11]:checked').val()){
		    		$('input[name=otherIP]').removeAttr('disabled');
		    	} else {
		    		$('input[name=otherIP]').attr('disabled', 'disabled');
		    	}
		    }
		    
		    /**
			 * @summary Displays or hides an element
			 *
			 * This function displays or hides an element, based on a boolean.
			 *
			 * @param type $var visible. This parameter is a boolean which causes an
			 * element to be displayed if true, or hidden if false.
			 *
			 * @returns type none.
			 */
		    function changeVisibility(visible){
		    	if(visible==true){
		    		document.getElementById('recommendationSec').style.display= 'block';
		    		document.getElementById('error').style.display = 'none';
		    		document.getElementById('date').value = formattedDate;
		    		document.getElementById('fname').value = fullName;
		    		$('#errorLabel').hide();
		    	} 
		    	else {
		    		document.getElementById('recommendationSec').style.display= 'none';
		    		document.getElementById('error').style.display = 'block';
		    		$('#errorLabel').show();
		    		$('#nameError').hide();
		    	}
		    }
		    
		    /**
			 * @summary Uses a registry expression to verify a name string
			 *
			 * This function uses a registry expression to confirm whether or
			 * not an entered name is valid.
			 *
			 * @returns type boolean. If the name is valid, the
			 * function returns true. Otherwise, it returns false.
			 */
			function validateName (string) {
				var nameString = document.getElementById(string).value;
				var name = /^[a-zA-Z ]+$/;
				
				return name.test(nameString);
			}
		    
		    /**
			* @summary Redirects to index.html
			*
			* This function validates data, then redirects to the home page.
			*
			* @returns type none.
			*/
		    function submit() {
		    	var formIsValid = false;
		    
		    	// Check full name syntax
				if (validateName('fname') === false) {
					$('#error').show();
					$('#nameError').show();
					$('#nameError').text('Please enter a valid first and last name ' +
					'(Only letters and spaces allowed).');
										
					formIsValid = false;
				}
				else {
					$('#nameError').hide();
										
					formIsValid = true;
				}
		    
		    	if (formIsValid == true) {
		    		result = result + formattedDate + ';';
		    		
		    		console.log(result);
							    		
		    		$.post('script.php',  { res: result, answers:'true'},
						function (result) {   
						  		window.location.href = 'index.html';			    
						  });
		    	}
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
	    	<div id='envelope' class='container' align='center'>
		        <br />
		    
        		<div id='Feedback Section'align='center'>
        			
        			<p class='envelope-text'>
        				Please review the following user agreement:
        			</p>
        			
        			<br />
        			
        			<embed src="201600262-Document_Informing_the_Physician_about_the_Study.pdf" width="100%" height="500vh" />
        			
        			<br />
        			
        			<div id='error' class='alert alert-error'>
		    			<label id='errorLabel'>Please accept the user agreement to proceed.</label>
		    			<label id='nameError' hidden>Please enter a valid first and last name.</label>
		    		</div>
        			
					<div>
						<input type='radio' name='FeedBack' value='No' checked onchange='changeVisibility(false);'>  Decline
						&nbsp;
						&nbsp;
						<input type='radio' name='FeedBack' value='Yes' onchange='changeVisibility(true);'>  Accept
		        	</div>
		        	<br />
        		</div>
        		<div id='recommendationSec' style='display: none;'>
        			<!-- Full Name and Date -->
        			<br />
        			<div>
	                	<p class='envelope-text'>
		            	  	Full Name
		            	</p>
		            	
		            	<div class='input-append'>
							<input class='span14' id='fname' type='text'  style='color: #808080' readonly>  
						</div>
					</div>
					
					<br />
					<br />
					<div>
	                	<p class='envelope-text'>
		            	  	Date
		            	</p>
		            	
		            	<div class='input-append'>
							<input type='text' id='date' name='date'  style='color: #808080' class='span14' readonly>
						</div>
					</div>
					
					<br />
					<br />
					<div style="margin-right: auto; margin-left: auto;">
							<button name='submit' class='btn btn-primary btn-large' onclick='submit()'>SUBMIT</button>
					</div>
					<br />
					<br />
        			
        		</div>
	        </div>
	        <br />
	    </body>
</html>