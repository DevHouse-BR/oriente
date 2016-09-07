<?php
/**
* @package   oriente Template
* @file      default.php
* @version   1.5.0 May 2010
* @author    Oriente http://www.oriente.com.br
* @copyright 
*/

// no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<?php
srand((double) microtime() * 1000000);
$flashnum	= rand(0, $items -1);
$item		= $list[$flashnum];
modNewsFlashHelper::renderItem($item, $params, $access);
?>