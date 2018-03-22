<?php
	require_once __DIR__.'/urlPath.php';
	require_once __DIR__.'/RestCurl.php';
	
	$data = '';
	$ptID = 996;
	
	$urlRaw = $urlPath.'patientDetailsRaw?patientId='.$ptID;
	//$data = $curl->getData($urlRaw);
	$data = $curl->getData ('-i '.$urlRaw);
	$data = json_encode($data);
	//$data = json_decode($data,true);
	
	echo $data;
	
	/*
	$ptID = 996;

	$urlRaw = $urlPath.'patientDetailsRaw?patientId='.$ptID;
	$patientDetailsRaw = $curl->getData($urlRaw);
	$patientDetailsRaw = json_decode($patientDetailsRaw,true);

	// Variables for patientDetailsText1
	$patientAge = round($patientDetailsRaw[0]['featureValueMap']['age'], 0);
	$patientRace = strtolower($patientDetailsRaw[0]['featureValueMap']['race']);
	$patientSex = strtolower($patientDetailsRaw[0]['featureValueMap']['sex']);
	
	// Comorbidities
	$myocardialInfraction = $patientDetailsRaw[0]['featureValueMap']['imi'];
	$congestiveHeartFailure = $patientDetailsRaw[0]['featureValueMap']['ichf'];
	$peripheralVascularDisease = $patientDetailsRaw[0]['featureValueMap']['ipvd'];
	$cerebrovascularDisease = $patientDetailsRaw[0]['featureValueMap']['icvd'];
	$chronicPulmonaryDisease = $patientDetailsRaw[0]['featureValueMap']['icpd'];
	$cancer = $patientDetailsRaw[0]['featureValueMap']['icancer'];
	$metastaticCarcinoma = $patientDetailsRaw[0]['featureValueMap']['imcancer'];
	$liverDisease = $patientDetailsRaw[0]['featureValueMap']['liverd'];
	$diabetes = $patientDetailsRaw[0]['featureValueMap']['diabetes'];
	$hypertension = $patientDetailsRaw[0]['featureValueMap']['htn_c'];
	$hypothyroidism = $patientDetailsRaw[0]['featureValueMap']['hypothy'];
	$coagulopthy = $patientDetailsRaw[0]['featureValueMap']['coag'];
	$obesity = $patientDetailsRaw[0]['featureValueMap']['obese'];
	$weightLoss = $patientDetailsRaw[0]['featureValueMap']['wghtloss'];
	$fluidAndElectrolyteDisorders = $patientDetailsRaw[0]['featureValueMap']['lytes'];
	$chronicAnemia = $patientDetailsRaw[0]['featureValueMap']['anemia'];
	$substanceAbuse = $patientDetailsRaw[0]['featureValueMap']['alc_drug'];
	$depression = $patientDetailsRaw[0]['featureValueMap']['depress'];
	$valvularDisease = $patientDetailsRaw[0]['featureValueMap']['valve'];
	$kidneyDisease = $patientDetailsRaw[0]['featureValueMap']['reference creatinine'];
	//---------------------(levels CKD, No CKD, ESRD, missing)
	$cci = $patientDetailsRaw[0]['featureValueMap']['cci'];
	$comorbidityCount = 0;
	$comorbidities = '';
	
	// Variables for patientDetailsText2
	$timestamp = $patientDetailsRaw[0]['featureValueMap']['timestamp'];
	$surgeryTime = round($patientDetailsRaw[0]['featureValueMap']['time_to_surgery']/24, 0);
	$surgeryWeekend = $patientDetailsRaw[0]['featureValueMap']['admit_isweekend'];
	$transfer = $patientDetailsRaw[0]['featureValueMap']['admission_source'];
	$emergent = $patientDetailsRaw[0]['featureValueMap']['emergent'];
	$surgeryType = $patientDetailsRaw[0]['featureValueMap']['surgery_type'];
	$primaryProcedure = $patientDetailsRaw[0]['featureValueMap']['primary_proc'];
	$primaryProcedureDescription = $patientDetailsRaw[0]['featureValueMap']['primary_proc_description'];
	$bloodTests = round($patientDetailsRaw[0]['featureValueMap']['count_hgbn_0_7'], 2);
	$urineTests = round($patientDetailsRaw[0]['featureValueMap']['count_hgburn_0_7'], 2);
	$averageLabValues = round($patientDetailsRaw[0]['featureValueMap']['hgb_avg_0_7'], 2);
	$urineGlucose = round($patientDetailsRaw[0]['featureValueMap']['gluurn_0_7'], 2);
	$urineHemoglobin = round($patientDetailsRaw[0]['featureValueMap']['hgbur_0_7'], 2);
	$urineProtein = round($patientDetailsRaw[0]['featureValueMap']['uap_0_365'], 2);
	$estimatedGfr = round($patientDetailsRaw[0]['featureValueMap']['egfr'], 2);
	$mdrdCreatinine = round($patientDetailsRaw[0]['featureValueMap']['ratio_ref_cr_mdrd'], 2);
	$serumPlatelets = round($patientDetailsRaw[0]['featureValueMap']['plts_avg_0_7'], 2);
	$redBloodCount = round($patientDetailsRaw[0]['featureValueMap']['rbc_avg_0_7'], 2);
	$hematocrit = round($patientDetailsRaw[0]['featureValueMap']['hct_avg_0_7'], 2);
	
	// Medications
	$numMeds = round($patientDetailsRaw[0]['featureValueMap']['num_meds'], 0);
	$ACEInhibitors = $patientDetailsRaw[0]['featureValueMap']['aceis_arbs'];
	$aminoglycosides = $patientDetailsRaw[0]['featureValueMap']['aminoglycosides'];
	$antiemetics = $patientDetailsRaw[0]['featureValueMap']['antiemetics'];
	$aspirin = $patientDetailsRaw[0]['featureValueMap']['aspirin'];
	$betaBlockers = $patientDetailsRaw[0]['featureValueMap']['beta_blockers'];
	$bicarbonates = $patientDetailsRaw[0]['featureValueMap']['bicarbonates'];
	$corticosteroids = $patientDetailsRaw[0]['featureValueMap']['corticosteroids'];
	$diuretics = $patientDetailsRaw[0]['featureValueMap']['diuretics'];
	$nephrotoxic = round($patientDetailsRaw[0]['featureValueMap']['nephrotoxic'], 0);
	$nsaids = $patientDetailsRaw[0]['featureValueMap']['nsaids'];
	$pressorsInotropes = $patientDetailsRaw[0]['featureValueMap']['pressors_inotropes'];
	$statins = $patientDetailsRaw[0]['featureValueMap']['statins'];
	$vancomycin = $patientDetailsRaw[0]['featureValueMap']['vancomycin'];
	$admissionMeds = 0;
	$medications = '';
	
	// Variables for patientDetailsText3
	$payer = $patientDetailsRaw[0]['featureValueMap']['payer'];
	$county = $patientDetailsRaw[0]['featureValueMap']['county'];
	$rural = $patientDetailsRaw[0]['featureValueMap']['rural'];
	$population = round($patientDetailsRaw[0]['featureValueMap']['total'], 0);
	$propBlack = round($patientDetailsRaw[0]['featureValueMap']['prop_black'], 2) * 100;
	$propHisp = round($patientDetailsRaw[0]['featureValueMap']['prop_hisp'], 2) * 100;
	$medianIncome = round($patientDetailsRaw[0]['featureValueMap']['median_income'], 2);
	$percBelowPoverty = round($patientDetailsRaw[0]['featureValueMap']['perc_below_poverty'], 2);
	
	// Placeholder variable for Patient Details summary
	$patientDetailsSummary = 'Missing patient details';
	// Placeholder variable for full Patient Details text
	$patientDetailsTextFull = '';
	
	// Build comorbidities list
	if ($myocardialInfraction == 1) {
		$comorbidities = $comorbidities."Myocardial Infraction</br>";
		$comorbidityCount++;
	}
	if ($congestiveHeartFailure == 1) {
		$comorbidities = $comorbidities."Congestive Heart Failure</br>";
		$comorbidityCount++;
	}
	if ($peripheralVascularDisease == 1) {
		$comorbidities = $comorbidities."Peripheral Vascular Disease</br>";
		$comorbidityCount++;
	}
	if ($cerebrovascularDisease == 1) {
		$comorbidities = $comorbidities."Cerebrovascular Disease</br>";
		$comorbidityCount++;
	}
	if ($chronicPulmonaryDisease == 1) {
		$comorbidities = $comorbidities."Chronic Pulmonary Disease</br>";
		$comorbidityCount++;
	}
	if ($cancer == 1) {
		$comorbidities = $comorbidities."Cancer</br>";
		$comorbidityCount++;
	}
	if ($metastaticCarcinoma == 1) {
		$comorbidities = $comorbidities."Metastatic Carcinoma</br>";
		$comorbidityCount++;
	}
	if ($liverDisease == 1) {
		$comorbidities = $comorbidities."Liver Disease</br>";
		$comorbidityCount++;
	}
	if ($diabetes == 1) {
		$comorbidities = $comorbidities."Diabetes</br>";
		$comorbidityCount++;
	}
	if ($hypertension == 1) {
		$comorbidities = $comorbidities."Hypertension</br>";
		$comorbidityCount++;
	}
	if ($hypothyroidism == 1) {
		$comorbidities = $comorbidities."Hypothyroidism</br>";
		$comorbidityCount++;
	}
	if ($coagulopthy == 1) {
		$comorbidities = $comorbidities."Coagulopathy</br>";
		$comorbidityCount++;
	}
	if ($obesity == 1) {
		$comorbidities = $comorbidities."Obesity</br>";
		$comorbidityCount++;
	}
	if ($weightLoss == 1) {
		$comorbidities = $comorbidities."Weight Loss</br>";
		$comorbidityCount++;
	}
	if ($fluidAndElectrolyteDisorders == 1) {
		$comorbidities = $comorbidities."Fluid and Electrolyte Disorders</br>";
		$comorbidityCount++;
	}
	if ($chronicAnemia == 1) {
		$comorbidities = $comorbidities."Chronic Anemia</br>";
		$comorbidityCount++;
	}
	if ($substanceAbuse == 1) {
		$comorbidities = $comorbidities."Drug or Alcohol Abuse</br>";
		$comorbidityCount++;
	}
	if ($depression == 1) {
		$comorbidities = $comorbidities."Depression</br>";
		$comorbidityCount++;
	}
	if ($valvularDisease == 1) {
		$comorbidities = $comorbidities."Valvular Disease</br>";
		$comorbidityCount++;
	}
	if ($kidneyDisease == 1) {
		$comorbidities = $comorbidities."Kidney Disease</br>";
		$comorbidityCount++;
	}
	
	// A singular comorbidity?
	if ($comorbidityCount == 1) {
		$comorbidityCount = '1 comorbidity:';
	}
	else if ($comorbidityCount == 0) {
		$comorbidityCount = $comorbidityCount.' comorbidities.';
	}
	else {
		$comorbidityCount = $comorbidityCount.' comorbidities:';
	}
	
	// A single day?
	if ($surgeryTime == 1) {
		$surgeryTime = '1 day ago';
	}
	else if ( $surgeryTime == 'missing' ||  $surgeryTime == 0) {
		$surgeryTime = 'today';
	}
	else {
		$surgeryTime = $surgeryTime.' days ago';
	}
	
	// Race
	if ($patientRace == "aa") {
		$patientRace = "African American";
	}
	else if ($patientRace == "missing") {
		$patientRace = "unknown race";
	}
	
	// Sex
	if ($patientSex == "missing") {
		$patientSex = "unknown sex";
	}
	
	// Weekend or weekday
	if ($surgeryWeekend == 1) {
		$surgeryWeekend = 'on a weekend';
	}
	else if ($surgeryWeekend == 0) {
		$surgeryWeekend = 'on a weekday';
	}
	else if ($surgeryWeekend == 'missing') {
		$surgeryWeekend = 'today';
	}
	
	// Transfer or Non-Transfer
	if ($transfer == 1) {
		$transfer = 'transfer';
	}
	else if ($transfer == 0) {
		$transfer = 'non-transfer';
	}
	
	// Emergent or elective
	if ($emergent == 1) {
		$emergent = 'emergent';
	}
	else if ($emergent == 0) {
		$emergent = 'elective';
	}
	
	// Primary procedure missing?
	if ( $primaryProcedureDescription == 'missing' ) {
		$primaryProcedureDescription = 'unspecified primary procedure';
	}
	
	// More than 1 Blood Test?
	if ($bloodTests == 1) {
		$bloodTests = 'was 1 blood HGB test';
	}
	else {
		$bloodTests = 'were '.$bloodTests.' blood HGB tests';
	}
	
	// More than 1 Urine Test?
	if ($urineTests == 1) {
		$urineTests = '1 urine HGB test';
	}
	else {
		$urineTests = $urineTests.' urine HGB tests';
	}
	
	// Urine glucose missing?
	if ( $urineGlucose == 'missing') {
		$urineGlucose = 'not available';
	}
	// Urine hemoglobin missing?
	if ( $urineHemoglobin == 'missing') {
		$urineHemoglobin = 'not available';
	}
	// eGFR missing?
	if ( $estimatedGfr == 'missing' ) {
		$estimatedGfr = 'not available';
	}
	// Ratio ref Cr missing?
	if ( $mdrdCreatinine == 'missing' ) {
		$mdrdCreatinine = 'not available';
	}
	// Payer
	if ( $payer == 'Uninsured' ) {
		$payer = 'no';
	}
	// County missing?
	if ( $county == 'missing' ) {
		$county = 'not available';
	}
	// Population missing?
	if ( $population == 'missing' ) {
		$population = 'not available';
	}
	// Black population percentage missing?
	if ( $propBlack == 'missing' ) {
		$propBlack = 'not available';
	}
	// Hispanic population percentage missing?
	if ( $propHisp == 'missing' ) {
		$propHisp = 'not available';
	}
	// Median income missing?
	if ( $medianIncome == 'missing' ) {
		$medianIncome = 'not available';
	}
	// Percent below poverty line missing?
	if ( $percBelowPoverty == 'missing' ) {
		$percBelowPoverty = 'not available';
	}
	
	// Build medications list
	if ($ACEInhibitors == 1) {
		$medications = $medications."ACE Inhibitors</br>";
		$admissionMeds++;
	}
	if ($aminoglycosides == 1) {
		$medications = $medications."Aminoglycosides</br>";
		$admissionMeds++;
	}
	if ($antiemetics == 1) {
		$medications = $medications."Antiemetics</br>";
		$admissionMeds++;
	}
	if ($aspirin == 1) {
		$medications = $medications."Aspirin</br>";
		$admissionMeds++;
	}
	if ($betaBlockers == 1) {
		$medications = $medications."Beta Blockers</br>";
		$admissionMeds++;
	}
	if ($bicarbonates == 1) {
		$medications = $medications."Bicarbonates</br>";
		$admissionMeds++;
	}
	if ($corticosteroids == 1) {
		$medications = $medications."Corticosteroids</br>";
		$admissionMeds++;
	}
	if ($diuretics == 1) {
		$medications = $medications."Diuretics</br>";
		$admissionMeds++;
	}
	if ($nephrotoxic > 0) {
		$medications = $medications.$nephrotoxic." Nephrotoxic Drugs</br>";
		$admissionMeds++;
	}
	if ($nsaids == 1) {
		$medications = $medications."Nonsteroidal Anti-Inflammatory Drugs</br>";
		$admissionMeds++;
	}
	if ($pressorsInotropes == 1) {
		$medications = $medications."Pressors or Inotropes</br>";
		$admissionMeds++;
	}
	if ($statins == 1) {
		$medications = $medications."Statins</br>";
		$admissionMeds++;
	}
	if ($vancomycin == 1) {
		$medications = $medications."Vancomycin</br>";
		$admissionMeds++;
	}
	
	// Admission meds?
	if ($admissionMeds == 0) {
		$admissionMeds = '';
	}
	else {
		$admissionMeds = 'Medicines taken within the past one year are:'."</br>";
	}

	if ($numMeds == 0) {
		$medications = "The patient has taken no medications within the past year. "
		."</br></br>";
	}
	else {
		$medications = $medications."</br> Within the past one year, the number of "
		."nephrotoxic medications taken were ".$nephrotoxic.", and the total number of "
		."medications taken were ".$numMeds.".</br></br>";
	}
	
	// Urine protein strip absent?
	if ($urineProtein == 0) {
		$urineProtein = 'absent';
	}
	
	// If race = other, adjust text accordingly.
	if ( $patientRace = 'Other' ) {
		$patientRace = '';
		$patientSex = $patientSex.' of Other race';
	}
	else if  ( $patientRace = 'missing' ) {
		$patientRace = '';
		$patientSex = $patientSex.' of unknown race';
	}

	$patientDetailsText1 = 'Your patient is a(n) '.$patientAge.' year old '.$patientRace
							.' '.$patientSex.' with a Charlson comorbidity index of '.$cci
							.'. The patient has a history of '.$comorbidityCount."</br>";
	
	$patientDetailsText2 = 'The patient was admitted to the hospital '.$surgeryTime.' '
		.' '.$surgeryWeekend.' from a '.$transfer.' admission setting, and'
		.' is scheduled to have an '.$emergent.' '.$surgeryType.' surgery, specifically a(n) '
		.$primaryProcedureDescription.'. Within one week of surgery there '.$bloodTests.' and '.$urineTests
		.', and the average laboratory values are as follows: HGB '.$averageLabValues.' (g/dl)'
		.', serum platelets '.$serumPlatelets.' (thou/mm'."<sup>3</sup>".'), erythrocyte count '
		.$redBloodCount.' (million/UI), and hematocrit '.$hematocrit.' (%), while the highest urine glucose level is '
		.$urineGlucose.', and the highest urine hemoglobin level is '.$urineHemoglobin
		.'. And within one year, urine protein strip test analysis is '.$urineProtein
		.'. The estimated GFR is '.$estimatedGfr.' (ml/min/1.72.m'."<sup>2</sup>".') while the ratio of reference '
		.'creatinine to MDRD creatinine is '.$mdrdCreatinine.'. '.$admissionMeds.$medications;
	
	
	
	// Rural or urban
	if ($rural == 1) {
		$rural = 'rural';
	}
	else if ($rural == 0) {
		$rural = 'urban';
	}

	$patientDetailsText3 = 'The patient has '.$payer.' insurance and resides in '
	.$county.' county in a(n) '.$rural.' area with a total population of '.$population
	.'. The percentage of African-Americans and Hispanics in the patient\'s neighborhood'
	.' is '.$propBlack.'% and '.$propHisp.'%, respectively. The overall median income '
	.'for their neighborhood is $'.$medianIncome.', and '.$percBelowPoverty.'% of the '
	.'population lives below the poverty level.';
	
	$patientDetailsTextFull = $patientDetailsText1.$comorbidities."<br/>"
							.$patientDetailsText2.$patientDetailsText3;
	*/
?>