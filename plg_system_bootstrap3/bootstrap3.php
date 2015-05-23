<?php
/**
 * Bootstrap 3 Demo Template Package
 *
 * @copyright   Copyright (C) 2015 Michael Babker. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Bootstrap 3 Template System Plugin
 */
class PlgSystemBootstrap3 extends JPlugin
{
	/**
	 * Application object
	 *
	 * @var  JApplicationCms
	 */
	protected $app;

	/**
	 * Array containing information for loaded files
	 *
	 * @var  array
	 */
	protected static $loaded = array();

	/**
	 * Listener for onAfterInitialise event
	 *
	 * @return  void
	 */
	public function onAfterInitialise()
	{
		// Only for site
		if (!$this->app->isSite())
		{
			return;
		}

		// Register listeners for JHtml helpers
		if (!JHtml::isRegistered('bootstrap.loadCss'))
		{
			JHtml::register('bootstrap.loadCss', 'PlgSystemBootstrap3::loadCss');
		}

		if (!JHtml::isRegistered('bootstrap.carousel'))
		{
			JHtml::register('bootstrap.carousel', 'PlgSystemBootstrap3::carousel');
		}
	}

	/**
	 * Overrides JHtmlBootstrap::carousel() to add JavaScript support for Bootstrap's carousel plugin
	 *
	 * This method adds support for the wrap and keyboard options
	 *
	 * @param   string  $selector  Common class for the carousels.
	 * @param   array   $params    An array of options for the carousel.
	 *                             Options for the carousel can be:
	 *                             - interval  number   The amount of time to delay between automatically cycling an item.
	 *                                                  If false, carousel will not automatically cycle.
	 *                             - pause     string   Pauses the cycling of the carousel on mouseenter and resumes the cycling
	 *                                                  of the carousel on mouseleave.
	 *                             - wrap      boolean  Whether the carousel should cycle continuously or have hard stops.
	 *                             - keyboard  boolean  Whether the carousel should react to keyboard events.
	 *
	 * @return  void
	 */
	public static function carousel($selector = 'carousel', $params = array())
	{
		$sig = md5(serialize(array($selector, $params)));

		if (!isset(static::$loaded[__METHOD__][$sig]))
		{
			// Include Bootstrap framework
			JHtml::_('bootstrap.framework');

			// Setup options object
			$opt['interval'] = isset($params['interval']) ? (int) $params['interval'] : 5000;
			$opt['pause']    = isset($params['pause']) ? $params['pause'] : 'hover';
			$opt['wrap']     = isset($params['wrap']) ? (bool) $params['wrap'] : true;
			$opt['keyboard']     = isset($params['keyboard']) ? (bool) $params['keyboard'] : true;

			$options = json_encode($opt);

			// Attach the carousel to document
			JFactory::getDocument()->addScriptDeclaration(
				"(function($){
					$('.$selector').carousel($options);
					})(jQuery);"
			);

			// Set static array
			static::$loaded[__METHOD__][$sig] = true;
		}

		return;
	}

	/**
	 * Overrides JHtmlBootstrap::loadCss() to loads CSS files needed by Bootstrap
	 *
	 * This method removes support for the bootstrap-responsive and bootstrap-extended CSS files
	 *
	 * @param   boolean  $includeMainCss  If true, main bootstrap.css files are loaded
	 * @param   string   $direction       rtl or ltr direction. If empty, ltr is assumed
	 * @param   array    $attribs         Optional array of attributes to be passed to JHtml::_('stylesheet')
	 *
	 * @return  void
	 */
	public static function loadCss($includeMainCss = true, $direction = 'ltr', $attribs = array())
	{
		// Load Bootstrap main CSS
		if ($includeMainCss)
		{
			JHtml::_('stylesheet', 'jui/bootstrap.min.css', $attribs, true);
		}

		// Load Bootstrap RTL CSS
		if ($direction === 'rtl')
		{
			JHtml::_('stylesheet', 'jui/bootstrap-rtl.css', $attribs, true);
		}
	}
}
