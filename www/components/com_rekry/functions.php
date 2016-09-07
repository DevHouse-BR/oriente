<?php

/**
 * rekry!Joom for Joomla 1.0.+
 *
 * LICENSE: Open Source (GNU GPL)
 *
 * @copyright      2006-2008 Teknologiaplaneetta
 * @license        http://www.gnu.org/copyleft/gpl.html
 * @version        $Id$ 1.0.1
 * @link           http://www.teknologiaplaneetta.com/
 * @lead developer Matti Kiviharju: matti dot kiviharju at teknologiaplaneetta dot com
 * @contibutors    ArMyBoT: armybot at gmail dot com 
 */ 

# Don't allow direct linking
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

function len_limited_text($text, $limit, $tags = 0) {
    $text = trim($text);
    if ($tags == 0) $text = preg_replace('/\s\s+/', ' ', strip_tags($text));
    if (strlen($text) < $limit) return $text;
    if ($tags == 0) return substr($text, 0, $limit) . " ...";	
    else {
        $counter = 0;
        for ($i = 0; $i<= strlen($text); $i++) {
            if ($text{$i} == "<") $stop = 1;
            if ($stop != 1) {
                $counter++;
            }
            if ($text{$i} == ">") $stop = 0;
            $return .= $text{$i};
            if ($counter >= $limit && $text{$i} == " ") break;
        }
        return $return . "...";
    }
}

function encrypt_data($key, $plain_text) {
  $plain_text = trim($plain_text);
  $iv = substr(md5($key), 0,mcrypt_get_iv_size (MCRYPT_BLOWFISH,MCRYPT_MODE_CFB));
  $c_t = mcrypt_cfb (MCRYPT_BLOWFISH, $key, $plain_text, MCRYPT_ENCRYPT, $iv);
  return base64_encode($c_t); 
}

function decrypt_data($key, $c_t) {
  $c_t = base64_decode($c_t);
  $iv = substr(md5($key), 0,mcrypt_get_iv_size (MCRYPT_BLOWFISH,MCRYPT_MODE_CFB));
  $p_t = mcrypt_cfb (MCRYPT_BLOWFISH, $key, $c_t, MCRYPT_DECRYPT, $iv);
  return trim($p_t);
}
	
?>