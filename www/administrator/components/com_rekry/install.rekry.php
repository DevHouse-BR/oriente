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

function com_install() {
  global $database, $mosConfig_absolute_path;

  # Show installation result to user
  ?>
  <center>
  <table width="100%" border="0">
    <tr>
      <td>
        <strong>rekry!Joom</strong><br/>
      </td>
    </tr>
    <tr>
      <td background="F0F0F0" colspan="2">
        <code>Process:<br />
         <?php
echo "Start to make databese for rekry!Joom in administration backend.<br />";

          # Set up new icons for admin menu
		  
$database->setQuery("CREATE TABLE IF NOT EXISTS `jos_rekry_applications` (
  `ap_id` int(8) NOT NULL auto_increment,
  `career_fname` text NOT NULL,
  `career_lname` text NOT NULL,
  `career_add` text NOT NULL,
  `career_city` text NOT NULL,
  `career_zip` text NOT NULL,
  `career_ph` text NOT NULL,
  `career_gsm` text NOT NULL,
  `career_mail` text NOT NULL,
  `career_bdate` date NOT NULL default '0000-00-00',
  `career_gender` enum('M','F') NOT NULL default 'M',
  `career_info` text NOT NULL,
  `career_edu` text NOT NULL,
  `career_eedu` text NOT NULL,
  `career_exp` text NOT NULL,
  `career_referen` text NOT NULL,
  `career_keys` text NOT NULL,
  `career_cv` text NOT NULL,
  `op_id` int(8) NOT NULL default '0',
  `user_id` int(8) NOT NULL,
  `op_name` text NOT NULL,
  `cu_timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `int_enum` enum('true','false') NOT NULL default 'false',
  `int_date` date NOT NULL default '0000-00-00',
  `int_time` time NOT NULL default '00:00:00',
  PRIMARY KEY  (`ap_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

$result[0] = $database->query();

$database->setQuery("CREATE TABLE IF NOT EXISTS `#__rekry_career_details` (
  `id` int(11) NOT NULL auto_increment,
  `addr` varchar(40) NOT NULL,
  `address` text NOT NULL,
  `city` text NOT NULL,
  `zip` text NOT NULL,
  `phone` text NOT NULL,
  `bdate` date NOT NULL default '0000-00-00',
  `gender` enum('M','F') NOT NULL,
  `exp` text NOT NULL,
  `ext` text NOT NULL,
  `edu` text NOT NULL,
  `ref` text NOT NULL,
  `info` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `gsm` text NOT NULL,
  `latestupdate` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `cv_crypted` text NOT NULL,
  `lname` text NOT NULL,
  `fname` text NOT NULL,
  `keys` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

$result[1] = $database->query();

$database->setQuery("CREATE TABLE IF NOT EXISTS `#__rekry_opportunities` (
  `op_id` int(11) NOT NULL auto_increment,
  `op_name` varchar(255) NOT NULL default '',
  `op_desc` text NOT NULL,
  `op_company` varchar(255) NOT NULL default '',
  `op_type` varchar(255) NOT NULL default '',
  `op_start` date NOT NULL default '0000-00-00',
  `op_end` date NOT NULL default '0000-00-00',
  `company` text NOT NULL,
  `culture` text NOT NULL,
  `opportunity` text NOT NULL,
  `responsibilities` text NOT NULL,
  `required_knowledge_and_skills` text NOT NULL,
  `required_experience` text NOT NULL,
  `compensation` text NOT NULL,
  `contact` text NOT NULL,
  `edit` enum('true','false') NOT NULL default 'false',
  `emp_id` int(8) NOT NULL default '1',
  `active` enum('true','false') NOT NULL default 'false',
  `modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `deleted` enum('true','false') NOT NULL default 'false',
  PRIMARY KEY  (`op_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

$result[2] = $database->query();

$database->setQuery("CREATE TABLE IF NOT EXISTS `jos_rekry_professions` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(40) NOT NULL,
  `text` varchar(255) NOT NULL,
  `modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;");

$result[3] = $database->query();

$database->setQuery("INSERT INTO `jos_rekry_professions` (`id`, `name`, `text`, `modified`) VALUES
(1, 'None', 'None', NOW());");

$result[4] = $database->query();

          foreach ($result as $i=>$icresult) {
            if ($icresult) {
              echo "<font color='green'>FINISHED:</font> Database $i has been done.<br />";
            } else {
              echo "<font color='red'>ERROR:</font> Database $i could not be done.<br />";
            }
          }

          # Set up new icons for admin menu
          echo "Start to make menu for rekry!Joom in administration backend.<br />";
          $database->setQuery("UPDATE #__components SET admin_menu_img='js/ThemeOffice/edit.png' WHERE admin_menu_link='option=com_rekry&task=admin'");
          $iconresult[0] = $database->query();
          foreach ($iconresult as $i=>$icresult) {
            if ($icresult) {
              echo "<font color='green'>FINISHED:</font> Menu entry $i has been done.<br />";
            } else {
              echo "<font color='red'>ERROR:</font> Menu entry $i could not be done.<br />";
            }
          }

        ?>


        <font color="green"><b>Installation finished.</b></font></code>
      </td>
    </tr>
  </table>
  </center>
  <?php
}
?>
