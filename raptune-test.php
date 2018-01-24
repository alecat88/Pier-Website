<?php

//use nusoap library: http://sourceforge.net/projects/nusoap/ 
//tested with php 5, nusoap version 0.9.5 
require_once('lib/nusoap.php'); 

//NOTE: both parameters and values are case sensitve! 
//NOTE: the internal php class SoapClient does not work with named parameters and SOAP headers 

//prepare soap request to Rapaport: 
$rap_soapUrl = "https://technet.rapaport.com/webservices/prices/rapaportprices.asmx?wsdl"; 
$soap_Client = new nusoap_client($rap_soapUrl, 'wsdl'); 
$rap_credentials['Username'] = "73923"; 
$rap_credentials['Password'] = "villamarts"; 

//do login, and save authentication ticket for further use: 

//do login, and save authentication ticket for further use: 
$result = $soap_Client->call('Login', $rap_credentials); 
$rap_auth_ticket = $soap_Client->getHeaders(); 

//get complete price sheet, and save as a file (call this both for Round and Pear): 
$paramsB["shape"] = "Round"; 
$soap_Client->setHeaders($rap_auth_ticket); 
$result = $soap_Client->call('GetPriceSheet', $paramsB); 

$file=fopen("round_prices.csv","w+") or exit("Unable to open file!"); 



$curLine = ""; 
$curLine .= $result['GetPriceSheetResult']['!Date']; 
$curLine .= "," . $result['GetPriceSheetResult']['!Shape']; 
$curLine .= "," . $result['GetPriceSheetResult']['Prices']['diffgram']['NewDataSet']['Table'][$i]['LowSize']; 
$curLine .= "," . $result['GetPriceSheetResult']['Prices']['diffgram']['NewDataSet']['Table'][$i]['LowSize']; 
$curLine .= "," . $result['GetPriceSheetResult']['Prices']['diffgram']['NewDataSet']['Table'][$i]['Color']; 
$curLine .= "," . $result['GetPriceSheetResult']['Prices']['diffgram']['NewDataSet']['Table'][$i]['Clarity']; 
$curLine .= "," . $result['GetPriceSheetResult']['Prices']['diffgram']['NewDataSet']['Table'][$i]['Price']; 

fwrite($file, $curLine.PHP_EOL); 


fclose($file); 

?> 