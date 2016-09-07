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
 * @lead developer Matti Kiviharju matti dot kiviharju at teknologiaplaneetta dot com
 * @contibutors    none
 */ 

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );

require_once( $mainframe->getPath( 'toolbar_html' ) );

switch ( $task ) {
	case 'newO':
	case 'opv':
		TOOLBAR_users::_EDIT();
		break;

	default:
		TOOLBAR_users::_DEFAULT();
		break;
}

?>