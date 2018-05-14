### Google Play Billing Verification

[![Twitter][1]][2]

Google Play Billing Verification is a simple PHP library for verifying responses from the Google Play In-App billing service. By verifying responses signed using public-key cryptography you can check whether a user has genuinely purchased your application using [OpenSSL][1] and [Google Play's In-app Billing][5]. 



### Disclaimer

This repository contains a simple sample code intended to demonstrate the capabilities of [Google Play Developer API][5]. It is not intended to be used as-is in applications as a library dependency, and will not be maintained as such. Bug fix contributions are welcome, but issues and feature requests will not be addressed.

### Summary

You can use this library to validate market responses before allowing a user to download files from your server or access restricted content. It is PEAR compliant (PSR-0) and can easily be integrated with your server-side applications. [More information here][6]

```
GET https://www.googleapis.com/androidpublisher/v3/applications/packageName/purchases/products/productId/tokens/token
```

## Google In-app-Billing Set Up

To set up your server-side Android in-app-billing correctly, you must provide the public key string as a file from your Developer Console account.

**Reference:** <a href="https://developer.android.com/google/play/billing/billing_integrate.html#billing-security">Implementing In-app Billing</a>

Once you copy the public key string from the Developer Console account for your application, you simply need to copy and paste it to a file and name it `iap-live` as shown in the example above.

**NOTE:** The public key string you copy from the Developer Console account is actually a base64 string. You do NOT have to convert this to anything yourself. The module converts it to the public key automatically for you.

### Google Play Store API

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
 * Aadd this to `Authorized Redirect URIs`: https://developers.google.com/oauthplayground
 * Hit Save and copy the **clientID** and **clientSecret** somewhere safe.

##### Part 2 - Get Access and Refresh Tokens
1. Go to: https://developers.google.com/oauthplayground
2. On the right, hit the gear/settings.
3. Check the box: `Use your own OAuth credentials`
	* Enter in clientID and clientSecret
	* Close
4. On the left, find "Google Play Developer API v2"
 * Select "https://www.googleapis.com/auth/androidpublisher"
5. Hit Authorize Api's button
6. Save `Authorization Code` 
 * This is your: **googleAccToken**
7. Hit `Exchange Authorization code for token`
8. Grab: `Refresh Token`
 * This is your: **googleRefToken**

Now you are able to query for Android subscription status!


### Pre-requisites
    
The only requirements for this library are PHP compiled with OpenSSL support, and a PHP version of 4.0.4 or higher. PHP5 works too. If you want to run the unit tests you will need PHPUnit 3.5 or later.

## Credits

* [OpenSSL][3]  is a robust, commercial-grade, and full-featured toolkit for the Transport Layer Security (TLS) and Secure Sockets Layer (SSL) protocols. 
* [android-market-license-verification][4]

## License

The code supplied here is covered under the MIT Open Source License.


  [1]: https://img.shields.io/badge/Twitter-@Teocci-blue.svg?style=flat
  [2]: http://twitter.com/teocci
  [3]: https://php.net/openssl
  [4]: https://code.google.com/p/android-market-license-verification/
  [5]: hhttp://developer.android.com/guide/google/play/billing/index.html
  [6]: https://developers.google.com/android-publisher/api-ref/purchases/products/get


