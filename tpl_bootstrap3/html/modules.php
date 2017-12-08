<?php
/**
 * Bootstrap 3 Demo Template Package
 *
 * @site        http://mokhin-tech.ru
 * @e-mail      mokhin.denis@yandex.ru
 * @copyright   Copyright (C) 2015 Denis E Mokhin. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * This is a file to add template specific chrome to module rendering.  To use it you would
 * set the style attribute for the given module(s) include in your template to use the style
 * for each given modChrome function.
 *
 * eg.  To render a module mod_test in the bstrap style, you would use the following include:
 * <jdoc:include type="module" name="test" style="bsrow" />
 *
 * This gives template designers ultimate control over how modules are rendered.
 *
 * NOTICE: All chrome wrapping methods should be named: modChrome_{STYLE} and take the same
 * two arguments.
 */

/*
 * Module chrome for rendering the module in a bstrap
 */
function modChrome_bsrow($module, &$params, &$attribs)
{    
    $headerLevel = isset($attribs['headerLevel']) ? (int) $attribs['headerLevel'] : 3;
    if ($module->content) : ?>
        <div class="row module<?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
            <?php if ($module->showtitle != 0) : ?>
            <div class="col-xs-12 moduleheader"><?php echo "<h{$headerLevel}>{$module->title}</h{$headerLevel}>"; ?></div>
            <?php endif; ?>
            <div class="col-xs-12 modulecontent">
                <?php echo $module->content; ?>
            </div>
        </div>
    <?php endif;
}
function modChrome_bscol($module, &$params, &$attribs)
{    
    $headerLevel = isset($attribs['headerLevel']) ? (int) $attribs['headerLevel'] : 3;
    if ($module->content) : ?>
        <<?php echo $params->get('module_tag'); ?> class="col-xs-<?php echo $params->get('bootstrap_size'); ?> module<?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
            <div class="row">
                <?php if ($module->showtitle != 0) : ?>
                <div class="col-xs-12 moduleheader"><?php echo "<h{$headerLevel}>{$module->title}</h{$headerLevel}>"; ?></div>
                <?php endif; ?>
                <div class="col-xs-12 modulecontent">
                    <?php echo $module->content; ?>
                </div>
            </div>
        </<?php echo $params->get('module_tag'); ?>>
    <?php endif;
}
?>