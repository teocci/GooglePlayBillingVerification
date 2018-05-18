<?php
/**
 * Created by IntelliJ IDEA.
 * User: teocci
 * Date: 5/16/18
 * Time: 2:52 PM
 */

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../library/GooglePlay/Validator.php';

session_start();

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

$root = realpath(dirname(dirname(__FILE__)));

//echo $root;

$library = "$root/library";
$path = array($library, get_include_path());
set_include_path(implode(PATH_SEPARATOR, $path));


use ReceiptValidator\GooglePlay\Validator as Validator;

// google authentication
$applicationName = 'xxxxxx';
$configLocation = 'google_api.json';
$tokenLocation = 'token.json';
$scope = [Google_Service_AndroidPublisher::ANDROIDPUBLISHER];
$redirectURL = getRedirectUri();


$client = new \Google_Client();
$client->setApplicationName($applicationName);
$client->setAuthConfig($configLocation);
$client->setScopes($scope);
$client->setRedirectUri($redirectURL);

// Incremental authorization
$client->setIncludeGrantedScopes(true);

// Allow access to Google API when the user is not present. 
$client->setAccessType('offline');

if (isset($_GET['code']) && !empty($_GET['code'])) {
    try {
        // Exchange the one-time authorization code for an access token
        $accessToken = $client->fetchAccessTokenWithAuthCode($_GET['code']);

        // Save the access token and refresh token in local filesystem
        file_put_contents($tokenLocation, json_encode($accessToken));

        $_SESSION['accessToken'] = $accessToken;
        header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));
        exit();
    } catch (\Google_Service_Exception $e) {
        print_r($e);
    }
}

if (!isset($_SESSION['accessToken'])) {
    $token = @file_get_contents($tokenLocation);
    if ($token == null) {
        // Generate a URL to request access from Google's OAuth 2.0 server:
        $authUrl = $client->createAuthUrl();

        // Redirect the user to Google's OAuth server
        header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
        exit();
    } else {
        $_SESSION['accessToken'] = json_decode($token, true);
    }
}

$client->setAccessToken($_SESSION['accessToken']);

/* Refresh token when expired */
if ($client->isAccessTokenExpired()) {
    // the new access token comes with a refresh token as well
    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
    file_put_contents($tokenLocation, json_encode($client->getAccessToken()));
}

validate($client);


function validate($client)
{
    // receipt data
    $packageName = 'xxxxx';
    $productId = 'xxxxx';
    $purchaseToken = 'xxxxx';

    $validator = new Validator(new Google_Service_AndroidPublisher($client));
    try {
        $response = $validator->setPackageName($packageName)->setProductId($productId)->setPurchaseToken($purchaseToken)->validatePurchase();
        echo 'response = ' . $response->getPurchaseState() . PHP_EOL;
    } catch (Exception $e) {
        echo 'got error = ' . $e->getMessage() . PHP_EOL;
    }
}