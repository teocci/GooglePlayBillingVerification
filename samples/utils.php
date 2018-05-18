<?php
/**
 * Created by IntelliJ IDEA.
 * User: teocci
 * Date: 5/18/18
 * Time: 4:16 PM
 */



/**
 * Builds the redirect uri.
 * Documentation: https://developers.google.com/api-client-library/python/auth/installed-app#choosingredirecturi
 * Hostname and current server path are needed to redirect to verifyOAuth2.php
 * @return string redirect uri.
 */
function getRedirectUri()
{
    //Building Redirect URI
    $url = $_SERVER['REQUEST_URI'];                    //returns the current URL
    if (strrpos($url, '?') > 0) {
        $url = substr($url, 0, strrpos($url, '?'));  // Removing any parameters.
    }
    $folder = substr($url, 0, strrpos($url, '/'));   // Removing current file.

    return (isset($_SERVER['HTTPS']) ? "https" : "http") . '://' . $_SERVER['HTTP_HOST'] . $folder . '/verifyOAuth2.php';
}

/**
 * @param $url
 * @return bool|mixed
 */
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