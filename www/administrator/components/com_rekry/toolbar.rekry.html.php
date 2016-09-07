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
 * @contibutors    none
 */ 

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );

class TOOLBAR_users {
	/**
	* Draws the menu to edit a user
	*/

	function _EDIT() {
		mosMenuBar::startTable();
		mosMenuBar::save();
		mosMenuBar::spacer();
		mosMenuBar::cancel();
		mosMenuBar::endTable();
	}

	function _DEFAULT() {
		mosMenuBar::startTable();
		mosMenuBar::endTable();
	}
	
}

?>