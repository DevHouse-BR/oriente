<?php
/**
* Images option for RSGallery2 - HTML display code
* @version $Id$
* @package RSGallery2
* @copyright (C) 2003 - 2006 RSGallery2
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* RSGallery is Free Software
*/

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );

/**
 * Handles HTML screens for image option 
 * @package RSGallery2
 */
class html_rsg2_images {

	function showImages( $option, &$rows, &$lists, &$search, &$pageNav ) {
		global $my, $rsgOption, $option, $rsgConfig, $mosConfig_live_site;

		mosCommonHTML::loadOverlib();
		
		?>
		<script language="Javascript">
        function showInfo(name, title, description) {
                var src = '<?php echo $mosConfig_live_site.$rsgConfig->get('imgPath_display'); ?>/'+name+'.jpg';
                var html=name;
                html = '<table width="250" border="0"><tr><td colspan="3"><img border="1" src="'+src+'" name="imagelib" alt="No preview available" width="250" /></td></tr><tr><td><strong>Filename:</strong></td><td>'+name+'</td></tr><tr><td valign="top"><strong>Description:</strong></td><td>'+description+'</td></tr></table>';
                return overlib(html, CAPTION, title);
        }
        </script>
        
		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th>Image Manager</th>
			<td>Filter:</td>
			<td>
				<input type="text" name="search" value="<?php echo $search;?>" class="text_area" onChange="document.adminForm.submit();" />
			</td>
			<td width="right"><?php echo $lists['gallery_id'];?></td>
		</tr>
		</table>

		<table class="adminlist">
		<tr>
			<th width="5">#</th>
			<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows ); ?>);" />
			</th>
			<th class="title">Title (filename)</th>
			<th width="5%">Published</th>
			<th colspan="2" width="5%">Reorder</th>
			<th width="2%">Order</th>
			<th width="2%">
			<a href="javascript: saveorder( <?php echo count( $rows )-1; ?> )">
				<img src="images/filesave.png" border="0" width="16" height="16" alt="Save Order" />
			</a>
			</th>
			<th width="15%" align="left">Gallery</th>
			<th width="5%">Hits</th>
			<th width="">Date & time</th>
		</tr>
		<?php
		$k = 0;
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row = &$rows[$i];

			$link 	= 'index2.php?option=com_rsgallery2&rsgOption='.$rsgOption.'&task=editA&hidemainmenu=1&id='. $row->id;

			$task 	= $row->published ? 'unpublish' : 'publish';
			$img 	= $row->published ? 'publish_g.png' : 'publish_x.png';
			$alt 	= $row->published ? 'Published' : 'Unpublished';

			$checked 	= mosCommonHTML::CheckedOutProcessing( $row, $i );

			$row->cat_link 	= 'index2.php?option=com_rsgallery2&rsgOption=galleries&task=editA&hidemainmenu=1&id='. $row->gallery_id;
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
				<?php echo $pageNav->rowNumber( $i ); ?>
				</td>
				<td>
				<?php echo $checked; ?>
				</td>
				<td>
				<?php
				if ( $row->checked_out && ( $row->checked_out != $my->id ) ) {
					echo $row->title;
				} else {
					?>
					<a href="<?php echo $link; ?>" title="Edit Images" onmouseover="showInfo('<?php echo $row->name;?>', '<?php echo $row->title;?>', '<?php echo $row->descr;?>')" onmouseout="return nd();">
					<?php echo $row->title; ?>&nbsp;(<?php echo $row->name;?>)
					</a>
					<?php
				}
				?>
				</td>
				<td align="center">
				<a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
				<img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
				</a>
				</td>
				<td>
				<?php echo $pageNav->orderUpIcon( $i, ($row->gallery_id == @$rows[$i-1]->gallery_id) ); ?>
				</td>
	  			<td>
				<?php echo $pageNav->orderDownIcon( $i, $n, ($row->gallery_id == @$rows[$i+1]->gallery_id) ); ?>
				</td>
				<td colspan="2" align="center">
				<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" class="text_area" style="text-align: center" />
				</td>
				<td>
				<a href="<?php echo $row->cat_link; ?>" title="Edit Category">
				<?php echo $row->category; ?>
				</a>
				</td>
				<td align="left">
				<?php echo $row->hits; ?>
				</td>
				<td align="left">
				<?php echo $row->date;?>
				</td>
			</tr>
			<?php
			$k = 1 - $k;
		}
		?>
		</table>
		<?php echo $pageNav->getListFooter(); ?>
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="rsgOption" value="<?php echo $rsgOption;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0">
		</form>
		<?php
	}

	/**
	* Writes the edit form for new and existing record
	*
	* A new record is defined when <var>$row</var> is passed with the <var>id</var>
	* property set to 0.
	* @param mosWeblink The weblink object
	* @param array An array of select lists
	* @param object Parameters
	* @param string The option
	*/
	function editImage( &$row, &$lists, &$params, $option ) {
		global $rsgOption;
		mosMakeHtmlSafe( $row, ENT_QUOTES, 'descr' );
		
		mosCommonHTML::loadOverlib();
		?>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}

			// do field validation
			if (form.title.value == ""){
				alert( "Image must have a title" );
			} else if (form.gallery_id.value == "0"){
				alert( "You must select a category." );
			} else {
				<?php getEditorContents( 'editor1', 'descr' ) ; ?>
				submitform( pressbutton );
			}
		}
		</script>
		
		<form action="index2.php" method="post" name="adminForm" id="adminForm">
		<table class="adminheading">
		<tr>
			<th>Image:<small><?php echo $row->id ? 'Edit' : 'New';?></small></th>
		</tr>
		</table>

		<table width="100%">
		<tr>
			<td width="60%" valign="top">
				<table class="adminform">
				<tr>
					<th colspan="2">Details</th>
				</tr>
				<tr>
					<td width="20%" align="right">Name:</td>
					<td width="80%">
						<input class="text_area" type="text" name="title" size="50" maxlength="250" value="<?php echo $row->title;?>" />
					</td>
				</tr>
				<tr>
					<td width="20%" align="right">Filename:</td>
					<td width="80%"><?php echo $row->name;?></td>
				</tr>
				<tr>
					<td valign="top" align="right">Gallery:</td>
					<td><?php echo $lists['gallery_id']; ?></td>
				</tr>
				<tr>
					<td valign="top" align="right">Description:</td>
					<td>
						<?php
						// parameters : areaname, content, hidden field, width, height, rows, cols
                    	editorArea( 'editor1',  $row->descr , 'descr', '100%;', '200', '10', '20' ) ; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">Ordering:</td>
					<td><?php echo $lists['ordering']; ?></td>
				</tr>
				<tr>
					<td valign="top" align="right">Published:</td>
					<td><?php echo $lists['published']; ?></td>
				</tr>
				</table>
			</td>
			<td width="40%" valign="top">
				<table class="adminform">
				<tr>
					<th colspan="1">Image preview</th>
				</tr>
				<tr>
					<td>
						<div align="center">
						<img width="300" border="1" src="<?php echo imgUtils::getImgDisplay($row->name);?>" alt="<?php echo htmlspecialchars(stripslashes($row->descr), ENT_QUOTES);?>" />
						</div>
					</td>
				</tr>
				</table>
				<table class="adminform">
				<tr>
					<th colspan="1">Parameters</th>
				</tr>
				<tr>
					<td><?php echo $params->render();?>&nbsp;</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>

		<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="rsgOption" value="<?php echo $rsgOption;?>" />
		<input type="hidden" name="task" value="" />
		</form>
		<?php
	}

	/**
	* Writes the edit form for new and existing record
	*
	* A new record is defined when <var>$row</var> is passed with the <var>id</var>
	* property set to 0.
	* @param mosWeblink The weblink object
	* @param array An array of select lists
	* @param object Parameters
	* @param string The option
	*/
	function uploadImage( $lists, $option ) {
		global $rsgOption, $mosConfig_live_site;
		//mosMakeHtmlSafe( $row, ENT_QUOTES, 'descr' );
		
		mosCommonHTML::loadOverlib();
		?>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}
        
			// do field validation
			if (form.gallery_id.value == "0"){
				alert( "You must select a category." );
			} else if (form.images.value == ''){
				alert( "No file was selected in one or more fields." );
			} else {
				submitform( pressbutton );
			}
		}
		</script>
		<script language="JavaScript" type="text/javascript" src="<?php echo $mosConfig_live_site;?>/administrator/components/com_rsgallery2/includes/script.js"></script>
		<form action="index2.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
		<table class="adminheading">
		<tr>
			<th>
			Image:
			<small>
			Upload
			</small>
			</th>
		</tr>
		</table>

		<table width="100%">
		<tr>
			<td width="60%" valign="top">
				<table class="adminform">
				<tr>
					<th colspan="2">
					*Upload details*
					</th>
				</tr>
				<tr>
					<td width="20%" align="right">*Upload Category*</td>
					<td width="80%"><?php echo $lists['gallery_id']?></td>
				</tr>
				<tr>
					<td valign="top" align="right">
					*Generic Description*:
					</td>
					<td>
					<textarea class="inputbox" cols="50" rows="5" name="descr" style="width:500px" width="500"></textarea>
					</td>
				</tr>
				</table>
				<br />
				<table class="adminform">
				<tr>
					<th colspan="2">
					*Image files*
					</th>
				</tr>
				<tr>
					<td  width="20%" valign="top" align="right">
					*Images*:
					</td>
					<td width="80%">
						Title:&nbsp;<input class="text" type="text" id= "title" name="title[]" value="" size="60" maxlength="250" /><br /><br />
						File:&nbsp;&nbsp;<input type="file" size="48" id="images" name="images[]" /><br /><hr />
    					<span id="moreAttachments"></span>
    					<a href="javascript:addAttachment(); void(0);">(more images)</a><br />
    					<noscript><input type="file" size="48" name="images[]" /><br /></noscript>
					</td>
				</tr>
				</table>
			</td>
			<td width="40%" valign="top">
				<table class="adminform">
				<tr>
					<th colspan="1">
					Parameters
					</th>
				</tr>
				<tr>
					<td>
					<?php /*echo $params->render();*/?>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="rsgOption" value="<?php echo $rsgOption;?>" />
		<input type="hidden" name="task" value="" />
		</form>
		<?php
	}
}
?>