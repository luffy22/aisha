<?php
// 1. Autoload the SDK Package. This will include all the files and classes to your autoloader
// Used for composer based installation
require __DIR__  . '/vendor/autoload.php';
// Use below for direct download installation
// require __DIR__  . '/PayPal-PHP-SDK/autoload.php';
// After Step 1
$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'AQTmuXv3b_AC_GBMrw7Mw53pWDUmpjbQI68g8ndsrxqXIFa4ORLQfj-5Pc0Vtko0tSBWUPpFuaG06m8J',     // ClientID
        'ENK7itoOD2FFbOikvfCm70scARdRVZkSrh-IghH3Z01_jPClOcFSaRMVURvsUx7vdElbN8uYgu5K5gUG'      // ClientSecret
    )
);
$apiContext->setConfig(
  array(
    'log.LogEnabled' => true,
    'log.FileName' => 'PayPal.log',
    'log.LogLevel' => 'FINE'
  )
);
