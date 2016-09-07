<?php
/**
* @package   oriente Template
* @file      default.php
* @version   1.5.0 May 2010
* @author    Oriente http://www.oriente.com.br
* @copyright 
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// include YOOmenu system
require_once(dirname(__FILE__).'/yoomenu.php');

// render YOOmenu
$yoomenu = &YOOMenu::getInstance();
$yoomenu->setParams($params);
$yoomenu->render($params, 'YOOMenuDefaultDecorator');

?>