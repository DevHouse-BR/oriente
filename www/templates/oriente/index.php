<?php
/**
* @package   oriente Template
* @file      index.php
* @version   1.5.0 May 2010
* @author    Oriente http://www.oriente.com.br
* @copyright 
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.mootools');

// include config	
include_once(dirname(__FILE__).'/config.php');
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>
<jdoc:include type="head" />
<link rel="apple-touch-icon" href="<?php echo $template->url ?>/apple_touch_icon.png" />
</head>

<body id="page" class="yoopage <?php echo $this->params->get('columns'); ?> <?php echo $this->params->get('itemcolor'); ?> <?php echo $this->params->get('toolscolor'); ?>">

	<?php if($this->countModules('absolute')) : ?>
	<div id="absolute">
		<jdoc:include type="yoomodules" name="absolute" />
	</div>
	<?php endif; ?>

	<div id="page-body">
		<div class="page-body-img">
			<div class="wrapper">
	
				<div id="header">
	
					<div id="toolbar">
					
						<?php if($this->params->get('date')) : ?>
						<div id="date">
							<div class="module mod-toolbar"><div class="box-1"><div class="box-2"><div class="box-3 deepest">
								<?php echo JHTML::_('date', 'now', JText::_('DATE_FORMAT_LC')) ?>
							</div></div></div></div>
						</div>
						<?php endif; ?>
					
						<?php if($this->countModules('toolbarleft')) : ?>
						<div class="left">
							<jdoc:include type="yoomodules" name="toolbarleft" style="yoo" />
						</div>
						<?php endif; ?>
						
						<?php if($this->countModules('toolbarright')) : ?>
						<div class="right">
							<jdoc:include type="yoomodules" name="toolbarright" style="yoo" />
						</div>
						<?php endif; ?>
						
					</div>
	
								
					<div id="headerbar">
	
						<?php if($this->countModules('headerleft')) : ?>
						<div class="left">
							<jdoc:include type="yoomodules" name="headerleft" style="yoo" />
						</div>
						<?php endif; ?>
						
						<?php if($this->countModules('headerright')) : ?>
						<div class="right">
							<jdoc:include type="yoomodules" name="headerright" style="yoo" />
						</div>
						<?php endif; ?>
						
					</div>
	
					<?php if($this->countModules('logo')) : ?>		
					<div id="logo">
						<jdoc:include type="yoomodules" name="logo" />
					</div>
					<?php endif; ?>
	
					<?php if($this->countModules('menu')) : ?>
					<div id="menu">
						<jdoc:include type="yoomodules" name="menu" style="yoo" />
					</div>
					<?php endif; ?>
	
					<?php if($this->countModules('search')) : ?>
					<div id="search" class="<?php if($this->countModules('left + right')) echo "sidebar-search"; ?>">
						<jdoc:include type="yoomodules" name="search" />
					</div>
					<?php endif; ?>
	
					<?php if ($this->countModules('banner')) : ?>
					<div id="banner">
						<jdoc:include type="yoomodules" name="banner" />
					</div>
					<?php endif; ?>
	
				</div>
				<!-- header end -->
	
				<div class="content-wrapper-t1">
					<div class="content-wrapper-t2">
						<div class="content-wrapper-t3"></div>
					</div>
				</div>
	
				<div class="content-wrapper-1">
					<div class="content-wrapper-2">
						<div class="content-wrapper-3">
							<div class="content-wrapper-4">
					
								<div id="middle">
									<div id="middle-expand">
					
										<div id="main">
											<div id="main-shift">
	
												<?php if ($this->countModules('breadcrumbs')) : ?>
												<div id="breadcrumbs">
													<jdoc:include type="yoomodules" name="breadcrumbs" />
												</div>
												<?php endif; ?>
	
												<?php if ($this->countModules('maintop + maintopblock')) : ?>
												<div id="maintop">
	
													<?php if($this->countModules('maintopblock')) : ?>
													<div class="maintopblock width100 float-left <?php if ($this->countModules('maintop')) echo "not-last"; ?>">
														<jdoc:include type="yoomodules" name="maintopblock" style="yoo" />
													</div>
													<?php endif; ?>
												
													<?php if ($this->countModules('maintop')) : ?>
														<jdoc:include type="yoomodules" name="maintop" wrapper="maintopbox float-left" layout="<?php echo $this->params->get('maintop'); ?>" style="yoo" />
													<?php endif; ?>
	
												</div>
												<!-- maintop end -->
												<?php endif; ?>
	
												<div class="component-bg floatbox <?php if (!$this->countModules('mainbottom + mainbottomblock')) echo "last"; ?>">
													<jdoc:include type="message" />
													<jdoc:include type="component" />
												</div>
	
												<?php if ($this->countModules('mainbottom + mainbottomblock')) : ?>
												<div id="mainbottom">
	
													<?php if ($this->countModules('mainbottom')) : ?>
														<jdoc:include type="yoomodules" name="mainbottom" wrapper="mainbottombox float-left" layout="<?php echo $this->params->get('mainbottom'); ?>" style="yoo" />
													<?php endif; ?>
	
													<?php if($this->countModules('mainbottomblock')) : ?>
													<div class="mainbottomblock width100 float-left">
														<jdoc:include type="yoomodules" name="mainbottomblock" style="yoo" />
													</div>
													<?php endif; ?>
	
												</div>
												<!-- maintop end -->
												<?php endif; ?>
	
											</div>
										</div>
										
										<?php if($this->countModules('left')) : ?>
										<div id="left" class="sidebar">
											<jdoc:include type="yoomodules" name="left" style="yoo" />
										</div>
										<?php endif; ?>
										
										<?php if($this->countModules('right')) : ?>
										<div id="right" class="sidebar">
											<jdoc:include type="yoomodules" name="right" style="yoo" />
										</div>
										<?php endif; ?>
								
									</div>
								</div>
								
							</div>
						</div>
					</div>
				</div>
	
				<div class="content-wrapper-b1">
					<div class="content-wrapper-b2">
						<div class="content-wrapper-b3"></div>
					</div>
				</div>
	
			</div>
		</div>
	</div>

	<div id="page-footer">
		<div class="wrapper">

			<?php if ($this->countModules('bottom + bottomblock')) : ?>
			<div id="bottom">
			
				<?php if ($this->countModules('bottom')) : ?>
					<jdoc:include type="yoomodules" name="bottom" wrapper="bottombox float-left" layout="<?php echo $this->params->get('bottom'); ?>" style="yoo" />
				<?php endif; ?>
				
				<?php if($this->countModules('bottomblock')) : ?>
				<div class="bottomblock width100 float-left">
					<jdoc:include type="yoomodules" name="bottomblock" style="yoo" />
				</div>
				<?php endif; ?>

			</div>
			<!-- bottom end -->
			<?php endif; ?>

			<?php if ($this->countModules('footer + debug')) : ?>
			<div id="footer">

				<a class="anchor" href="#page"></a>
				<jdoc:include type="yoomodules" name="footer" />
				<jdoc:include type="yoomodules" name="debug" />

			</div>
			<!-- footer end -->
			<?php endif; ?>
			
		</div>
	</div>

</body>
</html>