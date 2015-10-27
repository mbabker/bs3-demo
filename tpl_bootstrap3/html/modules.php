<?php
/**
 * Bootstrap 3 Demo Template Package
 *
 * @site        http://mokh.in
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
 * <jdoc:include type="module" name="test" style="bstrap" />
 *
 * This gives template designers ultimate control over how modules are rendered.
 *
 * NOTICE: All chrome wrapping methods should be named: modChrome_{STYLE} and take the same
 * two arguments.
 */

/*
 * Module chrome for rendering the module in a bstrap
 */
function modChrome_bstrap($module, &$params, &$attribs)
{
    if ($module->content) : ?>
        <div class="row module<?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
            <?php if ($module->showtitle != 0) : ?>
            <div class="col-xs-12 moduleheader"><h3><?php echo $module->title; ?></h3></div>
            <?php endif; ?>
            <div class="col-xs-12 modulecontent">
                <?php echo $module->content; ?>
            </div>
        </div>
    <?php endif;
}
?>