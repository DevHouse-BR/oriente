<?php 
if ($this->title): 
?>

<h1><?php echo $this->escape($this->title) ?></h1>

<?php else: ?>

<?php endif; ?>

<?php 
if ($this->fname): 
?>

<form enctype="multipart/form-data" action="<?php echo $this->escape($this->action) ?>" method="post" name="job">

<table width="100%" border="0" cellspacing="0" cellpadding="5">

  <tr>
    <td valign="top">
<?php echo $this->escape($this->fname) ?>:
<br />
<input name="enimi" type="text" size="30" class="rekry" value="<?php echo $this->escape($this->fnval) ?>" />
<br />
<br />
<?php echo $this->escape($this->lname) ?>:
<br />
<input name="snimi" type="text" size="30" class="rekry" value="<?php echo $this->escape($this->lnval) ?>" />
<br />
<br />
<?php echo $this->escape($this->address) ?>:
<br />
<input name="a" type="text" size="30" class="rekry" value="<?php echo $this->escape($this->aval) ?>" />

<br />
<br />
<?php echo $this->escape($this->zip) ?>:
<br />
<input name="zip" type="text" size="30" class="rekry" value="<?php echo $this->escape($this->zval) ?>" />
<br />
<br />
<?php echo $this->escape($this->city) ?>:
<br />
<input name="city" type="text" size="30" class="rekry" value="<?php echo $this->escape($this->cval) ?>" />
<br />
<br />
<?php echo $this->escape($this->phone) ?>:
<br />
<input name="phone" type="text" size="30" class="rekry" value="<?php echo $this->escape($this->pval) ?>" />
<br />
<br />

<?php echo $this->escape($this->mobile) ?>:
<br />
<input name="gsm" type="text" size="30" class="rekry" value="<?php echo $this->escape($this->mval) ?>" />
<br />
<br />
<?php echo $this->escape($this->email) ?>:
<br />
<input name="mail" type="text" size="30" class="rekry" value="<?php echo $this->escape($this->emval) ?>" />
<br />
<br />
<?php echo $this->escape($this->bdate) ?>:
<br />
<input name="date" value="<?php echo $this->escape($this->bdval) ?>" type="text" size="20" class="date_rekry" id="date" />
<br />
<br />
<?php echo $this->escape($this->gender) ?>:
<br />
<select name="gender" class="rekry">
<option value="M"<?php echo $this->escape($this->selm) ?>><?php echo $this->escape($this->male) ?></option>
<option value="F"<?php echo $this->escape($this->self) ?>><?php echo $this->escape($this->female) ?></option>
</select>
<br />
<br />
<?php echo $this->escape($this->cv) ?>:
<br />
<input name="uploader" type="file" size="30" class="file-rekry" />
<?php if ($this->download_link) { ?>
<br />
<a href="<?php echo $this->download_link ?>">[ <?php echo $this->escape($this->download) ?> ]</a>
<?php } ?>
<br />
<?php echo $this->escape($this->updatecv) ?>
<br />
<br />
<input type="hidden" name="updatemy" value="true" />
<input name="submit" type="submit" value="<?php echo $this->escape($this->submit) ?>" class="button-rekry" /> 
<input name="reset" type="reset" value="<?php echo $this->escape($this->reset) ?>" class="button-rekry" />
</td>
    <td valign="top">
<?php echo $this->escape($this->tell) ?>:
<br />
<textarea name="sinfo" cols="40" rows="4" class="rekry"><?php echo str_replace('\r\n',"\r\n",$this->tellval) ?></textarea>
<br />
<br />
<?php echo $this->escape($this->edu) ?>:
<br />

<textarea name="edu" cols="40" rows="2" class="rekry"><?php echo str_replace('\r\n',"\r\n",$this->eduval) ?></textarea>
<br />
<br />
<?php echo $this->escape($this->eedu) ?>:
<br />
<textarea name="eedu" cols="40" rows="2" class="rekry"><?php echo str_replace('\r\n',"\r\n",$this->eeduval) ?></textarea>
<br />
<br />
<?php echo $this->escape($this->exp) ?>:
<br />
<textarea name="exp" cols="40" rows="4" class="rekry"><?php echo str_replace('\r\n',"\r\n",$this->expval) ?></textarea>
<br />
<br />
<?php echo $this->escape($this->ref) ?>:
<br />
<textarea name="ref" cols="40" rows="4" class="rekry"><?php echo str_replace('\r\n',"\r\n",$this->refval) ?></textarea>
<br />
<br />
<?php echo $this->escape($this->keys) ?>:
<br />
<textarea name="keys" cols="40" rows="2" class="rekry"><?php echo str_replace('\r\n',"\r\n",$this->keysval) ?></textarea>
<br />
<br />


   </td>
  </tr>
</table>

</form>
<script type="text/javascript">
$(document).ready(function(){
$("#date").datepicker({
    dateFormat: "yy-mm-dd",
    showOn: "both", 
    buttonImage: "components/com_rekry/images/calendar.gif", 
    buttonImageOnly: true 
});
}); 
</script>
<?php 
if ($this->backlink): 
$val = $this->backlink;
?>
<br />
<a href="<?php echo $val['backlink_url'] ?>">[ <?php echo $this->escape($val['backlink_text']) ?> ]</a><br />
<br />
<?php
endif;
?>
<?php else: ?>

<?php endif; ?>