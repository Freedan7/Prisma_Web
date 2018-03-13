<?php

require_once __DIR__.'/urlPath.php';
require_once __DIR__.'/RestCurl.php';
//Patient Details URL

$url = $urlPath.'patientRecords?patientId=3496';
$patient_records = $curl->getData($url);
$patient_records = json_decode($patient_records,true);

$patient_records = json_encode($patient_records);

echo $patient_records;
echo $patient_records['meddata']["u'med_order_display_name"];