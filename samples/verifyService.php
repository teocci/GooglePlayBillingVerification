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
require_once __DIR__ . '/../library/GooglePlay/Validator.php';


$root = realpath(dirname(dirname(__FILE__)));

echo $root;

$library = "$root/library";
$path = array($library, get_include_path());
set_include_path(implode(PATH_SEPARATOR, $path));


use ReceiptValidator\GooglePlay\Validator as Validator;

// google authentication
$applicationName = 'xxxxxx';
$scope = [Google_Service_AndroidPublisher::ANDROIDPUBLISHER];
$configLocation = 'google_service.json';

// receipt data
$packageName = 'kseek.stime';
$productId = 'heart_10';
$purchaseToken = 'daegknfedaiepglhaljnhmld.AO-J1Oy0ty5TwQQAJbjOn5Ruvk9_PBlbRw20WGW_q1LRVzPHhfWAvSIe91IXJHYLGkSye8OXeytK2oGAG3E5ICuf37Fs6YDvb_bkuJl2nevPwicrvasWiPU';
$client = new \Google_Client();


if ($credentialsFile = checkServiceAccountCredentialsFile()) {
    // set the location manually
    $client->setAuthConfig($credentialsFile);
} elseif (getenv('GOOGLE_APPLICATION_CREDENTIALS')) {
    // use the application default credentials
    $client->useApplicationDefaultCredentials();
} else {
    echo missingServiceAccountDetailsWarning();
    return;
}

$client->setApplicationName($applicationName);
$client->setAuthConfig($configLocation);
$client->setScopes($scope);


$validator = new Validator(new \Google_Service_AndroidPublisher($client));
try {
    $response = $validator->setPackageName($packageName)->setProductId($productId)->setPurchaseToken($purchaseToken)->validatePurchase();
    echo 'Purchase State = ' . $response->getPurchaseState() ? 'Completed' : 'Canceled';
} catch (Exception $e) {
    echo 'got error = ' . $e->getMessage() . PHP_EOL;
}

function checkServiceAccountCredentialsFile()
{
    // service account credentials
    $app_credentials = __DIR__ . '/google_service.json';
    return file_exists($app_credentials) ? $app_credentials : false;
}

function missingServiceAccountDetailsWarning()
{
    $ret = "
    <h3 class='warn'>
      Warning: You need download your Service Account Credentials JSON from the
      <a href='http://developers.google.com/console'>Google API console</a>.
    </h3>
    <p>
      Once downloaded, move them into the root directory of this repository and
      rename them 'service-account-credentials.json'.
    </p>
    <p>
      In your application, you should set the GOOGLE_APPLICATION_CREDENTIALS environment variable
      as the path to this file, but in the context of this example we will do this for you.
    </p>";
    return $ret;
}