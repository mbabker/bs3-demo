<?php
/**
 * Bootstrap 3 Demo Template Package
 *
 * @copyright   Copyright (C) 2015 Michael Babker. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/** @var JDocumentHtml $this */

$app  = JFactory::getApplication();
$user = JFactory::getUser();

// Getting params from template
$params = $app->getTemplate(true)->params;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = $app->get('sitename');

// Add JavaScript Frameworks
JHtml::_('bootstrap.framework');

// Add Stylesheets
JHtml::_('bootstrap.loadCss', true);
$this->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/template.css');

// Adjusting content width
if ($this->countModules('left-sidebar') && $this->countModules('right-sidebar'))
{
	$span = 'col-md-6';
}
elseif ($this->countModules('left-sidebar') && !$this->countModules('right-sidebar'))
{
	$span = 'col-md-9';
}
elseif (!$this->countModules('left-sidebar') && $this->countModules('right-sidebar'))
{
	$span = 'col-md-9';
}
else
{
	$span = 'col-md-12';
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<jdoc:include type="head"/>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	<body class="site <?php echo $option . ' view-' . $view . ($layout ? ' layout-' . $layout : ' no-layout') . ($task ? ' task-' . $task : ' no-task')	. ($itemid ? ' itemid-' . $itemid : ''); ?>">

		<?php if ($this->countModules('top-nav')) : ?>
			<nav class="navbar navbar-inverse navbar-fixed-top">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#"><?php echo $sitename; ?></a>
					</div>
					<div id="navbar" class="collapse navbar-collapse">
						<jdoc:include type="modules" name="top-nav" style="none"/>
					</div>
					<!--/.nav-collapse -->
				</div>
			</nav>
		<?php endif; ?>

		<div class="container">
			<div class="row">
				<?php if ($this->countModules('left-sidebar')) : ?>
					<div id="left-sidebar" class="col-md-3">
						<jdoc:include type="modules" name="left-sidebar" style="xhtml" />
					</div>
				<?php endif; ?>
				<main id="main-body" class="<?php echo $span; ?>">
					<!-- Begin Content -->
					<jdoc:include type="modules" name="before-component" style="xhtml" />
					<jdoc:include type="message" />
					<jdoc:include type="component" />
					<jdoc:include type="modules" name="after-component" style="xhtml" />
					<!-- End Content -->
				</main>
				<?php if ($this->countModules('right-sidebar')) : ?>
					<div id="right-sidebar" class="col-md-3">
						<jdoc:include type="modules" name="right-sidebar" style="xhtml" />
					</div>
				<?php endif; ?>
			</div>
		</div>
		<!-- /.container -->

		<?php if ($this->countModules('footer')) : ?>
			<footer class="footer" role="contentinfo">
				<div class="container">
					<hr />
					<jdoc:include type="modules" name="footer" style="none" />
				</div>
			</footer>
		<?php endif; ?>
		<jdoc:include type="modules" name="debug" style="none" />
	</body>
</html>
