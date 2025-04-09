<?PHP

// Database credentials
define('DBNAME', "example");
define('DBUSR', "root");
define('DBPWD', "example");
define("DBHOST", "db");

// Master crypto keys
define('MASTERIV', base64_decode('c8d1f+3prsU2ptQ=='));
define('MASTERKEY', base64_decode('DIwBUwTEpTIrrPLHNygmLg=='));

// Developper IP's get access in-game when game is set offline
define('DEV_IPS', json_encode(
    array("127.0.0.1", "::1")
));

// PayPal Config
define('PP_SANDBOX', false);
$client = PP_SANDBOX === true ?
    "" : // sandbox
    ""; // live
$secret = PP_SANDBOX === true ?
    "" : // sandbox
    ""; //live
$buttonID = PP_SANDBOX === true ? "SANDBOX_BUTTON_ID" : "9YFKWYW4653VW";
$env = PP_SANDBOX === true ? "sandbox" : "production";
define('PP_CLIENT', $client);
define('PP_SECRET', $secret);
define('PP_ENV', $env);
define('PP_BTN_ID', $buttonID);
$client = $secret = $env = $buttonID = null;

define("tebex_secret", "");
