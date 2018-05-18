### Google Play Billing Verification (GPBV)

[![Twitter][1]][2]

Google Play Billing Verification (GPBV) is a simple PHP library for verifying responses from the Google Play In-App billing service by verifying responses signed using public-key cryptography. You can check whether a user has genuinely purchased your application based on the [Google APIs from PHP][9]. 

### Disclaimer

This repository contains a simple sample code intended to demonstrate the capabilities of [Google APIs from PHP][9]. It is not intended to be used as-is in applications as a library dependency, and will not be maintained as such. Bug fix contributions are welcome, but issues and feature requests will not be addressed.

### Summary

You can use this library to validate market responses before allowing a user to download files from your server or access restricted content. It is PEAR compliant (PSR-0) and can easily be integrated with your server-side applications. [More information here][6]

The following query shows that the main parameters are `packageName`, `productId`, and `token`.

```
GET https://www.googleapis.com/androidpublisher/v3/applications/packageName/purchases/products/productId/tokens/token
```

## Google In-app-Billing Set Up

### Authorization
The Google PHP Client Library supports several methods for making authenticated calls to the Google APIs.

* OAuth 2.0 Service Accounts (Recommended)
* OAuth 2.0 For Web Server Applications
* Simple API Access (Not enough grants for these kind of request)

#### OAuth 2.0 Service Accounts for Server to Server Applications (verifyService.php)
To support server-to-server interactions, first create a service account for your project in the API Console. If you want to access user data for users in your Google Apps domain, then delegate domain-wide access to the service account.

Then, your application prepares to make authorized API calls by using the service account's credentials to request an access token from the OAuth 2.0 auth server.

Finally, your application can use the access token to call Google APIs.

##### Creating a service account
A service account's credentials include a unique generated email address, a client ID, and one public/private key pair. *If your application runs on Google App Engine, a service account is set up automatically when you create your project.*

If your application does not run on Google App Engine or Google Compute Engine, you must obtain these credentials in the Google API Console. To generate service-account credentials, or to view the public credentials that you've already generated, do the following:

1. Open the Service accounts page. If prompted, select a project.
2. Click Create service account.
3. In the Create service account window, type a name for the service account, and select Furnish a new private key.
4. Rename the downloaded json file as `google_service.json` and use it with the `verifyService.php` in the `samples` directory.

Finally, your new public/private key pair is generated and downloaded; it serves as the **only copy** of this key. You are responsible for storing it securely.

#### OAuth 2.0 For Webs Server Applications (verifyOAuth2.php)

This OAuth 2.0 flow is specifically for user authorization. It is designed for applications that can store confidential information and maintain state. A properly authorized web server application can access an API while the user interacts with the application or after the user has left the application.

##### Create authorization credentials
Any application that uses OAuth 2.0 to access Google APIs must have authorization credentials that identify the application to Google's OAuth 2.0 server. The following steps explain how to create credentials for your project. Your applications can then use the credentials to access APIs that you have enabled for that project.

1. Open the [Credentials page][10] in the API Console.
2. Click **Create credentials** > **OAuth client ID**.
3. Complete the form. Set the application type to `Web application`. For testing this example, you must specify authorized redirect URIs. The redirect URIs are the endpoints to which the OAuth 2.0 server can send responses. You should specify URIs that refer to the local machine, such as http://localhost:8000, http://localhost:8000/verifyOAuth2.php.
4. After creating your credentials, download the client secrets as a JSON file and securely store it in a location that only your application can access. Rename the downloaded json file as `google_api.json` and use it with the `verifyOAuth2.php` in the `samples` directory.

We recommend that you design your app's auth endpoints so that your application does not expose authorization codes to other resources on the page.


#### Manual OAuth 2.0 For Webs Server Applications (verifyOAuth2WithRefreshToken.php)

To check expiration date or auto renewal status of an Android subscription, you should first setup the access to the Google Play Store API. You should follow these steps:

##### Part 1 - Get ClientID and ClientSecret 
1. Go to https://play.google.com/apps/publish/
2. Click on `Settings`
3. Click on `API Access`
4. There should be a linked project already, if not, create one. If you have it, click it.
* You should now be at: https://console.developers.google.com/apis/library?project=xxxx
5. Under Mobile API's, make sure "Google Play Developer API is enabled".
6. Go back, on the left click on `Credentials`
7. Click `Create Credentials` button
8. Choose `OAuth Client ID`
9. Choose `Web Application`
 * Give it a name, skip the `Authorized JS origins`
 * Add this to `Authorized Redirect URIs`: https://developers.google.com/oauthplayground
 * After creating your credentials, download the client secrets as a JSON file and securely store it in a location that only your application can access. Rename the downloaded json file as `google_api.json` and use it with the `verifyOAuth2WithRefreshToken.php` in the `samples` directory.

##### Part 2 - Get Access and Refresh Tokens
1. Go to: https://developers.google.com/oauthplayground
2. On the right, hit the gear/settings.
3. Check the box: `Use your own OAuth credentials`
	* Enter in clientID and clientSecret
	* Close
4. On the left, find "Google Play Developer API v3"
 * Select "https://www.googleapis.com/auth/androidpublisher"
5. Hit Authorize Api's button
6. Save `Authorization Code` 
 * This is your: **googleAccToken**
7. Hit `Exchange Authorization code for token`
8. Grab: `Refresh Token`
 * This is your: **googleRefToken**
9. Replace the `$refreshToken`'s value in `verifyOAuth2WithRefreshToken.php` in the `samples` directory.

Now you are able to query for Android subscription status!


**NOTE:** The public key string you copy from the Developer Console account is actually a base64 string. You do **NOT** have to convert this to anything yourself. The module converts it to the public key automatically for you.


### Pre-requisites
    
The only requirements for this library are PHP compiled with OpenSSL support, and a PHP version of 7.0 or higher. If you want to run the unit tests you will need PHPUnit 3.5 or later.

#### Composer
The preferred method is via composer. Follow the [installation instructions][11] if you do not already have composer installed.

Once composer is installed, execute the following command in your project root to install this library:

```
composer require google/apiclient:^2.0
```

#### Samples
See the `samples/` directory for examples of the key client features. You can view them in your browser by running the php built-in web server.

```
$ php -S localhost:8000 -t examples/
```

And then browsing to the host and port you specified (in the above example, http://localhost:8000).

You can run `verifyService.php` as a bash process with this command:

```
php -q verifyService.php start
```

## Credits

* [OpenSSL][3]  is a robust, commercial-grade, and full-featured toolkit for the Transport Layer Security (TLS) and Secure Sockets Layer (SSL) protocols. 
* [android-market-license-verification][4]
* [Google APIs from PHP][9]

## License

The code supplied here is covered under the MIT Open Source License.


  [1]: https://img.shields.io/badge/Twitter-@Teocci-blue.svg?style=flat
  [2]: http://twitter.com/teocci
  [3]: https://php.net/openssl
  [4]: https://code.google.com/p/android-market-license-verification/
  [5]: hhttp://developer.android.com/guide/google/play/billing/index.html
  [6]: https://developers.google.com/android-publisher/api-ref/purchases/products/get
  [7]: https://developer.android.com/google/play/billing/billing_integrate.html#billing-security
  [8]: https://github.com/google/google-api-php-client
  [9]: https://developers.google.com/api-client-library/php/
  [10]: https://console.developers.google.com/apis/credentials
  [11]: https://getcomposer.org/doc/00-intro.md


