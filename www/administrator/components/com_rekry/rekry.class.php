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

function startTekTable() {
global $mosConfig_live_site;
echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\" style=\"border: 1px #666666 solid;\">"
    ."<tr><td colspan=\"2\" style=\"background-image: url($mosConfig_live_site/administrator/templates/joomla_admin/images/background.jpg);\">"
	."rekry!Joom</td></tr>"
	."<tr></table>"
    ."<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"15\" style=\"border: 2px #220000 solid;\" bgcolor=\"#888888\">"
    ."<tr>"
	."<td bgcolor=\"#eeeeee\" valign=\"top\">"; 
}

function endTekTable() { 
echo '</td></tr></table>';
	}

function oppmenu() {
 echo '<table border="0" width="100%" ellspacing="0" cellpadding="0">
<tr>
  <td>
		<div style="float: left; border: 1px #ccc solid; background-color: #eee; padding: 10px; margin: 5px;"><a href="index2.php?option=com_rekry&task=newO">New Opportunity</a></div>
   </td>
</tr>
</table>';
}

?>
