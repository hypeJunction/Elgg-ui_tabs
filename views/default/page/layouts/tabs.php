<?php

/**
 * Tabbed layout view
 *
 * @uses $vars['id'] Unique ID
 * @uses $vars['class'] Layout class
 * @uses $vars['tabs'] Tabs view
 * @uses $vars['content'] Content
 */

if (empty($vars['tabs'])) {
	echo $vars['content'];
	return;
}

$class = (array) elgg_extract('class', $vars, []);
$class[] = 'elgg-layout elgg-layout-tabs';
$vars['class'] = $class;

echo elgg_view('components/tabs', $vars);


