<?php
/**
* @package   oriente Template
* @file      default.php
* @version   1.5.0 May 2010
* @author    Oriente http://www.oriente.com.br
* @copyright 
*/

defined('_JEXEC') or die('Restricted access'); ?>

<div class="module-poll <?php echo $params->get('moduleclass_sfx'); ?>">

<form action="index.php" method="post" name="form2">

	<h4><?php echo $poll->title; ?></h4>
		
	<ul>
	<?php for ($i = 0, $n = count($options); $i < $n; $i ++) : ?>
		<li>
			<input type="radio" name="voteid" id="voteid<?php echo $options[$i]->id;?>" value="<?php echo $options[$i]->id;?>" alt="<?php echo $options[$i]->id;?>" />
			<label for="voteid<?php echo $options[$i]->id;?>"><?php echo $options[$i]->text; ?></label>
		</li>
	<?php endfor; ?>
	</ul>
	
	<p class="buttons">
		<input type="submit" name="task_button" class="button-vote" value="<?php echo JText::_('Vote'); ?>" />
		<input type="button" name="option" class="button-results" value="<?php echo JText::_('Results'); ?>" onclick="document.location.href='<?php echo JRoute::_("index.php?option=com_poll&id=$poll->slug".$itemid); ?>'" />
	</p>

	<input type="hidden" name="option" value="com_poll" />
	<input type="hidden" name="task" value="vote" />
	<input type="hidden" name="id" value="<?php echo $poll->id;?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>

</div>