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
		
		if (!JHtml::isRegistered('calendar'))
		{
			JHtml::register('calendar', 'PlgSystemBootstrap3::calendar');
		}
		
		if (!JHtml::isRegistered('bootstrap.modal'))
		{		
			JHtml::register('bootstrap.modal', 'PlgSystemBootstrap3::modal');
		}
	}
	
	/**
	 * Displays a calendar control field
	 *
	 * @param   string  $value    The date value
	 * @param   string  $name     The name of the text field
	 * @param   string  $id       The id of the text field
	 * @param   string  $format   The date format
	 * @param   mixed   $attribs  Additional HTML attributes
	 *
	 * @return  string  HTML markup for a calendar field
	 *
	 * @since   1.5
	 */
	public static function calendar($value, $name, $id, $format = '%Y-%m-%d', $attribs = null)
	{		
		static $done;

		if ($done === null)
		{
			$done = array();
		}

		$readonly = isset($attribs['readonly']) && $attribs['readonly'] == 'readonly';
		$disabled = isset($attribs['disabled']) && $attribs['disabled'] == 'disabled';

		if (is_array($attribs))
		{
			$attribs['class'] = isset($attribs['class']) ? $attribs['class'] : 'input-medium';
			$attribs['class'] = trim($attribs['class'] . ' hasTooltip');

			$attribs = JArrayHelper::toString($attribs);
		}

		JHtml::_('bootstrap.tooltip');

		// Format value when not nulldate ('0000-00-00 00:00:00'), otherwise blank it as it would result in 1970-01-01.
		if ($value && $value != JFactory::getDbo()->getNullDate())
		{
			$tz = date_default_timezone_get();
			date_default_timezone_set('UTC');
			$inputvalue = strftime($format, strtotime($value));
			date_default_timezone_set($tz);
		}
		else
		{
			$inputvalue = '';
		}

		// Load the calendar behavior
		JHtml::_('behavior.calendar');

		// Only display the triggers once for each control.
		if (!in_array($id, $done))
		{
			$document = JFactory::getDocument();
			$document
				->addScriptDeclaration(
				'jQuery(document).ready(function($) {Calendar.setup({
			// Id of the input field
			inputField: "' . $id . '",
			// Format of the input field
			ifFormat: "' . $format . '",
			// Trigger for the calendar (button ID)
			button: "' . $id . '_img",
			// Alignment (defaults to "Bl")
			align: "Tl",
			singleClick: true,
			firstDay: ' . JFactory::getLanguage()->getFirstDay() . '
			});});'
			);
			$done[] = $id;
		}

		// Hide button using inline styles for readonly/disabled fields
		$btn_style = ($readonly || $disabled) ? ' style="display:none;"' : '';
		$div_class = (!$readonly && !$disabled) ? ' class="input-group"' : '';

		return '<div' . $div_class . '>'
				. '<input type="text" title="' . ($inputvalue ? JHtml::_('date', $value, null, null) : '')
				. '" name="' . $name . '" id="' . $id . '" value="' . htmlspecialchars($inputvalue, ENT_COMPAT, 'UTF-8') . '" ' . $attribs . ' />'
				. '<span class="input-group-btn">'
				. '<button type="button" class="btn btn-default" id="' . $id . '_img"' . $btn_style . '><span class="icon-calendar"></span></button>'
				. '</span>'
			. '</div>';
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
	
	public static function modal($params)
	{	
		$name = isset($params['name']) ? $params['name'] : 'frmModal';
		$content = isset($params['content']) ? $params['content'] : 'Modal content';
		$titletag = isset($params['titletag']) ? $params['titletag'] : 'h3';
		$title = isset($params['title']) ? $params['title'] : 'Title';
		
		// Include jQuery
		JHtml::_('jquery.framework');
		JFactory::getDocument()->addScriptDeclaration("
	jQuery(document).ready(function (){
		//Main content element
            var content = 
                jQuery('<div/>',{
                        class:  'modal-content'
                    }).append(
                        jQuery('<div/>',{
                            class:  'modal-header'
                        }).append(
                            jQuery('<button/>',{
                                type:           'button',
                                class:          'close',
                                'data-dismiss': 'modal',
                                'aria-label':   'Close'
                            }).append(
                                jQuery('<span/>',{
                                    'aria-hidden': 'true'
                                })
                            ).html('&times;')
                        ).append(
                            jQuery('<$titletag/>',{
                                class:  'modal-title',
                                id:     '{$name}Label'
                            }).html('$title')
                        )
                    ).append(
                        jQuery('<div/>',{
                            class: 'modal-body'                            
                        }).html('$content')
                    );
		var modalDiv = jQuery('<div/>',{
			class:              'modal fade',
			id:                 '$name',
			tabindex:           '-1',
			role:               'dialog',
			'aria-labelledby':  '{$name}Label'
		}).css({
                        'text-align': 'center'
                    }).append(
		jQuery('<div/>',{
			class:  'modal-dialog',
			role:   'document'
		}).append(
			content
			).css({
                'max-width': '100%',
                width: 'auto',
                display: 'inline-block'
            })
		);

		//Insert modal to DOM
		jQuery('body').append(modalDiv);
	});
		");				
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
