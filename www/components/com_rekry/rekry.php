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
 * @contibutors    ArMyBoT: armybot at gmail dot com 
 */ 

# Don't allow direct linking
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

if (version_compare(phpversion(), '5.2.0', '<') === true) {
die('Sorry PHP 5.2.0 or never is needed. You have a vesion ' .phpversion(). '.' );
}

 $mainframe->addCustomHeadTag('<script type="text/javascript" src="'.$mosConfig_live_site.'/components/com_rekry/js/jquery-1.2.6.js"></script>
<script type="text/javascript" src="'.$mosConfig_live_site.'/components/com_rekry/js/ui.datepicker.js"></script>
<link rel="stylesheet" type="text/css" href="'.$mosConfig_live_site.'/components/com_rekry/css/smoothness/ui.datepicker.css" />
<link rel="stylesheet" type="text/css" href="'.$mosConfig_live_site.'/components/com_rekry/css/default.css" />');

  if (file_exists($mosConfig_absolute_path.'/components/com_rekry/functions.php')) {
  require_once($mosConfig_absolute_path."/components/com_rekry/functions.php"); }

  
# Variables - Don't change anything here!!!
  if (file_exists($mosConfig_absolute_path.'/administrator/components/com_rekry/config.rekry.php')) {
  require_once($mosConfig_absolute_path."/administrator/components/com_rekry/config.rekry.php"); } 
  
  # Zend View Template path if is not set
  if(!isset($tpl_path)) { $tpl_path = 'default'; }

  # Zend Framework config
  if (file_exists($mosConfig_absolute_path.'/administrator/components/com_rekry/zfconfig.rekry.php')) {
  require_once($mosConfig_absolute_path."/administrator/components/com_rekry/zfconfig.rekry.php"); }

require_once ('Zend/Loader.php');

Zend_Loader::loadClass('Zend_Version');

if(Zend_Version::compareVersion('1.5.2') === 1) {
    die('Sorry Zend Framework 1.5.2 is needed. You have version ' . Zend_Version::VERSION . '.');
}

/*

@todo: make vars like this here  ---->  $id = intval( mosGetParam( $_REQUEST, 'id', 0 ) ); <--

@todo: make die();s for common exploits ... if REQUEST_URI contains evil ones then die();

*/

// HMAC  
$hmac_check = mosGetParam( $_POST, 'hmac' );

$key = md5($blow_fish_key . $my->id . $my->username) ;

// OP_ID
$op_id = intval(mosGetParam( $_GET, 'op_id' ), 0);
// pagination
$page_ppp = mosGetParam( $_GET, 'page' );
// and other vars...
$Itemid = intval(mosGetParam( $_GET, 'Itemid' ), 0);
$id = intval(mosGetParam( $_GET, 'id' ), 0);
$rekryview = mosGetParam( $_GET, 'rekryview' );
$proupdate = mosGetParam( $_GET, 'proupdate' );
if(!isset($rekryview)) {$rekryview='default';}
if(!isset($page_ppp)) {$page_ppp=1;}
// uploadpath..
$uploadpath = $mosConfig_absolute_path."/administrator/components/com_rekry/uploads/";

// for security escape we change all Int / Float
// variables possible to be only Int / Float

settype($page_ppp,"float");

settype($op_id,"float");
  
  // for security we allow only chars 0-9, A-Z, a-z in this variable
  // fixing these to better
 $rekryview = preg_replace("![^0-9A-Za-z\s]!", "", strip_tags($rekryview));
 $proupdate = preg_replace("![^a-z\s]!", "", strip_tags($proupdate));
  
  // config vars
  settype($front,"float");
  settype($community,"float");
  settype($en,"float");
  settype($r1,"float");
  settype($r2,"float");
  settype($r3,"float");
  settype($r4,"float");
  settype($r5,"float");
  settype($r6,"float");
  settype($r7,"float");
  settype($r8,"float");
  settype($r9,"float");
  settype($r10,"float");
  settype($r11,"float");
  
  // en var
  if ($en == "1") { $mosConfig_lang = "english"; }
 
  //error msg
  $cverrorMsg = "";

// we setup jQuery
?>



<?php
// jQuery ends
  
# Get the right language if it exists
  if (file_exists($mosConfig_absolute_path.'/components/com_rekry/languages/'.$mosConfig_lang.'.php')) {
    include($mosConfig_absolute_path.'/components/com_rekry/languages/'.$mosConfig_lang.'.php');
  } else {
    include($mosConfig_absolute_path.'/components/com_rekry/languages/english.php');
  }

  Zend_Loader::loadClass('Zend_View');
  
# making new Zend_View 
$view = new Zend_View();
# set template script path
$view->setScriptPath($mosConfig_absolute_path.'/components/com_rekry/templates/'.$tpl_path);
$view->setEscape('htmlentities');	
$view->setEncoding('UTF-8');
$view->mosConfig_live_site = $mosConfig_live_site;

// $rekryview switch LIKE: /careers.html?rekryview=view&op_id=1

switch ($rekryview) {

case "view":

################
# ACTION VIEW
################

	    // query 
        $query = "SELECT * FROM #__rekry_opportunities WHERE op_id = ".$op_id." AND active = 'true';";

		$database->setQuery( $query );
		$rows = $database->loadObjectList();
	 
	 // making arrays for Zend_View foreach starts
	 
	 $i = 1;
	 
    foreach ( $rows as $row ) 

     { 	   
   
     // making arrays for Zend_View
	 $title['title'] = $row->op_name;
	 // making arrays for Zend_View
	 
	 if ($community == 1) { 
	 
	 if ((!$my->id)){
	 
	   $cverrorMsg = _CV_ERROR_ONLY_REGISTERED;
	
	  } else {
	  
	  	    // query 
        $sql_num = "SELECT ap_id FROM #__rekry_applications WHERE user_id = ". $my->id ." AND op_id = ".$op_id.";";

		$database->setQuery( $sql_num );
		$num_rows = $database->loadObjectList();
	  
	 
	     if (count($num_rows) > 0) { 
		 // making arrays for Zend_View 
		 $msgApplied['text'] = _you_have_app; 
		 // making arrays for Zend_View
		 } 
	 
	 }
	 
	 }
	 
     if ($r1 == 1) { 
	 $data[$i]['title'] = _RCOMPANY; 
     $data[$i]['text'] = $row->company; 
	 $i++; // importan!
	 }
		 
	 if ($r2 == 1) { 
	 $data[$i]['title'] = _RCULTURE;
	 $data[$i]['text'] =  $row->culture; 
	 $i++; // importan!
	 }
	 
	 if ($r3 == 1) { 
	 $data[$i]['title'] = _ROPPORTUNITY;
	 $data[$i]['text'] =  $row->opportunity; 
	 $i++; // importan!
	 }
	 
	 if ($r4 == 1) {  
	 $data[$i]['title'] = _RRESPONSIBILITIES;
	 $data[$i]['text'] = $row->responsibilities; 
	 $i++; // importan!
	 }
	 
	if ($r5 == 1) {  
	$data[$i]['title'] = _RSKILLS;
	$data[$i]['text'] =  $row->required_knowledge_and_skills; 
	$i++; // importan!
	}
	
	if ($r6 == 1) {  
	$data[$i]['title'] = _RREGE;
	$data[$i]['text'] = $row->required_experience; 
	$i++; // importan!
	}
	
	if ($r7 == 1) { 	
	$data[$i]['title'] = _RCOMP;
	$data[$i]['text'] = $row->compensation; 
	$i++; // importan!
	}
	
	if ($r8 == 1) {  
	$data[$i]['title'] = _RCONT;
	$data[$i]['text'] = $row->contact; 
	$i++; // importan!
	}
	
	if ($r9 == 1) {
	  
	$view_data[$i]['title'] = _RCOMPY;
	
	$query = "SELECT * FROM #__rekry_professions WHERE id = ".$row->op_company." LIMIT 1;";

	$database->setQuery( $query );
	$prorows = $database->loadObjectList();
	
	foreach ( $prorows as $prorow ) 

     { 	
	 $view_data[$i]['text'] = $prorow->name;
	 }	 
		
	$i++; // importan!
	
	}
	 
	 $ts = $row->op_start;
     $tss = explode('-',$ts) ;
	 
	if ($r10 == 1) {  
	
	$view_data[$i]['title'] = _RST;
	$view_data[$i]['text'] =  date ( _DATE_F, mktime (1,1,1,$tss[1],$tss[2],$tss[0]) );

	$i++; // importan!
	
	}
	
	 $ts = $row->op_end; 
     $tss = explode('-',$ts) ;
	 
   if ($r11 == 1) {   
   
     $view_data[$i]['title'] = _RET;
	 
   	 if ($ts == '0000-00-00') { $view_data[$i]['text'] =  _no_due; 
	 } else {
	 $view_data[$i]['text'] = date ( _DATE_F, mktime (1,1,1,$tss[1],$tss[2],$tss[0]) );
	 }
   
    $i++; // importan!
   
    }
	
	// making arrays for Zend_View

	if ($community == 1) { 
	
	if ((!$my->id)){
	
	$cverrorMsg = _CV_ERROR_ONLY_REGISTERED;
	
	     } else {
	
	if (count($num_rows) == 0) {
	
	 $link = sefRelToAbs("index.php?option=com_rekry&amp;Itemid="
	.$Itemid."&amp;rekryview=add&amp;op_id=".$op_id);
	
	 // making arrays for Zend_View
	 $AppView['link_text'] = _APOP; 
	 $AppView['link_url'] = $link;
	 // making arrays for Zend_View
	 
	        } 
	 
	 else if (count($num_rows) > 0) { } 
	 
	        }
	 
	    }
	 
	 }
	 
	 // SEO links yess...
	 $link = sefRelToAbs("index.php?option=com_rekry&amp;Itemid="
	.$Itemid);
	
	// making arrays for Zend_View
	$PubMsgView['backlink_text'] = _BACK_OP; 
	$PubMsgView['backlink_url'] = $link;
	// making arrays for Zend_View
	
	if ($community == 1) { 
	if ((!$my->id)){ 
	
	// making arrays for Zend_View
	$ErrMsgView['errmsg'] = $cverrorMsg;
	// making arrays for Zend_View
	
	}
	
// set vars for template
if (isset($data)) $view->opportunity = $data;
if (isset($title)) $view->title = $title;
if (isset($view_data)) $view->viewdata = $view_data;
if (isset($PubMsgView)) $view->backlink = $PubMsgView;

if (isset($AppView)) $view->applink = $AppView;
if (isset($msgApplied)) $view->msgapplied = $msgApplied;
if (isset($ErrMsgView)) $view->errmgs = $ErrMsgView;

// view_opportunity.php template
echo $view->render('view_opportunity.php');
	
	}
	
################
# ACTION VIEW
################
	 
break;
case "my":

################
# ACTION MY
################

if ((!$my->id)) {
	$cverrorMsg = _CV_ERROR_ONLY_REGISTERED;
} else {



	 	// query 
        $sql_r = "SELECT * FROM #__rekry_career_details WHERE user_id = ". $my->id ." LIMIT 1;";

		$database->setQuery( $sql_r );
		$sql_r = $database->loadObjectList();
	 
	 
	 
	 foreach ( $sql_r as $sql_r_row ) 
     {     
      
	  // loop for nothing but just making vars
     
	 }

$link = sefRelToAbs("index.php?option=com_rekry&Itemid=".$Itemid."&rekryview=submit&proupdate=true");

$action = $link; 

	 	# query for Values-->template 
        $sql_r = "SELECT * FROM #__rekry_career_details WHERE user_id = ". $my->id ." LIMIT 1;";

		$database->setQuery( $sql_r );
		$sql_r = $database->loadObjectList();
	 
	 
	 
	 foreach ( $sql_r as $sql_r_row ) 
     {     

     # Making-->Values-->template 
	 
	 } 

# for Firstname-->template 
$fname = _Firstname;
if (isset($sql_r_row->fname)) { 
$fnval = decrypt_data($key, pack('H*', $sql_r_row->fname)) ; } 
else { $fnval = ''; }

# for Lastname-->template 
$lname = _Lastname;  
 if (isset($sql_r_row->lname)) { 
 $lnval = decrypt_data($key, pack('H*', $sql_r_row->lname)); } 
 else { $lnval = '' ; } 
 
 # for Address-->template 
 $address =  _Address;  
 if (isset($sql_r_row->address)) {
  $aval = decrypt_data($key, pack('H*', $sql_r_row->address)); } 
  else { $aval = ''; } 
  
  # for Zip-->template 
   $zip = _Zip; 
 if (isset($sql_r_row->zip)) { 
 $zval = decrypt_data($key, pack('H*', $sql_r_row->zip)); } 
 else { $zval = ''; }  
 
 # for City-->template 
 $city =  _City;  
 if (isset($sql_r_row->city)) { 
 $cval = decrypt_data($key, pack('H*', $sql_r_row->city)); } 
 else { $cval = '';  }

# for Phone-->template 
$phone =  _Phone; 
if (isset($sql_r_row->phone)) { 
$pval = decrypt_data($key, pack('H*', $sql_r_row->phone)); } 
else { $pval = ''; } 

# for Phone-->template
$mobile = _Mobilephone; 
if (isset($sql_r_row->gsm)) { 
$mval = decrypt_data($key, pack('H*', $sql_r_row->gsm)); } 
else { $mval = ''; } 

# for Email-->template
$email = _Email; 
$emval = $my->email; 
$bdate = _Birthdate; 

# for SiteURL-->template
$siteurl = $mosConfig_live_site;

# for Bdval-->template
if (isset($sql_r_row->bdate)) { $bdval = $sql_r_row->bdate; } 
else { $bdval = ''; } 

# for Gender-->template
$gender = _Gender; 
$fm = _Female;
$mm = _Male;
if (isset($sql_r_row->gender) && $sql_r_row->gender == "M") 
{ $selm = ' selected'; } else { $selm = ''; } 
if (isset($sql_r_row->gender) && $sql_r_row->gender == "F") 
{ $self = ' selected'; } else { $self = ''; } 
	 // SEO links yess...
	 $link = sefRelToAbs("index.php?option=com_rekry&amp;Itemid="
	.$Itemid);
	
	// making arrays for Zend_View
	$PubMsgView['backlink_text'] = _BACK_OP; 
	$PubMsgView['backlink_url'] = $link;
	// making arrays for Zend_View
# for template
$cv = _Curriculum_Vitae; 
$submit = _Submit;
$reset = _Reset;
# for template
 
# for template
$tell = _Tell; 
if (isset($sql_r_row->info)) { 
$ival = decrypt_data($key, pack('H*', $sql_r_row->info)); } 
else { $ival = ''; } 
# for template
$edu = _Education; 
if (isset($sql_r_row->edu)) { 
$eduval = decrypt_data($key, pack('H*', $sql_r_row->edu)); } 
else { $eduval = ''; }
# for template
 $eedu = _Extra_courses; 
 if (isset($sql_r_row->ext)) { 
 $extval = decrypt_data($key, pack('H*', $sql_r_row->ext)); } 
 else { $extval = ''; }
# for template
$exp = _Work_Experience; 
if (isset($sql_r_row->exp)) { $expval = decrypt_data($key, pack('H*', $sql_r_row->exp)); } else { $expval = ''; }
# for template
$ref = _References; 
if (isset($sql_r_row->ref)) { $refval = decrypt_data($key, pack('H*', $sql_r_row->ref)); } else { $refval = ''; }
# for template
$keys = _Keys; 
if (isset($sql_r_row->keys)) { $keysval = $sql_r_row->keys; } else { $keysval = ''; }
# for template

$title = _my_profile.': '.$my->name;

# for CV-->template 
if (isset($sql_r_row->cv_crypted)) { 
$cvval = _Download; 
$cnurl = $sql_r_row->cv_crypted ; 
$encrypted = bin2hex(encrypt_data($key, $cnurl));
$cnurl = sefRelToAbs("index.php?option=com_rekry&amp;Itemid=".$Itemid."&amp;rekryview=loadpdf&amp;usrid=".$my->id."&amp;filename=" . $encrypted);
}

// set vars if someting is set..
if (isset($cvval)) $view->download = $cvval;
if (isset($cnurl)) $view->download_link = $cnurl;

if (isset($title)) $view->title = $title;

if (isset($action)) $view->action = $action;

if (isset($fname)) $view->fname = $fname;
if (isset($fnval)) $view->fnval = $fnval;
if (isset($lname)) $view->lname = $lname;
if (isset($lnval)) $view->lnval = $lnval;

if (isset($address)) $view->address = $address;
if (isset($aval)) $view->aval = $aval;
if (isset($zip)) $view->zip = $zip;
if (isset($zval)) $view->zval = $zval;
if (isset($city)) $view->city = $city;
if (isset($cval)) $view->cval = $cval;
if (isset($phone)) $view->phone = $phone;
if (isset($pval)) $view->pval = $pval;
if (isset($mobile)) $view->mobile = $mobile;
if (isset($mval)) $view->mval = $mval;
if (isset($email)) $view->email = $email;
if (isset($emval)) $view->emval = $emval;
if (isset($bdate)) $view->bdate = $bdate;
if (isset($bdval)) $view->bdval = $bdval;
if (isset($gender)) $view->gender = $gender;
if (isset($mm)) $view->male = $mm;
if (isset($fm)) $view->female = $fm;
if (isset($selm)) $view->selm = $selm;
if (isset($self)) $view->self = $self;
if (isset($cv)) $view->cv = $cv;

if (isset($submit)) $view->submit = $submit;
if (isset($reset)) $view->reset = $reset;

if (isset($tell)) $view->tell = $tell;
if (isset($edu)) $view->edu = $edu;
if (isset($eedu)) $view->eedu = $eedu;
if (isset($exp)) $view->exp = $exp;
if (isset($ref)) $view->ref = $ref;

if (isset($ival)) $view->tellval = $ival;
if (isset($eduval)) $view->eduval = $eduval;
if (isset($extval)) $view->eeduval = $extval;
if (isset($expval)) $view->expval = $expval;
if (isset($refval)) $view->refval = $refval;
if (isset($PubMsgView)) $view->backlink = $PubMsgView;
if (isset($keys)) $view->keys = $keys;
if (isset($keysval)) $view->keysval = $keysval;
$view->updatecv = _Updata_Cv_Too;

echo $view->render('my_profile_form.php');

}

################
# ACTION MY
################

break;
case "add":

################
# ACTION ADD
################

if ((!$my->id)) {
	$cverrorMsg = _CV_ERROR_ONLY_REGISTERED;
} else {

if (!isset($op_id)) {$op_id = 0;}

$op_id = mysql_real_escape_string($op_id);

	 	// query 
        $sql = "SELECT op_id, op_name, op_desc FROM "
             ."#__rekry_opportunities WHERE op_id = "
			 .$op_id." LIMIT 1;";

		$database->setQuery( $sql );
		$numrows = $database->loadObjectList();
		
		$numrow = count($numrows);

$sql_num = "SELECT ap_id FROM #__rekry_applications WHERE user_id = ". $my->id ." AND op_id = ".$op_id." LIMIT 1;";

		$database->setQuery( $sql_num );
		$sql_num = $database->loadObjectList();

if (count($sql_num) == 0) {

if ($numrow == 1 && $community == 1) {

	 foreach ( $numrows as $row ) 
     {
	 
     # for Title-->template 
	 $title = _ROPPORTUNITY.": ".$row->op_name;
	 # for Text-->template 
	 $text = $row->op_desc;
     
	 }

$opid = $op_id;

$link = sefRelToAbs("index.php?option=com_rekry&Itemid=".$Itemid."&rekryview=submit");

$action = $link; 

	 	# query for Values-->template 
        $sql_r = "SELECT * FROM #__rekry_career_details WHERE user_id = ". $my->id ." LIMIT 1;";

		$database->setQuery( $sql_r );
		$sql_r = $database->loadObjectList();
	 
	 
	 
	 foreach ( $sql_r as $sql_r_row ) 
     {     

     # Making-->Values-->template 
	 
	 } 

# for Firstname-->template 
$fname = _Firstname;
if (isset($sql_r_row->fname)) { 
$fnval = decrypt_data($key, pack('H*', $sql_r_row->fname)) ; } 
else { $fnval = ''; }

# for Lastname-->template 
$lname = _Lastname;  
 if (isset($sql_r_row->lname)) { 
 $lnval = decrypt_data($key, pack('H*', $sql_r_row->lname)); } 
 else { $lnval = '' ; } 
 
 # for Address-->template 
 $address =  _Address;  
 if (isset($sql_r_row->address)) {
  $aval = decrypt_data($key, pack('H*', $sql_r_row->address)); } 
  else { $aval = ''; } 
  
  # for Zip-->template 
   $zip = _Zip; 
 if (isset($sql_r_row->zip)) { 
 $zval = decrypt_data($key, pack('H*', $sql_r_row->zip)); } 
 else { $zval = ''; }  
 
 # for City-->template 
 $city =  _City;  
 if (isset($sql_r_row->city)) { 
 $cval = decrypt_data($key, pack('H*', $sql_r_row->city)); } 
 else { $cval = '';  }

# for Phone-->template 
$phone =  _Phone; 
if (isset($sql_r_row->phone)) { 
$pval = decrypt_data($key, pack('H*', $sql_r_row->phone)); } 
else { $pval = ''; } 

# for Phone-->template
$mobile = _Mobilephone; 
if (isset($sql_r_row->gsm)) { 
$mval = decrypt_data($key, pack('H*', $sql_r_row->gsm)); } 
else { $mval = ''; } 

# for Email-->template
$email = _Email; 
$emval = $my->email; 
$bdate = _Birthdate; 

# for SiteURL-->template
$siteurl = $mosConfig_live_site;

# for Bdval-->template
if (isset($sql_r_row->bdate)) { $bdval = $sql_r_row->bdate; } 
else { $bdval = ''; } 

# for Gender-->template
$gender = _Gender; 
$fm = _Female;
$mm = _Male;
if (isset($sql_r_row->gender) && $sql_r_row->gender == "M") 
{ $selm = ' selected'; } else { $selm = ''; } 
if (isset($sql_r_row->gender) && $sql_r_row->gender == "F") 
{ $self = ' selected'; } else { $self = ''; } 

# for template
$cv = _Curriculum_Vitae; 
$opname = $row->op_name; 
$oid = $opid; 
$submit = _Submit;
$reset = _Reset;
# for template
 
# for template
$tell = _Tell; 
if (isset($sql_r_row->info)) { 
$ival = decrypt_data($key, pack('H*', $sql_r_row->info)); } 
else { $ival = ''; } 
# for template
$edu = _Education; 
if (isset($sql_r_row->edu)) { 
$eduval = decrypt_data($key, pack('H*', $sql_r_row->edu)); } 
else { $eduval = ''; }
# for template
 $eedu = _Extra_courses; 
 if (isset($sql_r_row->ext)) { 
 $extval = decrypt_data($key, pack('H*', $sql_r_row->ext)); } 
 else { $extval = ''; }
# for template
$exp = _Work_Experience; 
if (isset($sql_r_row->exp)) { $expval = decrypt_data($key, pack('H*', $sql_r_row->exp)); } else { $expval = ''; }
# for template
$ref = _References; 
if (isset($sql_r_row->ref)) { $refval = decrypt_data($key, pack('H*', $sql_r_row->ref)); } else { $refval = ''; }
# for template
$keys = _Keys; 
if (isset($sql_r_row->keys)) { $keysval = $sql_r_row->keys; } else { $keysval = ''; }
# for template

if (isset($title)) $view->title = $title;
if (isset($text)) $view->text = $text;

if (isset($action)) $view->action = $action;

if (isset($fname)) $view->fname = $fname;
if (isset($fnval)) $view->fnval = $fnval;
if (isset($lname)) $view->lname = $lname;
if (isset($lnval)) $view->lnval = $lnval;

if (isset($address)) $view->address = $address;
if (isset($aval)) $view->aval = $aval;
if (isset($zip)) $view->zip = $zip;
if (isset($zval)) $view->zval = $zval;
if (isset($city)) $view->city = $city;
if (isset($cval)) $view->cval = $cval;
if (isset($phone)) $view->phone = $phone;
if (isset($pval)) $view->pval = $pval;
if (isset($mobile)) $view->mobile = $mobile;
if (isset($mval)) $view->mval = $mval;
if (isset($email)) $view->email = $email;
if (isset($emval)) $view->emval = $emval;
if (isset($bdate)) $view->bdate = $bdate;
if (isset($bdval)) $view->bdval = $bdval;
if (isset($gender)) $view->gender = $gender;
if (isset($mm)) $view->male = $mm;
if (isset($fm)) $view->female = $fm;
if (isset($selm)) $view->selm = $selm;
if (isset($self)) $view->self = $self;
if (isset($cv)) $view->cv = $cv;

if (isset($submit)) $view->submit = $submit;
if (isset($reset)) $view->reset = $reset;

if (isset($opname)) $view->opname = $opname;
if (isset($oid)) $view->opid = $oid;

if (isset($tell)) $view->tell = $tell;
if (isset($edu)) $view->edu = $edu;
if (isset($eedu)) $view->eedu = $eedu;
if (isset($exp)) $view->exp = $exp;
if (isset($ref)) $view->ref = $ref;

if (isset($ival)) $view->tellval = $ival;
if (isset($eduval)) $view->eduval = $eduval;
if (isset($extval)) $view->eeduval = $extval;
if (isset($expval)) $view->expval = $expval;
if (isset($refval)) $view->refval = $refval;

if (isset($keys)) $view->keys = $keys;
if (isset($keysval)) $view->keysval = $keysval;
$view->updatecv = _Load_Cv_Too;

echo $view->render('application_form.php');

} else if (count($sql_num) > 0) {

}

}
}

################
# ACTION ADD
################

break;
case "submit":

################
# ACTION SUBMIT
################

if ((!$my->id)) {
  $cverrorMsg = _CV_ERROR_ONLY_REGISTERED;
} else {

if (isset($_POST['op_id']) && isset($_POST['op_name']) && $community == 1) {

if (!isset($_POST['op_id'])) {$_POST['op_id'] = 0;}

$op_id = mysql_real_escape_string($_POST['op_id']);

$sql = "SELECT * FROM "
."#__rekry_opportunities WHERE op_id = ".$op_id.";";

$sql = $database->setQuery($sql);
$numrow = $database->loadObjectList();
$numrow = count($numrow);

if ($numrow == 1 && $community == 1) {

$sql_num = $database->setQuery("SELECT ap_id FROM #__rekry_applications WHERE user_id = ". $my->id ." AND op_id = ".$op_id.";");
$sql_num = $database->loadObjectList();

if (count($sql_num) == 0) {

$uploaddir = $uploadpath;

$hashkey = $key ;

$r = bin2hex(encrypt_data($hashkey, md5( $my->username.$my->id.$secret_cv_crypt) ));

$iii = $r . ".pdf";

$iii = preg_replace("![^0-9A-Za-z._\s]!", "_", $iii);

$uploadfile = $uploaddir . $iii;

if (stristr( $iii, ".pdf" )) {
if (move_uploaded_file($_FILES['uploader']['tmp_name'], $uploadfile) ) {

echo _RRFILE;

settype($_POST['user_id'],'integer');
settype($_POST['op_id'],'integer');

$a = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'enimi' ) )));
$b = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'snimi' ) )));
$c = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'a' ) )));
$d = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'city' ) )));
$e = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'zip' ) )));
$f = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'phone' ) )));
$g = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'gsm' ) )));
$h = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'mail' ) )));
$i = mysql_real_escape_string(strip_tags(stripslashes(date('Y-m-d', strtotime( mosGetParam( $_POST, 'date' ) )))));
$j = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'gender' ) )));
$k = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'sinfo' ) )));
$l = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'edu' ) )));
$m = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'eedu' ) )));
$n = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'exp' ) )));
$o = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'ref' ) )));
$p = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'keys' ) )));
$ui = mysql_real_escape_string(strip_tags(stripslashes($my->id)));
$on = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'op_name' ) )));
$op = mysql_real_escape_string(strip_tags(stripslashes( intval(mosGetParam( $_POST, 'op_id' )) )));

# making date to MySQL Compatible in both Linux and Windows
$i = date("Y-m-d", strtotime($i));

# BLOW_FISH HMAC KEY


# Crypting with mCrypt Extension
$on = bin2hex(encrypt_data($key, $on));
$a = bin2hex(encrypt_data($key, $a));
$b = bin2hex(encrypt_data($key, $b));
$c = bin2hex(encrypt_data($key, $c));
$d = bin2hex(encrypt_data($key, $d));
$e = bin2hex(encrypt_data($key, $e));
$f = bin2hex(encrypt_data($key, $f));
$g = bin2hex(encrypt_data($key, $g));
$h = bin2hex(encrypt_data($key, $h));
$k = bin2hex(encrypt_data($key, $k));
$l = bin2hex(encrypt_data($key, $l));
$m = bin2hex(encrypt_data($key, $m));
$n = bin2hex(encrypt_data($key, $n));
$o = bin2hex(encrypt_data($key, $o));
$p = $p;


$sql = "INSERT DELAYED IGNORE INTO `#__rekry_applications` (`ap_id`, `career_fname`, 
`career_lname`, `career_add`, `career_city`, `career_zip`, `career_ph`, 
`career_gsm`, `career_mail`, `career_bdate`, `career_gender`, `career_info`, 
`career_edu`, `career_eedu`, `career_exp`, `career_referen`, `career_keys`, 
`career_cv`, `op_id`, `user_id`, `op_name`) VALUES (NULL, '".$a."', '".$b."', '"
.$c."', '".$d."', '".$e."', '".$f."', '".$g."', '".$h."', '".$i."', '".$j."', '"
.$k."', '".$l."', '".$m."', '".$n."', '".$o."', '".$p."', '".$iii."', '".$op."', '"
.$ui."', '".$on."');";

$database->setQuery($sql);
$result[0] = $database->query();

$sql_rows = $database->setQuery("SELECT id FROM #__rekry_career_details WHERE user_id = ". $my->id .";");
$sql_rows = $database->loadObjectList();

if (count($sql_rows) == 0) {

$sql = "INSERT DELAYED IGNORE INTO `#__rekry_career_details` (`id`, `addr`, `address`, `city`, `zip`, `phone`, `bdate`, `gender`, `exp`, `ext`, `edu`, `ref`, `info`, `user_id`, `gsm`, `latestupdate`, `cv_crypted`, `lname`, `fname`, `keys`) VALUES 
(NULL, '".$_SERVER['REMOTE_ADDR']."', '".$c."', '".$d."', '".$e."', '".$f."', '".$i."', '".$j."', '".$n."', '".$m."', '".$l."', '".$o."', '".$k."', ". $my->id .", '".$g."', 'NOW()', '".$iii."', '".$b."', '".$a."', '".$p."');";

$database->setQuery($sql);
$result[1] = $database->query();

} else if (count($sql_rows) == 1) {

$sql = "UPDATE `#__rekry_career_details` SET  `addr` = '".$_SERVER['REMOTE_ADDR']."', `address` = '".$c."', `city` = '".$d."', `zip` = '".$e."', `phone` = '".$f."', `bdate` = '".$i."', `gender` = '".$j."', `exp` = '".$n."', `ext` = '".$m."', `edu` = '".$l."', `ref` = '".$o."', `info` = '".$k."', `gsm` = '".$g."', `cv_crypted` = '".$iii."', `fname` = '".$a."', `lname` = '".$b."', `keys` = '".$p."' WHERE  `jos_rekry_career_details`.`user_id` = ". $my->id .";";

$database->setQuery($sql);
$result[2] = $database->query();

}

          foreach ($result as $i=>$icresult) {
		  
            if ($icresult) {
              
            } else {
              
            }
			
          }	 			
			
			if ($comp==1) {
			
			$mail = JFactory::getMailer();
			
			if ($cult=='company_and_career') {
			
            // Prepare email body
			$body 	= _THANK_APP_MAIL_BY." $on\r\n\r\n";
			
			$mail->addRecipient( $my->email );
			$mail->setSender( array( $company_email, _RECRUITING ) );
			$mail->setSubject( _THANK_APP_MAIL_BY.': '.$my->email );
			$mail->setBody( $body );

			$sent = $mail->Send();	
			
			// Prepare email body
			$body 	= _APP_MAIL_BY." $on\r\n\r\n";

			$mail = JFactory::getMailer();

			$mail->addRecipient( $company_email );
			$mail->setSender( array( $company_email, _RECRUITING ) );
			$mail->setSubject( _APP_MAIL_BY.': '.$my->email );
			$mail->setBody( $body );

			$sent = $mail->Send();	
			
			} else if ($cult=='company') {
			
					// Prepare email body
			$body 	= _APP_MAIL_BY." $on\r\n\r\n";

			$mail = JFactory::getMailer();

			$mail->addRecipient( $company_email );
			$mail->setSender( array( $company_email, _RECRUITING ) );
			$mail->setSubject( _APP_MAIL_BY.': '.$my->email );
			$mail->setBody( $body );

			$sent = $mail->Send();	
			
			} else {
			
			// Prepare email body
			$body 	= _THANK_APP_MAIL_BY." $on\r\n\r\n";
			
			$mail->addRecipient( $my->email );
			$mail->setSender( array( $company_email, _RECRUITING ) );
			$mail->setSubject( _THANK_APP_MAIL_BY.': '.$my->email );
			$mail->setBody( $body );

			$sent = $mail->Send();	
			
			}
			
			}


$link = sefRelToAbs('index.php?option=com_rekry&Itemid='.$Itemid.'&rekryview=thankyou');

mosRedirect( $link  );

} else {
   echo _RRERROR;
}
} else {
   echo _RRERROR;
}

} else if (count($sql_num) > 0) {
   echo '';
}

}

} else if (isset($_POST['updatemy']) 
&& !isset($_POST['op_id']) 
&& !isset($_POST['op_name']) 
&& $community == 1) {

$uploaddir = $uploadpath;

$hashkey = $key ;

$r = bin2hex(encrypt_data($hashkey, md5($my->username.$my->id.$secret_cv_crypt) ));

$iii = $r . ".pdf";

$iii = preg_replace("![^0-9A-Za-z._\s]!", "_", $iii);

$uploadfile = $uploaddir . $iii;

if (stristr( $iii, ".pdf" )) {
if (move_uploaded_file($_FILES['uploader']['tmp_name'], $uploadfile) ) {

echo _RRFILE;

settype($_POST['user_id'],'integer');
settype($_POST['op_id'],'integer');

$a = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'enimi' ) )));
$b = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'snimi' ) )));
$c = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'a' ) )));
$d = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'city' ) )));
$e = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'zip' ) )));
$f = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'phone' ) )));
$g = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'gsm' ) )));
$h = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'mail' ) )));
$i = mysql_real_escape_string(strip_tags(stripslashes(date('Y-m-d', strtotime( mosGetParam( $_POST, 'date' ) )))));
$j = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'gender' ) )));
$k = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'sinfo' ) )));
$l = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'edu' ) )));
$m = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'eedu' ) )));
$n = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'exp' ) )));
$o = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'ref'  ) )));
$p = mysql_real_escape_string(strip_tags(stripslashes( mosGetParam( $_POST, 'keys' ) )));
$ui = mysql_real_escape_string(strip_tags(stripslashes($my->id)));

# making date to MySQL Compatible in both Linux and Windows
$i = date("Y-m-d", strtotime($i));

# BLOW_FISH HMAC KEY
 
# Crypting with mCrypt Extension
$on = bin2hex(encrypt_data($key, $on));
$a = bin2hex(encrypt_data($key, $a));
$b = bin2hex(encrypt_data($key, $b));
$c = bin2hex(encrypt_data($key, $c));
$d = bin2hex(encrypt_data($key, $d));
$e = bin2hex(encrypt_data($key, $e));
$f = bin2hex(encrypt_data($key, $f));
$g = bin2hex(encrypt_data($key, $g));
$h = bin2hex(encrypt_data($key, $h));
$k = bin2hex(encrypt_data($key, $k));
$l = bin2hex(encrypt_data($key, $l));
$m = bin2hex(encrypt_data($key, $m));
$n = bin2hex(encrypt_data($key, $n));
$o = bin2hex(encrypt_data($key, $o));
$p = $p;

$sql = "UPDATE `#__rekry_career_details` SET  `addr` = '".$_SERVER['REMOTE_ADDR']."', `address` = '".$c."', `city` = '".$d."', `zip` = '".$e."', `phone` = '".$f."', `bdate` = '".$i."', `gender` = '".$j."', `exp` = '".$n."', `ext` = '".$m."', `edu` = '".$l."', `ref` = '".$o."', `info` = '".$k."', `gsm` = '".$g."', `cv_crypted` = '".$iii."', `fname` = '".$a."', `lname` = '".$b."', `keys` = '".$p."' WHERE  `jos_rekry_career_details`.`user_id` = ". $my->id .";";

$database->setQuery($sql);
$result[2] = $database->query();

          foreach ($result as $i=>$icresult) {
		  
            if ($icresult) {
              
            } else {		
			
              
            }
			
          }
		  
		  $sql = "INSERT DELAYED IGNORE INTO `#__rekry_career_details` (`id`, `addr`, `address`, `city`, `zip`, `phone`, `bdate`, `gender`, `exp`, `ext`, `edu`, `ref`, `info`, `user_id`, `gsm`, `latestupdate`, `cv_crypted`, `lname`, `fname`, `keys`) VALUES 
(NULL, '".$_SERVER['REMOTE_ADDR']."', '".$c."', '".$d."', '".$e."', '".$f."', '".$i."', '".$j."', '".$n."', '".$m."', '".$l."', '".$o."', '".$k."', ". $my->id .", '".$g."', 'NOW()', '".$q."', '".$b."', '".$a."', '".$p."');";

             $database->setQuery($sql);
             $result[3] = $database->query();
			 
			 if ($comp==1) {
			 
			 $mail = JFactory::getMailer();
			
			if ($cult=='company_and_career') {
			 
			// Prepare email body
			$body 	= _THANK_UP_MAIL_BY."\r\n\r\n";			

			$mail->addRecipient( $my->email );
			$mail->setSender( array( $company_email, _RECRUITING ) );
			$mail->setSubject( _THANK_UP_MAIL_BY.': '.$my->email );
			$mail->setBody( $body );

			$sent = $mail->Send();	
			
			// Prepare email body
			$body 	= _UP_MAIL_BY."\r\n\r\n";

			$mail = JFactory::getMailer();

			$mail->addRecipient( $company_email );
			$mail->setSender( array( $company_email, _RECRUITING ) );
			$mail->setSubject( _UP_MAIL_BY.': '.$my->email );
			$mail->setBody( $body );

			$sent = $mail->Send();	
			
			} else if ($cult=='company') {
			
			// Prepare email body
			$body 	= _UP_MAIL_BY."\r\n\r\n";

			$mail = JFactory::getMailer();

			$mail->addRecipient( $company_email );
			$mail->setSender( array( $company_email, _RECRUITING ) );
			$mail->setSubject( _UP_MAIL_BY.': '.$my->email );
			$mail->setBody( $body );

			$sent = $mail->Send();	
			
			} else {
			
			// Prepare email body
			$body 	= _THANK_UP_MAIL_BY."\r\n\r\n";			

			$mail->addRecipient( $my->email );
			$mail->setSender( array( $company_email, _RECRUITING ) );
			$mail->setSubject( _THANK_UP_MAIL_BY.': '.$my->email );
			$mail->setBody( $body );

			$sent = $mail->Send();
			
			}
			
			}	
		  
$link = sefRelToAbs('index.php?option=com_rekry&Itemid='.$Itemid.'&rekryview=my');

mosRedirect( $link  );

} else {
   echo _RRERROR;
}
} else {
   echo _RRERROR;
}

}



}

################
# ACTION SUBMIT
################

break;
case "thankyou":

################
# ACTION THANKYOU
################

if ($community == 1) {
echo _Thank_you;

$link = sefRelToAbs('index.php?option=com_rekry&Itemid='.$Itemid);

sleep(2);

mosRedirect( $link  );

}

################
# ACTION THANKYOU
################

break;

################
# ACTION PDF
################

case 'loadpdf':

	ob_clean();
	
	global $mosConfig_absolute_path;
	
	//exit ($key);
		
	   $id = mosGetParam( $_GET, 'usrid' );
	   $check = preg_replace("![^0-9a-z.\s]!", "", decrypt_data($key, pack('H*', preg_replace("![^0-9a-z\s]!", "", mosGetParam( $_GET, 'filename' ) ) ) ) );
	   
	   settype($id, 'integer');  
	   
	   $latestupdate = ("SELECT latestupdate, cv_crypted, 
	   fname, lname FROM #__rekry_career_details WHERE user_id = "
	   .$id." LIMIT 1;");	
	   
	   	$database->setQuery( $latestupdate );
		$rows = $database->loadObjectList();
	 
      foreach ( $rows as $row ) 

      { 	
	    $latestupdate = $row->latestupdate;
	    $cv_crypted = $row->cv_crypted;
		$l = decrypt_data($key, pack('H*', $row->lname )) ;
		$f = decrypt_data($key, pack('H*', $row->fname )) ;
	  }	
	    
		if ($check != $cv_crypted) { ob_clean(); exit(); }		
		
	   if ($id == $my->id) {
	      
       Zend_Loader::loadClass('Zend_Pdf');   
	   
	   $cv_crypted = preg_replace("![^0-9a-z.\s]!", "_", $cv_crypted);	
	   $latestupdate = date("Y-m-d", strtotime($latestupdate));

	   $flname =  $f . '_' . $l;
	   
	   $cvname = $latestupdate.'_'.$flname.'_Curriculum_Vitae.pdf';
	   
    header('Content-type: application/pdf');
    header('Content-Disposition: attachment; filename="'.$cvname.'"');
	$pdf = Zend_Pdf::load($mosConfig_absolute_path
	."/administrator/components/com_rekry/uploads/".$cv_crypted);
	
	global $company, $dateformat;
	
	foreach ($pdf->pages as $page){
            $page->saveGS();
            $page->setFillColor(new Zend_Pdf_Color_Rgb(0.9, 0, 0));
            $page->setLineColor(new Zend_Pdf_Color_GrayScale(0.2));
            $page->setLineWidth(1);
            $page->setLineDashingPattern(array(3, 2, 3, 4), 1.6);
            $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 8);
            $page->rotate(0, 0, 0);			
            $page->drawText($company.' Confidential: '
			.date($dateformat, strtotime('NOW')).': '
			.$username[0], 10, 10);
            $page->restoreGS();
        }
		
	$pdfString = $pdf->render();
	echo $pdfString;
	exit();
	
	} else {
	
	exit();
	
	}
	
	break;	

default:

################
# ACTION DEFAULT
################
	 
	$limit = 5 ; 

	 $page = $page_ppp;
	 
	 settype($page,"integer");
	 settype($limit,"integer");	 
 
	 	// query 
        $query = "SELECT * FROM #__rekry_opportunities WHERE active = 'true' ORDER BY op_start ASC;";

		$database->setQuery( $query );
		$rows = $database->loadObjectList();

	 
	if (count($rows)) {
				  
	$page_start['start'] = _Open_opportunities;
	
	}
	
$i = 1;
$b = 1;
$c = 4;
			 
	 foreach ( $rows as $row ) 
     {
	   
	  $link = sefRelToAbs("index.php?option=com_rekry&amp;Itemid=".$Itemid
	 ."&amp;rekryview=view&amp;op_id="
	 .$row->op_id);
	 
	 	 $d = $i - $c;  

                 if ($d == -3) { $page = "page".$b; $$page = $page; }			

	 $page_html[$$page][$i]['title'] = $row->op_name;
	 $page_html[$$page][$i]['text'] = len_limited_text($row->op_desc,200,0);
	 $page_html[$$page][$i]['link'] = $link;
	 $page_html[$$page][$i]['link_text'] = _MORE_DETAILS;

	 $ts = $row->op_start;
     $tss = explode('-',$ts) ;
	 
	 $page_html[$$page][$i]['sttext'] = _RST;
	 $page_html[$$page][$i]['stdate'] = date ( _DATE_F, mktime (1,1,1,$tss[1],$tss[2],$tss[0]) );

	 $ts = $row->op_end;
     $tss = explode('-',$ts) ;
	 
      $page_html[$$page][$i]['retext'] = _RET;
	 
	 if ($ts == '0000-00-00') { 
	 $page_html[$$page][$i]['redate'] = _no_due; 
	 } else {
	 $page_html[$$page][$i]['redate'] = date ( _DATE_F, mktime (1,1,1,$tss[1],$tss[2],$tss[0]) );
	 }
		
				  
				  if (is_integer($i / 4)) { $b++; $c+=4; }
				  
				  $p = $i / 4;
			  
                  $i++;
				  
	 }


if (!isset($page_ppp)) {$page_ppp = 1;}
if ( $i != 1 ) {
$page = 'page'.$page_ppp;

if (isset($$page)) {

$view_html = $page_html[$$page];

} else {

$empMsg['empty'] =  _empty;

}

} else {

$empMsg['empty'] =  _empty;

}	 

		
		

if ( $i != 1 ) {

$i = 1;

$p = ceil($p);

while ($i <= $p) {

$link = sefRelToAbs('index.php?option=com_rekry&amp;page='.$i.'&amp;Itemid='.$Itemid);

$pagesLinks[$i]['link'] = $link;
$pagesLinks[$i]['text'] = $i;
$i++;

};
}

if ((!$my->id)) {

} else {
$link = sefRelToAbs('index.php?option=com_rekry&amp;rekryview=my&amp;Itemid='.$Itemid);
$myLink['link'] = $link;
$myLink['text'] = _my_profile;
}

if (isset($view_html)) $view->viewhtml = $view_html;
if (isset($pagesLinks)) $view->pages = $pagesLinks;
if (isset($page_start)) $view->pagestart = $page_start;
if (isset($myLink)) $view->mylink = $myLink;

echo $view->render('default_view.php');

################
# ACTION DEFAULT
################ 

break; 
}

################
# END
################

?> 