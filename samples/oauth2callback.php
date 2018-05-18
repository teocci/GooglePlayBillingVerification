<?php
/**
 * Created by IntelliJ IDEA.
 * User: teocci
 * Date: 5/17/18
 * Time: 4:38 PM
 */

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/utils.php';

session_start();

$scope = [Google_Service_AndroidPublisher::ANDROIDPUBLISHER];
$configLocation = 'google_api.json';

$client = new Google_Client();
$client->setAuthConfig($configLocation);
$client->setRedirectUri(getRedirectUri());
$client->addScope($scope);

if (!isset($_GET['code'])) {
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
    $client->fetchAccessTokenWithAuthCode($_GET['code']);
    // Add access token and refresh token to session.
    $_SESSION['access_token'] = $client->getAccessToken();
    $_SESSION['refresh_token'] = $client->getRefreshToken();
    //Redirect back to main script
    $redirect_uri = str_replace("oauth2callback.php", $_SESSION['mainScript'], getRedirectUri());
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}