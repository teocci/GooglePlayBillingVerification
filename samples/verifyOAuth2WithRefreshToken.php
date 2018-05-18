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
$refreshToken = ['xxxxxx'];
$scope = [Google_Service_AndroidPublisher::ANDROIDPUBLISHER];

$client = new \Google_Client();
$client->setApplicationName($applicationName);
$client->setAuthConfig($configLocation);
$client->setScopes($scope);

// Incremental authorization
$client->setIncludeGrantedScopes(true);

// Allow access to Google API when the user is not present. 
$client->setAccessType('offline');

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    validate($client);
} else {
    $client->fetchAccessTokenWithRefreshToken($refreshToken);
    $_SESSION['access_token'] = $client->getAccessToken();
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

function getUrlContent($url)
{
    $name = 'xxxx';
    $ip = 'xxxx';

    $data = array(
        'name' => $name,
        'ip' => $ip,
        'text' => "text"
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $data = curl_exec($ch);
    $responseCode = curl_getinfo($ch);
    curl_close($ch);
    echo '$responseCode: ' . PHP_EOL;
    print_r($responseCode);

    return ($responseCode >= 200 && $responseCode < 300) ? $data : false;
}
