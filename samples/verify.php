<?php
/**
 * Created by IntelliJ IDEA.
 * User: teocci
 * Date: 5/11/18
 * Time: 5:26 PM
 */

set_include_path(get_include_path() . PATH_SEPARATOR . '../library');

require_once 'GooglePlay/Billing/GoogleResponseData.php';
require_once 'GooglePlay/Billing/GoogleResponseValidator.php';

//Your key, copy and paste from https://market.android.com/publish/editProfile
define('PUBLIC_KEY', '');
//Your app's package name, e.g. com.kseek.thankyouage
define('PACKAGE_NAME', '');

$order = '';
//The | delimited response data from the licensing server
$responseData = '';
//The signature provided with the response data (Base64)
$signature = '';

//if you wish to inspect or use the response data, you can create
//a response object and pass it as the first argument to the Validator's verify method
//$response = new AndroidMarket_Licensing_ResponseData($responseData);
//$valid = $validator->verify($response, $signature);

$validator = new GooglePlayResponseValidator(PUBLIC_KEY, PACKAGE_NAME);
$valid = $validator->verify($order, $responseData, $signature);

var_dump($valid);
