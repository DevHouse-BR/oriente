<?php
/**
 * This class encapsulates the HTML for the non-administration RSGallery pages.
 * @version $Id$
 * @package RSGallery2
 * @copyright (C) 2003 - 2006 RSGallery2
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined( '_VALID_MOS' ) or die( 'Access Denied.' );

require_once(JPATH_ROOT.'/includes/pageNavigation.php');
//why do we need this, this messes up the joomfish translation
//require_once(JPATH_ROOT.'/configuration.php');

/**
 * HTML for the frontend
 * @package RSGallery2
 */
class HTML_RSGALLERY{

    /**
     *  write the footer
     */
    function RSGalleryFooter(){
        global $rsgConfig, $rsgVersion;

        $hidebranding = '';
        if( $rsgConfig->get( 'displayBranding' ) == false )
            $hidebranding ="style='display: none'";
            
        ?>
		<div id='rsg2-footer' <?php echo $hidebranding; ?>>
			<div><br /><br />
				<?php echo $rsgVersion->getShortVersion(); ?>
			</div>
		</div>
		<div class='rsg2-clr'>&nbsp;</div>
        <?php
    }
    
    function showUserGallery($rows)
    {
    global $my, $rsgConfig, $mosConfig_live_site, $Itemid;
    ?>
    <script language="javascript" type="text/javascript">
        function submitbutton2(pressbutton) {
        var form = document.form1;
        // do field validation
        if (form.catname1.value == "") {
            alert( "<?php echo _RSGALLERY_MAKECAT_ALERT_NAME; ?>" );
        }
        else if (form.description.value == ""){
            alert( "<?php echo _RSGALLERY_MAKECAT_ALERT_DESCR; ?>" );
        }
        else{
        	<?php //getEditorContents( 'editor1', 'description' ) ; ?>
            form.submit();
        }
        }
    </script>
    <?php
    if ($rows) {
        foreach ($rows as $row){
            $catname        = $row->name;
            $description    = $row->description;
            $ordering       = $row->ordering;
            $uid            = $row->uid;
            $catid          = $row->id;
            $published      = $row->published;
            $user           = $row->user;
            $parent         = $row->parent;
        }
    }
    else{
        $catname        = "";
        $description    = "";
        $ordering       = "";
        $uid            = "";
        $catid          = "";
        $published      = "";
        $user           = "";
        $parent         = "";
    }
    ?>
        <form name="form1" id="form1" method="post" action="<?php echo sefRelToAbs("index.php?option=com_rsgallery2&amp;Itemid=$Itemid&amp;page=makeusercat"); ?>">
        <table width="100%">
        <tr>
            <td colspan="2"><h3><?php echo _RSGALLERY_CREATE_GALLERY; ?></h3></td>
        </tr>
        <tr>

            <td align="right">
                <img onClick="javascript:submitbutton2('save');" src="<?php echo $mosConfig_live_site; ?>/administrator/images/save.png" alt="<?php echo _RSGALLERY_SAVE; ?>" border="0" name="save" onMouseOver="document.save.src='<?php echo $mosConfig_live_site; ?>/administrator/images/save_f2.png';" onMouseOut="document.save.src='<?php echo $mosConfig_live_site;?>/administrator/images/save.png';" />&nbsp;&nbsp;
                <?php
                if ($rows)
                    {
                    ?>
                    <img onClick="form1.reset();" src="<?php echo $mosConfig_live_site; ?>/administrator/images/cancel.png" alt="<?php echo _RSGALLERY_CANCEL; ?>" border="0" name="cancel" onMouseOver="document.cancel.src='<?php echo $mosConfig_live_site; ?>/administrator/images/cancel_f2.png';" onMouseOut="document.cancel.src='<?php echo $mosConfig_live_site; ?>/administrator/images/cancel.png';" />
                    <?php
                    }
               else
                    {
                    ?>
                    <img onClick="form1.reset();" src="<?php echo $mosConfig_live_site; ?>/administrator/images/cancel.png" alt="<?php echo _RSGALLERY_CANCEL; ?>" border="0" name="cancel" onMouseOver="document.cancel.src='<?php echo $mosConfig_live_site; ?>/administrator/images/cancel_f2.png';" onMouseOut="document.cancel.src='<?php echo $mosConfig_live_site; ?>/administrator/images/cancel.png';" />
                    <?php
                    }
                    ?>
            </td>

        </tr>
        </table>
        <input type="hidden" name="catid" value="<?php echo $catid; ?>" />
        <input type="hidden" name="ordering" value="<?php echo $ordering; ?>" />
        <table class="adminlist" border="1">
        <tr>
            <th colspan="2"><?php echo _RSGALLERY_CREATE_GALLERY; ?></th>
        </tr>
        <tr>
            <td><?php echo _RSGALLERY_CATLEVEL;?></td>
            <td>
            	<?php //galleryUtils::showCategories(NULL, $my->id, 'parent');?>
                <?php //galleryUtils::galleriesSelectList( $parent, 'parent', false );?>
                <?php galleryUtils::createGalSelectList( NULL, $listName='parent', true );?>
            </td>
        </tr>
        <tr>
            <td><?php echo _RSGALLERY_USERCAT_NAME; ?></td>
            <td align="left"><input type="text" name="catname1" size="30" value="<?php echo $catname; ?>" /></td>
        </tr>
        <tr>
            <td><?php echo _RSGALLERY_DESCR; ?></td>
            <td align="left">
            	<textarea cols="20" rows="5" name="description"><?php echo htmlspecialchars(stripslashes($description)); ?></textarea>
            	<?php
            	// parameters : areaname, content, hidden field, width, height, rows, cols
                //editorArea( 'editor1',  $description , 'description', '200', '300', '10', '10' ) ; ?>
            </td>
        </tr>
        <tr>
            <td><?php echo _RSGALLERY_CATPUBLISHED; ?></td>
            <td align="left"><input type="checkbox" name="published" value="1" <?php if ($published==1) echo "checked"; ?> /></td>
        </tr>
        </table>
        </form>
        <?php
        }

    function slideShowLink ()
        {
        global $rsgConfig, $Itemid;
        $displaySlideshow = $rsgConfig->get("displaySlideshow");
        if (isset($_REQUEST['catid'])) $catid = mosGetParam ( $_REQUEST, 'catid'  , '');
        
        if ( $displaySlideshow )
            {
            ?>
            <a href="<?php echo sefRelToAbs("index.php?option=com_rsgallery2&Itemid=".$Itemid."&page=slideshow&catid=".$catid);?>">Slideshow</a>
            <?php
            }
        }
	function writeSlideShowLink($Itemid) {
		global $rsgConfig, $Itemid;
        if (isset($_REQUEST['catid'])) $catid = mosGetParam ( $_REQUEST, 'catid'  , '');
        if (isset($_REQUEST['id'])) $id = mosGetParam ( $_REQUEST, 'id'  , '');
		?>
			<div style="float: right;">
			<ul id='rsg2-navigation'>
				<li>
				<?php
				if ( $rsgConfig->get('displaySlideshow') ) {
				?>
					<a href="<?php echo sefRelToAbs('index.php?option=com_rsgallery2&Itemid='.$Itemid.'&page=slideshow&catid='.$catid.'&id='.$id);?>">
					<?php echo _RSGALLERY_SLIDESHOW; ?>
					</a>
				<?php
				}
				?>
				</li>
			</ul>
			</div>
			<div class='rsg2-clr'>&nbsp;</div>
		<?php
	}
	
    function edit_image($rows)
        {
        global $my, $mosConfig_live_site, $rsgConfig, $Itemid;
		require_once( $GLOBALS['mosConfig_absolute_path'] . '/includes/HTML_toolbar.php' );
        foreach ($rows as $row)
            {
            $filename       = $row->name;
            $title          = $row->title;
            $description    = $row->descr;
            $id             = $row->id;
            $limitstart     = $row->ordering - 1;
            $catid          = $row->gallery_id;
            }
        echo "<h3>"._RSGALLERY_EDIT_IMAGE."</h3>";
        ?>
        <form name="form1" method="post" action="<?php echo sefRelToAbs("index.php?option=com_rsgallery2&amp;Itemid=$Itemid&amp;page=save_image"); ?>">
        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        <input type="hidden" name="catid" value="<?php echo $catid; ?>" />
        <table width="100%">
            <tr>
                <td align="right">
                    <img onClick="form1.submit();" src="<?php echo $mosConfig_live_site; ?>/administrator/images/save.png" alt="<?php echo _RSGALLERY_TOOL_UP ?>" border="0" name="upload" onMouseOver="document.upload.src='<?php echo $mosConfig_live_site; ?>/administrator/images/save_f2.png';" onMouseOut="document.upload.src='<?php echo $mosConfig_live_site; ?>/administrator/images/save.png';" />&nbsp;&nbsp;
                    <img onClick="history.back();" src="<?php echo $mosConfig_live_site; ?>/administrator/images/cancel.png" alt="<?php echo _RSGALLERY_CANCEL; ?>" border="0" name="cancel" onMouseOver="document.cancel.src='<?php echo $mosConfig_live_site; ?>/administrator/images/cancel_f2.png';" onMouseOut="document.cancel.src='<?php echo $mosConfig_live_site; ?>/administrator/images/cancel.png';" />
                </td>
            </tr>
        </table>
        <table class="adminlist" border="2" width="100%">
            <tr>
                <th colspan="3"><?php echo _RSGALLERY_EDIT_IMAGE; ?></th>
            </tr>
            <tr>
                <td align="left"><?php echo _RSGALLERY_CAT_NAME; ?></td>
                <td align="left">
                	<?php if (!$rsgConfig->get('acl_enabled')) {
                    	galleryUtils::showCategories(NULL, $my->id, 'catid');
                    } else {
                    	galleryUtils::showUserGalSelectList('up_mod_img', 'catid', $catid);
                    }
                    ?>
                </td>
                <td rowspan="2"><img src="<?php echo imgUtils::getImgThumb($filename); ?>" alt="<?php echo $title; ?>" border="0" /></td>
            </tr>
            <tr>
                <td align="left"><?php echo _RSGALLERY_EDIT_FILENAME; ?></td>
                <td align="left"><strong><?php echo $filename; ?></strong></td>
            </tr>
            <tr>
                <td align="left"><?php echo _RSGALLERY_EDIT_TITLE;?></td>
                <td align="left"><input type="text" name="title" size="30" value="<?php echo $title; ?>" /></td>
            </tr>
            <tr>
                <td align="left" valign="top"><?PHP echo _RSGALLERY_EDIT_DESCRIPTION; ?></td>
                <td align="left" colspan="2">
                    <textarea cols="25" rows="5" name="descr"><?php echo htmlspecialchars(stripslashes($description)); ?></textarea>
                    <?php
                    // parameters : areaname, content, hidden field, width, height, rows, cols
					//editorArea( 'editor1',  $description, 'descr', '100%;', '500', '75', '50' );
                    ?>
                </td>
            </tr>
            <tr>
                <th colspan="3">&nbsp;</th>
            </tr>
        </table>
        </form>
        <?php
        }


    function showFrontUpload()
        {
        global $rsgConfig, $mosConfig_live_site, $mosConfig_absolute_path, $i_file, $conversiontype, $my, $Itemid;
        
        //Load frontend toolbar class
        require_once( $GLOBALS['mosConfig_absolute_path'] . '/includes/HTML_toolbar.php' );
        ?>
        <script language="javascript" type="text/javascript">
        function submitbutton(pressbutton)
            {
            var form = document.uploadform;
			if (pressbutton == 'cancel') {
				form.reset();
				return;
			}
			
            // do field validation
            if (form.i_cat.value == 0) {
                alert( "<?php echo _RSGALLERY_UPLOAD_ALERT_CAT; ?>" );
            } else if (form.i_file.value == "") {
                alert( "<?php echo _RSGALLERY_UPLOAD_ALERT_FILE; ?>" );
			} else {
                form.submit();
            }
        }
        
    </script>
        <form name="uploadform" id="uploadform" method="post" action="<?php echo sefRelToAbs("index.php?option=com_rsgallery2&amp;Itemid=$Itemid&amp;page=doFrontUpload"); ?>" enctype="multipart/form-data">
        <table border="0" width="100%">
            <tr>
                <td colspan="2"><h3><?php echo _RSGALLERY_ADD_IMAGE;?></h3></td>
            </tr>
            <tr>

                <td align="right">
                    <div style="float: right;">
						<?php
						// Toolbar
						mosToolBar::startTable();
						mosToolBar::save();
						mosToolBar::cancel();
						mosToolBar::endtable();
						?>
					</div>
                </td>

            </tr>
            <tr>
                <td>
                    <table class="adminlist" border="1">
                    <tr>
                        <th colspan="2"><?php echo _RSGALLERY_USERUPLOAD_TITLE; ?></th>
                    </tr>
                    <tr>
                        <td><?php echo _RSGALLERY_USERUPLOAD_CATEGORY; ?></td>
                        <td>
                            <?php 
                            if (!$rsgConfig->get('acl_enabled')) {
                            	galleryUtils::showCategories(NULL, $my->id, 'i_cat');
                            } else {
                            	galleryUtils::showUserGalSelectList('up_mod_img', 'i_cat');
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo _RSGALLERY_FILENAME ?></td>
                        <td align="left"><input size="49" type="file" name="i_file" /></td>
                    </tr>
                    </tr>
                        <td><?php echo _RSGALLERY_UPLOAD_FORM_TITLE ?>:</td>
                        <td align="left"><input name="title" type="text" size="49" />
                    </td>
                    </tr>
                    <tr>
                        <td><?php echo _RSGALLERY_DESCR ?></td>
                        <td align="left"><textarea cols="35" rows="3" name="descr"></textarea></td>
                    </tr>
                    <?php
                    if ($rsgConfig->get('graphicsLib') == '')
                        { ?>
                    <tr>
                        <td><?php echo _RSGALLERY_UPLOAD_THUMB; ?></td>
                        <td align="left"><input type="file" name="i_thumb" /></td>
                    </tr>
                        <?php } ?>
                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="cat" value="9999" />
                            <input type="hidden" name="uploader" value="<?php echo $my->id; ?>">
                        </td>
                    <tr>
                        <th colspan="2">&nbsp;</th>
                    </tr>
                    </table>
                </td>
            </tr>
        </table>
        </form>
        <?php
        }

    /**
        @todo this bowl of spagetti needs to be rewritten!!!
    **/
    function RSGalleryInline($id, $catid){
        global $my, $mosConfig_absolute_path, $mosConfig_live_site, $rsgConfig, $database;
        ?>
        <script type="text/javascript">
            function deleteComment(id) {
                var yesno = confirm ('<?php echo _RSGALLERY_COMMENT_DELETE;?>');
                if (yesno == true) {
                    location = 'index.php?option=com_rsgallery2&page=delete_comment&id='+id+'';
                }
            }
            </script>
        <?php
        include_once(JPATH_RSGALLERY2_ADMIN.'/includes/img.utils.php');
        
        $limitstart = mosGetParam ( $_REQUEST, 'limitstart', 0);
        
        $displayDesc            = $rsgConfig->get("displayDesc");
        $displayVoting          = $rsgConfig->get("displayVoting");
        $displayComments        = $rsgConfig->get("displayComments");
        $displayEXIF            = $rsgConfig->get("displayEXIF");
        $imagepath              = $rsgConfig->get("imgPath_display");
        $image_width            = $rsgConfig->get("image_width");
        $ResizeOption           = $rsgConfig->get("display_img_dynamicResize");
        $PageSize               = $rsgConfig->get("display_thumbs_maxPerPage");
        $displayPopup			= $rsgConfig->get("displayPopup");
        
        $useTabs=0;

        if ($displayDesc == 1) $useTabs++;
        if ($displayVoting == 1) $useTabs++;
        if ($displayComments ==1) $useTabs++;
        if ($displayEXIF == 1) $useTabs++;
        $useTabs = $useTabs > 1 ? 1 : 0;

        $firstTab='';

        if($displayDesc) 			$firstTab = 'tab1';
        elseif($displayVoting) 		$firstTab = 'tab2';
        elseif($displayComments)	$firstTab = 'tab3';
        elseif($displayEXIF) 		$firstTab = 'tab4';

        $PageSize=1;

        $database->setQuery("SELECT COUNT(*) FROM #__rsgallery2_files WHERE gallery_id = '$catid'");
        $numPics = $database->loadResult();


    //instantiate page navigation
    $pagenav = new mosPageNav($numPics, $limitstart, $PageSize);
	$thisPage = floor($limitstart/$PageSize)+1;
	$maxPage = ceil($numPics / $PageSize);

    if (!$numPics) {
        echo "1" . _RSGALLERY_NOIMG;
        }
    $database->setQuery("SELECT * FROM #__rsgallery2_files".
           " WHERE gallery_id = $catid".
           " ORDER BY ordering ASC".
           " LIMIT $limitstart, $PageSize");
    $rows = $database->loadObjectlist();

    if (!$rows) echo _RSGALLERY_NOIMG;

    $j = $limitstart;
    $i =0;
        foreach($rows as $row)
            {
            galleryUtils::addHit($row->id);
            $size = getimagesize(imgUtils::getImgDisplay($row->name, true));
            $ext = substr(strchr($row->name, '.'),1);

        $img_width = $size[0];
        switch( $ResizeOption ) {
        case 0:  // No display resizing
            $dispWidth = $img_width;
            break;
        case 1:  // Resize larger pics down, and leave smaller pics as is
            if( $img_width > $image_width )
            {
                $dispWidth = $image_width;
            }
            else $dispWidth = $img_width;
            break;
        case 2:  // Resize smaller pics up, and leave larger pics as is
            if( $img_width < $image_width )
            {
                $dispWidth = $image_width;
            }
            else $dispWidth = $img_width;
            break;
        case 3:  // Resize all pics to fit into frame.
            $dispWidth = $image_width;
            break;
        default:
            $dispWidth = $img_width;
       }
       
       //Different popup methods
       switch ($displayPopup) {
       		//No popup
       		case 0:
       			
       			break;
       		//Normal popup
       		case 1:
       			$imgtag = "target=\"_blank\"";
       			break;
       		//Fancy popup using JS (This one generates errors in IE6, so offered as an option)
       		case 2:
       			//Load stylesheet business for JS Highslide
       			$imgtag = "class=\"highslide\" onclick=\"return hs.expand(this)\"";
       			?>
				<link rel="stylesheet" href="<?php echo $mosConfig_live_site;?>/components/com_rsgallery2/js_highslide/highslide.css" type="text/css" />
				<script type="text/javascript" src="<?php echo $mosConfig_live_site;?>/components/com_rsgallery2/js_highslide/highslide.js"></script>
				<script type="text/javascript">    
					hs.graphicsDir = '<?php echo $mosConfig_live_site;?>/components/com_rsgallery2/js_highslide/graphics/';
					hs.showCredits = false;
					hs.outlineType = 'drop-shadow';
					window.onload = function() {
						hs.preloadImages();
		    		}
				</script>
				<div id="highslide-container">
       			<?php
       }//end switch 

        //Write slideshowlink
		if ($rsgConfig->get('displaySlideshow')) {
			global $Itemid;
			HTML_RSGALLERY::writeSlideShowLink($Itemid);
		}
		
		//Write page navigation
		?>
		</div><!-- end highslide container 2 -->
        <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tr>
        	<td colspan="2">&nbsp;</td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
	        <td>
	            <div align="center">
	            <?php
	            // print page navigation.
				global $Itemid;
	            echo $pagenav->writePagesLinks( "index.php?option=com_rsgallery2&amp;Itemid=$Itemid&amp;page=inline&amp;catid=".$catid."&amp;id=".$row->id );
	            ?>
	            </div>
	        </td>
	        <td>&nbsp;</td>
	    </tr>
	    </table>
	    <?php
	    //Write main body
	    ?>
	    <table border="0" cellspacing="0" cellpadding="0" width="100%">
	    <tr>
	        <td>&nbsp;</td>
	        <td><h2 class='rsg2_display_name' align="center"><?php echo htmlspecialchars(stripslashes($row->title), ENT_QUOTES); ?></h2></td>
	        <td>&nbsp;</td>
	    </tr>
	    <tr>
	        <td>&nbsp;</td>
	        <td>
	            <div align="center">
	            <?php
	            if (!$displayPopup == 0) {
	            	if ($rsgConfig->get('watermark') == true) { 
	            	?>
	            		<a href="<?php echo waterMarker::showMarkedImage($row->name, 'original'); ?>" <?php echo $imgtag;?>>
	            	<?php
	            	} else {
	            		?>
	            		<a href="<?php echo imgUtils::getImgOriginal($row->name); ?>" <?php echo $imgtag;?>>
	            	<?php
	            	}
	            }
	            
	            if ($rsgConfig->get('watermark') == true) {
	                ?>
	                <!--<div class="img-shadow">-->
	                <img id="thumb1" src="<?php waterMarker::showMarkedImage($row->name);?>" alt="<?php echo htmlspecialchars(stripslashes($row->descr), ENT_QUOTES); ?>" border="0" width="<?php echo $dispWidth;?>" />
	                <!--</div>-->
	                <?php
	            } else {
	                ?>
	                <!--<div class="img-shadow">-->
	            	<img id="thumb1" src="<?php echo imgUtils::getImgDisplay($row->name); ?>" alt="<?php echo htmlspecialchars(stripslashes($row->descr), ENT_QUOTES); ?>" border="0" width="<?php echo $dispWidth;?>" />
	            	<!--</div>-->
	            	<?php
	            }
	            if (!$displayPopup == 0) {
	            	?>
	            		</a>
	            	<?php
	            }
	            ?>
	            </div>
	            <?php
	            if ($displayPopup == 2) {
		            ?>
		            <div class='highslide-caption' id='caption-for-thumb1'>
		    			<?php echo galleryUtils::getTitleFromId($row->id);?>
					</div></div><!-- End higslide container -->
				<?php
	            }
	            ?>
        	</td>
        	<td valign="top">&nbsp;</td>
    	</tr>
	    <tr>
	    	<td valign="top">&nbsp;</td>
	        <td><div align="center">
	    		<?php 
				if ($rsgConfig->get('displayDownload') )
					galleryUtils::writeDownloadLink($row->id);
				?></div>
			</td>
			<td valign="top">&nbsp;</td>
	    </tr>
    </table>
    

    <?php
    //Here comes the row with the tabs
    if ($useTabs)
    {
    $tabs = new mosTabs(0);
    $tabs->startPane( 'tabs' );
    }
    if ($displayDesc == 1)
    {
    if ($useTabs)   $tabs->startTab(_RSGALLERY_DESCR, 'rs-description' );
    ?>
            <table width="100%" border="0" cellpadding="0" cellspacing="1" class="adminForm">
            <tr>
                <td>
                    <table width="100%" cellpadding="2" cellspacing="1">
                        <?php if( $rsgConfig->get('displayHits')): ?>
                        <tr>
                            <td valign="top" width="100">&nbsp;<strong><?php echo _RSGALLERY_CATHITS; ?>:</strong></td>
                            <td valign="top"><?php echo $row->hits+1; ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <td valign="top" colspan='2'><?php if ($row->descr) echo $row->descr; else echo "<em>"._RSGALLERY_NODESCR."</em>"; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            </table>
         <?php 
    if ($useTabs)   $tabs->endTab();
    }
    if ($displayVoting == 1)
    {
    if ($useTabs)   $tabs->startTab(_RSGALLERY_VOTING, 'Voting' );
    ?>
    <table width="100%" border="0" cellpadding="0" cellspacing="1" class="adminForm">
       <tr>
             <td>
               <table width="100%" cellpadding="2" cellspacing="1">

                        <form method="post" action="<?php echo sefRelToAbs("index.php?option=com_rsgallery2&amp;Itemid=$Itemid&amp;page=vote"); ?>">
                        <tr>
                                <td colspan="1" width="100"><strong><?php echo _RSGALLERY_VOTES_NR; ?>:</strong></td>
                                <td colspan="4"><?php echo $row->votes; ?></td>
                        </tr>
                        <tr>
                            <td colspan="1"><strong><?php echo _RSGALLERY_VOTES_AVG; ?>:</strong></td>
                            <td colspan="4"><?php if ($row->votes > 0) echo galleryUtils::showRating($row->id);else echo _RSGALLERY_NO_RATINGS; ?></td>
                        </tr>
                        <tr>
                            <input type="hidden" name="picid" value="<?php echo $row->id; ?>" />
                            <input type="hidden" name="limitstart" value="<?php echo $limitstart; ?>" />
                            <td valign="top"><strong><?php echo _RSGALLERY_VOTE; ?>:</strong></td>
                            <td colspan="4">
                                <input type="radio" name="vote" value="1" /><?php echo _RSGALLERY_VERYBAD; ?><br />
                                <input type="radio" name="vote" value="2" /><?php echo _RSGALLERY_BAD; ?><br />
                                <input type="radio" name="vote" value="3" CHECKED/><?php echo _RSGALLERY_OK; ?><br />
                                <input type="radio" name="vote" value="4" /><?php echo _RSGALLERY_GOOD; ?><br />
                                <input type="radio" name="vote" value="5" /><?php echo _RSGALLERY_VERYGOOD; ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" align="center"><input class="button" type="submit" name="submit" value="<?php echo _RSGALLERY_VOTE;?>" /></td>
                        </tr>
                        </form>
                    </table>
                </td>
            </tr>
    </table>
    <?php
    if ($useTabs)   $tabs->endTab();
    }
    if ($displayComments == 1) 
    {
    if ($useTabs)   $tabs->startTab(_RSGALLERY_COMMENTS, 'Comments' );
    ?>
        <table width="100%" border="0" cellpadding="0" cellspacing="1" class="adminForm">
        <?php
        $database->setQuery("SELECT * FROM #__rsgallery2_comments WHERE picid='$row->id' ORDER BY id DESC");
        $crows = $database->loadObjectList();
        if (!$crows)
        {
        ?>
            <tr>
                <td><?php echo _RSGALLERY_NO_COMMENTS; ?></td>
            </tr>
        <?php 
        }
        else
        {
        ?>
            <tr>
                <td>
                            <table width="100%" cellpadding="2" cellspacing="1">
                        <?php
                        foreach ($crows as $crow)
                            {
                                ?>
                                <tr>
                                    <td width="120"><strong><?php echo _RSGALLERY_COMMENT_DATE; ?>:</strong></td>
                                    <td><?php echo mosFormatDate($crow->date); ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo _RSGALLERY_COMMENT_BY; ?>:</strong></td>
                                    <td><?php echo htmlspecialchars(stripslashes($crow->name), ENT_QUOTES); ?></td>
                                </tr>
                                <tr>
                                    <td valign="top"><strong><?php echo _RSGALLERY_COMMENT_TEXT; ?>:</strong></td>
                                    <td><?php echo htmlspecialchars(stripslashes($crow->comment), ENT_QUOTES); ?></td>
                                </tr>
                                <?php
                                if ($my->usertype == 'Super Administrator')
                                    {
                                    ?>
                                    <tr>
                                        <td colspan="2">
                                        <div align="right">
                                            <a href="#" onClick="javascript:deleteComment(<?php echo $crow->id;?>);">
                                            <?php echo _RSGALLERY_DELETE_COMMENT;?>
                                            </a>
                                        </div>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                <tr>
                                    <td colspan="2" align="center"><hr></td>
                                </tr>              
                                <?php 
                                }
                                ?>
                            </table>
                        </td>
            </tr>
        <?php
        }
        ?> 
                    <tr>
                        <td colspan="2"><strong><font color="#FFFFFF">&nbsp;<?php echo _RSGALLERY_COMMENT_ADD; ?></font></strong></td>
                    </tr>
                    <tr>
                        <td>
                        <form method="post" action="<?php global $Itemid; echo sefRelToAbs("index.php?option=com_rsgallery2&amp;Itemid=$Itemid&amp;page=addcomment"); ?>">
                        <input type="hidden" name="picid" value="<?php echo $row->id; ?>" />
                        <input type="hidden" name="limitstart" value="<?php echo $limitstart; ?>" />
                        <table width="100%" cellpadding="2" cellspacing="1">
                            <tr>
                                <td width="130"><strong><?php echo _RSGALLERY_COMMENT_NAME; ?>:</strong></td>
                                <td><input class="inputbox" type="text" name="name" size="30" value="<?php echo $my->username; ?>" /></td>
                            </tr>
                            <tr>
                                <td width="130" valign="top"><strong><?php echo _RSGALLERY_COMMENT_ADD_TEXT; ?>:</strong></td>
                                <td><textarea class="inputbox" cols="30" rows="3" name="comment" /></textarea></td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center"><input class="button" type="submit" name="submit" value="<?php echo _RSGALLERY_COMMENT_ADD; ?>" /></td>
                            </tr>
                        </table>
                        </form>
                        </td>
                    </tr>
        </table>
        <?php
        if ($useTabs)   $tabs->endTab();
    }
    if ($displayEXIF == 1)
    {
        if ($useTabs)   $tabs->startTab(_RSGALLERY_EXIF, 'EXIF' );
        ?>
        <table width="100%" border="0" cellpadding="0" cellspacing="1" class="adminForm">
          <tr>
            <td>
            <table width="100%" cellpadding="2" cellspacing="1"><tr>
                <td align="center"><?php echo imgUtils::showEXIF(imgUtils::getImgOriginal($row->name, true)); ?></td>
            </tr></table>
            </td>
          </tr>
        </table>
        <?php
        if ($useTabs)   $tabs->endTab();
    }
    if ($useTabs)   $tabs->endPane();
      }
 $i++; $j++;
    }
    //end of inline
    
    /**
     * Shows header with appropriate links at top of each rsgallery page
     * @param integer category ID. Used to echo category name if present
     * @param string intro text to show on main gallery page.
     * @todo Rewrite this into cleaner coding style.
     */
    function RSGalleryTitleblock($catid, $intro_text)   {
        global $my, $mosConfig_live_site, $rsgConfig, $Itemid;
        
        if ( isset($_REQUEST['page']) ) 
            $page = mosGetParam ( $_REQUEST, 'page'  , '');
		else
			$page = NULL;
			
        //$user_cats  = $rsgConfig->get('uu_enabled');
        //$my_galleries = $rsgConfig->get('show_mygalleries');
        ?>
        <div style="float:right; text-align:right;">
        <ul id='rsg2-navigation'>
            <li>
                <a href="<?php echo sefRelToAbs("index.php?option=com_rsgallery2&amp;Itemid=".$Itemid); ?>">
                <?php echo _RSGALLERY_MAIN_GALLERY_PAGE; ?>
                </a>
            </li>
            <?php 
            if ( !$my->id == "" && $page != "my_galleries" && $rsgConfig->get('show_mygalleries') == 1):
            ?>
            <li>
                <a href="<?php echo sefRelToAbs("index.php?option=com_rsgallery2&Itemid=".$Itemid."&page=my_galleries");?>">
                <?php echo _RSGALLERY_MY_GALLERIES; ?>
                </a>
            </li>
            <?php
            elseif( $page == "slideshow" ): 
            ?>
            <li>
                <a href="<?php echo sefRelToAbs("index.php?option=com_rsgallery2&Itemid=".$Itemid."&page=inline&catid=".$catid."&id=".$_GET['id']);?>">
                <?php echo _RSGALLERY_SLIDESHOW_EXIT; ?>
                </a>
            </li>
        <?php endif; ?>
        </ul>
        </div>
		<div style="float:left;">
        <?php if( isset( $catid )): ?>
            <h2 id='rsg2-galleryTitle'><?php htmlspecialchars(stripslashes(galleryUtils::getCatNameFromId($catid)), ENT_QUOTES) ?></h2>
        <?php elseif( $page != "my_galleries" ): ?>
            <h2 id='rsg2-galleryTitle'><?php echo _RSGALLERY_COMPONENT_TITLE ?></h2>
        <?php endif; ?>
        <div id='rsg2-galleryIntroText'>
        	<?php //echo htmlspecialchars(stripslashes($intro_text), ENT_QUOTES); ?>
        	<?php echo stripslashes($intro_text); ?>
        </div>
        <?php
        ?>
        
        </div>
        <?php
    }

    /**
     * show a sub gallery
     * @param string parent cat id
     */
    function subGalleryList($parent){
        global $database, $Itemid, $rsgAccess;
        
        $database->setQuery("SELECT * FROM #__rsgallery2_galleries WHERE published = 1 and parent = '$parent' ORDER BY ordering ASC");
        $rows = $database->loadObjectList();
        if( count( $rows ) == 0 ) return;
        ?>
        <div class='rsg2-subGalleryList-container'>
            <div class='rsg2-subGalleryList-title'><?php //echo _RSGALLERY_SUB_GALLERIES; ?><div>
            <ul class='rsg2-subGalleryList-list'>
        
            <?php
            foreach( $rows as $row ) {
            	//check if viewer has the rights to view subgallery
            	if ($rsgAccess->checkGallery('view',$row->id)) {
	            ?>
	                <li>
	                	<a href="<?php echo sefRelToAbs("index.php?option=com_rsgallery2&amp;Itemid=$Itemid&amp;catid=".$row->id); ?>">
	                		<?php echo htmlspecialchars(stripslashes($row->name), ENT_QUOTES); ?>&nbsp;
	                		[<?php echo galleryUtils::getFileCount($row->id); ?>]
	                	</a>
	                </li>
	                
	            <?php
            	}
            }
            ?>
            </ul>
        </div>
        <?php
        }
	
    function RSGalleryList( $gallery ){
        global $Itemid, $rsgConfig;
        //Get values for page navigation from URL
        $limit = mosGetParam ( $_REQUEST, 'limit', $rsgConfig->galcountNrs);
        $limitstart = mosGetParam ( $_REQUEST, 'limitstart', 0);
		
		//Get number of galleries including main gallery
        $kids = $gallery->kids();
        $kidCountTotal = count( $kids );

        $pageNav = false;
		
		if( $rsgConfig->dispLimitbox == 1) {
			if( $kidCountTotal > $limit ){
				$kids = array_slice( $kids, $limitstart, $limit );
				$pageNav = new mosPageNav( $kidCountTotal, $limitstart, $limit );
			}
		} elseif($rsgConfig->dispLimitbox == 2) {
			$kids = array_slice( $kids, $limitstart, $limit );
			$pageNav = new mosPageNav( $kidCountTotal, $limitstart, $limit );
		}

		//Show page navigation
        if( $pageNav ): ?>
        <div class="rsg2-pagenav-limitbox">
        <?php echo $pageNav->writeLimitBox("index.php?option=com_rsgallery2&amp;Itemid=$Itemid"); ?>
        </div>
        <?php endif; ?>

        <ul id='rsg2-galleryList'>
        <?php foreach( $kids as $kid ): ?>
            <li class='rsg2-galleryList-item' >
            <?php if ( $rsgConfig->get('displayStatus') ) {?>
            	<div class="rsg2-galleryList-status"><?php echo $kid->status; ?></div>
            	<?php }?>
            	<!--<div class="img-shadow">-->
	                <a class='rsg2-galleryList-thumb' href="<?php echo sefRelToAbs($kid->url); ?>">
	                <?php echo $kid->thumbHTML; ?>
	                </a>
                <!--</div>-->
                <div class='rsg2-galleryList-info'>
                    <a class='rsg2-galleryList-title' href="<?php echo sefRelToAbs($kid->url); ?>"><?php echo htmlspecialchars(stripslashes($kid->get('name')), ENT_QUOTES); ?></a>
                    <div class='rsg2-galleryList-totalImages'><?php echo galleryUtils::getFileCount($kid->get('id')). _RSGALLERY_IMAGES;?></div>
                    <div class='rsg2-galleryList-newImages'><?php echo galleryUtils::newImages($kid->get('id')); ?></div>
                    <div class='rsg2-galleryList-description'><?php echo ampReplace($kid->get('description'));?></div>
                    <?php HTML_RSGALLERY::subGalleryList( $kid->get('id') ); ?>
                </div>
                <div class='clr'>&nbsp;</div>
            </li>
        <?php endforeach; ?>
        </ul>

        <?php if( $pageNav ): ?>
        <div class="rsg2-pageNav">
        <?php 
        	echo $pageNav->writePagesLinks("index.php?option=com_rsgallery2&amp;Itemid=$Itemid");echo "<br>".$pageNav->writePagesCounter(); ?></div>
        <?php endif; ?>
        <div class='clr'>&nbsp;</div>

        <?php
    }

    /**
     * Shows gallery list on main gallery page
     * @TODO Depreciated!  Remove after not needed as a coding reference.
     */
    function RSGalleryList_legacy ($rows, $pageNav, $parentCat=0 ){
        global $database,$mosConfig_live_site;
        
        if (isset($pageNav) )
    	{
        ?>
        <div style="text-align:right;"><?php global $Itemid; echo $pageNav->writeLimitBox("index.php?option=com_rsgallery2&amp;Itemid=$Itemid"); ?></div>
        <?php
		}
		?>
		<ul id='rsg2-galleryList'>
		<?php
        foreach ($rows as $row) {
            $c_id = $row->id;
            $database->setQuery("SELECT * FROM #__rsgallery2_galleries WHERE published = 1 and parent = '$c_id' ORDER BY ordering ASC");
            $rows2 = $database->loadObjectList();
            ?>     
            <li class='rsg2-galleryList-item' >
                <a class='rsg2-galleryList-thumb' href="<?php global $Itemid; echo sefRelToAbs("index.php?option=com_rsgallery2&amp;Itemid=$Itemid&amp;catid=".$row->id); ?>"><?php echo galleryUtils::getThumb($row->id,0,0,""); ?></a>
                <div class='rsg2-galleryList-info'>
                    <a class='rsg2-galleryList-title' href="<?php echo sefRelToAbs("index.php?option=com_rsgallery2&amp;Itemid=$Itemid&amp;catid=".$row->id); ?>"><?php echo htmlspecialchars(stripslashes($row->name), ENT_QUOTES); ?></a>
                    <div class='rsg2-galleryList-totalImages'><?php echo galleryUtils::getFileCount($row->id). _RSGALLERY_IMAGES;?></div>
                    <div class='rsg2-galleryList-newImages'><?php echo galleryUtils::newImages($row->id); ?></div>
                    <div class='rsg2-galleryList-description'><?php echo ampReplace($row->description);?></div>
                    <?php HTML_RSGALLERY::subGalleryList( $row->id ); ?>
                </div>
                <div class='clr'>&nbsp;</div>
            </li>
            <?php
            }
            ?>
        </ul>
        <?php
        if (isset($pageNav))
        	{
        	?>
        	<div class="rsg2-pageNav"><?php global $Itemid; echo $pageNav->writePagesLinks("index.php?option=com_rsgallery2&amp;Itemid=$Itemid");echo "<br>".$pageNav->writePagesCounter(); ?></div>
        	<?php
        	}
        ?>
        <div class='clr'>&nbsp;</div>
        <?php
        }
    //End of  funcion RSGalleryList()


    /**
     * Shows thumbnails for gallery and links to subgalleries if they exist.
     * @param integer Category ID
     * @param integer Columns per page
     * @param integer Number of thumbs per page
     * @param integer pagenav stuff
     * @param integer pagenav stuff
     */
    function RSShowPictures ($catid, $limit, $limitstart){
        global $database, $my, $mosConfig_live_site, $rsgConfig;
        $thumb_width                = $rsgConfig->get("thumb_width");
        $columns                    = $rsgConfig->get("display_thumbs_colsPerPage");
        $PageSize                   = $rsgConfig->get("display_thumbs_maxPerPage");
        //$my_id                      = $my->id;
    
        $database->setQuery("SELECT COUNT(*) FROM #__rsgallery2_files WHERE gallery_id='$catid'");
        $numPics = $database->loadResult();
        
        if(!isset($limitstart))
            $limitstart = 0;
        //instantiate page navigation
        $pagenav = new mosPageNav($numPics, $limitstart, $PageSize);
    
        $picsThisPage = min($PageSize, $numPics - $limitstart);
    
        if (!$picsThisPage == 0)
                $columns = min($picsThisPage, $columns);
                
        //Add a hit to the database
        if ($catid && !$limitstart)
            {
            galleryUtils::addCatHit($catid);
            }
		//Old rights management. If user is owner or user is Super Administrator, you can edit this gallery
        if(( $my->id <> 0 ) and (( galleryUtils::getUID( $catid ) == $my->id ) OR ( $my->usertype == 'Super Administrator' )))
            $allowEdit = true;
        else
            $allowEdit = false;

        $thumbNumber = 0;
        ?>
        <div id='rsg2-pageNav'>
                <?php
                /*
                if( $numPics > $PageSize ){
        		global $Itemid;
                    echo $pagenav->writePagesLinks("index.php?option=com_rsgallery2&amp;Itemid=$Itemid&amp;catid=".$catid);
                }
                */
                ?>
        </div>
        <br />
        <?php
        if ($picsThisPage) {
        $database->setQuery("SELECT * FROM #__rsgallery2_files".
                                " WHERE gallery_id='$catid'".
                                " ORDER BY ordering ASC".
                                " LIMIT $limitstart, $PageSize");
        $rows = $database->loadObjectList();
        
        switch( $rsgConfig->get( 'display_thumbs_style' )):
            case 'float':
                $floatDirection = $rsgConfig->get( 'display_thumbs_floatDirection' );
                ?>
                <ul id='rsg2-thumbsList'>
                <?php foreach( $rows as $row ): ?>
                <li <?php echo "style='float: $floatDirection'"; ?> >
                    <a href="<?php global $Itemid; echo sefRelToAbs( "index.php?option=com_rsgallery2&amp;Itemid=$Itemid&amp;page=inline&amp;id=".$row->id."&amp;catid=".$row->gallery_id."&amp;limitstart=".$limitstart++ ); ?>">
                    	<!--<div class="img-shadow">-->
                        <img border="1" alt="<?php echo htmlspecialchars(stripslashes($row->descr), ENT_QUOTES); ?>" width="<?php echo $thumb_width; ?>" src="<?php echo imgUtils::getImgThumb($row->name); ?>" />
                        <!--</div>-->
                        <div class="clr"></div>
                        <?php if($rsgConfig->get("display_thumbs_showImgName")): ?>
                            <br /><span class='rsg2_thumb_name'><?php echo htmlspecialchars(stripslashes($row->title), ENT_QUOTES); ?></span>
                        <?php endif; ?>
                    </a>
                    <?php if( $allowEdit ): ?>
                    <div id='rsg2-adminButtons'>
                        <a href="<?php echo sefRelToAbs("index.php?option=com_rsgallery2&amp;Itemid=$Itemid&amp;page=edit_image&amp;id=".$row->id); ?>"><img src="<?php echo $mosConfig_live_site; ?>/administrator/images/edit_f2.png" alt="" border="0" height="15" /></a>
                        <a href="#" onClick="if(window.confirm('<?php echo _RSGALLERY_DELIMAGE_TEXT;?>')) location='<?php echo sefRelToAbs("index.php?option=com_rsgallery2&amp;Itemid=$Itemid&amp;page=delete_image&amp;id=".$row->id); ?>'"><img src="<?php echo $mosConfig_live_site; ?>/administrator/images/delete_f2.png" alt="" border="0" height="15" /></a>
                    </div>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
                </ul>
                <div class='clr'>&nbsp;</div>
                <?php
                break;
            case 'table':
                $cols = $rsgConfig->get( 'display_thumbs_colsPerPage' );
                $i = 0;
                ?>
                <table id='rsg2-thumbsList'>
                <?php foreach( $rows as $row ): ?>
                    <?php if( $i % $cols== 0) echo "<tr>\n"; ?>
                        <td>
                        	<!--<div class="img-shadow">-->
                            	<a href="<?php global $Itemid; echo sefRelToAbs( "index.php?option=com_rsgallery2&amp;Itemid=$Itemid&amp;page=inline&amp;id=".$row->id."&amp;catid=".$row->gallery_id."&amp;limitstart=".$limitstart++ ); ?>">
								<img border="1" alt="<?php echo htmlspecialchars(stripslashes($row->descr), ENT_QUOTES); ?>" width="<?php echo $thumb_width; ?>" src="<?php echo imgUtils::getImgThumb($row->name); ?>" />
								</a>
							<!--</div>-->
                            <div class="clr"></div>
                            <?php if($rsgConfig->get("display_thumbs_showImgName")): ?>
                            <br />
                            <span class='rsg2_thumb_name'>
                            	<?php echo htmlspecialchars(stripslashes($row->title), ENT_QUOTES); ?>
                            </span>
                            <?php endif; ?>
                            <?php if( $allowEdit ): ?>
                            <div id='rsg2-adminButtons'>
                                <a href="<?php echo sefRelToAbs("index.php?option=com_rsgallery2&amp;Itemid=$Itemid&amp;page=edit_image&amp;id=".$row->id); ?>"><img src="<?php echo $mosConfig_live_site; ?>/administrator/images/edit_f2.png" alt="" border="0" height="15" /></a>
                                <a href="#" onClick="if(window.confirm('<?php echo _RSGALLERY_DELIMAGE_TEXT;?>')) location='<?php echo sefRelToAbs("index.php?option=com_rsgallery2&amp;Itemid=$Itemid&amp;page=delete_image&amp;id=".$row->id); ?>'"><img src="<?php echo $mosConfig_live_site; ?>/administrator/images/delete_f2.png" alt="" border="0" height="15" /></a>
                            </div>
                            <?php endif; ?>
                        </td>
                    <?php if( ++$i % $cols == 0) echo "</tr>\n"; ?>
                <?php endforeach; ?>
                <?php if( $i % $cols != 0) echo "</tr>\n"; ?>
                </table>
                <?php
                break;
            case 'magic':
                echo _RSGALLERY_MAGIC_NOTIMP;
                ?>
                <table id='rsg2-thumbsList'>
                <tr>
                	<td><?php echo _RSGALLERY_MAGIC_NOTIMP?></td>
                </tr>
                </table>
                <?php
                break;
            endswitch;
            ?>
            <div id='rsg2-pageNav'>
                    <?php
                    if( $numPics > $PageSize ){
            		global $Itemid;
                        echo $pagenav->writePagesLinks("index.php?option=com_rsgallery2&amp;Itemid=$Itemid&amp;catid=".$catid);
                        echo "<br /><br />".$pagenav->writePagesCounter();
                    }
                    ?>
            </div>
            <?php
            }
        else {
            if (!$catid == 0)echo _RSGALLERY_NOIMG;
        }
    }
    
    
    function showMyGalleries($rows) {
    global $mosConfig_live_site, $database;
    //Set variables
    $count = count($rows);
    ?>
    <table class="adminform" width="100%" border="1">
            <tr>
                <td colspan="5"><h3><?php echo _RSGALLERY_USER_MY_GAL;?></h3></td>
            </tr>
            <tr>
                <th><div align="center"><?php echo _RSGALLERY_MY_IMAGES_CATEGORY; ?></div></th>
                <th width="75"><div align="center"><?php echo _RSGALLERY_MY_IMAGES_PUBLISHED; ?></div></th>
                <th width="75"><div align="center"><?php echo _RSGALLERY_MY_IMAGES_DELETE; ?></div></th>
                <th width="75"><div align="center"><?php echo _RSGALLERY_MY_IMAGES_EDIT; ?></div></th>
                <th width="75"><div align="center"><?php echo _RSGALLERY_MY_IMAGES_PERMISSIONS; ?></div></th>
            </tr>
            <?php
            if ($count == 0)
                {
                ?>
				<tr><td colspan="5"><?php echo _RSGALLERY_NO_USER_GAL; ?></td></tr>
				<?php
                }
            else
                {
                //echo "This is the overview screen";
                foreach ($rows as $row)
                    {
					global $Itemid;
                    ?>
                    <script type="text/javascript">
                    function deletePres(catid)
                    {
                        var yesno = confirm ("<?php echo _RSGALLERY_DELCAT_TEXT;?>");
                        if (yesno == true)
                        {
                            location = "<?php echo $mosConfig_live_site;?>/index.php?option=com_rsgallery2&page=delusercat&catid="+catid;
                        }
                    }
                    </script>
                    <tr>
                        <td><?php echo $row->name;?></td>
                        <?php
                        if ($row->published == 1)
                            $img = "publish_g.png";
                        else
                            $img = "publish_r.png";?>
                            
                        <td><div align="center"><img src="<?php echo $mosConfig_live_site;?>/administrator/images/<?php echo $img;?>" alt="" width="12" height="12" border="0"></div></td>
                        <td><a href="javascript:deletePres(<?php echo $row->id;?>);"><div align="center"><img src="<?php echo $mosConfig_live_site;?>/administrator/images/publish_x.png" alt="" width="12" height="12" border="0"></a></div></td>
                        <td><a href="<?php echo sefRelToAbs('index.php?option=com_rsgallery2&page=editusercat&catid='.$row->id);?>"><div align="center"><img src="<?php echo $mosConfig_live_site;?>/administrator/images/edit_f2.png" alt="" width="18" height="18" border="0"></a></div></td>
                        <td><a href="#" onclick="alert('Feature not implemented yet')"><div align="center"><img src="<?php echo $mosConfig_live_site;?>/administrator/images/users.png" alt="" width="22" height="22" border="0"></div></td>
                    </tr>
                    <?php
                    $sql2 = "SELECT * FROM #__rsgallery2_galleries WHERE parent = $row->id ORDER BY ordering ASC";
                    $database->setQuery($sql2);
                    $rows2 = $database->loadObjectList();
					global $Itemid;
                    foreach ($rows2 as $row2)
                        {
                        if ($row2->published == 1)
                            $img = "publish_g.png";
                        else
                            $img = "publish_r.png";?>
                        <tr>
                        	<td>
                        		<img src="<?php echo $mosConfig_live_site;?>/administrator/components/com_rsgallery2/images/sub_arrow.png" alt="" width="12" height="12" border="0">
                        		&nbsp;
                        		<?php echo $row2->name;?>
                        	</td>
                        	<td>
                        		<div align="center">
                        			<img src="<?php echo $mosConfig_live_site;?>/administrator/images/<?php echo $img;?>" alt="" width="12" height="12" border="0">
                        		</div>
                        	</td>
                        	<td>
                        		<a href="javascript:deletePres(<?php echo $row2->id;?>);">
                        		<!--<a href="<?php echo sefRelToAbs('index.php?option=com_rsgallery2&Itemid=$Itemid&page=delusercat&catid='.$row2->id);?>">-->
                        			<div align="center">
                        			<img src="<?php echo $mosConfig_live_site;?>/administrator/images/publish_x.png" alt="" width="12" height="12" border="0">
                        			</div>
                        		</a>
                        	</td>
                        	<td>
                        		<a href="<?php echo sefRelToAbs('index.php?option=com_rsgallery2&Itemid=$Itemid&page=editusercat&catid='.$row2->id);?>">
                        		<div align="center">
                        			<img src="<?php echo $mosConfig_live_site;?>/administrator/images/edit_f2.png" alt="" width="18" height="18" border="0">
                        		</div>
                        		</a>
                        	</td>
                        	<td>
                        		<a href="#" onclick="alert('<?php echo _RSGALLERY_FEAT_NOTIMP?>')">
                        		<div align="center">
                        			<img src="<?php echo $mosConfig_live_site;?>/administrator/images/users.png" alt="" width="22" height="22" border="0">
                        		</div>
                        		</a>
                        	</td>
                        </tr>
                        <?php
                        }
                    }
                }
                    ?>
                    <tr>
                        <th colspan="5">&nbsp;</th>
                    </tr>
                </table>
    <?php
    }
    /**
     * This will show the images, available to the logged in users in the My Galleries screen
     * under the tab "My Images".
     * @param array Result array with image details for the logged in users
     * @param array Result array with pagenav details
     */
    function showMyImages($images, $pageNav) {
        global $rsgAccess, $mosConfig_live_site;
        ?>
        <table width="100%" class="adminlist" border="1">
        <tr>
            <td colspan="4"><h3><?php echo _RSGALLERY_MY_IMAGES; ?></h3></td>
        </tr>
        <tr>
            <th colspan="4"><div align="right"><?php echo $pageNav->writeLimitBox("index.php?option=com_rsgallery2&page=my_galleries"); ?></div></th>
        </tr>
        <tr>
            <th><?php echo _RSGALLERY_MY_IMAGES_NAME; ?></th>
            <th><?php echo _RSGALLERY_MY_IMAGES_CATEGORY; ?></th>
            <th width="75"><?php echo _RSGALLERY_MY_IMAGES_DELETE; ?></th>
            <th width="75"><?php echo _RSGALLERY_MY_IMAGES_EDIT; ?></th>
        </tr>
        
        <?php
        if (count($images) > 0)
            {
             ?>
            <script type="text/javascript">
            function deleteImage(id)
            {
                var yesno = confirm ('<?php echo _RSGALLERY_DELIMAGE_TEXT;?>');
                if (yesno == true)
                {
                    location = "<?php echo $mosConfig_live_site;?>/index.php?option=com_rsgallery2&page=delete_image&id="+id;
                }
            }
            </script>
            <?php
            foreach ($images as $image)
                {
				global $Itemid;
               ?>
                <tr>
                    <td>
                    	<?php
                    	if (!$rsgAccess->checkGallery('up_mod_img', $image->gallery_id)) {
                    		echo $image->name;
                    	} else {
	                    	?>
	                    	<a href="index.php?option=com_rsgallery2&Itemid=<?php echo $Itemid;?>&page=edit_image&id=<?php echo $image->id;?>">
	                    	<?php echo $image->name;?>
	                    	</a>
	                    	<?php
                    	}
                    	?>
                    </td>
                    <td><?php echo galleryUtils::getCatnameFromId($image->gallery_id)?></td>
                    <td>
                    	<?php
                    	if (!$rsgAccess->checkGallery('del_img', $image->gallery_id)) {
                    		?>
                    		<div align="center">
                    			<img src="<?php echo $mosConfig_live_site;?>/components/com_rsgallery2/images/no_delete.png" alt="" width="12" height="12" border="0">
                    		</div>
                    		<?php
                    	} else {
                    	?>
                    	<a href="javascript:deleteImage(<?php echo $image->id;?>);">
                    		<div align="center">
                    			<img src="<?php echo $mosConfig_live_site;?>/components/com_rsgallery2/images/delete.png" alt="" width="12" height="12" border="0">
                    		</div>
                    	</a>
                    	<?php
                    	}
                    	?>
                    </td>
                    <td>
                    	<?php
                    	if ( !$rsgAccess->checkGallery('up_mod_img', $image->gallery_id) ) {
                    		?>
                    		<div align="center">
                    			<img src="<?php echo $mosConfig_live_site;?>/components/com_rsgallery2/images/no_edit.png" alt="" width="15" height="15" border="0">
                    		</div>
                    		<?php
                    	} else {
                    	?>
                    	<a href="index.php?option=com_rsgallery2&Itemid=<?php echo $Itemid;?>&page=edit_image&id=<?php echo $image->id;?>">
                    	<div align="center">
                    		<img src="<?php echo $mosConfig_live_site;?>/components/com_rsgallery2/images/edit.png" alt="" width="15" height="15" border="0">
                    	</div>
                    	</a>
                    	<?php
                    	}
                    	?>
                    </td>
                </tr>
                <?php
                }
            }
        else
            {
            ?>
			<tr><td colspan="4"><?php echo _RSGALLERY_NOIMG_USER; ?></td></tr>
			<?php
            }
            ?>
            <tr>
                <th colspan="4"><div align="center"><?php global $Itemid; echo $pageNav->writePagesLinks("index.php?option=com_rsgallery2&amp;Itemid=$Itemid&amp;page=my_galleries");echo "<br>".$pageNav->writePagesCounter(); ?></div></th>
            </tr>
            </table>
            <?php
    }
    /**
     * Displays details about the logged in user and the privileges he/she has
     * $param integer User ID from Joomla user table
     */
     function RSGalleryUserInfo($id) {
     global $my, $rsgConfig;
     if ($my->usertype == "Super Administrator" OR $my->usertype == "Administrator") {
     	$maxcat = "unlimited";
     	$max_images = "unlimited";
     } else {
     	$maxcat = $rsgConfig->get('uu_maxCat');
     	$max_images = $rsgConfig->get('uu_maxImages');
     }
     ?>
     <table class="adminform" border="1">
     <tr>
        <th colspan="2"><?php echo _RSGALLERY_USER_INFO; ?></th>
     </tr>
     <tr>
        <td width="250"><?php echo _RSGALLERY_USER_INFO_NAME; ?></td>
        <td><?php echo $my->username;?></td>
     </tr>
     <tr>
        <td><?php echo _RSGALLERY_USER_INFO_ACL; ?></td>
        <td><?php echo $my->usertype;?></td>
     </tr>
     <tr>
        <td><?php echo _RSGALLERY_USER_INFO_MAX_GAL; ?></td>
        <td><?php echo $maxcat;?>&nbsp;&nbsp;(<font color="#008000"><strong><?php echo galleryUtils::userCategoryTotal($my->id);?></strong></font> <?php echo _RSGALLERY_USER_INFO_CREATED;?></td>
     </tr>
     <tr>
        <td><?php echo _RSGALLERY_USER_INFO_MAX_IMG; ?></td>
        <td><?php echo $max_images;?>&nbsp;&nbsp;(<font color="#008000"><strong><?php echo galleryUtils::userImageTotal($my->id);?></strong></font> <?php echo _RSGALLERY_USER_INFO_UPL; ?></td>
     </tr>
     <tr>
        <th colspan="2"></th>
     </tr>
     </table>
     <br><br>
     <?php
     }
     
    /**
     * This presents the main My Galleries page
     * @param array Result array with category details for logged in users
     * @param array Result array with image details for logged in users
     * @param array Result array with pagenav information
     */
    function myGalleries($rows, $images, $pageNav)
        {
        global $rsgConfig, $my, $database, $mosConfig_live_site;
        if (!$rsgConfig->get('show_mygalleries'))
        	mosRedirect( sefRelToAbs("index.php?option=com_rsgallery2&amp;Itemid=$Itemid"),_RSGALLERY_USERGAL_DISABLED);
        ?>
        <h2><?php echo _RSGALLERY_USER_MY_GAL;?></h2>
        
        <?php
        //Show User information
        HTML_RSGALLERY::RSGalleryUSerInfo($my->id);
        
        //Start tabs
        $tabs = new mosTabs(0);
        $tabs->startPane( 'tabs' );
        $tabs->startTab( _RSGALLERY_MY_IMAGES, 'my_images' );
            HTML_RSGALLERY::showMyImages($images, $pageNav);
            HTML_RSGALLERY::showFrontUpload();
        $tabs->endtab();
        if ($rsgConfig->get('uu_createCat')) {
	        $tabs->startTab( _RSGALLERY_USER_MY_GAL, 'my_galleries' );
	            HTML_RSGALLERY::showMyGalleries($rows);
	            HTML_RSGALLERY::showUserGallery(NULL);
	        $tabs->endtab();
        }
        $tabs->endpane();
        ?>
        <div class='rsg2-clr'>&nbsp;</div>
        <?php
        }
        
    function showRandom($rows) {
    global $mosConfig_live_site;
    ?>
    <table class="table_border" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr>
        <td colspan="3"><?php echo _RSGALLERY_RANDOM_TITLE;?></td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
        <?php
        foreach($rows as $row)
            {
            $l_start = $row->ordering - 1;
			?>
            <td align="center">
            <!--<div class="img-shadow">-->
			<a href="<?php echo sefRelToAbs($mosConfig_live_site."/index.php?option=com_rsgallery2&page=inline&id=".$row->id."&catid=".$row->gallery_id."&limitstart=".$l_start);?>">
            <img src="<?php echo imgUtils::getImgThumb($row->name);?>" alt="<?php echo $row->descr;?>" border="0" />
            </a>
            <!--</div>-->
            </td>
			<?php
            }
        ?>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
    </table>
    <?php
    }
    
    function showLatest($rows) {
    global $mosConfig_live_site;
    ?>
    <table class="table_border" cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td colspan="3"><?php echo _RSGALLERY_LATEST_TITLE;?></td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <?php
            foreach($rows as $row)
                {
                $l_start = $row->ordering - 1;
				?>
				<td align="center">
					<!--<div class="img-shadow">-->
	                <a href="<?php echo sefRelToAbs($mosConfig_live_site."/index.php?option=com_rsgallery2&page=inline&id=".$row->id."&catid=".$row->gallery_id."&limitstart=".$l_start);?>">
					<img src="<?php echo imgUtils::getImgThumb($row->name);?>" alt="<?php $row->descr;?>" border="0" />
					</a>
					<!--</div>-->
				</td>
				<?php
                }
            ?>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
    </table>
    <?php
    }
}//end class
?>