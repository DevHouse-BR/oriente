<table width="60%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>

<?php 
if ($this->pagestart): 
$val = $this->pagestart;
?>
	
<h1><?php echo $this->escape($val['start']) ?></h1>

<?php else: ?>

<?php endif; ?>

<?php 
if ($this->viewhtml): 
?>
<ul id="op">
<?php foreach ($this->viewhtml as $key => $val): ?>

<li><b><?php echo $this->escape($val['title']) ?></b>
<br />
<?php echo $val['text'] ?>
<br /><b><?php echo $this->escape($val['sttext']) ?>:</b> <?php echo $this->escape($val['stdate']) ?>
<br /><b><?php echo $this->escape($val['retext']) ?>:</b> <?php echo $this->escape($val['redate']) ?>
<br /><a href="<?php echo $val['link'] ?>" class="op_link"><?php echo $this->escape($val['link_text']) ?></a>
</li>

<?php endforeach; ?>
</ul>
<?php else: ?>

<?php endif; ?>
<div style="clear:both;"></div>
<?php 
if ($this->pages): 
?>

<?php foreach ($this->pages as $key => $val): ?>

<a href="<?php echo $val['link'] ?>" class="op_pages">[ <?php echo $this->escape($val['text']) ?> ]</a>

<?php endforeach; ?>

<?php else: ?>

<?php endif; ?>

<?php 
if ($this->mylink): 
$val = $this->mylink;
?>
<br /><br />
<a href="<?php echo $val['link'] ?>" class="op_mylink">[ <?php echo $this->escape($val['text']) ?> ]</a>

<?php else: ?>

<?php endif; ?>

    </td>
  </tr>
</table>