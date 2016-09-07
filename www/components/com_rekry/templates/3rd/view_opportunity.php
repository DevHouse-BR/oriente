<?php 
if ($this->applink): 
$val = $this->applink;
?>

<a href="<?php echo $this->escape($val['link_url']) ?>"><?php echo $this->escape($val['link_text']) ?></a>

<?php else: ?>

<?php endif; ?>

<?php 
if ($this->msgapplied): 
$val = $this->msgapplied;
?>

<?php echo $this->escape($val['text']) ?>

<?php else: ?>

<?php endif; ?>

<?php 
if ($this->title): 
$val = $this->title;
?>

<h1><?php echo $this->escape($val['title']) ?></h1>

<table width="80%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	
<?php else: ?>

<?php endif; ?>

<?php if ($this->opportunity): ?>

<?php foreach ($this->opportunity as $key => $val): ?>

<b><?php echo $this->escape($val['title']) ?></b>

<br /><br />

<?php echo $val['text'] ?>

<br /><br />

<?php endforeach; ?>

<?php else: ?>

<?php endif; ?>

<?php if ($this->viewdata): ?>

<?php foreach ($this->viewdata as $key => $val): ?>

<b><?php echo $this->escape($val['title']) ?></b>: <?php echo $this->escape($val['text']) ?>

<br />

<?php endforeach; ?>

<?php else: ?>

<?php endif; ?>

<?php 
if ($this->backlink): 
$val = $this->backlink;
?>
<br />
<a href="<?php echo $val['backlink_url'] ?>">[ <?php echo $this->escape($val['backlink_text']) ?> ]</a><br />
<br />
<?php else: ?>

<?php endif; ?>

<?php 
if ($this->errmgs): 
$val = $this->errmgs;
?>

<h3 class="only_op"><?php echo $this->escape($val['errmsg']) ?></h3>

<?php else: ?>

<?php endif; ?>

    </td>
  </tr>
</table>