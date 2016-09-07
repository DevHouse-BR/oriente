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
?>
<span class="breadcrumbs">
<?php for ($i = 0; $i < $count; $i ++) :

	// clean subtitle from breadcrumb
	if ($pos = strpos($list[$i]->name, '||')) {
		$name = trim(substr($list[$i]->name, 0, $pos));
	} else {
		$name = $list[$i]->name;
	}
	
	// if not the last item in the breadcrumbs add the separator
	if ($i < $count -1) {
		if(!empty($list[$i]->link)) {
			echo '<a href="'.$list[$i]->link.'" class="box-1"><span class="box-2"><span class="box-3">'.$name.'</span></span></a>';
		} else {
			echo '<span class="separator box-1"><span class="box-2"><span class="box-3">'.$name.'</span></span></span>';
		}
		//echo ' '.$separator.' ';
	} else { // when $i == $count -1
	    echo '<span class="current box-1"><span class="box-2"><span class="box-3">'.$name.'</span></span></span>';
	}	
endfor; ?>
</span>