<?php

/**
 * rekry!Joom for Joomla 1.5.+
 *
 * LICENSE: Open Source (GNU GPL)
 *
 * @copyright      2006-2008 Teknologiaplaneetta
 * @license        http://www.gnu.org/copyleft/gpl.html
 * @version        $Id$ 1.0.1
 * @link           http://www.teknologiaplaneetta.com/
 * @lead developer Matti Kiviharju: matti dot kiviharju at teknologiaplaneetta dot com
 * @contibutors    none
 */ 
 
 // no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );

global $mosConfig_absolute_path, $mosConfig_live_site;

$zfLibrary = $mosConfig_absolute_path . "/administrator/components/com_rekry/library";

set_include_path('.' . PATH_SEPARATOR . $zfLibrary . PATH_SEPARATOR );

$company = 'Company Ltd';
$dateformat = 'F j, Y';
$blow_fish_key = 'sER4564GG';
$secret_cv_crypt = 'sER4564GG';
$company_email="jobs@invalid.tld";
DEFINE("_UP_MAIL_BY",utf8_encode("User updated the profile"));
DEFINE("_THANK_UP_MAIL_BY",utf8_encode("Thank you from profile update!"));
DEFINE("_RECRUITING",utf8_encode("Recruting Company Ltd"));
DEFINE("_THANK_APP_MAIL_BY",utf8_encode("Thank you from your Job Application!"));
DEFINE("_APP_MAIL_BY",utf8_encode("User applied to job oppoertunity!"));


?>