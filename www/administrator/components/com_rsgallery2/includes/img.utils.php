<?php
/**
* This file handles image manipulation functions RSGallery2
* @version $Id$
* @package RSGallery2
* @copyright (C) 2005 - 2006 RSGallery2
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* RSGallery2 is Free Software
*/

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
require_once(JPATH_RSGALLERY2_ADMIN.'/includes/mimetype.php');
require_once(JPATH_ROOT.'/includes/PEAR/PEAR.php');


/**
* Image utilities class
* @package RSGallery2
* @author Jonah Braun <Jonah@WhaleHosting.ca>
*/
class imgUtils{

    /**
      * thumb and display are resized into jpeg regardless of what the original image was
      * @todo update these functions when the user is given an option as to what image type thumb and display are
      * @param string name of original image
      * @return filename of image
      */
    function getImgNameThumb($name){
        return $name . '.jpg';
    }
    
    /**
      * thumb and display are resized into jpeg regardless of what the original image was
      * @todo update these functions when the user is given an option as to what image type thumb and display are
      * @param string name of original image
      * @return filename of image
      */
    function getImgNameDisplay($name){
        return $name . '.jpg';
    }
    
    /**
      * checks if filetype is allowed
      * @todo instead of array, get from settings
      * @param string full path to file
      * @return true if allowed, false if not
      */
    function isAllowedType($filename){
        $file_array = array_reverse(explode(".", $filename));
        $file_ext = strtolower($file_array[0]);
        $allowed = array("jpg","gif","png");

        if (in_array( $file_ext, $allowed )) {
            return true;
            }
        else {
            return false;   
            }
    }

    /**
      * @param string full path of source image
      * @param string name destination file (path is retrieved from rsgConfig)
      * @return true if successfull, PEAR_Error if error
      */
    function makeDisplayImage($source, $name='', $width){
        global $rsgConfig;

        if( $name=='' ){
            $parts = pathinfo( $source );
            $name = $parts['basename'];
        }
        $target = JPATH_DISPLAY . DS . imgUtils::getImgNameDisplay( $name );
        
        return imgUtils::resizeImage( $source, $target, $width );
    }   
    /**
      * @param string full path of source image
      * @param string name destination file (path is retrieved from rsgConfig)
      * @return true if successfull, PEAR_Error if error
      */
    function makeThumbImage($source, $name=''){
        global $rsgConfig;
        
        if( $name=='' ){
            $parts = pathinfo( $source );
            $name = $parts['basename'];
        }
        $target = JPATH_THUMB . DS . imgUtils::getImgNameThumb( $name );
        
        if ( $rsgConfig->get('thumb_style') == 1 && $rsgConfig->get('graphicsLib') == 'gd2'){
            return GD2::createSquareThumb( $source, $target, $rsgConfig->get('thumb_width') );
        } else {
            return imgUtils::resizeImage( $source, $target, $rsgConfig->get('thumb_width') );
        }
    }
    
    /**
      * generic image resize function
      * @param string full path of source image
      * @param string full path of target image
      * @param int width of target
      * @return true if successfull, PEAR_Error if error
      * @todo only writes in JPEG, this should be given as a user option
      */
    function resizeImage($source, $target, $targetWidth){
        global $rsgConfig;

        switch( $rsgConfig->get( 'graphicsLib' )){
            case 'gd2':
                return GD2::resizeImage($source, $target, $targetWidth);
                break;
            case 'imagemagick':
                return ImageMagick::resizeImage($source, $target, $targetWidth);
                break;
            case 'netpbm':
                return Netpbm::resizeImage($source, $target, $targetWidth);
                break;
            default:
                return new PEAR_Error( "invalid graphics library: " . $rsgConfig->get( 'graphicsLib' ));
        }
    }

    /**
     * Takes an image file, moves the file and adds database entry
     * !OBSOLETE AS SOON AS CONFIRMED THAT NEW FUNCTION BELOW FIXES OPEN BASEDIR PROBLEMS
     * @param the verified REAL name of the local file including path
     * @param name of file according to user/browser or just the name excluding path
     * @param desired category
     * @param title of image, if empty will be created from $imgName
     * @param description of image, if empty will remain empty
     * @return returns true if successfull otherwise returns an ImageUploadError
     */
    function importImageX($imgTmpName, $imgName, $imgCat, $imgTitle='', $imgDesc='') {
        global $mosConfig_absolute_path, $database, $my, $rsgConfig;
        
        $fullPath_display   = JPATH_ROOT.$rsgConfig->get('imgPath_display') . '/';
        $fullPath_original  = JPATH_ROOT.$rsgConfig->get('imgPath_original') . '/';
        
        // if debug mode, do some extra testing
        if( $rsgConfig->get('debug') ){
            $fullPath_thumb = JPATH_ROOT.$rsgConfig->get('imgPath_thumb') . '/';
            
            // on a normal install, these would be created
            file_exists( $fullPath_original ) or die("original image directory does not exist: $fullPath_original");
            file_exists( $fullPath_display ) or die("display image directory does not exist: $fullPath_display");
            file_exists( $fullPath_thumb ) or die("thumb image directory does not exist: $fullPath_thumb");
        }
        /* There was a mime type check here but this is already done in an earlier stage, If we are here, all valid files */

        // breakdown image name
        $parts = pathinfo( $imgName );
        
        // fill $imgTitle if empty
        if( $imgTitle == '' ) 
            $imgTitle = substr( $parts['basename'], 0, -( strlen( $parts['extension'] ) + ( $parts['extension'] == '' ? 0 : 1 )));
        
        // figure out a filename to move the file to.
        $newName = galleryUtils::replaceStrangeChar( $parts['basename'] );
        $ext = substr( strrchr( $imgName, "." ), 1 );
        
        if ( file_exists( $fullPath_display . $newName ) || file_exists( $fullPath_original . $newName )){
            // get name minus extension
            $stub=substr( $newName, 0, (strlen( $ext )+1)*-1 );
    
            // if file exists, add a number, test, increment, test...  similar to what filemanagers will do
            $i=0;
            do{
                $newName=$stub . "-" . ++$i . "." . $ext;
            }while( file_exists( $fullPath_display . $newName ) || file_exists( $fullPath_original . $newName ));
        }

        $width = getimagesize( $imgTmpName );
        if( !$width ){
            imgUtils::deleteImage( $newName );
            return new imageUploadError( $imgName, "not an image OR can't read $imgTmpName" );
        }
        //the actual image width
        $width = $width[0];

        // user wants to keep original image or original is <= display image width
        // if the original image is smaller than display/thumb, it will be used in place of those
        if( $rsgConfig->get('keepOriginalImage') || $width<=$rsgConfig->get('image_width') ){
            if(! copy( $imgTmpName, $fullPath_original.$newName )){
                imgUtils::deleteImage( $newName );
                return new imageUploadError( $imgName, "could not copy original image to: $fullPath_original.$newName" );
            }
        }
        /*
        // if original is wider than display, create a display image
        if( $width > $rsgConfig->get('image_width') ){
            $result = imgUtils::makeDisplayImage( $imgTmpName, $newName );
            if( PEAR::isError( $result )){
                imgUtils::deleteImage( $newName );
                return new imageUploadError( $imgName, "error creating display image: " . $result->getMessage() );
            }
        }*/
        // if original is wider than display, create a display image
        if( $width > $rsgConfig->get('image_width') ) {
            $result = imgUtils::makeDisplayImage( $imgTmpName, $newName, $rsgConfig->get('image_width') );
            if( PEAR::isError( $result )){
                imgUtils::deleteImage( $newName );
                return new imageUploadError( $imgName, "error creating display image: " . $result->getMessage() );
            }
        } else {
            $result = imgUtils::makeDisplayImage($imgTmpName,$newName,$width);
            if( PEAR::isError( $result )){
                imgUtils::deleteImage( $newName );
                return new imageUploadError( $imgName, "error creating display image: " . $result->getMessage() );
                }
        }
           
        // if original is wider than thumb, create a thumb image
        if( $width > $rsgConfig->get('thumb_width') ){
            $result = imgUtils::makeThumbImage( $imgTmpName, $newName );
            if( PEAR::isError( $result )){
                imgUtils::deleteImage( $newName );
                return new imageUploadError( $imgName, "error creating thumb image: " . $result->getMessage() );
            }
        }

        // determine ordering
        $database->setQuery("SELECT COUNT(*) FROM #__rsgallery2_files WHERE gallery_id = '$imgCat'");
        $ordering = $database->loadResult() + 1;
        
        // add entry to db, or as the original RS would say: Naam opslaan in database
        // if fail: delete file, return error
        //if the description or the title have weird caracters like ' you need to embed them
        $imgDesc = mysql_real_escape_string($imgDesc);
        $imgTitle = mysql_real_escape_string($imgTitle);
        $database->setQuery("INSERT INTO #__rsgallery2_files".
                " (title, name, descr, gallery_id, date, ordering, userid) VALUES".
                " ('$imgTitle', '$newName', '$imgDesc', '$imgCat', now(), '$ordering', '$my->id')");
        
        if (!$database->query()){
            imgUtils::deleteImage( $newName );
            return new imageUploadError( $imgName, $database->stderr(true) );
        }

        return true;
    }
//--------------------------------------------------------------------------------------------------------------
    /**
     * Takes an image file, moves the file and adds database entry
     * @param the verified REAL name of the local file including path
     * @param name of file according to user/browser or just the name excluding path
     * @param desired category
     * @param title of image, if empty will be created from $imgName
     * @param description of image, if empty will remain empty
     * @return returns true if successfull otherwise returns an ImageUploadError
     */
    function importImage($imgTmpName, $imgName, $imgCat, $imgTitle='', $imgDesc='') {
        global $database, $my, $rsgConfig;

        // breakdown image name
        $parts = pathinfo( $imgName );
        
        // fill $imgTitle if empty
        if( $imgTitle == '' ) 
            $imgTitle = substr( $parts['basename'], 0, -( strlen( $parts['extension'] ) + ( $parts['extension'] == '' ? 0 : 1 )));
        
        // figure out a filename to move the file to.
        $newName = galleryUtils::replaceStrangeChar( $parts['basename'] );
        $ext = substr( strrchr( $imgName, "." ), 1 );
        
        if ( file_exists( JPATH_DISPLAY . DS . $newName ) || file_exists( JPATH_ORIGINAL . DS . $newName )){
            // get name minus extension
            $stub=substr( $newName, 0, (strlen( $ext )+1)*-1 );
    
            // if file exists, add a number, test, increment, test...  similar to what filemanagers will do
            $i=0;
            do {
                $newName=$stub . "-" . ++$i . "." . $ext;
            } while( file_exists( JPATH_DISPLAY . DS . $newName ) || file_exists( JPATH_ORIGINAL . DS . $newName ));
        }

        //First move uploaded file to original directory
        $destination = JPATH_ORIGINAL . DS .$newName;
        if ( !copy($imgTmpName, $destination) ) {
            if( !move_uploaded_file( $imgTmpName, $destination )){
                    imgUtils::deleteImage( $newName );
                    return new imageUploadError( $imgName, "could not copy $imgTmpName image to: $destination" );
                }
        }
        //Get details of the original image.
        $width = getimagesize( $destination );
        if( !$width ){
            imgUtils::deleteImage( $newName );
            return new imageUploadError( $imgName, "not an image OR can't read $imgTmpName" );
        } else {
            //the actual image width
            $width = $width[0];
        }
        //Destination becomes original image, just for readability
        $original_image = $destination;
        
        // if original is wider than display, create a display image
        if( $width > $rsgConfig->get('image_width') ) {
            $result = imgUtils::makeDisplayImage( $original_image, $newName, $rsgConfig->get('image_width') );
            if( PEAR::isError( $result )){
                imgUtils::deleteImage( $newName );
                return new imageUploadError( $imgName, "error creating display image: " . $result->getMessage() );
            }
        } else {
            $result = imgUtils::makeDisplayImage( $original_image, $newName, $width );
            if( PEAR::isError( $result )){
                imgUtils::deleteImage( $newName );
                return new imageUploadError( $imgName, "error creating display image: " . $result->getMessage() );
                }
        }
           
        // if original is wider than thumb, create a thumb image
        if( $width > $rsgConfig->get('thumb_width') ){
            $result = imgUtils::makeThumbImage( $original_image, $newName );
            if( PEAR::isError( $result )){
                imgUtils::deleteImage( $newName );
                return new imageUploadError( $imgName, "error creating thumb image: " . $result->getMessage() );
            }
        }

        // determine ordering
        $database->setQuery("SELECT COUNT(*) FROM #__rsgallery2_files WHERE gallery_id = '$imgCat'");
        $ordering = $database->loadResult() + 1;
        
        //Store image details in database
        $imgDesc = mysql_real_escape_string($imgDesc);
        $imgTitle = mysql_real_escape_string($imgTitle);
        $database->setQuery("INSERT INTO #__rsgallery2_files".
                " (title, name, descr, gallery_id, date, ordering, userid) VALUES".
                " ('$imgTitle', '$newName', '$imgDesc', '$imgCat', now(), '$ordering', '$my->id')");
        
        if (!$database->query()){
            imgUtils::deleteImage( $newName );
            return new imageUploadError( $imgName, $database->stderr(true) );
        }
        
        //check if original image needs to be kept, otherwise delete it.
        if ( !$rsgConfig->get('keepOriginalImage') ) {
            unlink( imgUtils::getImgOriginal( $newName, true ) );
        }
            
        return true;
    }
//------------------------------------------------------------------------------------------------------------------------
    /**
      * deletes all elements of image on disk and in database
      * @param string name of image
      * @return true if success or PEAR_Error if error
      */
    function deleteImage($name){
        global $database, $rsgConfig;
        
        $thumb      = JPATH_THUMB . DS . imgUtils::getImgNameThumb( $name );
        $display    = JPATH_DISPLAY . DS . imgUtils::getImgNameDisplay( $name );
        $original   = JPATH_ORIGINAL . DS . $name;
        
        if( file_exists( $thumb ))
            if( !unlink( $thumb ))
                return new PEAR_Error( "error deleting thumb image: " . $thumb );
        if( file_exists( $display ))
            if( !unlink( $display ))
                return new PEAR_Error( "error deleting display image: " . $display );
        if( file_exists( $original ))
            if( !unlink( $original ))
                return new PEAR_Error( "error deleting original image: " . $original );
        
        $database->setQuery("SELECT gallery_id FROM #__rsgallery2_files WHERE name = '$name'");
        $gallery_id = $database->loadResult();
                
        $database->setQuery("DELETE FROM #__rsgallery2_files WHERE name = '$name'");
        if( !$database->query())
            return new PEAR_Error( "error deleting database entry for image: " . $name);

        galleryUtils::reorderRSGallery('#__rsgallery2_files', "gallery_id = '$gallery_id'");
        
        return true;
    }
    
    /**
      * @param string name of the image
      * @param boolean return a local path instead of URL
      * @return complete URL of the image
      */
    function getImgOriginal($name, $local=false){
        global $mosConfig_live_site, $rsgConfig;
        
        $locale = $local? JPATH_ROOT : $mosConfig_live_site;
        
        // if original image exists return that, otherwise $keepOriginalImage is false and and we return the display image instead.
        if( file_exists( JPATH_ROOT.$rsgConfig->get('imgPath_original') . '/' . $name )){
            return $locale . $rsgConfig->get('imgPath_original') . '/' . rawurlencode($name);
        }else {
            return $locale . $rsgConfig->get('imgPath_display') . '/' . rawurlencode( imgUtils::getImgNameDisplay( $name ));
        }
    }
    
    /**
      * @param string name of the image
      * @param boolean return a local path instead of URL
      * @return complete URL of the image
      */
    function getImgDisplay($name, $local=false){
        global $mosConfig_live_site, $rsgConfig;
        
        $locale = $local? JPATH_ROOT : $mosConfig_live_site;
        
        // if display image exists return that, otherwise the original image width <= $display_width so we return the original image instead.
        if( file_exists( JPATH_ROOT.$rsgConfig->get('imgPath_display') . '/' . imgUtils::getImgNameDisplay( $name ))){
            return $locale . $rsgConfig->get('imgPath_display') . '/' . rawurlencode( imgUtils::getImgNameDisplay( $name ));
        }else {
            return $locale . $rsgConfig->get('imgPath_original') . '/' . rawurlencode($name);
        }
    }
    
    /**
      * @param string name of the image
      * @param boolean return a local path instead of URL
      * @return complete URL of the image
      */
    function getImgThumb($name, $local=false){
        global $mosConfig_live_site, $rsgConfig;
        
        $locale = $local? JPATH_ROOT : $mosConfig_live_site;
        
        // if thumb image exists return that, otherwise the original image width <= $thumb_width so we return the original image instead.
        if( file_exists( JPATH_ROOT.$rsgConfig->get('imgPath_thumb') . '/' . imgUtils::getImgNameThumb( $name ))){
            return $locale  . $rsgConfig->get('imgPath_thumb') . '/' . rawurlencode( imgUtils::getImgNameThumb( $name ));
        }else {
            return $locale  . $rsgConfig->get('imgPath_original') . '/' . rawurlencode($name);
        }
    }
    
        /**
        TODO: this class is for logic only!!!  take this html generation somewhere else.
          reminder: exif should be read from original image only.
    **/
    function showEXIF($imagefile){
        if(!function_exists('exif_read_data')) return false;

        if (!@exif_read_data($imagefile, 0, true))
        {
        ?>
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="imageExif">
    <tr><td>No EXIF info available</td></tr>
    </table>
        <?php
        return false;
        } 
        $exif = exif_read_data($imagefile, 0, true);
        ?>
        <table width="100%" border="0" cellspacing="1" cellpadding="0" class="imageExif">
            <tr>
                <th>Section</th>
                <th>Name</th>
                <th>Value</th>
            </tr>
        <?php
                foreach ($exif as $key => $section):
                    foreach ($section as $name => $val):
        ?>
            <tr>
                <td class="exifKey"><?php echo $key;?></td>
                <td class="exifName"><?php echo $name;?></td>
                <td class="exifVal"><?php echo $val;?></td>
            </tr>
        <?php
                    endforeach;
                endforeach;
        ?>
        </table>
        <?php
    }
    
    /**
     * Shows a selectbox  with the filenames in the selected gallery
     * @param int Gallery ID
     * @param int Currently selected thumbnail
     * @return HTML representation of a selectbox
     * @todo Also offer the possiblity to select thumbs from subgalleries
     */
    function showThumbNames($id, $current_id, $selectname = 'thumb_id') {
        global $database;
        $list = galleryUtils::getChildList( $id );
        //$sql = "SELECT name, id FROM #__rsgallery2_files WHERE gallery_id in ($list)";
        $sql = "SELECT a.name, a.id, b.name as gname FROM #__rsgallery2_files AS a " .
            "LEFT JOIN #__rsgallery2_galleries AS b ON a.gallery_id = b.id " .
            "WHERE gallery_id IN ($list) " .
            "ORDER BY gname, a.id ASC";

        $database->setQuery($sql);
        $list = $database->loadObjectList();

        if( $list==null ){
            echo 'No images in gallery yet.';
            return;
        }

        $dropdown_html = "<select name=\"$selectname\"><option value=\"0\" SELECTED>- Random thumbnail -</option>\n";
        if (!isset($current_id)) {
            $current_id = 0;
        }

        foreach ($list as $item) {
            $dropdown_html .= "<option value=\"$item->id\"";
            if ($item->id == $current_id)
                $dropdown_html .= " SELECTED>";
            else
                $dropdown_html .= ">";
            $dropdown_html .=  $item->name." (".$item->gname.")</option>\n";
        }
        echo $dropdown_html."</select>";
    }

}//End class

/**
  * abstract image library class
  * @package RSGallery2
  */
class genericImageLib{
    /**
      * resize source to targetWidth and output result to target
      * @param string full path of source image
      * @param string full path of target image
      * @param int width of target
      * @return true if successfull, PEAR_Error if error
      */ 
    function resizeImage($source, $target, $targetWidth){
        return new PEAR_Error( 'this is the abstract image library class, no resize available' );
    }

    /**
      * detects if image library is available
      * @return false if not detected, user friendly string of library name and version if detected
      */
    function detect(){
        return false;
    }
}
/**
 * NETPBM handler class
 * @package RSGallery2
 */
class Netpbm extends genericImageLib{
    /**
     * image resize function
     * @param string full path of source image
     * @param string full path of target image
     * @param int width of target
     * @return true if successfull, PEAR_Error if error
     * @todo only writes in JPEG, this should be given as a user option
     */
    function resizeImage($source, $target, $targetWidth){
        global $rsgConfig;
        
        // if path exists add the final /
        $netpbm_path = $rsgConfig->get( "netpbm_path" );
        $netpbm_path = $netpbm_path==''? '' : $netpbm_path.'/';
        
        $cmd = $netpbm_path . "anytopnm $source | " .
            $netpbm_path . "pnmscale -width=$targetWidth | " .
            $netpbm_path . "pnmtojpeg -quality=" . $rsgConfig->get( "jpegQuality" ) . " > $target";
        @exec($cmd);
    }

    /**
      * detects if image library is available
      * @return false if not detected, user friendly string of library name and version if detected
      */
    function detect(){
        @exec($shell_cmd. 'jpegtopnm -version 2>&1',  $output, $status);
        if(!$status){
            if(preg_match("/netpbm[ \t]+([0-9\.]+)/i",$output[0],$matches)){
                return $matches[0];
            }
            else return false;
        }
    }
}
/**
 * ImageMagick handler class
 * @package RSGallery2
 */
class ImageMagick extends genericImageLib{
    /**
     * image resize function
     * @param string full path of source image
     * @param string full path of target image
     * @param int width of target
     * @return true if successfull, PEAR_Error if error
     * @todo only writes in JPEG, this should be given as a user option
     */
    function resizeImage($source, $target, $targetWidth){
        global $rsgConfig;
        
        // if path exists add the final /
        $impath = $rsgConfig->get( "imageMagick_path" );
        $impath = $impath==''? '' : $impath.'/';
        
        $cmd = $impath."convert -resize $targetWidth $source $target";
        exec($cmd, $results, $return);
        if( $return > 0 ) return new PEAR_Error( $results );
        else return true;
    }

    /**
     * detects if image library is available
     * @return false if not detected, user friendly string of library name and version if detected
     */
    function detect(){
        global $rsgConfig;
    
        // if path exists add the final /
        $impath = $rsgConfig->get( "imageMagick_path" );
        $impath = $impath==''? '' : $impath.'/';
    
        @exec($impath.'convert -version',  $output, $status);
        if(!$status){
            if(preg_match("/imagemagick[\t]+([0-9\.]+)/i",$output[0],$matches)){
                return $matches[0];
            } else {
                return false;
            }
        }
    }
}
/**
 * GD2 handler class
 * @package RSGallery2
 */
class GD2 extends genericImageLib{
    
    /**
     * image resize function
     * @param string full path of source image
     * @param string full path of target image
     * @param int width of target
     * @return true if successfull, PEAR_Error if error
     * @todo only writes in JPEG, this should be given as a user option
     * @todo use constants found in http://www.php.net/gd rather than numbers
     */
    function resizeImage($source, $target, $targetWidth){
        global $rsgConfig;
        // an array of image types
        
        $imageTypes = array( 1 => 'gif', 2 => 'jpeg', 3 => 'png', 4 => 'swf', 5 => 'psd', 6 => 'bmp', 7 => 'tiff', 8 => 'tiff', 9 => 'jpc', 10 => 'jp2', 11 => 'jpx', 12 => 'jb2', 13 => 'swc', 14 => 'iff', 15 => 'wbmp', 16 => 'xbm');
        
        $imgInfo = getimagesize( $source );
        if( !$imgInfo )
            return new PEAR_Error( "not a valid image" );
        
        list( $sourceWidth, $sourceHeight, $type, $attr ) = $imgInfo;
        
        // convert $type into a usable string
        $type = $imageTypes[$type];
        
        // check if we can read this type of file
        if( !function_exists( "imagecreatefrom$type" ))
            return new PEAR_Error( "GD2 doesn't support reading image type $type" );
        
        // determine target height
        $targetHeight = ( $targetWidth / $sourceWidth ) * $sourceHeight;
        
        // load source image file into a resource
        $loadImg = "imagecreatefrom" . $type;
        $sourceImg = $loadImg( $source );
        if( !$sourceImg )
            return new PEAR_Error( "error reading source image: $source" );
        
        // create target resource
        $targetImg = imagecreatetruecolor( $targetWidth, $targetHeight );
        
        // resize from source resource image to target
        if( !imagecopyresampled(
            $targetImg,
            $sourceImg,
            0,0,0,0,
            $targetWidth, $targetHeight,
            $sourceWidth, $sourceHeight
        )) return new PEAR_Error( "error resizing image: $source" );
        
        // write the image
        if( !imagejpeg( $targetImg, $target, $rsgConfig->get('jpegQuality')))
            return new PEAR_Error( "error writing target image: $target" );
        //Free up memory
        imagedestroy($targetImg);
    }
    
    /**
      * Creates a square thumbnail by first resizing and then cutting out the thumb
      * @param string Full path of source image
      * @param string Full path of target image
      * @param int width of target
      * @return true if successfull, PEAR_Error if error
      */
    function createSquareThumb( $source, $target, $width ) {
        global $rsgConfig;
        
        //Create a square image, based on the set width
        $t_width  = $width;
        $t_height = $width;
        
        //Get details on original image
        $imgdata = getimagesize($source);
        $width_orig     = $imgdata[0];
        $height_orig    = $imgdata[1];
        $ext            = $imgdata[2];
        
        switch($ext)
            {
            case 1:
                $image = imagecreatefromgif($source);
                break;
            case 2:
                $image = imagecreatefromjpeg($source);
                break;
            case 3:
                $image = imagecreatefrompng($source);
                break;
            }
    
        $width  = $t_width;    //New width
        $height = $t_height;   //New height
        list($width_orig, $height_orig) = getimagesize($source);
        
        if ($width_orig < $height_orig) {
          $height = ($t_width / $width_orig) * $height_orig;
        } else {
           $width = ($t_height / $height_orig) * $width_orig;
        }
        
        //if the width is smaller than supplied thumbnail size
        if ($width < $t_width) {
            $width = $t_width;
            $height = ($t_width/ $width_orig) * $height_orig;;
            }
        
        //if the height is smaller than supplied thumbnail size
        if ($height < $t_height) {
            $height = $t_height;
            $width = ($t_height / $height_orig) * $width_orig;
            }
    
        //Resize the image
        $thumb = imagecreatetruecolor($width , $height); 
        if ( !imagecopyresampled($thumb, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig))
            return new PEAR_Error( "error resizing image: $source" );
        
        //Create the cropped thumbnail
        $w1 =($width/2) - ($t_width/2);
        $h1 = ($height/2) - ($t_height/2);
        $thumb2 = imagecreatetruecolor($t_width , $t_height);
        if ( !imagecopyresampled($thumb2, $thumb, 0,0, $w1, $h1, $t_width , $t_height ,$t_width, $t_height) )
            return new PEAR_Error( "error cropping image: $source" );
        
        // write the image
        if( !imagejpeg( $thumb2, $target, $rsgConfig->get('jpegQuality')))
            return new PEAR_Error( "error writing target image: $target" );
        //Free up memory
        imagedestroy($thumb);
        imagedestroy($thumb2);
    }
    
    /**
      * detects if image library is available
      * @return false if not detected, user friendly string of library name and version if detected
      */
    function detect(){
        $GDfuncList = get_extension_funcs('gd');
        ob_start();
        @phpinfo(INFO_MODULES);
        $output=ob_get_contents();
        ob_end_clean();
        $matches[1]='';
        if(preg_match("/GD Version[ \t]*(<[^>]+>[ \t]*)+([^<>]+)/s",$output,$matches)){
            $gdversion = $matches[2];
        }
        if( $GDfuncList ){
            if( in_array('imagegd2',$GDfuncList) ){
                return 'gd2 '. $gdversion;
            }
            else{
//                 return 'gd1 '. $gdversion);
                return false;
            }
        }
        else return false;
    }
}


/**
* Image watermarking class
* @package RSGallery2
* @author Ronald Smit <webmaster@rsdev.nl>
* @todo Make text transparent to keep the image presentable
*/
class waterMarker extends GD2 {
    var $imagePath; //valid absolute path to image file
    var $waterMarkText; //the text to draw as watermark
    var $font = "arial.ttf"; //font file to use for drawing text. need absolute path
    var $size = 10; //font size
    var $angle = 45; //angle to draw watermark text
    var $imageResource; //to store the image resource after completion of watermarking
    var $imageType="jpg"; //this could be either of png, jpg, jpeg, bmp, or gif (if gif then output will be in png)
    var $shadow = false; //if set to true then a shadow will be drawn under every watermark text
    var $antialiased = true; //if set to true then watermark text will be drwan anti aliased. this is recommended
    
    /**
     * this function draw the watermark over the image
     * @return image resource after completion of watermarking
     */
    function mark($imagetype = 'display'){
    global $rsgConfig;
    
    list($width, $height, $type, $attr) = getimagesize($this->imagePath); //get basic properties of the image file
        
        switch ($this->imageType)
        {

                case "png":
                    $createProc = "imagecreatefrompng";
                    $outputProc = "imagepng";
                    break;
                case "gif";
                    $createProc = "imagecreatefromgif";
                    $outputProc = "imagepng";
                    break;
                case "bmp";
                    $createProc = "imagecreatefrombmp";
                    $outputProc = "imagebmp";
                    break;
                case "jpeg":
                case "jpg":
                    $createProc = "imagecreatefromjpeg";
                    $outputProc = "imagejpeg";
                    break;
        }
       
        $im = $createProc($this->imagePath); //create the image with generalized image create function

        $grey           = imagecolorallocate($im, 180, 180, 180); //color for watermark text
        $shadowColor    = imagecolorallocate($im, 130, 130, 130); //color for shadow text

        if (!$this->antialiased)
            {
            $grey           *= -1; //grey = grey * -1
            $shadowColor    *= -1; //shadowColor = shadowColor * -1
            }
            
        /**
         * Determines the position of the image and returns x and y
         * (1 = Top Left    ; 2 = Top Center    ; 3 = Top Right)
         * (4 = Left        ; 5 = Center        ; 6 = Right)
         * (7 = Bottom Left ; 8 = Bottom Center ; 9 = Bottom Right)
         * @return x and y coordinates
         */
        $position = $rsgConfig->get('watermark_position');
        $bbox = imagettfbbox($rsgConfig->get('watermark_font_size'), $rsgConfig->get('watermark_angle'), JPATH_RSGALLERY2_ADMIN."/fonts/arial.ttf", $rsgConfig->get('watermark_text'));
        $textW = abs($bbox[0] - $bbox[2]) + 20;
        $textH = abs($bbox[7] - $bbox[1]) + 20;

        list($width, $height, $type, $attr) = getimagesize($this->imagePath); //get basic properties of the image file
        switch ($position) {
        case 1://Top Left
            $newX = 20;
            $newY = 0 + $textH;
            break;
        case 2://Top Center
            $newX = ($width/2) - ($textW/2);
            $newY = 0 + $textH;
            break;
        case 3://Top Right
            $newX = $width - $textW;
            $newY = 0 + $textH;
            break;
        case 4://Left
            $newX = 20;
            $newY = ($height/2) + ($textH/2);
            break;
        case 5://Center
            $newX = ($width/2) - ($textW/2);
            $newY = ($height/2) + ($textH/2);
            break;
        case 6://Right
            $newX = $width - $textW;
            $newY = ($height/2) + ($textH/2);
            break;
        case 7://Bottom left
            $newX = 20;
            $newY = $height - ($textH/2);
            break;
        case 8://Bottom Center
            $newX = ($width/2) - ($textW/2);
            $newY = $height - ($textH/2);
            break;
        case 9://Bottom right
            $newX = $width - $textW;
            $newY = $height - ($textH/2);
            break;
        }

        imagettftext($im, $this->size, $this->angle, $newX+1, $newY+1, $shadowColor, $this->font, $this->waterMarkText); //draw shadow text over image
        imagettftext($im, $this->size, $this->angle, $newX, $newY, $grey, $this->font, $this->waterMarkText); //draw text over image
        
        if ($imagetype == 'display')
            $file_name_dest = JPATH_ROOT."/media/display_temp.jpg";
        else
            $file_name_dest = JPATH_ROOT."/media/original_temp.jpg";
            
        $fh=fopen($file_name_dest,'w');
        fclose($fh);
        $this->imageResource= $outputProc($im, $file_name_dest, 100); //deploy the image with generalized image deploy function
        
    }
     
    /**
     * Function that takes an image and displays it with the predefined watermark text
     * @param string Name of the image in question
     * @param string Font used for watermark
     * @param string Text size in pixels
     * @param int Vertical spacing between text
     * @param int Horizontal spacing between text
     * @param boolean Shadow text yes or no
     */
    function showMarkedImage($imagename, $imagetype = 'display', $font="arial.ttf", $shadow = true){
    global $rsgConfig, $mosConfig_live_site;
        if ( $imagetype == 'display')
            $imagepath = JPATH_DISPLAY . DS . $imagename.".jpg";
        else
            $imagepath = JPATH_ORIGINAL . DS . $imagename;
            
        $imark = new waterMarker();
        $imark->waterMarkText = $rsgConfig->get('watermark_text');
        $imark->imagePath = $imagepath;
        $imark->font= JPATH_RSGALLERY2_ADMIN.DS."fonts".DS.$rsgConfig->get('watermark_font');
        $imark->size = $rsgConfig->get('watermark_font_size');
        $imark->shadow= $shadow;
        $imark->angle = $rsgConfig->get('watermark_angle');
        $imark->mark($imagetype); //draw watermark
        $rand = rand();
        if ($imagetype == 'original')
            echo $mosConfig_live_site."/media/original_temp.jpg?".$rand;
        else
            echo $mosConfig_live_site."/media/display_temp.jpg?".$rand;
    }
}//END CLASS WATERMARKER

/**
* Filehandling class
* @package RSGallery2
* @author Ronald Smit <webmaster@rsdev.nl>
*/
class fileHandler {
    /** @var array List of protected files */
    var $protectedFiles;
    /** @var array List of allowed image formats */
    var $allowedFiles;
    /** @var array List of all used folders */
    var $usedFolders;
    
    /** Constructor */
    function fileHandler() {
        global $rsgConfig;
        $this->protectedFiles = array('.','..','index.html','Helvetica.afm');
        $this->allowedFiles = array('jpg','gif','png');
        $this->usedFolders = array(
            JPATH_THUMB,
            JPATH_DISPLAY,
            JPATH_ORIGINAL,
            JPATH_ROOT.'/media'
            );
    }
    
    function is_win() {
        if ( substr(PHP_OS, 0, 3) == 'WIN' )
            return true;
        else
            return false;
    }
    
    /**
     * Function returns the permissions in a 4 digit format (e.g: 0777)
     * @param string full path to folder to check
     * @return int 4 digit folder permissions
     */
    function getPerms($folder) {
        $perms = substr(sprintf('%o', fileperms($folder)), -4);
        return $perms;
    }
    
    /**
     * Check routine to see is all prerequisites are met to start handling the upload process
     * @return boolean True if all is well, false if something is missing
     */
    function preHandlerCheck() {
        /* Check if media gallery exists and is writable */
        /* Check if RSGallery directories exist and are writable */
        $error = "";
        foreach ($this->usedFolders as $folder) {
            if ( file_exists($folder) ) {
                if ( is_writable($folder) )
                    continue;
                else
                    $error .= "<p>".$folder." exists, but is not Writable!</p>";
            } else {
                $error .= "<p>".$folder." does not exist!</p>";
            }
        }
        //Error handling
        if ($error != "")
            return $error;
        else
            return true;
        }
    
    /**
     * Checks the size of an uploaded ZIP-file and checks it against the upload_max_filesize in php.ini
     * @param array File array from form post method
     * @return int 1 if size is within the upload limit, 0 if not
     */
    function checkSize($zip_file) {
        //Check if file does not exceed upload_max_filesize in php.ini
        $max_size = ini_get('upload_max_filesize')*1024000;
        $real_size = $zip_file['size'];
        if ($real_size < $max_size) {
            return 1;
        } else {
            return 0;
        }
    }
    
    /**
     * Checks if uploaded file is a zipfile or a single file
     * @param string filename
     * @return string 'zip' if zip-file, 'image' if image file, 'error' if illegal file type
     */
    function checkFileType($filename) {
        //Retrieve extension    
        $file_array = array_reverse(explode(".", $filename));
        $file_ext = strtolower($file_array[0]);
        
        if ($file_ext == 'zip') {
            $imagetype = 'zip';
        } else {
            if ( in_array($file_ext, $this->allowedFiles) ) {
                $imagetype = 'image';
            } else {
                $imagetype = 'error';
            }
        }
        return $imagetype;
    }
    /**
     * Returns the correct imagetype
     */
    function getImageType( $filename ) {
        $image = getimagesize( $filename );
        $type = $image[2];
        switch ( $type ) {
            case 1:
                $imagetype = "gif";
                break;
            case 2:
                $imagetype = "jpg";
                break;
            case 3:
                $imagetype = "png";
                break;
            case 4:
                $imagetype = "swf";
                break;
            case 5:
                $imagetype = "psd";
                break;
                                                            
        }
        return $imagetype;
    }
    
    /**
     * Checks the number of images against the number of images to upload.
     * @return boolean True if number is within boundaries, false if number exceeds maximum
     * @todo Check if user is Super Administrator. Limits do not count for him
     */
    function checkMaxImages($zip = false, $zip_count = '' ) {
    global $database, $rsgConfig;
        $maxImages = $rsgConfig->get('uu_maxImages');
        
        //Check if maximum number of images is exceeded
        $database->setQuery("SELECT count(*) FROM #__rsgallery2_files WHERE userid = $my->id");
        $count = $database->loadResult();
        
        if ($zip == true)
            {
            $total = $count + $zip_count['nb'];
            if ( $total > $maxImages )
                {
                return false;
                }
            else
                {
                return true;
                }
            }
        else
            {
            if ( $count >= $maxImages )
                {
                return false;
                }
            else
                {
                return true;
                }
            }
        }
    
    /**
     * Cleans out any last remains out of /media directory, except files that belong there
     * @return boolean True upon completion, false if some files remain in media
     */
    function cleanMediaDir() {
        $mediadir = JPATH_ROOT."/media";
        $files = mosReadDirectory($mediadir);
        foreach ($files as $file) {
            if ( !in_array($file, $this->protectedFiles) ) {
                unlink($mediadir."/".$file);
            }
        }
        return true;
    }
    
    /**
     * Picks up a ZIP-file from a form and extracts it to a designated directory
     * @param array File array from form post method
     * @param string Absolute path to destination folder, defaults to Joomla /media folder
     * @return array with filenames
     */
    function handleZIP($zip_file, $destination = '' ) {
    global $rsgConfig;
    include(JPATH_ROOT.'/administrator/includes/pcl/pclzip.lib.php');
    
    $maxImages = $rsgConfig->get('uu_maxImages');
    
    //Default to /media
    if (!$destination)
        $destination = JPATH_ROOT.DS.'media'.DS;
        
        //Function to discard subfolder information during extraction of ZIP-file
        function myPreExtractCallBack($p_event, &$p_header) {
            if ($p_header['folder'] == 1) {
                return 0;
            } else {
                return 1;
            }
        }
        
        //Create new zipfile
        $tzipfile = new PclZip($zip_file['tmp_name']);
        
        $ziplist = $tzipfile->listContent();
        
        //For future checking of maximages
        //$zip_properties = $tzipfile->properties();
        
        //Unzip to ftp directory, removing all path info
        
        $zip_list = $tzipfile->extract(  PCLZIP_OPT_PATH, $destination,
                                PCLZIP_OPT_REMOVE_ALL_PATH,
                                PCLZIP_CB_PRE_EXTRACT, "myPreExtractCallBack",
                                PCLZIP_OPT_BY_PREG, '/^[^_]/' );

        if ($zip_list == 0){
            return 0;
            die ("- Error message :".$tzipfile->errorInfo(true));
        } else {
            return $ziplist;
        }
    }
    
    /**
     * Copies all files from a map to the /media map.
     * It will NOT delete the media from the FTP-location
     * @param string Absolute path to the sourcefolder
     * @param string Absolute path to destination folder, defaults to Joomla /media folder
     */
    function handleFTP($source, $destination = '') {
        global $ziplist;
        //Default to /media
        if (!$destination)
            $destination = JPATH_ROOT.DS.'media'.DS;
            
        //Check for trailing slash in source path and add one if necessary
        if(strcmp(substr($source,-1),'/') !== 0) {
            $source .= '/';
        }
        
        //check source directory
        if (!file_exists( $source ) OR !is_dir ( $source )) {
            echo $source." does not exist is is no directory on your server. Please check the path.";
            mosRedirect('index2.php?option=com_rsgallery2&task=batchupload', $source.' does not exist or is no directory on your server. Please check the path.');
        }
        //Read files from FTP-directory
        $files = mosReadDirectory($source, '');
        if (!$files) {
            mosRedirect('index2.php?option=com_rsgallery2&task=batchupload', 'No valid images found in '.$source.'. Please check the path.');
        }
        
        foreach ($files as $file) {
        //Check if upload directory exists and are there any files to process
            if ( imgUtils::isAllowedType($file) ) {
                //Add filename to array $ziplist
                $ziplist[]['filename'] = $file;
                if ($source != JPATH_ROOT."/media/") {
                    //copy to "/media" if not already there
                    copy( $source.$file, $destination.$file);
                } else {
                    //Image already in the right place, continue
                    continue;
                }
            } else {
                //Report wrong filetype and go on. It will be ignored.
                echo "<p style=\"color:#cc0000;font-style:bold;\">$source$file is not an allowed filetype, it will be ignored!</p>";
            }
        }
        
        if (count($ziplist) == 0) {
            echo "No files found to process!";
        } else {
        return $ziplist;            
        }
    }
    /**
     * Reads the error code from the upload routine and generates corresponding message.
     * @param int Error code, from $_FILES['i_file']['error']
     * @param string redirect text. e.g. "index2.php?option=com_rsgallery2&page=my_galleries"
     * @param boolean True if redirect is needed, false if only msg text is needed. 
     */
    function handleUploadError( $error, $redirect_statement, $redirect = true) {
        
        if ( $error == 0 ) {
            continue;
        } else {
            switch ( $error ) {
                case 1:
                    $msg = "The uploaded file exceeds the upload_max_filesize directive in php.ini.(UPLOAD_ERR_INI_SIZE)";
                    break;
                case 2:
                    $msg = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.(UPLOAD_ERR_FORM_SIZE)";
                    break;
                case 3:
                    $msg = "The uploaded file was only partially uploaded.(UPLOAD_ERR_PARTIAL)";
                    break;
                case 4:
                    $msg = "No file was uploaded.(UPLOAD_ERR_NO_FILE)";
                    break;
                case 6:
                    $msg = "Your server is missing a temporary folder.(UPLOAD_ERR_NO_TMP_DIR)";
                    break;
                case 7:
                    $msg = "Failed to write file to disk.(UPLOAD_ERR_CANT_WRITE)";
                    break;
                case 8:
                    $msg = "File upload stopped by extension.(UPLOAD_ERR_EXTENSION)";
                    break;
            }
        //Redirect or not
        if ($redirect)
            mosRedirect($redirect_statement, $msg);
        else
            echo $msg;
        }
    }
    
    /**
     * Extracts archive file into specified directory
     * @param string filename of archive
     */
        function extractArchive($archivename) {

        $extractdir     = mosPathName( JPATH_ROOT . '/media' );

        $this->unpackDir( $extractdir );

        if (eregi( '.zip$', $archivename )) {
            // Extract functions
            require_once( JPATH_ROOT . '/administrator/includes/pcl/pclzip.lib.php' );
            require_once( JPATH_ROOT . '/administrator/includes/pcl/pclerror.lib.php' );

            $zipfile = new PclZip( $archivename );
            if($this->isWindows()) {
                define('OS_WINDOWS',1);
            } else {
                define('OS_WINDOWS',0);
            }

            $ret = $zipfile->extract( PCLZIP_OPT_PATH, $extractdir );
            if($ret == 0) {
                $this->setError( 1, 'Unrecoverable error "'.$zipfile->errorName(true).'"' );
                return false;
            }
        } else {
            require_once( JPATH_ROOT . '/includes/Archive/Tar.php' );
            $archive = new Archive_Tar( $archivename );
            $archive->setErrorHandling( PEAR_ERROR_PRINT );

            if (!$archive->extractModify( $extractdir, '' )) {
                $this->setError( 1, 'Extract Error' );
                return false;
            }
        }

        $this->installDir( $extractdir );

        // Try to find the correct install dir. in case that the package have subdirs
        // Save the install dir for later cleanup
        $filesindir = mosReadDirectory( $this->installDir(), '' );

        if (count( $filesindir ) == 1) {
            if (is_dir( $extractdir . $filesindir[0] )) {
                $this->installDir( mosPathName( $extractdir . $filesindir[0] ) );
            }
        }
        return true;
    }
        
}//End class FileHandler
?>