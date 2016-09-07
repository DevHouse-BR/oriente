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

global $database, $mosConfig_dbprefix;

  if (file_exists($mosConfig_absolute_path
  .'/administrator/components/com_rekry/zfconfig.rekry.php')) {
  require_once($mosConfig_absolute_path
  ."/administrator/components/com_rekry/zfconfig.rekry.php"); }
  
  require_once ('Zend/Loader.php');

/*
* Loading Zend Classes
*/
Zend_Loader::loadClass('Zend_Version');
Zend_Loader::loadClass('Zend_Json');

require_once( $mainframe->getPath( 'admin_html' ) );
require_once( $mainframe->getPath( 'class' ) );

require($mosConfig_absolute_path . '/components/com_rekry/functions.php' );
	
switch ($task) {

   case 'opportunities':
   
   	 $mainframe->addCustomHeadTag('<link rel="stylesheet" type="text/css" href="components/com_rekry/os/ext/resources/css/ext-all.css" />
<script type="text/javascript" src="components/com_rekry/os/ext/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="components/com_rekry/os/ext/ext-all.js"></script>
    <script type="text/javascript" src="components/com_rekry/os/desktop/js/Ext.ux.grid.CellActions.js"></script>
	<script type="text/javascript" src="components/com_rekry/os/desktop/js/Ext.ux.grid.RowActions.js"></script>
	<script type="text/javascript" src="components/com_rekry/os/desktop/js/Ext.ux.grid.Search.js"></script>
	<script type="text/javascript" src="components/com_rekry/os/desktop/opp.js"></script>
    <link rel="stylesheet" type="text/css" href="components/com_rekry/os/desktop/css/desktop.css" />
	<link rel="stylesheet" type="text/css" href="components/com_rekry/os/desktop/css/Ext.ux.grid.CellActions.css" />
	<link rel="stylesheet" type="text/css" href="components/com_rekry/os/desktop/css/Ext.ux.grid.RowActions.css" />');
	
	showGUI( $option );
   
   break;
   
case 'applications':

$mainframe->addCustomHeadTag('<link rel="stylesheet" type="text/css" href="components/com_rekry/os/ext/resources/css/ext-all.css" />
<script type="text/javascript" src="components/com_rekry/os/ext/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="components/com_rekry/os/ext/ext-all.js"></script>
    <script type="text/javascript" src="components/com_rekry/os/desktop/js/Ext.ux.grid.CellActions.js"></script>
	<script type="text/javascript" src="components/com_rekry/os/desktop/js/Ext.ux.grid.RowActions.js"></script>
	<script type="text/javascript" src="components/com_rekry/os/desktop/js/Ext.ux.grid.Search.js"></script>
	<script type="text/javascript" src="components/com_rekry/os/desktop/app.js"></script>
    <link rel="stylesheet" type="text/css" href="components/com_rekry/os/desktop/css/desktop.css" />
	<link rel="stylesheet" type="text/css" href="components/com_rekry/os/desktop/css/Ext.ux.grid.CellActions.css" />
	<link rel="stylesheet" type="text/css" href="components/com_rekry/os/desktop/css/Ext.ux.grid.RowActions.css" />');
	
	showGUI( $option );
   
    break;
	
   case 'defaultconfig':
   
   $mainframe->addCustomHeadTag('<link rel="stylesheet" type="text/css" href="components/com_rekry/os/ext/resources/css/ext-all.css" />
<script type="text/javascript" src="components/com_rekry/os/ext/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="components/com_rekry/os/ext/ext-all.js"></script>
    <script type="text/javascript" src="components/com_rekry/os/desktop/js/Ext.ux.grid.CellActions.js"></script>
	<script type="text/javascript" src="components/com_rekry/os/desktop/js/Ext.ux.grid.RowActions.js"></script>
	<script type="text/javascript" src="components/com_rekry/os/desktop/js/Ext.ux.grid.Search.js"></script>
	<script type="text/javascript" src="components/com_rekry/os/desktop/conf.js"></script>
    <link rel="stylesheet" type="text/css" href="components/com_rekry/os/desktop/css/desktop.css" />
	<link rel="stylesheet" type="text/css" href="components/com_rekry/os/desktop/css/Ext.ux.grid.CellActions.css" />
	<link rel="stylesheet" type="text/css" href="components/com_rekry/os/desktop/css/Ext.ux.grid.RowActions.css" />');
	
	showGUI( $option );
   
   break;  
   
    case 'save_app_tab':
	
    ob_clean();
	
    $json['success'] = false;

    $keyID = (integer) mosGetParam( $_POST, 'keyID' );
	$title = mosGetParam( $_POST, 'title' );
    $st_date = mosGetParam( $_POST, 'st_date' ); 
	$ed_date = mosGetParam( $_POST, 'ed_date' );
    $active = mosGetParam( $_POST, 'active' ); 
    $main = mosGetParam( $_POST, 'main', null, _MOS_ALLOWHTML );
    $company = mosGetParam( $_POST, 'company', null, _MOS_ALLOWHTML ); 
	$culture = mosGetParam( $_POST, 'culture', null, _MOS_ALLOWHTML );
    $opportunity = mosGetParam( $_POST, 'opportunity', null, _MOS_ALLOWHTML ); 
	$responsibilities = mosGetParam( $_POST, 'responsibilities', null, _MOS_ALLOWHTML );
    $skills = mosGetParam( $_POST, 'skills', null, _MOS_ALLOWHTML ); 
    $experience = mosGetParam( $_POST, 'experience', null, _MOS_ALLOWHTML );
    $compensation = mosGetParam( $_POST, 'compensation', null, _MOS_ALLOWHTML ); 
	$contact = mosGetParam( $_POST, 'contact', null, _MOS_ALLOWHTML ); 
	
	$sql = "UPDATE `#__rekry_opportunities` 
	SET `modified` = NOW( ), 
	`op_name` = '$title',
	`op_desc` = '$main',
	`op_start` = '$st_date',
	`op_end` = '$ed_date',
	`company` = '$company',
	`culture` = '$culture',
	`opportunity` = '$opportunity',
	`responsibilities` = '$responsibilities',
	`required_knowledge_and_skills` = '$skills',
	`required_experience` = '$experience',
	`compensation` = '$compensation',
	`contact` = '$contact',
	`active` = '$active'
	WHERE `#__rekry_opportunities`.`op_id` = $keyID LIMIT 1 ;";
	
	$database->setQuery($sql);
        $result[0] = $database->query();
		
		if ($result[0]) {
		$json['success'] = true;
		} else {
		$json['success'] = false;
		}
	
	$json = Zend_Json::encode($json);
    echo $json;
	
    exit();  
	
	break;
	
	case 'save_app_tab_dub':
	
    ob_clean();
	
$json['success'] = false;


    $title = mosGetParam( $_POST, 'title' );
    $st_date = mosGetParam( $_POST, 'st_date' ); 
	$ed_date = mosGetParam( $_POST, 'ed_date' );
    $active = mosGetParam( $_POST, 'active' ); 
    $main = mosGetParam( $_POST, 'main', null, _MOS_ALLOWHTML );
    $company = mosGetParam( $_POST, 'company', null, _MOS_ALLOWHTML ); 
	$culture = mosGetParam( $_POST, 'culture', null, _MOS_ALLOWHTML );
    $opportunity = mosGetParam( $_POST, 'opportunity', null, _MOS_ALLOWHTML ); 
	$responsibilities = mosGetParam( $_POST, 'responsibilities', null, _MOS_ALLOWHTML );
    $skills = mosGetParam( $_POST, 'skills', null, _MOS_ALLOWHTML ); 
    $experience = mosGetParam( $_POST, 'experience', null, _MOS_ALLOWHTML );
    $compensation = mosGetParam( $_POST, 'compensation', null, _MOS_ALLOWHTML ); 
	$contact = mosGetParam( $_POST, 'contact', null, _MOS_ALLOWHTML ); 

		
		$sql = "INSERT INTO `#__rekry_opportunities` 
		( `op_id` , `op_name` , `op_desc` , `op_company` , `op_type` , `op_start` , `op_end` , `company` , 
		`culture` , `opportunity` , `responsibilities` , `required_knowledge_and_skills` , `required_experience` , 
		`compensation` , `contact` , `edit` , `emp_id` , `active` , `modified` , `deleted` )
VALUES (NULL , '$title', '$main', 
'None', 'None', $st_date, '$ed_date', 
'$company', '$culture', '$opportunity', 
'$responsibilities', '$skills', '$experience', 
'$compensation', '$contact', 'false', '1', 'false', NOW( ) , 'false'
);";		
	
		$database->setQuery($sql);
        $result[0] = $database->query();
		
		if ($result[0]) {
		$json['success'] = true;
		} else {
		$json['success'] = false;
		}
				
		$json = Zend_Json::encode($json);
        echo $json;
	
    exit();  
	
	break;
	
	case 'prof':
	
    ob_clean();
	
	$success = "{'qo_parents': []}";
	
		 $query = "select `id` as 'KeyField', 
`name` as 'DisplayField' from 
`#__rekry_professions`  
order by name asc;";

		$database->setQuery( $query );
		$rows = $database->loadObjectList();
        $i = 1;	

 foreach ( $rows as $row ) 
     {
	 $json['prof_root'][] = array('KeyField' => $row->KeyField,
	 'DisplayField' => $row->DisplayField
	 );
	 
	 $i++;
	 }


$json = Zend_Json::encode($json);
echo $json;

	exit();  
	
	break;

    case 'apl':
	
    ob_clean();
	
 $start = (integer) mosGetParam( $_POST, 'start' );
    $end = (integer) mosGetParam( $_POST, 'limit' ); 
	$que = mosGetParam( $_POST, 'query' );
	
	$query = "SELECT * FROM #__rekry_career_details ORDER BY latestupdate ASC;";
	$database->setQuery( $query );
	// $json['totalCount'] = count($rows);
	
	
  if (!$database->query()) {
  $rows = $database->stderr();
  } else {
  $rows = $database->getNumRows();
  }
  
	$json['totalCount'] = $rows;

        $query = "SELECT * FROM #__rekry_career_details ORDER BY latestupdate ASC LIMIT $start, $end;";

		$database->setQuery( $query );
		$rows = $database->loadObjectList();
        $i = 1;	
		
	 foreach ( $rows as $row ) 
     {

	 $query = "SELECT username, email FROM #__users 
	 WHERE id = ".$row->user_id.";";
	 $database->setQuery( $query );
	 
	 $keys = $database->loadObjectList();
	 
	 foreach ( $keys as $key ) 
     {
	 $username = $key->username;	
	 $email = $key->email;
	 }
	 
	 $cccc = $row->cv_crypted;
	 
	 $key = md5( $blow_fish_key . $row->user_id . $username );
	 $row_cv = $cccc;
     $encrypted = bin2hex(encrypt_data($key, $row_cv));
	 
	 $json['apl'][] = array('id' => $row->id,
	 'career_name' => decrypt_data($key, pack('H*',$row->fname))
	 .' '.decrypt_data($key, pack('H*',$row->lname)),
	 'career_gsm' => decrypt_data($key, pack('H*',$row->gsm)),
	 'career_email' => $email,
	 'career_cv' => date('Y-m-d').'_'.$row->user_id.'_'.decrypt_data($key, pack('H*',$row->fname))
	 .'_'.decrypt_data($key, pack('H*',$row->lname)).'.pdf',
	 'career_cv_link' => $encrypted,
	 'addr' => $row->addr,
	 'user_id' => $row->user_id,
	 'lname' => decrypt_data($key, pack('H*',$row->lname)),
	 'keys' => str_replace('\r\n','<br />',$row->keys),
	 'address' => decrypt_data($key, pack('H*',$row->address)),
	 'city' => decrypt_data($key, pack('H*',$row->city)),
	 'zip' => decrypt_data($key, pack('H*',$row->zip)),
	 'phone' => decrypt_data($key, pack('H*',$row->phone)),
	 'bdate' => $row->bdate,
	 'gender' => $row->gender,
	 'exp' => str_replace('\r\n','<br />',decrypt_data($key, pack('H*',$row->exp))),
	 'ext' => str_replace('\r\n','<br />',decrypt_data($key, pack('H*',$row->ext))),
	 'edu' => str_replace('\r\n','<br />',decrypt_data($key, pack('H*',$row->edu))),
	 'ref' => str_replace('\r\n','<br />',decrypt_data($key, pack('H*',$row->ref))),
	 'info' => str_replace('\r\n','<br />',decrypt_data($key, pack('H*',$row->info)))
	 );
	 $i++;
	 }	 

$json = Zend_Json::encode($json);
echo $json;
	
	 exit();
	
	break;

    case 'app':
	
        ob_clean();
		
     $start = (integer) mosGetParam( $_POST, 'start' );
    $end = (integer) mosGetParam( $_POST, 'limit' ); 
	$que = mosGetParam( $_POST, 'query' );
	
	$query = "SELECT * FROM #__rekry_applications  
		WHERE career_keys LIKE '%".$que."%' ORDER BY cu_timestamp ASC;";
	$database->setQuery( $query );
	// $json['totalCount'] = count($rows);

  if (!$database->query()) {
  $rows = $database->stderr();
  } else {
  $rows = $database->getNumRows();
  }
  
	$json['totalCount'] = $rows;

        $query = "SELECT * FROM #__rekry_applications WHERE career_keys LIKE '%".$que."%' ORDER BY cu_timestamp ASC LIMIT $start, $end;";

		$database->setQuery( $query );
		$rows = $database->loadObjectList();
        $i = 1;	
		
	 foreach ( $rows as $row ) 
     {
	 $query = "SELECT op_name FROM #__rekry_opportunities 
	 WHERE op_id = ".$row->op_id.";";
     $database->setQuery( $query );
	 $opportunities = $database->loadObjectList();
	 
	 if (count($opportunities)>0) {
	 
	 foreach ( $opportunities as $opportunity ) 
     {
	 
	 $op_name = $opportunity->op_name;
	 
	 }
	 
	 } else {
	 
	 $op_name = '( deleted )';
	 
	 }
	 
	 $query = "SELECT username FROM #__users 
	 WHERE id = ".$row->user_id.";";
	 $database->setQuery( $query );
	 
	 $keys = $database->loadObjectList();
	 
	 foreach ( $keys as $key ) 
     {
	 $username = $key->username;
	 }
	 
	 $key = md5 ( $blow_fish_key . $row->user_id . $username ) ;
	 $row_cv = $row->career_cv;
     $encrypted = encrypt_data($key, $row_cv);
     $encrypted = bin2hex($encrypted);	 
	 
	 $json['app'][] = array('ap_id' => $row->ap_id,
	 'career_name' => decrypt_data($key, pack('H*',$row->career_fname))
	 .' '.decrypt_data($key, pack('H*',$row->career_lname)),
	 'career_gsm' => decrypt_data($key, pack('H*',$row->career_gsm)),
	 'career_mail' => decrypt_data($key, pack('H*',$row->career_mail)),
	 'career_cv' => date('Y-m-d').'_'.$row->user_id.'_'.decrypt_data($key, pack('H*',$row->career_fname))
	 .'_'.decrypt_data($key, pack('H*',$row->career_lname)).'.pdf',
	 'career_cv_link' => $encrypted,
	 'op_name' => $op_name,
	 'user_id' => $row->user_id,
	 'career_add' => decrypt_data($key, pack('H*',$row->career_add)),
	 'career_city' => decrypt_data($key, pack('H*',$row->career_city)),
	 'career_zip' => decrypt_data($key, pack('H*',$row->career_zip)),
	 'career_ph' => decrypt_data($key, pack('H*',$row->career_ph)),
	 'career_bdate' => $row->career_bdate,
	 'career_gender' => $row->career_gender,
	 'career_info' => str_replace('\r\n','<br />',decrypt_data($key, pack('H*',$row->career_info))),
	 'career_edu' => str_replace('\r\n','<br />',decrypt_data($key, pack('H*',$row->career_edu))),
	 'career_eedu' => str_replace('\r\n','<br />',decrypt_data($key, pack('H*',$row->career_eedu))),
	 'career_exp' => str_replace('\r\n','<br />',decrypt_data($key, pack('H*',$row->career_exp))),
	 'career_referen' => str_replace('\r\n','<br />',decrypt_data($key, pack('H*',$row->career_referen))),
	 'career_keys' => str_replace('\r\n','<br />',$row->career_keys)
	 );
	 $i++;
	 }	 

$json = Zend_Json::encode($json);
echo $json;

exit();

	break;
	
	case 'int':
	
        ob_clean();
		
     $start = (integer) mosGetParam( $_POST, 'start' );
    $end = (integer) mosGetParam( $_POST, 'limit' ); 
	
	$query = "SELECT * FROM #__rekry_applications  
		WHERE int_enum = 'true' ORDER BY cu_timestamp ASC;";
	$database->setQuery( $query );
	// $json['totalCount'] = count($rows);
	
  if (!$database->query()) {
  $rows = $database->stderr();
  } else {
  $rows = $database->getNumRows();
  }
  
	$json['totalCount'] = $rows;

        $query = "SELECT * FROM #__rekry_applications WHERE int_enum = 'true' ORDER BY cu_timestamp ASC LIMIT $start, $end;";
    
		$database->setQuery( $query );
		$rows = $database->loadObjectList();
        $i = 1;	
		
	 foreach ( $rows as $row ) 
     {
	 $query = "SELECT op_name FROM #__rekry_opportunities 
	 WHERE op_id = ".$row->op_id.";";
     $database->setQuery( $query );
	 $opportunities = $database->loadObjectList();
	 
	 if (count($opportunities)>0) {
	 
	 foreach ( $opportunities as $opportunity ) 
     {
	 
	 $op_name = $opportunity->op_name;
	 
	 }
	 
	 } else {
	 
	 $op_name = '( deleted )';
	 
	 }
	 
	 $query = "SELECT username FROM #__users 
	 WHERE id = ".$row->user_id.";";
	 $database->setQuery( $query );
	 
	 $keys = $database->loadObjectList();
	 
	 foreach ( $keys as $key ) 
     {
	 $username = $key->username;
	 }
	 
	 $key = md5 ( $blow_fish_key . $row->user_id . $username ) ;
	 $row_cv = $row->career_cv;
     $encrypted = encrypt_data($key, $row_cv);
     $encrypted = bin2hex($encrypted);		 
	 
	 $json['int'][] = array('ap_id' => $row->ap_id,
	 'name' => decrypt_data($key, pack('H*',$row->career_fname))
	 .' '.decrypt_data($key, pack('H*',$row->career_lname)),
	 'gsm' => decrypt_data($key, pack('H*',$row->career_gsm)),
	 'mail' => decrypt_data($key, pack('H*',$row->career_mail)),
	 'cv' => date('Y-m-d').'_'.$row->user_id.'_'.decrypt_data($key, pack('H*',$row->career_fname))
	 .'_'.decrypt_data($key, pack('H*',$row->career_lname)).'.pdf',
	 'cv_link' => $encrypted,
	 'op_name' => $op_name,
	 'user_id' => $row->user_id,
	 'add' => decrypt_data($key, pack('H*',$row->career_add)),
	 'city' => decrypt_data($key, pack('H*',$row->career_city)),
	 'zip' => decrypt_data($key, pack('H*',$row->career_zip)),
	 'ph' => decrypt_data($key, pack('H*',$row->career_ph)),
	 'bdate' => $row->career_bdate,
	 'gender' => $row->career_gender,
	 'info' => str_replace('\r\n','<br />',decrypt_data($key, pack('H*',$row->career_info))),
	 'edu' => str_replace('\r\n','<br />',decrypt_data($key, pack('H*',$row->career_edu))),
	 'eedu' => str_replace('\r\n','<br />',decrypt_data($key, pack('H*',$row->career_eedu))),
	 'exp' => str_replace('\r\n','<br />',decrypt_data($key, pack('H*',$row->career_exp))),
	 'referen' => str_replace('\r\n','<br />',decrypt_data($key, pack('H*',$row->career_referen))),
	 'keys' => str_replace('\r\n','<br />',$row->career_keys),
	 'int_date' => $row->int_date,
	 'int_time' => $row->int_time
	 );
	 $i++;
	 }	 

$json = Zend_Json::encode($json);
echo $json;

exit();

	break;
	
case 'opp':
	
ob_clean();

    $start = (integer) mosGetParam( $_POST, 'start' );
    $end = (integer) mosGetParam( $_POST, 'limit' ); 
	
	$query = "SELECT * FROM #__rekry_opportunities 
		WHERE deleted = 'false' ORDER BY op_start ASC;";
	$database->setQuery( $query );
	// $json['totalCount'] = count($rows);
	
  if (!$database->query()) {
  $rows = $database->stderr();
  } else {
  $rows = $database->getNumRows();
  }
  
	$json['totalCount'] = $rows;
	
	$query = "SELECT * FROM #__rekry_opportunities 
		WHERE deleted = 'false' ORDER BY op_start ASC LIMIT $start, $end;";

		$database->setQuery( $query );
		$rows = $database->loadObjectList();
        $i = 1;	
		
	 foreach ( $rows as $row ) 
     {
	 $query = "SELECT op_id FROM #__rekry_applications 
	 WHERE op_id = ".$row->op_id.";";
     $database->setQuery( $query );
	 $applicants = $database->loadObjectList();
	 $ii = count($applicants);
	 $json['opp'][] = array('op_id' => $row->op_id,
	 'op_name' => $row->op_name,
	 'applicants' => $ii,
	 'op_start' => $row->op_start,
	 'op_end' => $row->op_end,
	 'op_company' => $row->op_company,
	 'op_desc' => $row->op_desc,
	 'opportunity' => $row->opportunity,
	 'edit' => $row->edit,
	 'active' => $row->active,
	 'company' => $row->company,
	 'culture' => $row->culture,
	 'responsibilities' => $row->responsibilities,
	 'required_knowledge_and_skills' => $row->required_knowledge_and_skills,
	 'required_experience' => $row->required_experience,
	 'compensation' => $row->compensation,
	 'contact' => $row->contact	 
	 );
	 
	 $i++;
	 }


$json = Zend_Json::encode($json);
echo $json;

exit();

break;

case 'pro':
	
ob_clean();

    $start = (integer) mosGetParam( $_POST, 'start' );
    $end = (integer) mosGetParam( $_POST, 'limit' ); 
	
	$query = "SELECT * FROM #__rekry_professions ORDER BY name ASC;";
	$database->setQuery( $query );
	// $json['totalCount'] = count($rows);
	
  if (!$database->query()) {
  $rows = $database->stderr();
  } else {
  $rows = $database->getNumRows();
  }
  
	$json['totalCount'] = $rows;
	
	$query = "SELECT * FROM #__rekry_professions ORDER BY name ASC LIMIT $start, $end;";

		$database->setQuery( $query );
		$rows = $database->loadObjectList();
        $i = 1;	
		
	 foreach ( $rows as $row ) 
     {
	 $json['pro'][] = array('id' => $row->id,
	 'name' => $row->name,
	 'text' => $row->text,
	 'modified' => $row->modified	 
	 );
	 
	 $i++;
	 }


$json = Zend_Json::encode($json);
echo $json;

exit();

break;

case 'arr':
	
ob_clean();

    $start = (integer) mosGetParam( $_POST, 'start' );
    $end = (integer) mosGetParam( $_POST, 'limit' ); 
	
	$query = "SELECT * FROM #__rekry_opportunities 
		WHERE deleted = 'true' ORDER BY op_start ASC;";
	$database->setQuery( $query );
	// $json['totalCount'] = count($rows);
	
  if (!$database->query()) {
  $rows = $database->stderr();
  } else {
  $rows = $database->getNumRows();
  }
  
	$json['totalCount'] = $rows;
	
	$query = "SELECT * FROM #__rekry_opportunities 
		WHERE deleted = 'true' ORDER BY op_start ASC LIMIT $start, $end;";

		$database->setQuery( $query );
		$rows = $database->loadObjectList();
        $i = 1;	
		
	 foreach ( $rows as $row ) 
     {
	 $query = "SELECT op_id FROM #__rekry_applications 
	 WHERE op_id = ".$row->op_id.";";
     $database->setQuery( $query );
	 $applicants = $database->loadObjectList();
	 $ii = count($applicants);
	 $json['opp'][] = array('op_id' => $row->op_id,
	 'op_name' => $row->op_name,
	 'applicants' => $ii,
	 'op_start' => $row->op_start,
	 'op_end' => $row->op_end,
	 'op_company' => $row->op_company,
	 'op_desc' => $row->op_desc,
	 'opportunity' => $row->opportunity,
	 'edit' => $row->edit,
	 'active' => $row->active,
	 'company' => $row->company,
	 'culture' => $row->culture,
	 'responsibilities' => $row->responsibilities,
	 'required_knowledge_and_skills' => $row->required_knowledge_and_skills,
	 'required_experience' => $row->required_experience,
	 'compensation' => $row->compensation,
	 'contact' => $row->contact	 
	 );
	 
	 $i++;
	 }


$json = Zend_Json::encode($json);
echo $json;

exit();

break;
	
case 'loadpdf':

	ob_clean();
	
	global $mosConfig_absolute_path;
	
	   $id = mosGetParam( $_GET, 'usrid' );
	   $file = mosGetParam( $_GET, 'filename' );
       settype($id, 'integer');
	   $fileName = preg_replace("![^0-9A-Za-z\s]!", "_", $file);	
	
	   $username = ("SELECT username FROM #__users WHERE id = "
	   .$id." LIMIT 1;");	
	   
	   $database->setQuery( $username );
		$rows = $database->loadObjectList();
		
		foreach ( $rows as $row ) 

      { 	
	    $username = $row->username;
	  }	
	   
	   $key = md5($blow_fish_key . $id . $username) ;
	   
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
	
	   include('Zend/Pdf.php');	    
       
       $encrypted = $fileName;
       $decrypted = decrypt_data($key, pack('H*', $encrypted));
	   $latestupdate = date("Y-m-d", strtotime($latestupdate));
	   $flname =  $f . '_' . $l ;
	   
	   $cvname = $latestupdate.'_'.$flname.'_Curriculum_Vitae.pdf';
	   
    header('Content-type: application/pdf');
    header('Content-Disposition: attachment; filename="'.$cvname.'"');
	$pdf = Zend_Pdf::load($mosConfig_absolute_path
	."/administrator/components/com_rekry/uploads/".$cv_crypted);	
	
	foreach ($pdf->pages as $page){
            $page->saveGS();
            $page->setFillColor(new Zend_Pdf_Color_Rgb(0.9, 0, 0));
            $page->setLineColor(new Zend_Pdf_Color_GrayScale(0.2));
            $page->setLineWidth(1);
            $page->setLineDashingPattern(array(3, 2, 3, 4), 1.6);
            $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 8);
            $page->rotate(0, 0, 0);			
            $page->drawText($company .'  Confidential: '
			.date('Y-m-d', strtotime('NOW')).': '
			.str_replace('_',' ', $flname), 10, 10);
            $page->restoreGS();
        }
		
	$pdfString = $pdf->render();
	echo $pdfString;
	exit();
	
	break;	
	
	case 'no_date':
	
        ob_clean();
		
		$json['success'] = false;
		$id    = intval(mosGetParam( $_POST, 'id' ), 0);
        $field = 'op_end';
        $value = '0000-00-00';		
		
		$sql = 'UPDATE #__rekry_opportunities SET '
		.$field.' = \''.$value.'\' '
		.'WHERE #__rekry_opportunities.op_id = '
		.$id.' ;';
	
		$database->setQuery($sql);
        $result[0] = $database->query();
		
		if ($result[0]) {
		$json['success'] = true;
		} else {
		$json['success'] = false;
		}
				
		$json = Zend_Json::encode($json);
        echo $json;
		
		exit();
		
	break;
	
	case 'edit_opp':
	
        ob_clean();
		
		$json['success'] = false;
		$id    = intval(mosGetParam( $_POST, 'keyID' ), 0);
        $field = mosGetParam( $_POST, 'field' );
        $value = mosGetParam( $_POST, 'value' );	
		
		if ($field=='op_start') {
		$value = mosGetParam( $_POST, 'start_date' );
		} else if ($field=='op_end') {
		$value = mosGetParam( $_POST, 'end_date' );
		} else {
		$value = $value;
		}
		
		$sql = 'UPDATE #__rekry_opportunities SET '
		.$field.' = \''.$value.'\' '
		.'WHERE #__rekry_opportunities.op_id = '
		.$id.' ;';
	
		$database->setQuery($sql);
        $result[0] = $database->query();
		
		if ($result[0]) {
		$json['success'] = true;
		} else {
		$json['success'] = false;
		}
				
		$json = Zend_Json::encode($json);
        echo $json;
		
		exit();
		
	break;
	
	case 'edit_int':
	
        ob_clean();
		
		$json['success'] = false;
		$id    = intval(mosGetParam( $_POST, 'keyID' ), 0);
        $field = mosGetParam( $_POST, 'field' );
        $value = mosGetParam( $_POST, 'value' );	
		
		if ($field=='int_date') {
		$value = mosGetParam( $_POST, 'int_date' );
		} else {
		$value = $value;
		}
		
		$sql = 'UPDATE #__rekry_applications SET '
		.$field.' = \''.$value.'\' '
		.'WHERE #__rekry_applications.ap_id = '
		.$id.' ;';
	
		$database->setQuery($sql);
        $result[0] = $database->query();
		
		if ($result[0]) {
		$json['success'] = true;
		} else {
		$json['success'] = false;
		}
				
		$json = Zend_Json::encode($json);
        echo $json;
		
		exit();
		
	break;
	
	case 'edit_pro':
	
        ob_clean();
		
		$json['success'] = false;
		$id    = intval(mosGetParam( $_POST, 'keyID' ), 0);
        $field = mosGetParam( $_POST, 'field' );
        $value = mosGetParam( $_POST, 'value' );		
		
		$sql = 'UPDATE #__rekry_professions SET '
		.$field.' = \''.$value.'\' '
		.'WHERE #__rekry_professions.id = '
		.$id.' ;';
	
		$database->setQuery($sql);
        $result[0] = $database->query();
		
		if ($result[0]) {
		$json['success'] = true;
		} else {
		$json['success'] = false;
		}
				
		$json = Zend_Json::encode($json);
        echo $json;
		
		exit();
		
	    break;
	
	case 'new_opp':
	
        ob_clean();
		
		$json['success'] = false;
		
   $next_increment = rand(1,9999);
		
		$sql = "INSERT INTO `#__rekry_opportunities` ( `op_id` , `op_name` , `op_desc` , `op_company` , `op_type` , `op_start` , `op_end` , `company` , `culture` , `opportunity` , `responsibilities` , `required_knowledge_and_skills` , `required_experience` , `compensation` , `contact` , `edit` , `emp_id` , `active` , `modified` , `deleted` )
VALUES (
NULL , 'Opportunity $next_increment', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', '1', 'None', CURDATE( ), '0000-00-00', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam sit amet nunc. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam sit amet nunc. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam sit amet nunc. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam sit amet nunc. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam sit amet nunc. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam sit amet nunc. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam sit amet nunc. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam sit amet nunc. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.', 'false', '1', 'false', NOW( ) , 'false'
);";		
	
		$database->setQuery($sql);
        $result[0] = $database->query();
		
		if ($result[0]) {
		$json['success'] = true;
		} else {
		$json['success'] = false;
		}
				
		$json = Zend_Json::encode($json);
        echo $json;
		
		exit();
		
	break;
	
	case 'new_pro':
	
        ob_clean();
		
		$json['success'] = false;
		
   $next_increment = rand(1,9999);
		
		$sql = "INSERT INTO `#__rekry_professions` (
`id` ,
`name` ,
`text` ,
`modified`
)
VALUES (
NULL , 'Profession $next_increment', 'Lorem ipsum dolor sit amet $next_increment', NOW( )
);";		
	
		$database->setQuery($sql);
        $result[0] = $database->query();
		
		if ($result[0]) {
		$json['success'] = true;
		} else {
		$json['success'] = false;
		}
				
		$json = Zend_Json::encode($json);
        echo $json;
		
		exit();
		
	break;
	
	case 'del_opp':
	
        ob_clean();
		
		$json['success'] = false;
		
    $argumet = mosGetParam( $_POST, 'deleteKeys' );
    $count = 0;
	$selectedRows = json_decode(stripslashes($argumet));
	
    foreach($selectedRows as $row)
    {
	    $id = (integer) $row;
        $sql = "DELETE FROM `#__rekry_opportunities` "
		."WHERE `#__rekry_opportunities`.`op_id` = "
		.$id." AND `#__rekry_opportunities`.`edit` = 'false' LIMIT 1;";	
		$database->setQuery($sql);
        $result[0] = $database->query();		
		if ($result[0]) {
		$json['success'] = true;
		} else {
		$json['success'] = false;
		}
    }				
		$json = Zend_Json::encode($json);
        echo $json;
		
		exit();
		
	break;
	
	case 'del_app':
	
        ob_clean();
		
		$json['success'] = false;
		
    $argumet = mosGetParam( $_POST, 'deleteKeys' );
    $count = 0;
	$selectedRows = json_decode(stripslashes($argumet));
	
    foreach($selectedRows as $row)
    {
	    $id = (integer) $row;
        $sql = "DELETE FROM `#__rekry_applications` "
		."WHERE `#__rekry_applications`.`ap_id` = "
		.$id." LIMIT 1;";	
		$database->setQuery($sql);
        $result[0] = $database->query();		
		if ($result[0]) {
		$json['success'] = true;
		} else {
		$json['success'] = false;
		}
    }				
		$json = Zend_Json::encode($json);
        echo $json;
		
		exit();
		
	break;	
	
	case 'del_pro':
	
        ob_clean();
		
		$json['success'] = false;
		
    $argumet = mosGetParam( $_POST, 'deleteKeys' );
    $count = 0;
	$selectedRows = json_decode(stripslashes($argumet));
	
    foreach($selectedRows as $row)
    {
	    $id = (integer) $row;
        $sql = "DELETE FROM `#__rekry_professions` "
		."WHERE `#__rekry_professions`.`id` = "
		.$id." LIMIT 1;";	
		$database->setQuery($sql);
        $result[0] = $database->query();		
		if ($result[0]) {
		$json['success'] = true;
		} else {
		$json['success'] = false;
		}
    }				
		$json = Zend_Json::encode($json);
        echo $json;
		
		exit();
		
	break;
	
	case 'arr_opp':
	
        ob_clean();
		
		$json['success'] = false;
		
    $argumet = mosGetParam( $_POST, 'deleteKeys' );
    $count = 0;
	$selectedRows = json_decode(stripslashes($argumet));
	$field = 'deleted';
	$value = 'true';
	
    foreach($selectedRows as $row)
    {
	    $id = (integer) $row;
		
		$sql = 'UPDATE #__rekry_opportunities SET '
		.$field.' = \''.$value.'\' '
		.'WHERE #__rekry_opportunities.op_id = '
		.$id.' ;';
		
		$database->setQuery($sql);
        $result[0] = $database->query();		
		if ($result[0]) {
		$json['success'] = true;
		} else {
		$json['success'] = false;
		}
    }				
		$json = Zend_Json::encode($json);
        echo $json;
		
		exit();
		
	break;
	
	case 'opp_opp':
	
        ob_clean();
		
		$json['success'] = false;
		
    $argumet = mosGetParam( $_POST, 'deleteKeys' );
    $count = 0;
	$selectedRows = json_decode(stripslashes($argumet));
	$field = 'deleted';
	$value = 'false';
	
    foreach($selectedRows as $row)
    {
	    $id = (integer) $row;
		
		$sql = 'UPDATE #__rekry_opportunities SET '
		.$field.' = \''.$value.'\' '
		.'WHERE #__rekry_opportunities.op_id = '
		.$id.' ;';
		
		$database->setQuery($sql);
        $result[0] = $database->query();		
		if ($result[0]) {
		$json['success'] = true;
		} else {
		$json['success'] = false;
		}
    }				
		$json = Zend_Json::encode($json);
        echo $json;
		
		exit();
		
	break;
	
	case 'app_int':
	
        ob_clean();
		
		$json['success'] = false;
		
    $argumet = mosGetParam( $_POST, 'deleteKeys' );
    $count = 0;
	$selectedRows = Zend_Json::decode(stripslashes($argumet));
	$field = 'int_enum';
	$value = 'true';
	
    foreach($selectedRows as $row)
    {
	    $id = (integer) $row;
		
		$sql = 'UPDATE #__rekry_applications SET '
		.$field.' = \''.$value.'\' '
		.'WHERE #__rekry_applications.ap_id = '
		.$id.' ;';
		
		$database->setQuery($sql);
        $result[0] = $database->query();		
		if ($result[0]) {
		$json['success'] = true;
		} else {
		$json['success'] = false;
		}
    }				
		$json = Zend_Json::encode($json);
        echo $json;
		
		exit();
		
	break;
	
	case 'rem_int':
	
        ob_clean();
		
		$json['success'] = false;
		
    $argumet = mosGetParam( $_POST, 'deleteKeys' );
    $count = 0;
	$selectedRows = Zend_Json::decode(stripslashes($argumet));
	$field = 'int_enum';
	$value = 'false';
	
    foreach($selectedRows as $row)
    {
	    $id = (integer) $row;
		
		$sql = 'UPDATE #__rekry_applications SET '
		.$field.' = \''.$value.'\' '
		.'WHERE #__rekry_applications.ap_id = '
		.$id.' ;';

		$database->setQuery($sql);
        $result[0] = $database->query();		
		if ($result[0]) {
		$json['success'] = true;
		} else {
		$json['success'] = false;
		}
    }				
		$json = Zend_Json::encode($json);
        echo $json;
		
		exit();
		
	break;
	
	case 'pub_opp':
	
        ob_clean();
		
		$json['success'] = false;
		
    $argumet = mosGetParam( $_POST, 'deleteKeys' );
    $count = 0;
	$selectedRows = json_decode(stripslashes($argumet));
	$field = 'active';
	$value = 'true';
	
    foreach($selectedRows as $row)
    {
	    $id = (integer) $row;
		
		$sql = 'UPDATE #__rekry_opportunities SET '
		.$field.' = \''.$value.'\' '
		.'WHERE #__rekry_opportunities.op_id = '
		.$id.' ;';
		
		$database->setQuery($sql);
        $result[0] = $database->query();		
		if ($result[0]) {
		$json['success'] = true;
		} else {
		$json['success'] = false;
		}
    }				
		$json = Zend_Json::encode($json);
        echo $json;
		
		exit();
		
	break;
	
	case 'unpub_opp':
	
        ob_clean();
		
		$json['success'] = false;
		
    $argumet = mosGetParam( $_POST, 'deleteKeys' );
    $count = 0;
	$selectedRows = json_decode(stripslashes($argumet));
	$field = 'active';
	$value = 'false';
	
    foreach($selectedRows as $row)
    {
	    $id = (integer) $row;
		
		$sql = 'UPDATE #__rekry_opportunities SET '
		.$field.' = \''.$value.'\' '
		.'WHERE #__rekry_opportunities.op_id = '
		.$id.' ;';
		
		$database->setQuery($sql);
        $result[0] = $database->query();		
		if ($result[0]) {
		$json['success'] = true;
		} else {
		$json['success'] = false;
		}
    }				
		$json = Zend_Json::encode($json);
        echo $json;
		
		exit();
		
	break;
	
	case 'lock_opp':
	
        ob_clean();
		
		$json['success'] = false;
		
    $argumet = mosGetParam( $_POST, 'deleteKeys' );
    $count = 0;
	$selectedRows = json_decode(stripslashes($argumet));
	$field = 'edit';
	$value = 'true';
	
    foreach($selectedRows as $row)
    {
	    $id = (integer) $row;
		
		$sql = 'UPDATE #__rekry_opportunities SET '
		.$field.' = \''.$value.'\' '
		.'WHERE #__rekry_opportunities.op_id = '
		.$id.' ;';
		
		$database->setQuery($sql);
        $result[0] = $database->query();		
		if ($result[0]) {
		$json['success'] = true;
		} else {
		$json['success'] = false;
		}
    }				
		$json = Zend_Json::encode($json);
        echo $json;
		
		exit();
		
	break;
	
	case 'unlock_opp':
	
        ob_clean();
		
		$json['success'] = false;
		
    $argumet = mosGetParam( $_POST, 'deleteKeys' );
    $count = 0;
	$selectedRows = json_decode(stripslashes($argumet));
	$field = 'edit';
	$value = 'false';
	
    foreach($selectedRows as $row)
    {
	    $id = (integer) $row;
		
		$sql = 'UPDATE #__rekry_opportunities SET '
		.$field.' = \''.$value.'\' '
		.'WHERE #__rekry_opportunities.op_id = '
		.$id.' ;';
		
		$database->setQuery($sql);
        $result[0] = $database->query();		
		if ($result[0]) {
		$json['success'] = true;
		} else {
		$json['success'] = false;
		}
    }				
		$json = Zend_Json::encode($json);
        echo $json;
		
		exit();
		
	break;

       case 'saveconfig':
        
		saveconfig();
		
		break;
		
		

	

    case "config":
	
	ob_clean();
	
    require_once($mosConfig_absolute_path
	.'/administrator/components/com_rekry/config.rekry.php');

$json['success'] = true;
$json['results'] = 1;
$json['config'][] = array('front' => $front,
	 'community' => $community,
	 'en' => $en,
	 'r1' => $r1,
	 'r2' => $r2,
	 'r3' => $r3,
	 'r4' => $r4,
	 'r5' => $r5,
	 'r6' => $r6,
	 'r7' => $r7,
	 'r8' => $r8,
	 'r9' => $r9,
	 'r10' => $r10,
	 'r11' => $r11,
	 'cult' => $cult,
	 'comp' => $comp,
	 'tpl_path' => utf8_encode($tpl_path)
	 );

$json = Zend_Json::encode($json);
echo $json;

	
       exit();

    break;


    case "about":


	$html = '<div  style="'
	.'padding:10px;">'
	.'<h2>Copyright Info</h2><br /><span style="color:blue;">
  <b>rekry!Joom ERP for Joomla 1.5.+ (Legacy Mode)</b>
 <br /> 
  LICENSE: Open Source (GNU GPL)<br />
 <br /> </span><span style="color:green;">
  @copyright  2006-2008 Teknologiaplaneetta<br />
  @license    <a href="http://www.gnu.org/copyleft/gpl.html" target="_blank">http://www.gnu.org/copyleft/gpl.html</a><br />
  @version    $Id$ 1.0.1 BETA<br />
  @link       <a href="http://www.teknologiaplaneetta.com/" target="_blank">http://www.teknologiaplaneetta.com/</a></span></div>';


	 $html .= '<!-- <div  style="padding:10px;">
	 <h2>Support</h2><br />
	 Any support/bugs/issues reports/posts/requests can be made to address <a href="http://dev.teknologiaplaneetta.com/jira/" target="_blank">http://dev.teknologiaplaneetta.com/jira/</a>. 
	 <br /><br />
	 If you\'re rekry!Joom user with making user account to our JIRA you can report feature requests and report proplems with with software design and its usage (bugs). It will help you if you report them and us who is created this solution for you for free of charge. Reporting makes rekry!Joom quality better!
	 <br /><br />	
	 <h2>Documentation/Wiki</h2><br />
	 <a href="http://dev.teknologiaplaneetta.com/confluence/display/JOOMLA/rekry%21Joom" target="_blank">http://dev.teknologiaplaneetta.com/.../rekry!Joom</a>
	 <br /><br /><h2>For Developers: Source Code/SVN Browser</h2><br />
	 <a href="http://dev.teknologiaplaneetta.com/fisheye/browse/public/joomla/components/com_rekry/" target="_blank">http://dev.teknologiaplaneetta.com/fisheye/.../com_rekry/</a>
	 </div>

	 <div  style="padding:10px;">
	  <h2>Look and fell</h2><br />
	  <b style="color: red;">Add line below to your site template:</b><br /><br /><span style="color: blue;">&lt;link href="&lt;?php echo $this->baseurl ?&gt;/components/com_rekry/css/default.css" rel="stylesheet" type="text/css" /&gt;   <br /><br /></span><b style="color: green;">;befor &lt;/head&gt; tag.</b>
<br /><br /> -->
	  <h2>Release Notes</h2>
	  <br />
	  <b>1.0.1 BETA (2008)</b>  <ol>
	  <li>ExtJS Based AJAX GUI</li>
	  <li>Zend Framework for making coding easier</li>
	  <li>Uploaded PDF CV files filenames are crypted based to HMAC key</li>
	  <li>Uploaded PDF CV files is modified by Zend Framework by notice from this file is confidential information</li>
	  <li>Applicant interviewlist</li>
	  <li>Template system and other coding features with Zend Framework</li>
	  <li>Encypted applicant data by PHP mcrypt extension that basics to applicant based HMAC check.</li>
	  </ol>
	  <b>1.0.1 ALPHA (2008)</b> <ol><li>Fixing some medium level security issues.</li></ol>
	  <b>1.0.0 (2006)</b> <ol><li>Just a basic idea for Joomla! Recruting Component</li></ol>
	 </div>

	 <div  style="padding:10px;">
	 <h2>Server Details</h2>
	 <br />
	 Zend Framework: <span style="color:';
	 $html .= (Zend_Version::compareVersion('1.5.2') === 1) ? 'red' : 'green'; 
	 $html .= ';">';	 	 
	 $html .= Zend_Version::VERSION; 	 
	 $html .= ' (needed version is 1.5.2 or above)
	 </span>
	 
	 <br />	 
	 
	 PHP: <span style="color:';
	 $html .= (version_compare(phpversion(), '5.2.0', '>')) ? 'green' : 'red'; 
	 $html .= ';">';
	 
	 $html .= phpversion(); 	 
	
	 $html .= ' (recommended version is 5.2.0 >= never)</span> 
	 <br />Safe Mode: ';  
	 $html .= (ini_get('safe_mode')==0) ? '<span style="color:green;">Off' : '<span style="color:red;">On'; 
	 $html .= '</span>
	 <br />Register Globals: '; 
	 $html .= (ini_get('register_globals')==0) ? '<span style="color:green;">Off' : '<span style="color:red;">On'; 
	 $html .= '</span>
     <br />Memory Limit: <span style="color: '; 
	 $html .= (str_replace('M','',ini_get('memory_limit'))>='30') ? 'green' : 'red'; 
	 $html .= ';">';
	 $html .= ini_get('memory_limit'); 
	 $html .= '</span>
	 <br /><br />
	 </div>';
	 
	 echo $html;
		
    break;
	default:	
	
	 $mainframe->addCustomHeadTag('<link rel="stylesheet" type="text/css" href="components/com_rekry/os/ext/resources/css/ext-all.css" />
<script type="text/javascript" src="components/com_rekry/os/ext/adapter/ext/ext-base.js"></script>
<script type="text/javascript" src="components/com_rekry/os/ext/ext-all.js"></script>
    <script type="text/javascript" src="components/com_rekry/os/desktop/js/Ext.ux.grid.CellActions.js"></script>
	<script type="text/javascript" src="components/com_rekry/os/desktop/js/Ext.ux.grid.RowActions.js"></script>
	<script type="text/javascript" src="components/com_rekry/os/desktop/js/Ext.ux.grid.Search.js"></script>
	<script type="text/javascript" src="components/com_rekry/os/desktop/opp.js"></script>
    <link rel="stylesheet" type="text/css" href="components/com_rekry/os/desktop/css/desktop.css" />
	<link rel="stylesheet" type="text/css" href="components/com_rekry/os/desktop/css/Ext.ux.grid.CellActions.css" />
	<link rel="stylesheet" type="text/css" href="components/com_rekry/os/desktop/css/Ext.ux.grid.RowActions.css" />');
	
	showGUI( $option );   
	
	break;
}

function saveconfig(){

    ob_clean();
	
	global $mosConfig_absolute_path;
	
	$front = mosGetParam( $_POST, 'front' );
	$community = mosGetParam( $_POST, 'community' );
	$en = mosGetParam( $_POST, 'en' );
	$r1 = mosGetParam( $_POST, 'r1' );
	$r2 = mosGetParam( $_POST, 'r2' );
	$r3 = mosGetParam( $_POST, 'r3' );
	$r4 = mosGetParam( $_POST, 'r4' );
	$r5 = mosGetParam( $_POST, 'r5' );	
	$r6 = mosGetParam( $_POST, 'r6' );
	$r7 = mosGetParam( $_POST, 'r7' );
	$r8 = mosGetParam( $_POST, 'r8' );
	$r9 = mosGetParam( $_POST, 'r9' );
	$r10 = mosGetParam( $_POST, 'r10' );	
	$r11 = mosGetParam( $_POST, 'r11' );
	$cult = mosGetParam( $_POST, 'cult' );	
	$comp = mosGetParam( $_POST, 'comp' );	
	
	if ($front == 'true') { $front = 1; } else { $front = 0;}
	if ($community == 'true') { $community = 1; } else { $community = 0;}
	if ($en == 'true') { $en = 1; } else { $en = 0;}
	if ($r1 == 'true') { $r1 = 1; } else { $r1 = 0;}
	if ($r2 == 'true') { $r2 = 1; } else { $r2 = 0;}
	if ($r3 == 'true') { $r3 = 1; } else { $r3 = 0;}
	if ($r4 == 'true') { $r4 = 1; } else { $r4 = 0;}
	if ($r5 == 'true') { $r5 = 1; } else { $r5 = 0;}
	if ($r6 == 'true') { $r6 = 1; } else { $r6 = 0;}
	if ($r7 == 'true') { $r7 = 1; } else { $r7 = 0;}
	if ($r8 == 'true') { $r8 = 1; } else { $r8 = 0;}
	if ($r9 == 'true') { $r9 = 1; } else { $r9 = 0;}
	if ($r10 == 'true') { $r10 = 1; } else { $r10 = 0;}
	if ($r11 == 'true') { $r11 = 1; } else { $r11 = 0;}
	if ($comp == 'true') { $comp = 1; } else { $comp = 0;}
	
	$tpl_path = mosGetParam( $_POST, 'tpl_path' );	
	
	settype($front,"integer");
	settype($community,"integer");
	settype($en,"integer");
	settype($r1,"integer");
	settype($r2,"integer");
	settype($r3,"integer");
	settype($r4,"integer");
	settype($r5,"integer");
	settype($r6,"integer");
	settype($r7,"integer");
	settype($r8,"integer");
	settype($r9,"integer");
	settype($r10,"integer");
	settype($r11,"integer");	
	settype($comp,"integer");
	
	$config = "<?php\n\n";
	$config .= "$";
	$config .= "front = ".strip_tags(stripslashes($front)).";\n";
	$config .= "$";
	$config .= "community = ".strip_tags(stripslashes($community)).";\n";
	$config .= "$";
	$config .= "en = ".strip_tags(stripslashes($en)).";\n";
	$config .= "$";
    $config .= "r1 = \"".strip_tags(stripslashes($r1))."\";"."\n";
    $config .= "$";
    $config .= "r2 = \"".strip_tags(stripslashes($r2))."\";"."\n";
    $config .= "$";
    $config .= "r3 = \"".strip_tags(stripslashes($r3))."\";"."\n";
    $config .= "$";
    $config .= "r4 = \"".strip_tags(stripslashes($r4))."\";"."\n";
    $config .= "$";
    $config .= "r5 = \"".strip_tags(stripslashes($r5))."\";"."\n";
    $config .= "$";
    $config .= "r6 = \"".strip_tags(stripslashes($r6))."\";"."\n";
    $config .= "$";
    $config .= "r7 = \"".strip_tags(stripslashes($r7))."\";"."\n";
    $config .= "$";
    $config .= "r8 = \"".strip_tags(stripslashes($r8))."\";"."\n";
    $config .= "$";
    $config .= "r9 = \"".strip_tags(stripslashes($r9))."\";"."\n";
    $config .= "$";
    $config .= "r10 = \"".strip_tags(stripslashes($r10))."\";"."\n";
    $config .= "$";
    $config .= "r11 = \"".strip_tags(stripslashes($r11))."\";"."\n";   
    $config .= "$";
    $config .= "cult = \"".strip_tags(stripslashes($cult))."\";"."\n";   
    $config .= "$";
    $config .= "comp = \"".strip_tags(stripslashes($comp))."\";"."\n";   
    $config .= "$";
    $config .= "tpl_path = \"".strip_tags(stripslashes($tpl_path))."\";"."\n";	
	
	$config .= "\n"."?>";
	
	if ($fp = fopen($mosConfig_absolute_path.'/administrator/components/com_rekry/config.rekry.php', "w")) {
		fputs($fp, $config, strlen($config));
		fclose ($fp);
	    echo '{"success": true}';
	} else {
		echo '{"success": false}';
	}
	
    exit();
	
}




?>
