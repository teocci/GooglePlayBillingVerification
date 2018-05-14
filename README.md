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


