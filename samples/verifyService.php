<?php
/**
 * Created by IntelliJ IDEA.
 * User: teocci
 * Date: 5/16/18
 * Time: 2:52 PM
 */

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../library/GooglePlay/Developer/Validator.php';


$root = realpath(dirname(dirname(__FILE__)));

echo $root;

$library = "$root/library";
$path = array($library, get_include_path());
set_include_path(implode(PATH_SEPARATOR, $path));


use ReceiptValidator\GooglePlay\Validator as Validator;

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