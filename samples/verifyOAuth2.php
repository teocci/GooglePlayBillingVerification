<?php
/**
 * Created by IntelliJ IDEA.
 * User: teocci
 * Date: 5/16/18
 * Time: 2:52 PM
 */

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../library/GooglePlay/Developer/Validator.php';


// google authencation
$applicationName = 'xxxxxx';
$scope = ['https://www.googleapis.com/auth/androidpublisher'];
$configLocation = 'googleapi.json';

// receipt data
$packageName = 'xxxxx';
$productId = 'xxxxx';
$purchaseToken = 'xxxxx';
$client = new \Google_Client();
$client->setApplicationName($applicationName);
$client->setAuthConfig($configLocation);
$client->setScopes($scope);


$validator = new Validator(new \Google_Service_AndroidPublisher($client));
try {
    $response = $validator->setPackageName($packageName)->setProductId($productId)->setPurchaseToken($purchaseToken)->validatePurchase();
} catch (Exception $e) {
    echo 'got error = ' . $e->getMessage() . PHP_EOL;
}