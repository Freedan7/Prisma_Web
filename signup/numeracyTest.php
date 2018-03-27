<!DOCTYPE HTML>
<html>
	<head>
		<title>Register</title>
	    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
	    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	    <link href='../css/bootstrap.min.css' rel='stylesheet' media='screen'>
	    <script   src='https://code.jquery.com/jquery-3.1.0.min.js'   integrity='sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s='   crossorigin='anonymous'></script>
	    <script src='https://code.jquery.com/jquery.js'></script>
	    <script src='../js/bootstrap.min.js'></script>
		<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'></script>
		<link rel='stylesheet' href='https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css' />
		<script src='https://code.jquery.com/jquery-1.9.1.js'></script>
		<script src='https://code.jquery.com/ui/1.10.3/jquery-ui.js'></script>
		<link href='../css/prismaStyle.css' rel='stylesheet'>
		<script>
			// Global variable indicating whether or not a username exists
			var USER_EXIST = -1;
			
			/**
			 * @summary Reveals a specific div.
			 *
			 * This function selects a specific div, and sets its display 
			 * property.
			 *
			 * @param type $var varPage. This variable indicates which tab is
			 * currently being displayed.
			 *
			 * @returns type none.
			 */
			function goto(varPage){
				$('#tab a[href="#tab'+varPage+'"]').tab('show');
			}
			
			/**
			 * @summary Checks for username in database
			 *
			 * This function searches a database for a username. If the username
			 * exists, it sets the global variable USER_EXIST to 0. Otherwise,
			 * the variable is set to 1. If there is an error searching the
			 * database, the variable is set to -1.
			 *
			 * @global type $USER_EXIST This global variable indicates whether
			 * or not a username exists within a database.
			 *
			 * @returns type none.
			 */
			function checkUser(){
				// Create a deferred object
  				var deferredObject = $.Deferred();
  							
				username=$('#question2').val();
				$.post('script.php', { id: username, usercheck:'true'},
					function (result) {   
					    if (result==1) {
					    	$('#error').show();
					    	$('#errorLabel').show();
							$('#errorLabel').text(username+' already exists!');
							USER_EXIST=0;
					    } else if (result==0) {
					    	$('#errorLabel').hide();
					    	USER_EXIST=1;
					    } else{
					    	$('#error').show();	
							$('#errorLabel').text(result);
							USER_EXIST=-1;
					    }
					    
					  });
			
			//
				setTimeout(function () {
  				  // Resolve deferred object after function is complete
  				  deferredObject.resolve();
  				}, 2500);
				
  				// Return the deferred object
  				return deferredObject;
			}
			
			/**
			 * @summary Uses a registry expression to verify a username string
			 *
			 * This function uses a registry expression to confirm whether or
			 * not an entered username is valid.
			 *
			 * @returns type boolean. If the name is valid, the
			 * function returns true. Otherwise, it returns false.
			 */
			function validateUsername () {
				var usernameString = document.getElementById('question2').value;
				var username = /^[a-zA-Z0-9 ]+$/;
				
				return username.test(usernameString);
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
			function validateName () {
				var nameString = document.getElementById('question1').value;
				var name = /^[a-zA-Z ]+$/;
				
				return name.test(nameString);
			}
			
			/**
			 * @summary Uses a registry expression to verify an age
			 *
			 * This function uses a registry expression to confirm whether or
			 * not an entered age string is valid.
			 *
			 * @returns type boolean. If the age is valid, the
			 * function returns true. Otherwise, it returns false.
			 */
			function validateExperience () {
				var expString = document.getElementById('question8').value;
				var exp = /^([0-9]{1,2}){1}/;
				
				return exp.test(expString);
			}
			
			/**
			 * @summary Waits until the username is verified
			 *
			 * Waits until the username is verified before calling the register function
			 *
			 * @returns type none.
			 */
			function doesUserExist () {
				checkUser().done(register);
			}
			
			/**
			 * @summary After checking the USER_EXIST variable, updates database
			 *
			 * Once a username is confirmed to be unique, this function adds
			 * the username to a database, and redirects to a new page.
			 *
			 * @global type $USER_EXIST This global variable indicates whether
			 * or not a username exists within a database.
			 *
			 * @returns type none.
			 */
			function register(){
				var formIsValid = true;
				
				if(USER_EXIST==0){
					$('html, body').animate({ scrollTop: 0 }, 'fast');
					return;
				}
				
				var result='';
				var error='';
				
				for (var i = 1; i <= 19; i++) {
					result=result+$('#question'+i).val()+';';
					if($('#question'+i).val()==''){
						error=error+i+',';
					}
				}
				
				console.log(result);
				if (error!='') {
					error=error.substring(0,error.length - 1);
					$('#error').show();
					$('#errorLabel').show();
					$('#errorLabel').text('Please answer question numbers '
					+ error + ' to register successfully');
					
					formIsValid = false;
				}
				else {
					$('#errorLabel').hide();
				}
				
				// Check username syntax
				if (validateUsername() === false) {
					$('#error').show();
					$('#usernameError').show();
					$('#usernameError').text('Please enter a valid username ' +
					'(Only letters, numbers, and spaces allowed).');
					
					formIsValid = false;
				}
				else {
					$('#usernameError').hide();
				}
				
				// Check full name syntax
				if (validateName() === false) {
					$('#error').show();
					$('#nameError').show();
					$('#nameError').text('Please enter a valid full name ' +
					'(Only letters and spaces allowed).');
					
					formIsValid = false;
				}
				else {
					$('#nameError').hide();
				}

				// Check exp syntax
				if (validateExperience() === false) {
					$('#error').show();
					$('#expError').show();
					$('#expError').text('Please enter years since graduation' +
					' as one to two integers');
					
					formIsValid = false;
				}
				else {
					$('#expError').hide();
				}
				
				if (formIsValid === true) {
					username=$('#question5').val();
					document.getElementById('resultsHolder').value = result;
					console.log(result);
     				document.getElementById("numeracyTest").submit();
				}
				else {
					$('html, body').animate({ scrollTop: 0 }, 'fast');
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
    	<div id='envelope' class='container' align='center' >
	        <br />
	        <div id='error'class='alert alert-error' hidden>
		    	<label id='errorLabel' hidden>Fill in the following information</label>
		    	<br />
		    	<label id='usernameError'hidden>Fill in the following information</label>
		    	<br />
		    	<label id='nameError' hidden>Fill in the following information</label>
		    	<br />
		    	<label id='expError' hidden>Fill in the following information</label>
		    </div>
	        <div class='testTab' style='margin-bottom: 18px;'>
              	<div id='registrationForm' style='padding-bottom: 9px; border-bottom: 1px solid #ddd;'>
              		<div>
              		
              		<form id='numeracyTest' action="../signup/userAgreement.php" method="post">
              		<!-- Tab for Personal Information -->
	                <div class='tab-pane active' id='tab1'>
	                	<br />
	                	<div>
	                		<p class='envelope-text'>
		               			1. Full Name  	
		                	</p>
		                	
		                	<div class='input-append'>
								<input class='span14' id='question1' type='text' name='fullName'>  
							</div>
						</div>
								
						<br />
										
						<div>
	                    	<p class='envelope-text'>
		                	  	2. User Name  	
		                	</p>
		                	
		                	<div class='input-append'>
								<input class='span14' id='question2' type='text'>  
							</div>
						</div>
						
						<br />
						
						<div>
	                		<p class='envelope-text'>
		                	  	3. Password  	
							</p>
							
		                	<div class='input-append'>
								<input class='span14' id='question3' type='password'>  
		                	</div>
		                </div>
		                
		                <br />
		                
		                <div>		                  	
		                	<p class='envelope-text'>
		                	  	4. Gender
		                	</p>
		                	
		                	<div class='input-append'>
								<select id='question4'>
									<option>Male</option>
									<option>Female</option>
								</select>
							</div>
						</div>
						
						<br />
						
		                <div>
		                	<p class='envelope-text'>
		                  		5. Age  
		                  	</p> 	
		                  
		                  	<div class='input-append'>
									<select id='question5'>
										<option>30 years or less</option>
										<option>31 years TO 40 years</option>
										<option>41 years TO 50 years</option>
										<option>51 years TO 60 years</option>
										<option>more than 60 years</option>
									</select>
							</div>
		            	</div>
		                
		                <br />
		                	
	                	<div>
	                		<p class='envelope-text'>
		                  		6. Current Role   	
		                  	</p>

							<div class='input-append'>
								<select id='question6'>
									<option>Attending Doctor</option>
									<option>Resident</option>
								</select>
		                  	</div>
		                </div>
		                
		                <br />
		                
		                <div>
		            		<p class='envelope-text'>
		                  		7. Speciality
		                  	</p>
		                  	  	
							<div class='input-append'>
								<select id='question7'>
									<option>ER</option>
									<option>Medicine</option>
									<option>Surgery</option>
									<option>Anesthesiology</option>
								</select> 
							</div>
		                </div>
		                
		                <br />
		                
		            	<div>
		            		<p class='envelope-text'>
		                  		8. Number of years since graduation from Medical school
		                  	</p>
		                  	
		                  	<div class='input-append'>
								<input class='span14' id='question8' type='text'>
							</div>
		                </div>
		                
		                <br />
		                
	                	
	                </div>
              	
	                <!-- Pane for CRT test -->
	                <div class='tab-pane' id='tab2'>	                
		                <br />
	                	<p class='envelope-text'>
		                  	9. A bat and a ball cost $1.10 in total. The bat 
		                  	cost $1.00 more than the ball. How much does the 
		                  	ball cost?
		                </p>
		                
		                <div class='input-append'>
						    <input class='span2' id='question9' type='number'>
						    <span class='add-on'> cents</span>
						</div>
		                
		                <br />
		                <br />
		                
						<p class='envelope-text'>
		                  	10. If it takes 5 machines 5 minutes to make 5 
		                  	widgets, how long would it take 100 machines to 
		                  	make 100 widgets?
		                </p>

		                <div class='input-append'>
						    <input class='span2' id='question10' type='number'>
						    <span class='add-on'> minutes</span>
						</div>
		                
		                <br />
		                <br />
		                
		                <p class='envelope-text'>
		                	11. In a lake there is a patch of lily pads. Every 
		                	day, the patch doubles in size. If it takes 48 days 
		                	for the patch to cover the entire lake, how long 
		                	would it take for the patch to cover half of the lake?
		                </p>
		                  		
		                <div class='input-append'>
						    <input class='span2' id='question11' type='number'>
						    <span class='add-on'> days</span>
						</div>
		                
		                <br />
		                
	                	</table>
	                </div>
	                
	                <!-- Pane for Expanded Numeracy Test -->
	                <div class='tab-pane' id='tab3'>
	                	<br />
						<p class='envelope-text'>
		                	12.Which of the following numbers represents
		                	the biggest risk of getting a disease?
		                </p>
		                	
		                <div class='input-append'>
		                	<select id='question12'>
		                	<option></option>
								<option>1 in 10</option>
								<option>1 in 100</option>
								<option>1 in 1000</option>
							</select>
						</div>
						
						<br />
						<br />

						<p class='envelope-text'>
		            	    13.Which of the following numbers represents
		            	    	the biggest risk of getting a disease?  
		            	</p>

						<div class='input-append'>
	                  		<select id='question13'>
	                  			<option></option>
								<option>1%</option>
								<option>10%</option>
								<option>5%</option>
							</select>
						</div>
						
						<br />
						<br />
		                  	
						<p class='envelope-text'>
		                  	14.If Person A's risk of getting a disease is 1% in 
		                  	ten years, and person B's risk is double that of 
		                  	A's, what is B's risk?   	
						</p>

		               	<div class='input-append'>
						    <input class='span14' id='question14' type='number'>
						    <span class='add-on'> %</span>
						</div>
						
						<br />
						<br />
		                  	
						<p class='envelope-text'>
		                  	15.If Person A's chance of getting a disease is 1 in 
		                  	100 in ten years, and person B's risk is double 
		                  	that of A's, what is B's risk?
						</p>
						
		                <div class='input-append'>
						    <input class='span14' id='question15' type='number'>
						    <span class='add-on'> out of 100</span>
						</div>
						
						<br />
						<br />
		                  	
		                <p class='envelope-text'>
		                  	16 and 17.If the chance of getting a disease is 10%, 
		                  	how many people would be expected to get the disease?
		                </p>
		                
		                <div class='input-append'>
						    <input class='span14' id='question16' type='number'>
						    <span class='add-on'> Out of 100</span>
						</div>
		                
		                <div class='input-append'>
						    <input class='span14' id='question17' type='number'>
						    <span class='add-on'> Out of 1000</span>
						</div>
						
						<br />
						<br />
		                  	
		                <p class='envelope-text'>
		                  	18.If the chance of getting a disease is 20 out of 
		                  	100, this would be the same as having a ____% 
		                  	chance of getting the disease  	
		                </p>
		                
		                <div class='input-append'>
		                	<input class='span14' id='question18' type='number'>
		                </div>  	
		                
		                <br />
		                <br />
		                
		                <p class='envelope-text'>
		                  	19.The chance of getting a viral infection is .0005.
		                  	Out of 10,000 people, about how many of them are 
		                  	expected to get infected?   	
		                </p>

		                <div class='input-append'>
						    <input class='span14' id='question19' type='number'>
						    <span class='add-on'> people</span>
						</div>
						
						<br />

	                </div>
	                <!-- next -->
	                </div>
	                <input class='btn btn-large btn-primary' type='button' value='next'  onclick='doesUserExist()'>
	                <input id='resultsHolder' type='hidden' name='value' value=''>
	                </form>
	                
              	</div>
            </div>
        <br />
    	</div>
    	<br />
    </body>
</html>
<script type='text/javascript' src='https://platform.twitter.com/widgets.js'></script>
<script src='../js/jquery.js'></script>
<script src='../js/bootstrap-transition.js'></script>
<script src='../js/bootstrap-alert.js'></script>
<script src='../js/bootstrap-modal.js'></script>
<script src='../js/bootstrap-dropdown.js'></script>
<script src='../js/bootstrap-scrollspy.js'></script>
<script src='../js/bootstrap-tab.js'></script>
<script src='../js/bootstrap-tooltip.js'></script>
<script src='../js/bootstrap-popover.js'></script>
<script src='../js/bootstrap-button.js'></script>
<script src='../js/bootstrap-collapse.js'></script>
<script src='../js/bootstrap-carousel.js'></script>
<script src='../js/bootstrap-typeahead.js'></script>
<script src='../js/bootstrap-affix.js'></script>
<script src='../js/holder/holder.js'></script>
<script src='../js/google-code-prettify/prettify.js'></script>
<script src='../js/application.js'></script>