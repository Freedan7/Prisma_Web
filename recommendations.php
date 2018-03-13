<!DOCTYPE HTML>
<html>
	<?php
		$page = 4;
		
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
		<title>Have you considered this?</title>
	    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    	<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    	<script src='https://code.jquery.com/jquery-1.9.1.js'></script>
    	<link href='css/bootstrap.min.css' rel='stylesheet' media='screen'>
    	<link href='css/prismaStyle.css' rel='stylesheet'>
    	<script src='js/bootstrap.min.js'></script>
    	<link href='css/bootstrap-responsive.css' rel='stylesheet' media='screen'>
    	<script src='http://d3js.org/d3.v3.min.js'></script>
		
		<script>
			var startTime=Date.now();
			
			function submit(){
				var recoTaken=$('input[name=FeedBack]:checked').val();
				var recommendation='';
				var cases='';
				var id='<?php echo "$ptID"?>';
				var user='<?php echo "$user"?>';
				
				var time=(Date.now()-startTime)/1000;
				
				if(recoTaken=='Yes'){
					for (var i=1; i <= 11; i++) {
						if($('input[name=reco'+i+']:checked').val()) {
							recommendation+=$('input[name=reco'+i+']:checked').val()+';';
						}
						else {
							recommendation += null + ';';
						}
					}
					if($('input[name=reco11]:checked').val()) {
						recommendation += 'Other:'+$('input[name=otherIP]').val()+';';
					}
					else {
						recommendation += null + ';';
					}
							
					for (var i=1; i <= 8; i++) {
						if($('input[name=case'+i+']:checked').val()) {
							cases+=$('input[name=case'+i+']:checked').val()+';';
						}
						else {
							cases += null + ';';
						}
					}
					console.log ('recos = ' + recommendation);
					console.log ('cases = ' + cases);
					window.location.href = 'submit.php?recoPos=true&id='+id+'&docID='+user+'&recos='+recommendation+'&cases='+cases+'&time='+time;
				}
				else {
					window.location.href = 'submit.php?recoNeg=true&id='+id+'&docID='+user+'&time='+time;
				}
		    			    	
		    }
		    
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
		    	} else {
		    		document.getElementById('recommendationSec').style.display= 'none';
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
        				Based on the presented risk scores, would you consider any specific interventions?
        			</p>
        			<br />
					<div>
						<input type='radio' name='FeedBack' value='No' checked onchange='changeVisibility(false);'>No&nbsp;&nbsp;
						<input type='radio' name='FeedBack' value='Yes' onchange='changeVisibility(true);'>Yes
		        	</div>
		        	<br />
        		</div>
        		<div id='recommendationSec' align='left' style='display: none;'>
        			<hr>
					<p class='envelope-text'>• Choose one or more from the following interventions:</p>
					<br />
					<br />
					<div class='envelope-text'>
						<form>
						<input id='reco1' type='checkbox' name='reco1' value='arterial'><label for='reco1'>Place arterial line</label>
						<br />
						<input id='reco2' type='checkbox' name='reco2' value='arterialHemodynamic'><label for='reco2'><span></span>Place arterial line and use hemodynamic monitoring</label>
						<br />
						<input id='reco3' type='checkbox' name='reco3' value='CVP'><label for='reco3'><span></span>Place central venous line and use CVP</label>
						<br />
						<input id='reco4' type='checkbox' name='reco4' value='PA'><label for='reco4'><span></span>Place PA catheter</label>
						<br />
						<input id='reco5' type='checkbox' name='reco5' value='therapy'><label for='reco5'><span></span>Goal directed therapy</label>
						<br />
						<input id='reco6' type='checkbox' name='reco6' value='diuretics'><label for='reco6'><span></span>Avoid diuretics</label>
						<br />
						<input id='reco7' type='checkbox' name='reco7' value='transfusion'><label for='reco7'><span></span>Restrictive blood transfusions</label>
						<br />
						<input id='reco8' type='checkbox' name='reco8' value='resuscitation'><label for='reco8'><span></span>Restrictive crystalloid resuscitation</label>
						<br />
						<input id='reco9' type='checkbox' name='reco9' value='colloid'><label for='reco9'><span></span>Use colloid resuscitation</label>
						<br />
						<input id='reco10' type='checkbox' name='reco10' value='albumin'><label for='reco10'><span></span>Use albumin</label>
						<br />
						<input id='reco11' type='checkbox' name='reco11' value='other' onclick='changeEnable();'><label for='reco11'><span></span>Other:</label>
						<input type='text' name='otherIP' disabled />
						<br />
						</form>
					</div>
					<br/><br/>
					<p class='envelope-text'>• These intervention(s) would mitigate risk for which postoperative complications:</p>
						<br />
						<br />
						<div class='envelope-text'>
						<form>
						<input id='case1' type='checkbox' name='case1' value='AKI'><label for='case1'><span></span>Acute kidney injury</label>
						<br />
						<input id='case2' type='checkbox' name='case2' value='ICU'><label for='case2'><span></span>ICU admission more than 48 hours </label>
						<br />
						<input id='case3' type='checkbox' name='case3' value='MV'><label for='case3'><span></span>Mechanical ventilation more than 48 hours </label>
						<br />
						<input id='case4' type='checkbox' name='case4' value='CV'><label for='case4'><span></span>Cardiovascular complications</label>
						<br />
						<input id='case5' type='checkbox' name='case5' value='SEP'><label for='case5'><span></span>Sepsis</label>
						<br />
						<input id='case6' type='checkbox' name='case6' value='NEU'><label for='case6'><span></span>Neurologic complications including delirium</label>
						<br />
						<input id='case7' type='checkbox' name='case7' value='VTE'><label for='case7'><span></span>Venous thromboembolism</label>
						<br />
						<input id='case8' type='checkbox' name='case8' value='WND'><label for='case8'><span></span>Wound complications</label>
						<br />
						</form>
					</div>
					<br />
					</div>
					<button name='submit' class='btn btn-primary btn-large' onclick='submit()'>SUBMIT</button>
					<br />
					<br />
	        </div>
	        <br />
	    </body>
</html>
