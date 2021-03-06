<?php
// Include the composer Autoloader
// The location of your project's vendor autoloader.
$composerAutoload = __DIR__. '/autoload.php';
if (!file_exists($composerAutoload)) 
{
    echo "The 'vendor' folder is missing. You must run 'composer update' to resolve application dependencies.\nPlease see the README for more information.\n";
    exit(1);
}
require $composerAutoload;
require __DIR__ . '/common.php';

use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

error_reporting(E_ALL);
ini_set('display_errors', '1');

// Replace these values by entering your own ClientId and Secret by visiting https://developer.paypal.com/webapps/developer/applications/myapps
$clientId       = 'AQTmuXv3b_AC_GBMrw7Mw53pWDUmpjbQI68g8ndsrxqXIFa4ORLQfj-5Pc0Vtko0tSBWUPpFuaG06m8J';  //test credentials
$clientSecret   = 'EPRH1_YreHhUscH0WTc3usDSfPWUE3FdkBUsjehKkKxB-vli_AbcOYxoKqj7OnbYdFTUc79yVcCi9oKQ';   // test credentials
//$clientId = 'AZSURibGprhN1hx1hxMOJ_AnClc5dy7eamJeWdjcllzY6tQe7K0oRIikKKs9ntzh_n_lrEphL0c72h8G';       // live credentials
//$clientSecret = 'ECIKmjLENYkRES6wbOp3PwtwYKy4kOhPvRRGUBdpJ8-pTcv1EefMYUpjMOI50l170TbpAjLYWZJZyMdB';   // live credentials

/** @var \Paypal\Rest\ApiContext $apiContext */
$apiContext = getApiContext($clientId, $clientSecret);
return $apiContext;
/**
 * Helper method for getting an APIContext for all calls
 * @param string $clientId Client ID
 * @param string $clientSecret Client Secret
 * @return PayPal\Rest\ApiContext
 */
function getApiContext($clientId, $clientSecret)
{
    // ### Api context
    // Use an ApiContext object to authenticate
    // API calls. The clientId and clientSecret for the
    // OAuthTokenCredential class can be retrieved from
    // developer.paypal.com
    $apiContext = new ApiContext(
        new OAuthTokenCredential(
            $clientId,
            $clientSecret
        )
    );
    // Comment this line out and uncomment the PP_CONFIG_PATH
    // 'define' block if you want to use static file
    // based configuration
    $apiContext->setConfig(
        array(
            'mode' => 'SANDBOX',   // use sandbox for testing, LIVE for on
            'log.LogEnabled' => true,
            'log.FileName' => 'PayPal.log',
            'log.LogLevel' => 'DEBUG', // PLEASE USE `FINE` LEVEL FOR LIVE ELSE USE 'DEBUG' FOR TESTING
            'validation.level' => 'log',
            'cache.enabled' => true,
        )
    );
    // Partner Attribution Id
    // Use this header if you are a PayPal partner. Specify a unique BN Code to receive revenue attribution.
    // To learn more or to request a BN Code, contact your Partner Manager or visit the PayPal Partner Portal
    // $apiContext->addRequestHeader('PayPal-Partner-Attribution-Id', '123123123');
    return $apiContext;
}
