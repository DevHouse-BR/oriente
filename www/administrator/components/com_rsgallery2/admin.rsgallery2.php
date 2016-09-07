<?php
/**
* This file contains the non-presentation processing for the Admin section of RSGallery.
* @version $Id$
* @package RSGallery2
* @copyright (C) 2003 - 2006 RSGallery2
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* RSGallery is Free Software
*/
defined( '_VALID_MOS' ) or die( 'Access Denied.' );

// initialize RSG2 core functionality
require_once( $mosConfig_absolute_path.'/administrator/components/com_rsgallery2/init.rsgallery2.php' );

// add link to css
?>
<link href="<?php echo $mosConfig_live_site; ?>/administrator/components/com_rsgallery2/admin.rsgallery2.css" rel="stylesheet" type="text/css" />
<?php

//Load overlib routine for Tooltips
mosCommonHTML::loadOverlib();

require_once( $mainframe->getPath( 'admin_html' ) );

global $opt, $catid, $uploadStep, $numberOfUploads, $e_id ;
$opt                = mosGetParam( $_REQUEST, 'opt', '' );
$catid              = mosGetParam( $_REQUEST, 'catid', 0 );
$uploadStep         = mosGetParam( $_REQUEST, 'uploadStep', 0 );
$numberOfUploads    = mosGetParam( $_REQUEST, 'numberOfUploads', 1 );
$e_id               = mosGetParam( $_REQUEST, 'e_id', 1 );

$cid    = mosGetParam( $_REQUEST, 'cid', array(0) );
$id     = mosGetParam( $_REQUEST, 'id', 0 );

$rsgOption = mosGetParam( $_REQUEST, 'rsgOption', '' );


/**
    this is the new $rsgOption switch.  each option will have a switch for $task within it.
**/
switch( $rsgOption ) {
    case 'galleries':
        require_once( $rsgOptions_path . 'galleries.php' );
    break;
    case 'images':
        require_once( $rsgOptions_path . 'images.php' );
    break;
}

/**
    admin pathway hack when $rsgOption is used.
    this probably only works with Joomla <1.5
**/
if( $rsgOption != '' ){
    $option = "<a href='$mosConfig_live_site"
        . "/administrator/index2.php?option=com_rsgallery2'>"
        . "RSGallery2</a> / ";
    if( $task == '' ){
        $option .= "$rsgOption";
    }
    else{
        $option .= "<a href='$mosConfig_live_site"
        . "/administrator/index2.php?option=com_rsgallery2&rsgOption=$rsgOption'>"
        . "$rsgOption</a>";
    }
}

// only use the legacy task switch if rsgOption is not used.
if( $rsgOption == '' )
switch ( mosGetParam( $_REQUEST, 'task', '' ) ){
//     settings/config tasks
    case 'applyConfig':
        HTML_RSGallery::RSGalleryHeader('config', _RSGALLERY_HEAD_CONFIG);
        saveConfig();
        showConfig($option);
        HTML_RSGallery::RSGalleryFooter();
        break;
    case 'saveConfig':
        HTML_RSGallery::RSGalleryHeader('cpanel', _RSGALLERY_HEAD_CPANEL);
        saveConfig();
        HTML_RSGallery::showCP();
        HTML_RSGallery::RSGalleryFooter();
        break;
    case "showConfig":
        HTML_RSGallery::RSGalleryHeader('config', _RSGALLERY_HEAD_CONFIG);
        showConfig();
        HTML_RSGallery::RSGalleryFooter();
        break;

//     image tasks
    case "edit_image":
        HTML_RSGallery::RSGalleryHeader('edit', _RSGALLERY_HEAD_EDIT);
        editImageX($option, $cid[0]);
        HTML_RSGallery::RSGalleryFooter();
        break;
    case "upload":
        HTML_RSGallery::RSGalleryHeader('browser', _RSGALLERY_HEAD_UPLOAD);
        showUpload();
        HTML_RSGallery::RSGalleryFooter();
        break;
    case "batchupload":
        HTML_RSGallery::RSGalleryHeader('', _RSGALLERY_HEAD_UPLOAD_ZIP);
        batch_upload($option, $task);
        HTML_RSGallery::RSGalleryFooter();
        break;
    case "save_batchupload":
        save_batchupload();
        break;
    case "view_images":
        HTML_RSGallery::RSGalleryHeader();
        viewImagesX($option);
        HTML_RSGallery::RSGalleryFooter();
        break;
    case "save_image":
        saveImageX($option, $id);
        break;
    case "move_image":
        moveImageX($option, $cid);
        break;
    case "delete_image":
        HTML_RSGallery::RSGalleryHeader();
        deleteImageX( $cid, $option );
        viewImagesX($option);
        HTML_RSGallery::RSGalleryFooter();
        break;
	case 'edit_css':
		editTemplateCSS($option);
		HTML_RSGallery::RSGalleryFooter();
		break;
	case 'save_css':
		saveTemplateCSS( $option, $client );
        break;


//     image and category tasks
    case "categories_orderup":
    case "images_orderup":
        orderRSGallery( $cid[0], -1, $option, $task );
        break;
    case "categories_orderdown":
    case "images_orderdown":
        orderRSGallery( $cid[0], 1, $option, $task );
        break;

//     special/debug tasks
    case 'purgeEverything':
        HTML_RSGallery::RSGalleryHeader('cpanel', _RSGALLERY_HEAD_CPANEL);
        purgeEverything();
        HTML_RSGallery::showCP();
        HTML_RSGallery::RSGalleryFooter();
        break;
    case 'reallyUninstall':
        HTML_RSGallery::RSGalleryHeader('cpanel', _RSGALLERY_HEAD_CPANEL);
        reallyUninstall();
        HTML_RSGallery::showCP();
        HTML_RSGallery::RSGalleryFooter();
        break;
/**    case "migration":
        HTML_RSGallery::RSGalleryHeader('dbrestore', 'Migration options');
        showMigration();
        HTML_RSGallery::RSGalleryFooter();
        break;*/
    case "install":
        HTML_RSGallery::RSGalleryHeader('install', _RSGALLERY_HEAD_MIGRATE);
        RSInstall();
        HTML_RSGallery::RSGalleryFooter();
        break;
    case "regen_thumbs":
        HTML_RSGallery::RSGalleryHeader();
        HTML_RSGALLERY::printAdminMsg( "Feature not implemented. To follow.\n\n\nRonald Smit", true );
        HTML_RSGallery::RSGalleryFooter();
        break;
    case "consolidate_db":
        HTML_RSGallery::RSGalleryHeader('dbrestore',_RSGALLERY_HEAD_CONSDB);
        consolidateDbInform($option);
        HTML_RSGallery::RSGalleryFooter();
        break;
    case "consolidate_db_go":
        HTML_RSGallery::RSGalleryHeader('dbrestore',_RSGALLERY_HEAD_CONSDB);
        consolidateDbGo($option);
        HTML_RSGallery::RSGalleryFooter();
        break;
    /*case "import_captions":
        HTML_RSGallery::RSGalleryHeader('generic', 'Import Captions');
        import_captions();
        HTML_RSGallery::RSGalleryFooter();
        break;
        */
    case 'viewChangelog':
        HTML_RSGallery::RSGalleryHeader('viewChangelog', _RSGALLERY_HEAD_LOG);
        viewChangelog();
        HTML_RSGallery::RSGalleryFooter();
        break;
    case 'config_dumpVars':
        HTML_RSGallery::RSGalleryHeader('viewChangelog', _RSGALLERY_HEAD_CONF_VARIA);
        config_dumpVars();
        HTML_RSGallery::RSGalleryFooter();
        break;

    case 'config_rawEdit_apply':
        HTML_RSGallery::RSGalleryHeader('config_rawEdit', _RSGALLERY_HEAD_CONF_RAW_EDIT);
        config_rawEdit_save();
        config_rawEdit( );
        HTML_RSGallery::RSGalleryFooter();
        break;
    case 'config_rawEdit_save':
        HTML_RSGallery::RSGalleryHeader('cpanel', _RSGALLERY_HEAD_CPANEL);
        config_rawEdit_save();
        HTML_RSGallery::showCP();
        HTML_RSGallery::RSGalleryFooter();
        break;
    case 'config_rawEdit':
        HTML_RSGallery::RSGalleryHeader('config_rawEdit', _RSGALLERY_HEAD_CONF_RAW_EDIT);
        config_rawEdit( );
        HTML_RSGallery::RSGalleryFooter();
        break;
    case 'c_delete':
        HTML_RSGallery::RSGalleryHeader('dbrestore', _RSGALLERY_HEAD_CONSDB);
        c_delete();
        consolidateDbGo($option);
        HTML_RSGallery::RSGalleryFooter();
        break;
    case 'c_create':
        HTML_RSGallery::RSGalleryHeader('dbrestore', _RSGALLERY_HEAD_CONSDB);
        c_create($id);
        HTML_RSGALLERY::printAdminMsg('Missing images created');
        consolidateDbGo($option);
        HTML_RSGallery::RSGalleryFooter();
        break;
    case 'db_create':
    	db_create();
    	break;
    case 'test':
    	test();
    	break;
//     default - the control panel
    case "controlPanel":
    default:
        HTML_RSGallery::RSGalleryHeader('cpanel', _RSGALLERY_HEAD_CPANEL);
        HTML_RSGallery::showCP();
        HTML_RSGallery::RSGalleryFooter();
        break;
}

function test() {
	global $rsgAccess, $my;
	$rsgAccess->actionPermitted('del_img');
}

/**
 *  raw configuration editor save, debug only
 */
function config_rawEdit_save(){ 
       
    $rsgConfig = new rsgConfig();
    
    if($rsgConfig->saveConfig($_REQUEST)){
        HTML_RSGALLERY::printAdminMsg(_RSGALLERY_CONF_SAVED);
        
		//save succesfully,try creating some image directories if we were ask  to
        if( mosGetParam($_REQUEST,'createImdDirs') )
            HTML_RSGALLERY::printAdminMsg(_RSGALLERY_CONF_CREATE_DIR,true);
        } else {
        HTML_RSGALLERY::printAdmMsg(_RSGALLERY_CONF_SAVE_ERROR);
    }
}

function config_rawEdit( $save=false ){
    if( $save ){
        // save
    }

    HTML_RSGALLERY::config_rawEdit();
}

function viewChangelog(){
    //global $mosConfig_absolute_path;
    
    echo '<pre>';
    readfile( JPATH_RSGALLERY2_ADMIN.'/changelog.php' );
    echo '</pre>';
}

function config_dumpVars(){
    global $rsgConfig;

    $vars = get_object_vars( $rsgConfig );

    echo '<pre>';
    print_r( $rsgConfig );
    echo '</pre>';
}

/**
 * This function is called during step 2 of the RSGallery installation. It
 * outputs the HTML allowing the user to select between a "fresh" install,
 * or an "upgrade" install.
 */
function RSInstall() {
    global $opt, $mosConfig_live_site;
    require_once(JPATH_RSGALLERY2_ADMIN.'/includes/install.class.php');
    
    //Initialize new install instance
    $rsgInstall = new rsgInstall();

    if (isset($_REQUEST['type']))
        $type = mosGetParam ( $_REQUEST, 'type'  , '');
    else
        $type = NULL;

    switch ($opt) {
        case "fresh":
            $rsgInstall->FreshInstall();
            break;
        case "upgrade":
            $rsgInstall->upgradeInstall();
            break;
        case "migration":
            if( $type=='' ) {
            	$rsgInstall->showMigrationOptions();	
            	} else {
                $result = $rsgInstall->doMigration( $type );
                if( $result !==true ) {
                    echo $result;
                    HTML_RSGallery::showCP();
                	} else {
                    	echo _RSGALLERY_MIGR_OK;
                    	HTML_RSGallery::showCP();
                	}
            	}
            break;
        default:
            $rsgInstall->showInstallOptions();
            break;
        }
    }

/**
 * deletes all pictures, thumbs and their database entries. It leaves category information in DB intact.
 * this is a quick n dirty function for development, it shouldn't be available for regular users.
 */
function purgeEverything(){
    global $rsgConfig;
    
    $fullPath_thumb = JPATH_ROOT.$rsgConfig->get('imgPath_thumb') . '/';
    $fullPath_display = JPATH_ROOT.$rsgConfig->get('imgPath_display') . '/';
    $fullPath_original = JPATH_ROOT.$rsgConfig->get('imgPath_original') . '/';

    processAdminSqlQueryVerbosely( 'DELETE FROM #__rsgallery2_files', _RSGALLERY_PURGE_IMG );
    processAdminSqlQueryVerbosely( 'DELETE FROM #__rsgallery2_galleries', _RSGALLERY_PURGE_GAL );
    processAdminSqlQueryVerbosely( 'DELETE FROM #__rsgallery2_config', _RSGALLERY_PURGE_CONFIG );
    processAdminSqlQueryVerbosely( 'DELETE FROM #__rsgallery2_comments', _RSGALLERY_PURGE_COMMENTS );

    // remove thumbnails
    HTML_RSGALLERY::printAdminMsg( 'removing thumb images.' );
    foreach ( glob( $fullPath_thumb.'*' ) as $filename ) {
        if( is_file( $filename )) unlink( $filename );
    }
    
    // remove display imgs
    HTML_RSGALLERY::printAdminMsg( 'removing display images.' );
    foreach ( glob( $fullPath_display.'*' ) as $filename ) {
        if( is_file( $filename )) unlink( $filename );
    }
    
    // remove display imgs
    HTML_RSGALLERY::printAdminMsg( 'removing original images.' );
    foreach ( glob( $fullPath_original.'*' ) as $filename ) {
        if( is_file( $filename )) unlink( $filename );
    }
    
    HTML_RSGALLERY::printAdminMsg( 'purged.', true );
}

/**
 * drops all RSG2 tables, deletes image directory structure
 * use before uninstalling to REALLY uninstall
 * @todo This is a quick hack.  make it work on all OS and with non default directories.
 */
function reallyUninstall(){
    global $mosConfig_absolute_path;
    
    passthru( "rm -r $mosConfig_absolute_path/images/rsgallery");
    HTML_RSGALLERY::printAdminMsg( _RSGALLERY_REAL_UNINST_DIR );

    processAdminSqlQueryVerbosely( 'DROP TABLE IF EXISTS #__rsgallery2_acl', _RSGALLERY_REAL_UNINST_DROP_GAL );
    processAdminSqlQueryVerbosely( 'DROP TABLE IF EXISTS #__rsgallery2_files', _RSGALLERY_REAL_UNINST_DROP_FILES );
    processAdminSqlQueryVerbosely( 'DROP TABLE IF EXISTS #__rsgallery2_cats', _RSGALLERY_REAL_UNINST_DROP_GAL );
    processAdminSqlQueryVerbosely( 'DROP TABLE IF EXISTS #__rsgallery2_galleries', _RSGALLERY_REAL_UNINST_DROP_GAL );
    processAdminSqlQueryVerbosely( 'DROP TABLE IF EXISTS #__rsgallery2_config', _RSGALLERY_REAL_UNINST_DROP_CONF );
    processAdminSqlQueryVerbosely( 'DROP TABLE IF EXISTS #__rsgallery2_comments', _RSGALLERY_REAL_UNINST_DROP_COM );

    HTML_RSGALLERY::printAdminMsg( _RSGALLERY_REAL_UNINST_DONE );
}

/**
 * runs a sql query, displays admin message on success or error on error
 * @param String sql query
 * @param String message to display on success
 * @return boolean value indicating success
 */
function processAdminSqlQueryVerbosely( $query, $successMsg ){
    global $database;
    
    $database->setQuery( $query );
    $database->query();
    if($database->getErrorMsg()){
            HTML_RSGALLERY::printAdminMsg( $database->getErrorMsg(), true );
            return false;
    }
    else{
        HTML_RSGALLERY::printAdminMsg( $successMsg );
        return true;
    }
}

function deleteImageX( $cid, $option ){
    foreach ($cid as $id){
        imgUtils::deleteImage( galleryUtils::getFileNameFromId( $id ));
    }
    
    HTML_RSGALLERY::printAdminMsg( _RSGALLERY_ALERT_IMGDELETEOK );
}

function c_delete() {
global $database;
    if (isset($_REQUEST['cid']))
    	$cid    = mosGetParam($_REQUEST, 'cid', '');
    	
    if (isset($_REQUEST['name']))
    	$name	= mosGetParam($_REQUEST, 'name', '');
    else
    	$name = galleryUtils::getFileNameFromId( $cid );
    
    //Check if file is in database
    $sql ="SELECT count(name) FROM #__rsgallery2_files WHERE name = '$name'";
    $database->setQuery($sql);
    $result = $database->loadResult();
    
    if ($result > 0) {
    	//Delete from database
    	imgUtils::deleteImage( galleryUtils::getFileNameFromId( $cid ) );
    	HTML_RSGALLERY::printAdminMsg( _RSGALLERY_ALERT_IMGDELETEOK );
    } else {
    	imgUtils::deleteImage( $name );
    	HTML_RSGALLERY::printAdminMsg( _RSGALLERY_ALERT_IMGDELETEOK );
    }
}
/**
 * Used in the consolidate database function
 * Creates images based on an image id or an image name
 */
function c_create() {
	global $rsgConfig, $database;
	//Check if id or name is set
	if ( isset( $_REQUEST['id'] ) ) {
		$id    = mosGetParam($_REQUEST, 'id', '');
		$name = galleryUtils::getFileNameFromId($id);
	}
	elseif ( isset($_REQUEST['name'] ) ) {
		$name    = mosGetParam($_REQUEST, 'name', '');
	} else {
		mosRedirect("index2.php?option=com_rsgallery2&task=batchupload", 'No fileinformation found. This should never happen!');
	}
	
	//Just for readability of code
	$original = JPATH_ORIGINAL.DS.$name;
	$display  = JPATH_DISPLAY.DS.imgUtils::getImgNameDisplay($name);
	$thumb    = JPATH_THUMB.DS.imgUtils::getImgNameThumb($name);
	    
	if ( file_exists($original) ) {
		//Check if display image exists, if not make it.
		if (!file_exists($display)) {
	    	imgUtils::makeDisplayImage($original, NULL, $rsgConfig->get('image_width') );
	    }
		if (!file_exists($thumb)) {
	        imgUtils::makeThumbImage($original);
	    }
	} else {
	    if (file_exists($display)) {
	        copy($display, $original);
	    }
	    if (!file_exists($thumb)) {
	        imgUtils::makeThumbImage($display);
	    }
	}
}
/**
 * Creates DB records for images in system without DB entries
 */
function db_create() {
	global $database;
	if (isset($_REQUEST['name']))     		$name = mosGetParam ( $_REQUEST, 'name'  , '');
    if (isset($_REQUEST['gallery_id']))     $gallery_id = mosGetParam ( $_REQUEST, 'gallery_id'  , '');
    
    //Force only first entry, if more are selected. Temporary measure untill multiple entries is supported!
    if ( is_array($name) )
    	$name = $name[0];
    	
    if ( is_array($gallery_id) )
    	$gallery_id = $gallery_id[0];
    
    //Redirect if no gallery chosen
    if ($gallery_id < 1)
    	mosRedirect("index2.php?option=com_rsgallery2&task=consolidate_db_go", "No gallery chosen to place image in!");
    
    //If we are here, we're good to go. Save entry into database
    $title = explode(".", $name);
    $descr = "";
    
    // determine ordering
	$database->setQuery("SELECT COUNT(*) FROM #__rsgallery2_files WHERE gallery_id = '$gallery_id'");
	$ordering = $database->loadResult() + 1;
	
	$database->setQuery("INSERT INTO #__rsgallery2_files".
                " (title, name, descr, gallery_id, date, ordering, userid) VALUES".
                " ('$title[0]', '$name', '$descr', '$gallery_id', now(), '$ordering', '$my->id')");
	if ( $database->query() )
		mosRedirect("index2.php?option=com_rsgallery2&task=consolidate_db_go", "Images succesfully added to the database!");
	else
		mosRedirect("index2.php?option=com_rsgallery2&task=consolidate_db_go", "Images could NOT be added to the database!");
}

function save_batchupload()
    {
    global $database, $mosConfig_live_site, $rsgConfig;
    
    //Try to bypass max_execution_time as set in php.ini
    set_time_limit(0);
    
    require_once(JPATH_RSGALLERY2_ADMIN.'/includes/img.utils.php');
    $FTP_path = $rsgConfig->get('ftp_path');

    if (isset($_REQUEST['teller']))     $teller = mosGetParam ( $_REQUEST, 'teller'  , '');
    if (isset($_REQUEST['delete']))     $delete = mosGetParam ( $_REQUEST, 'delete'  , '');
    if (isset($_REQUEST['filename']))   $filename = mosGetParam ( $_REQUEST, 'filename'  , '');
    if (isset($_REQUEST['ptitle']))     $ptitle = mosGetParam ( $_REQUEST, 'ptitle'  , '');
    if (isset($_REQUEST['descr']))      $descr = mosGetParam ( $_REQUEST, 'descr'  , array(0));

    //Check if all categories are chosen
    if (isset($_REQUEST['category']))
        $category = mosGetParam ( $_REQUEST, 'category'  , '');
    else
        $category = array(0);

    if ( in_array("0",$category) ) {
        mosRedirect("index2.php?option=com_rsgallery2&task=batchupload", _RSGALLERY_ALERT_NOCATSELECTED);
        }

     for($i=0;$i<$teller;$i++)
        {
        //If image is marked for deletion, delete and continue with next iteration
        if (isset($delete[$i]) AND ($delete[$i] == 'true'))
            {
            //Delete file from server
            unlink(JPATH_ROOT."/media/".$filename[$i]);
            continue;
            }
        else
            {
            //Setting variables for importImage()
            $imgTmpName = JPATH_ROOT."/media/".$filename[$i];
            $imgName = $filename[$i];
            $imgCat = $category[$i];
            $imgTitle = $ptitle[$i];
            $imgDesc = $descr[$i];
            
            //Import image
            $e = imgUtils::importImage($imgTmpName, $imgName, $imgCat, $imgTitle, $imgDesc);
            
            //Check for errors
            if ( $e !== true )
                {
                $errors[] = $e;
                }
            }
        }
        // Error handling
        if (isset($errors ))
            {
            if ( count( $errors ) == 0)
                {
                echo _RSGALLERY_ALERT_UPLOADOK;
                }
            else
                {
                foreach( $errors as $err )
                    {
                        echo $err->toString();
                    }
                }
            }
        else
            {
            //Everything went smoothly, back to Control Panel
            mosRedirect("index2.php?option=com_rsgallery2", _RSGALLERY_ALERT_UPLOADOK);
            }

    }

function cancelGallery($option)
    {
    mosRedirect("index2.php?option=$option");
    }

/**
 * This function is called when you select batchupload from the backend. It
 * detects whether you choose ZIP or FTP and acts accordingly.
 * When you choose ZIP it unzips the file you upload to "/media" for further
 * handling, if you choose FTP it reads the files from the directory you uploaded
 * the files to and copies them to "/media".(this dir must be on the local server).
 * @todo Better error trapping
 * @todo Check FTP handling bit
 */
 
function batch_upload($option) {
    global $database, $mosConfig_live_site, $rsgConfig;
    $FTP_path = $rsgConfig->get('ftp_path');

    //Retrieve data from submit form
    if (isset($_REQUEST['batchmethod']))    $batchmethod = mosGetParam ( $_REQUEST, 'batchmethod'  , '');
    if (isset($_REQUEST['uploaded']))         $uploaded = mosGetParam ( $_REQUEST, 'uploaded'  , '');
    if (isset($_REQUEST['selcat']))         $selcat = mosGetParam ( $_REQUEST, 'selcat'  , '');
    if (isset($_FILES['zip_file']))         $zip_file = mosGetParam ( $_FILES, 'zip_file'  , '');
    if (isset($_REQUEST['ftppath']))        $ftppath = mosGetParam ( $_REQUEST, 'ftppath'  , '');
    if (isset($_REQUEST['xcat']))           $xcat = mosGetParam ( $_REQUEST, 'xcat'  , '');
    
    $database->setQuery( "SELECT id FROM #__rsgallery2_galleries" );
    $database->query();
    if( $database->getNumRows()==0 ){
        HTML_RSGALLERY::requestCatCreation( );
        return;
    }
    
    //New instance of fileHandler
    $uploadfile = new fileHandler();
    
    if (isset($uploaded))
        {
        if ($batchmethod == "zip") {
            if ($uploadfile->checkSize($zip_file) == 1) {
                $ziplist = $uploadfile->handleZIP($zip_file);
            } else {
                //Error message
                mosRedirect( "index2.php?option=com_rsgallery2&task=batchupload", _RSGALLERY_ZIP_TO_BIG);
            }
        } else {
            $ziplist = $uploadfile->handleFTP($ftppath);
        }
        //show all thumbs on a page with details
        HTML_RSGALLERY::batch_upload_2($ziplist);
    } else {
        HTML_RSGALLERY::batch_upload($option);
    }
}//End function

function editImageX($option, $cid){
    global $database;
    if (isset($_REQUEST['e_id']))    $e_id = mosGetParam ( $_REQUEST, 'e_id'  , '');
    if ( $cid[0] != "" ){
        $e_id = $cid;
    }
    $database->setQuery("SELECT a.name as fname, title, descr FROM".
						" #__rsgallery2_files AS a, #__rsgallery2_galleries AS b WHERE".
    					" a.gallery_id = b.id AND a.id='$e_id'");
    $rows = $database->loadObjectList();
    HTML_RSGALLERY::editImage($option, $e_id, $rows);
}

function moveImageX($option, $cid) {
    global $database, $mainframe;
    $catmoveid = $mainframe->getUserStateFromRequest( "catmoveid{$option}", 'catmoveid', 0 );

    // there will be at least 1 image selected for a move as well as a valid move category, but check anyways
    $database->setQuery("SELECT id FROM #__rsgallery2_galleries WHERE id = '$catmoveid'");

    if ($cid && $catmoveid && $database->loadResult()){
        // get largest ordering num from target category
        $database->setQuery("SELECT MAX(ordering) FROM #__rsgallery2_files WHERE gallery_id = '$catmoveid'");
        $k=$database->loadResult()+1;
        for($i=0;$i<count($cid);$i++){
            $e_id = $cid[$i];
            $database->setQuery("UPDATE #__rsgallery2_files SET ordering = $k, gallery_id = '$catmoveid' WHERE id='$e_id'");
            $database->query();
            $k++;
        }
    viewImagesX($option);
   }
}

/*
function ftp_upload() {
global $database, $mosConfig_absolute_path, $mosConfig_live_site, $submit, $rsgConfig;
$FTP_path = $rsgConfig->get('ftp_path');
$allowed_ext = array("gif","jpg","png");
    
if (isset($_REQUEST['submit'])) $submit = mosGetParam ( $_REQUEST, 'submit'  , '');

    if ($submit) {
        if( $handle = opendir( $FTP_path ) )
            {
            while (false !== ($file = readdir($handle)))
                {
                if ($file != "." && $file != "..")
                    {
                    if( copy( $FTP_path.$file, "$mosConfig_absolute_path/media/$file" ) )
                        {
                        chmod($mosConfig_absolute_path."/media/".$file,0755);
                            // make sure file is an image and process it
                            $frag = array_reverse(explode(".", $file));
                            $ext = strtolower($frag[0]);
    
                            if( in_array( $ext, $allowed_ext ) )
                            {
                                $ziplist[]['filename'] = $file;
                                unlink( $FTP_path.$file );
                            }
                        }
                    }
                }
            closedir($handle);
            }
            //show all thumbs on a page with details
            HTML_RSGALLERY::batch_upload_2($ziplist, $mosConfig_live_site,$mosConfig_absolute_path);
        } else {
        HTML_RSGALLERY::ftp_upload();
    }
}


function showUpload(){
    global $catid, $database, $uploadStep, $rsgConfig;

    require_once(JPATH_RSGALLERY2_ADMIN.'/includes/img.utils.php');
    if (isset($_REQUEST['uploadstep'])) $uploadstep = mosGetParam ( $_REQUEST, 'uploadstep'  , ''); 


    switch($uploadStep){
        // choose category
        case 0:
        case 1:
            // determine if any galleries exist
            $database->setQuery( "SELECT id FROM #__rsgallery2_galleries" );
            $database->query();

            if( $database->getNumRows()==0 ){
                HTML_RSGALLERY::requestCatCreation( );
                return;
            }

            HTML_RSGALLERY::showUploadStep1( );

            break;

        // choose number of files
        case 2:
            HTML_RSGALLERY::showUploadStep2( );
            break;

        // choose files to upload
        case 3:
            HTML_RSGALLERY::showUploadStep3( );
            break;

        // files uploaded
        case 4:
            if (isset($_REQUEST['imgTitle'])) $imgTitle = mosGetParam ( $_REQUEST, 'imgTitle'  , ''); 
            //if (isset($_REQUEST['images'])) $images = mosGetParam ( $_REQUEST, 'images'  , ''); 
            if (isset($_REQUEST['descr'])) $descr = mosGetParam ( $_REQUEST, 'descr'  , ''); 
            if (isset($_REQUEST['catid'])) $catid = mosGetParam ( $_REQUEST, 'catid'  , '');
            if (isset($_FILES['images'])) $files = mosGetParam ($_FILES, 'images','');
            
            $errors = array();
			
            foreach ($files["error"] as $key => $error) {
                if($error != UPLOAD_ERR_OK){
                    $errors[] = new imageUploadError($files["name"][$key], $error);
                    continue;
                }

                // check if file was actually uploaded
                if( !is_uploaded_file( $files["tmp_name"][$key] )) {
                    $errors[] = new imageUploadError( $files["tmp_name"][$key], "not an uploaded file, potential malice detected!" );
                    continue;
                }

                $e = imgUtils::importImage($files["tmp_name"][$key], $files["name"][$key], $catid, $imgTitle[$key], $descr[$key]);

                if ( $e !== true ) $errors[] = $e;
            }

            if ( count( $errors ) == 0){
                echo _RSGALLERY_ALERT_UPLOADOK;
            } else {
                foreach( $errors as $e ){
                    echo $e->toString();
                }
                if ( count( $errors ) < count( $files["error"] ) ){
                    echo "<br>"._RSGALLEY_ALERT_REST_UPLOADOK;
                }
            }
            viewImagesX(null);
            break;
        default: die("default switch case in function showUpload().  this should never happen.");
    }
}



function saveImageX($option, $id)
    {
    global $database;
    if (isset($_REQUEST['xtitle'])) $xtitle = mosGetParam ( $_REQUEST, 'xtitle'  , '');
    if (isset($_REQUEST['descr'])) $descr = mosGetParam ( $_REQUEST, 'descr'  , '');
    
    $database->setQuery("UPDATE #__rsgallery2_files SET descr = '$descr', title = '$xtitle' WHERE id='$id'");
    if ($database->query())
        {
        //terug naar overzicht
        ?>
        <script>
            alert("<?php echo _RSGALLERY_ALERT_IMAGEDETAILSOK;?>");
            location = "index2.php?option=com_rsgallery2&task=view_images";
        </script>
        <?php
        }
    else
        {
        ?>
        <script>
            alert("<?php echo _RSGALLERY_ALERT_IMAGEDETAILSNOTOK;?>");
            location = "index2.php?option=com_rsgallery2&task=view_images";
        </script>
        <?php
        }
    }
*/
/**
 * @todo if thumbname size has changed, advise user to regenerate thumbs
 */
function saveConfig(){
    global $rsgConfig;

    require_once( JPATH_RSGALLERY2_ADMIN.'/includes/config.class.php' );

    $rsgConfig = new rsgConfig();
    
    if( $rsgConfig->saveConfig( $_REQUEST )){
            HTML_RSGALLERY::printAdminMsg(_RSGALLERY_CONF_SAVED);

            // save successful, try creating some image directories if we were asked to
            if( mosGetParam( $_REQUEST, 'createImgDirs' ))
                HTML_RSGALLERY::printAdminMsg(_RSGALLERY_CONF_CREATE_DIR, true);
            
    }else{
            HTML_RSGALLERY::printAdminMsg(_RSGALLERY_CONF_SAVE_ERROR);
    }
}

function showConfig(){
    global $rsgConfig;
    require_once( JPATH_RSGALLERY2_ADMIN.'/includes/img.utils.php' );

    $langs      = array();
    $imageLib   = array();
    $lists      = array();

    // PRE-PROCESS SOME LISTS

    // -- Languages --

    if ($handle = opendir( JPATH_RSGALLERY2_ADMIN.'/language/' )) {
        $i=0;
        while (false !== ($file = readdir( $handle ))) {
            if (!strcasecmp(substr($file,-4),".php") && $file <> "." && $file <> ".." && strcasecmp(substr($file,-11),".ignore.php")) {
                $langs[] = mosHTML::makeOption( substr($file,0,-4) );
            }
        }
    }

    // sort list of languages
    sort( $langs );
    reset( $langs );

    /**
     * detect available graphics libraries
     * @todo call imgUtils graphics lib detection when it is built
    */
    $graphicsLib = array();

    $result = GD2::detect();
    if( $result )
        $graphicsLib[] = mosHTML::makeOption( 'gd2', $result );
    else
        $graphicsLib[] = mosHTML::makeOption( 'gd2', _RSGALLERY_CONF_NOGD2 );

    $result = ImageMagick::detect();
    if( $result )
        $graphicsLib[] = mosHTML::makeOption( 'imagemagick', $result );
    else
        $graphicsLib[] = mosHTML::makeOption( 'imagemagick', _RSAGALLERY_CONF_NOIMGMAGICK );

    $result = Netpbm::detect();
    if( $result )
        $graphicsLib[] = mosHTML::makeOption( 'netpbm', $result );
    else
        $graphicsLib[] = mosHTML::makeOption( 'netpbm', _RSAGALLERY_CONF_NONETPBM );
    
    
    $lists['graphicsLib'] = mosHTML::selectList( $graphicsLib, 'graphicsLib', '', 'value', 'text', $rsgConfig->graphicsLib );

    HTML_RSGALLERY::showconfig( $lists );
}

/*
function viewImagesX($option)
    {
    global $option, $database, $mainframe;

    $catid = $mainframe->getUserStateFromRequest( "catid{$option}", 'catid', 0 );
    $catChanged = $mainframe->getUserStateFromRequest( "catChanged{$option}", 'catChanged', 0 );
    $limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', 10 );
    $limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
    $search = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
    $search = $database->getEscaped( trim( strtolower( $search ) ) );

    if ($catid > 0)
        {
        $sql = "SELECT count(*) FROM #__rsgallery2_files AS a".
                  "\nWHERE a.gallery_id='$catid'";
        }
    else
        {
        $sql = "SELECT count(*) FROM #__rsgallery2_files AS a";
        }
    //get the total number of records
    $database->setQuery($sql);
    $total = $database->loadResult();
    echo $database->getErrorMsg();

    include_once( JPATH_ROOT."/administrator/includes/pageNavigation.php" );
    if($catChanged) $limitstart=0;
    $pageNav = new mosPageNav( $total, $limitstart, $limit  );
    $where = array();

    if ($catid > 0)
        {

        $sql2 = "SELECT a.name as fname, a.hits as ahits,a.id as xid,a.ordering as fordering, a.date as fdate, a.*,b.* FROM #__rsgallery2_files as a, #__rsgallery2_galleries as b".
                  "\n WHERE (a.gallery_id = b.id AND b.id = '$catid')".
                  "\n ORDER BY a.ordering".
                  "\n LIMIT $pageNav->limitstart,$pageNav->limit";
        }
    else
        {
        $sql2 = "SELECT a.name as fname, a.hits as ahits,a.id as xid,a.ordering as fordering, a.date as fdate, a.*,b.* FROM #__rsgallery2_files as a, #__rsgallery2_galleries as b".
                "\n WHERE a.gallery_id = b.id".
                "\n ORDER BY b.ordering, a.ordering".
                "\n LIMIT $pageNav->limitstart,$pageNav->limit";
        }

    $database->setQuery($sql2);
    $rows = $database->loadObjectList();
    if ($database->getErrorNum()) {
        echo $database->stderr();
        return false;
    }

    // get list of categories
    $categories[] = mosHTML::makeOption( '0', _RSGALLERY_VIEW_GAL );
    $categories[] = mosHTML::makeOption( '-1', _RSGALLERY_ALL_GAL );
    $database->setQuery( "SELECT id AS value, name AS text FROM #__rsgallery2_galleries"
        . "\n ORDER BY name" );
    $dbCategories = $database->loadObjectList();
    $categories = array_merge( $categories, $dbCategories );

    $clist = mosHTML::selectList( $categories, 'catid', 'class="inputbox" size="1" onchange="document.adminForm.catChanged.value=1;document.adminForm.submit();"',
        'value', 'text', $catid );
    $categories[0] = mosHTML::makeOption( '0', _RSGALLERY_SELECT_GAL );
    array_splice($categories, 1, 1);
    $clist2 = mosHTML::selectList( $categories, 'catmoveid', 'class="inputbox" size="1" ', 'value', 'text', 0 );

    // dmcd jan 12/04  tally total pics per category/gallery
        $database->setQuery("SELECT id FROM #__rsgallery2_galleries");
        $catss = $database->loadResultArray();
 		foreach($catss as $cat){
            $database->setQuery("SELECT MAX(ordering), MIN(ordering) FROM #__rsgallery2_files WHERE gallery_id = '$cat'");
            $maxmin = $database->loadRow();
            $cat_ordering_max[$cat] = $maxmin[0];
            $cat_ordering_min[$cat] = $maxmin[1];
       }
       //asdbg_break();
        HTML_RSGALLERY::viewImages( $option, $rows, $clist, $clist2, $search, $pageNav, $catss, $cat_ordering_min, $cat_ordering_max );
    //HTML_RSGALLERY::RSGalleryFooter();
}

*/
/**
 * This function is used to handle the RSGallery ordering tasks (I.e. the user indicating
 * that they want to display a given image and/or category before or after another one.)
 */
 /*
function orderRSGallery( $id, $inc, $option, $task ) {
   global $database;
   // reorder categories or pics within a category

switch ($task){
      case "images_orderup":
      case "images_orderdown":
         $table = "#__rsgallery2_files";
         $where = "gallery_id = '\$row->gallery_id'";
         $new_task = "view_images";
         break;

      default:
         $table = "#__rsgallery2_galleries";
         $where = NULL;
         $new_task = "view_categories";
         break;
   }

   $sql = "SELECT * FROM $table WHERE id = $id";
   $database->setQuery( $sql );
   $database->loadObject($row);

   eval("\$where=\"$where\";");
   $sql = "SELECT id, ordering FROM $table";
   if ($inc < 0) {
      $sql .= "\nWHERE ordering < '$row->ordering'";
      $sql .= ($where ? "\n AND $where" : '');
      $sql .= "\nORDER BY ordering DESC\nLIMIT 1";
   } else if ($inc > 0) {
      $sql .= "\nWHERE ordering > '$row->ordering'";
      $sql .= ($where ? "\n AND $where" : '');
      $sql .= "\nORDER BY ordering\nLIMIT 1";
   } else {
      $sql .= "\nWHERE ordering = '$row->ordering'";
      $sql .= ($where ? "\n AND $where" : '');
      $sql .= "\nORDER BY ordering\nLIMIT 1";
   }

   $database->setQuery( $sql );
   $adj_row = null;
   if ($database->loadObject( $adj_row )) {
      $database->setQuery( "UPDATE $table SET ordering='$row->ordering'"
     . "\nWHERE id='".$adj_row->id."'");
      $database->query();
      $database->setQuery( "UPDATE $table SET ordering='$adj_row->ordering'"
     . "\nWHERE id='".$row->id."'");
      $database->query();
   } else {
      // no adjacent row: either the only row or already the first or last row
      // what is this really doing?
      $database->setQuery( "UPDATE $table SET ordering='$row->ordering'"
     . "\nWHERE id='".$id."'");
      $database->query();
   }

   // go back to RSGallery category or image listing
   mosRedirect( "index2.php?option=$option&task=".$new_task );
}
*/
function consolidateDbInform($option){
    // inform user of purpose of this function, then provide a proceed button
	?>
    <script language="Javascript">
        function submitbutton(pressbutton){
            if (pressbutton != 'cancel'){
                submitform( pressbutton );
                return;
            } else {
                window.history.go(-1);
                return;
            }
        }
    </script>
    <form action="index2.php" method="post" name="adminForm">
    <table class="adminform" cellpadding="4" cellspacing="0" border="0" width="98%" align="center">
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><?php echo _RSGALLERY_CONSOLIDATE_DB;?></td>
        </tr>
        <tr>
            <td>
                <div align="center">
                <input type="button" name="consolidate_db_go" value="<?php echo _RSGALLERY_PROCEED ?>" class="button" onClick="submitbutton('consolidate_db_go');" />
                <input type="button" name="cancel" value="<?php echo _RSGALLERY_CANCEL ?>" class="button" onClick="submitbutton('cancel');" />
                </div>
            </td>
        </tr>
    </table>
    <input type="hidden" name="option" value="<?php echo $option;?>" />
    <input type="hidden" name="task" value="" />
    </form>

<?php
}
/**
 * Changes all values of an array to lowercase
 * @param array mixed case mixed or upper case values
 * @return array lower case values
 */
function arrayToLower($array) {
    $array = explode("|", strtolower(implode("|",$array)));
    return $array;
}

/**
 * Fills an array with the filenames, found in the specified directory
 * @param string Directory from Joomla root
 * @return array Array with filenames
 */
function getFilenameArray($dir){
    global $rsgConfig;
    
    //Load all image names from filesystem in array
    $dh  = opendir(JPATH_ROOT.$dir);
    //Files to exclude from the check
    $exclude = array('.', '..', 'Thumbs.db', 'thumbs.db');
    $allowed = array('jpg','gif');
    $names_fs = array();
    while (false !== ($filename = readdir($dh)))
        {
        $ext = explode(".", $filename);
        $ext = array_reverse($ext);
        $ext = strtolower($ext[0]);
        if (!is_dir(JPATH_ROOT.$dir."/".$filename) AND !in_array($filename, $exclude) AND in_array($ext, $allowed))
            {
            if ($dir == $rsgConfig->get('imgPath_display') OR $dir == $rsgConfig->get('imgPath_thumb'))
                {
                //Recreate normal filename, eliminating the extra ".jpg"
                $names_fs[] = substr(strtolower($filename), 0, -4);
                }
            else
                {
                $names_fs[] = strtolower($filename);
                }
            }
        else
            {
            //Do nothing
            continue;
            }
        }
    closedir($dh);
    return $names_fs;
    
}
function consolidateDbGo($option)
    {
    global $database, $rsgConfig;

    //Load all image names from DB in array
    $sql = "SELECT name FROM #__rsgallery2_files";
    $database->setQuery($sql);
    $names_db = arrayToLower($database->loadResultArray());

    $files_display  = getFilenameArray($rsgConfig->get('imgPath_display'));
    $files_original = getFilenameArray($rsgConfig->get('imgPath_original'));
    $files_thumb    = getFilenameArray($rsgConfig->get('imgPath_thumb'));
    $files_total    = array_unique(array_merge($files_display,$files_original,$files_thumb));
    
    HTML_RSGALLERY::consolidateDbGo($names_db, $files_display, $files_original, $files_thumb, $files_total);
    }

/** 
 * Function for editing css file
 * Function from joomla core
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * Adapted for RSgallery2
 */
function editTemplateCSS( $option) {
	$file = JPATH_RSGALLERY2_SITE.'/rsgallery.css';

	if ($fp = fopen( $file, 'r' )) {
		$content = fread( $fp, filesize( $file ) );
		$content = htmlspecialchars( $content );

		editCSSSource( $content, $option);
	} else {
		mosRedirect( 'index2.php?option='. $option, _RSGALLERY_EDITCSS_FAIL_NOOPEN. $file );
	}
}


function saveTemplateCSS( $option) {
	$filecontent 	= mosGetParam( $_POST, 'filecontent', '' );

	if ( !$filecontent ) {
		mosRedirect( 'index2.php?option='. $option, 'Operation failed: Content empty.' );
	}
	
	$file = JPATH_RSGALLERY2_SITE .'/rsgallery.css';

	$enable_write 	= mosGetParam($_POST,'enable_write',0);
	$oldperms 		= fileperms($file);
	
	if ($enable_write) {
		@chmod($file, $oldperms | 0222);
	}

	clearstatcache();
	if ( is_writable( $file ) == false ) {
		mosRedirect( 'index2.php?option='. $option, _RSGALLERY_EDITCSS_NOT_WRITABLE );
	}

	if ($fp = fopen ($file, 'w')) {
		fputs( $fp, stripslashes( $filecontent ) );
		fclose( $fp );
		if ($enable_write) {
			@chmod($file, $oldperms);
		} else {
			if (mosGetParam($_POST,'disable_write',0))
				@chmod($file, $oldperms & 0777555);
		} // if
		mosRedirect( 'index2.php?option='. $option );
	} else {
		if ($enable_write) @chmod($file, $oldperms);
		mosRedirect( 'index2.php?option='. $option, _RSGALLERY_EDITCSS_FAIL_NOTWRITING );
	}

}

function editCSSSource( $content, $option ) {
		$css_path = JPATH_RSGALLERY2_SITE .'/rsgallery.css';
		?>
		<form action="index2.php?option=com_rsgallery2&task=save_css" method="post" name="adminForm">
		<table cellpadding="1" cellspacing="1" border="0" width="100%">
		<tr>
			<td width="280"><table class="adminheading"><tr><th class="templates"><?php echo _RSGALLERY_EDITCSS_TITLE?></th></tr></table></td>
			<td width="260">
				<span class="componentheading"><?php echo _RSGALLERY_ISWRITABLE?>
				<b><?php echo is_writable($css_path) ? '<font color="green">'._RSGALLERY_ISWRITABLE_WRITABLE.'</font>' : '<font color="red">'._RSGALLERY_ISWRITABLE_UNWRITABLE.'</font>' ?></b>
				</span>
			</td>
			<?php
			if (mosIsChmodable($css_path)) {
				if (is_writable($css_path)) {
			?>
			<td>
				<input type="checkbox" id="disable_write" name="disable_write" value="1"/>
				<label for="disable_write"><?php echo _RSGALLERY_MAKE_WRITABLE?></label>
			</td>
			<?php
				} else {
			?>
			<td>
				<input type="checkbox" id="enable_write" name="enable_write" value="1"/>
				<label for="enable_write"><?php echo _RSGALLERY_OVERWRITE_WRITABLE?></label>
			</td>
			<?php
				} // if
			} // if
			?>
		</tr>
		</table>
		<table class="adminform">
			<tr><th><?php echo $css_path; ?></th></tr>
			<tr><td><textarea style="width:100%;height:500px" cols="110" rows="25" name="filecontent" class="inputbox"><?php echo $content; ?></textarea></td></tr>
		</table>
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="task" value="save_css" />
		</form>
		<?php
	}
?>