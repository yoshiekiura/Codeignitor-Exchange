<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// hard - cannot changed from code
// app constants 
defined('APP_BASE_URL')      OR define('APP_BASE_URL', base_url());
defined('APP_COMPANY_NAME')  OR define('APP_COMPANY_NAME', 'GuldenTrader');
defined('APP_LOGO')          OR define('APP_LOGO', base_url().'images/logo.png');
defined('APP_TITLE') 	     OR define('APP_TITLE', 'GuldenTrader.com');
defined('APP_ADMIN_EMAIL') 	 OR define('APP_ADMIN_EMAIL', 'exchange@guldentrader.com');
defined('APP_SMTP_HOST') 	 OR define('APP_SMTP_HOST', 'mail.guldentrader.com');
defined('APP_SMTP_USER') 	 OR define('APP_SMTP_USER', 'exchange@guldentrader.com');
defined('APP_SMTP_PASS') 	 OR define('APP_SMTP_PASS', '3PrVPkeB');
defined('APP_SMTP_PORT') 	 OR define('APP_SMTP_PORT', 587);
defined('APP_CHARSET') 		 OR define('APP_CHARSET', 'UTF-8');
defined('APP_RECAPTCHA') 	OR define('APP_RECAPTCHA', '6LcYRhoUAAAAANIWpNkhwHEXxvhlDHlQtAUlxo7C');


defined('GULDEN_USER') 	OR define('GULDEN_USER', 'GC_rpc');
defined('GULDEN_PASSWORD') 	OR define('GULDEN_PASSWORD', '75KH7EAhL2R6GNMe5BcSramQTciMDeHrQcVmrjbMWGTQ');
defined('GULDEN_HOST') 	OR define('GULDEN_HOST', '127.0.0.1');
defined('GULDEN_PORT') 	OR define('GULDEN_PORT', '8332');
defined('GULDEN_ACCOUNT') 	OR define('GULDEN_ACCOUNT', 'exchange');


defined('PAYAPITOKEN') or define('PAYAPITOKEN', '323b8ef7bfc81e41cf88d63a64e3e86e5d845ab5');
defined('PAYSERVICEID') or define('PAYSERVICEID', 'SL-7450-1950');

defined('FEE') or define('FEE', '0.25');
defined('MARKETS') or define('MARKETS', array('EUR-NLG', 'GTS-NLG'));


// can change this values from code
// configuration array
$config = [];