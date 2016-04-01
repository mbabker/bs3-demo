<?php
/**
 * Bootstrap 3 Demo Template Package
 *
 * @copyright   Copyright (C) 2015 Michael Babker. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/** @var JDocumentHtml $this */

$app             = JFactory::getApplication();
$doc             = JFactory::getDocument();
$user            = JFactory::getUser();
$this->language  = $doc->language;
$this->direction = $doc->direction;

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
if ($this->countModules('position-8') && $this->countModules('position-7'))
{
	$span = 'col-sm-6';
}
elseif ($this->countModules('position-8') && !$this->countModules('position-7'))
{
	$span = 'col-sm-9';
}
elseif (!$this->countModules('position-8') && $this->countModules('position-7'))
{
	$span = 'col-sm-9';
}
else
{
	$span = 'col-sm-12';
}

// Logo file or site title param
if ($this->params->get('logoFile'))
{
	$logo = '<img src="' . JUri::root() . $this->params->get('logoFile') . '" alt="' . $sitename . '" class="img-responsive" />';
}
elseif ($this->params->get('sitetitle'))
{
	$logo = '<span class="site-title" title="' . $sitename . '">' . htmlspecialchars($this->params->get('sitetitle')) . '</span>';
}
else
{
	$logo = '<span class="site-title" title="' . $sitename . '">' . $sitename . '</span>';
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
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
    <body class="site <?php echo $option . ' view-' . $view . ($layout ? ' layout-' . $layout : ' no-layout') . ($task ? ' task-' . $task : ' no-task')	. ($itemid ? ' itemid-' . $itemid : ''); ?>">
        <div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
            <header class="row" id="header">
                <div class="col-sm-9"><a href="<?php echo $this->baseurl; ?>" ><?php echo $logo; ?></a></div>
                <div class="col-sm-3">
                    <jdoc:include type="modules" name="search" style="none" />
                </div>
            </header>
            <?php if ($this->countModules('position-1')) : ?>
            <?php
                switch($params->get('navbarFixedType')) {
                    case '1':
                        $navbarFixedType=' navbar-fixed-top';
                        break;
                    case '2':
                        $navbarFixedType=' navbar-fixed-bottom';
                        break;
                    case '3':
                        $navbarFixedType=' navbar-static-top';
                        break;
                    case '0':
                    default:
                        $navbarFixedType='';
                }
            ?>
            <nav class="navbar navbar-<?php echo ($params->get('navbarType') ? 'default' : 'inverse').$navbarFixedType; ?>">
			<!-- Brand and toggle get grouped for better mobile display -->
                <div class="container-fluid">
                    <div class="navbar-header">
                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>
                      <a class="navbar-brand" href="<?php echo $this->baseurl; ?>">Brand</a>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <jdoc:include type="modules" name="position-1" style="none" />
                    </div>
                </div>
            </nav>
			<?php endif; ?>
            <div class="row">
                <jdoc:include type="modules" name="banner" style="bsrow" />
            </div>
            <main class="row" id="content_area">
                <?php if ($this->countModules('position-8')) : ?>
                <aside id="left-sidebar" class="col-sm-3">
                    <div class="row">
                        <jdoc:include type="modules" name="position-8" style="bsrow" />
                    </div>
                </aside>
				<?php endif; ?>
                <div id="main-body" class="<?php echo $span; ?>">
					<!-- Begin Content -->
					<div class="row">
					    <jdoc:include type="modules" name="position-4" style="bsrow" />    
					</div>
					<div class="row">
                        <div class="col-xs-12">
                            <jdoc:include type="module" name="breadcrumbs" style="none" />
                        </div>
                    </div>
					<div class="row">
                        <div class="col-xs-12">
					        
                            <jdoc:include type="message" />
                            <jdoc:include type="component" />
                        </div>
                    </div>
                    <div class="row">
					    <jdoc:include type="modules" name="position-5" style="bsrow" />    
					</div>
					<!-- End Content -->
				</div>
                <?php if ($this->countModules('position-7')) : ?>
                <aside id="right-sidebar" class="col-sm-3">
                    <div class="row">
                        <jdoc:include type="modules" name="position-7" style="bsrow" />
                    </div>
                </aside>
				<?php endif; ?>
            </main>
          <?php if ($this->countModules('footer')) : ?>
			<footer class="footer">
				<div class="container">
					<hr />
					<jdoc:include type="modules" name="footer" style="none" />
				</div>
			</footer>
		<?php endif; ?>
      </div>
      <jdoc:include type="modules" name="debug" style="none" />
    </body>
    <?php /* Check if Navbar needs jQuery for include CSS-style for <body> */
        switch($params->get('navbarFixedType')) {
            case '1': /*fixed-top*/ ?>
    <script type="text/javascript">
        jQuery('body').css('padding-top','70px');
    </script>
    <?php   break;
            case '2': /*fixed-bottom*/ ?>
    <script type="text/javascript">
        jQuery('body').css('padding-bottom','70px');
    </script>
    <?php   break;
        }
    ?>
</html>