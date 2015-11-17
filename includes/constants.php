<?php
/** Database Connection Strings */
define("SITE_URL","http://localhost/iadet/");
define("MOODLE_URL","http://localhost/moodle/");
define("MOODLE_DB_PREFIX","");
define("MOODLE_DB_NAME", 'ecourse');
define("DB_NAME","iadet"); //iadet910_iadetmobile
define("DB_USER","root");//iadet910_mobile
define("DB_PASSWORD","");//@Kaiste&NstProduct2015
define("DB_SERVER","localhost");
define("__ROOT__",dirname(dirname(__FILE__)));
define("CLASSES_PATH", __ROOT__.'/classes/');
define("DB_CONFIG_FILE", __ROOT__.'/DbConfig/Database.php');
define("MEDIA_FILES_PATH", '../media/');
define("FACEBOOK_APP_ID", "");
define("FACEBOOK_ADMINS", "");
define("TWITTER_ID", "");
define("WEBSITE_AUTHOR", "International Academy of Dental Education and Training (IADET)");

//PAYPAL CONSTATNTS
define('CLIENT_ID', 'AbpKwVx3-qwJC_tTshsrw_lY55KehDwCJ1xMb1Fxtn66U-2P4EPGpnkwWotmoFn5qeTjOa2nEq29Bout'); //your PayPal client ID
define('CLIENT_SECRET', 'ECf-EvTXsHaYF3mtnovh8LEAKGR6b3g6CxHc7IGyOF5qOgKJgaeiP4shtMzoUkAgoDrhF22AmnlJo2xx'); //PayPal Secret
define('RETURN_URL', 'http://localhost/iadet/paypal/order-process.php'); //order_process.php//return URL where PayPal redirects user
define('CANCEL_URL', 'http://localhost/iadet/payment-cancel'); //cancel URL
define('PP_CURRENCY', 'GBP'); //Currency code
define('PP_CONFIG_PATH', 'C://wamp/www/iadet/paypal/'); //PayPal config path (sdk_config.ini)

// context definitions for moodle database
define('CONTEXT_SYSTEM', 10);
define('CONTEXT_PERSONAL', 20);
define('CONTEXT_USER', 30);
define('CONTEXT_COURSECAT', 40);
define('CONTEXT_COURSE', 50);
define('CONTEXT_GROUP', 60);
define('CONTEXT_MODULE', 70);
define('CONTEXT_BLOCK', 80);

require __ROOT__.'/password_compat/lib/password.php';
