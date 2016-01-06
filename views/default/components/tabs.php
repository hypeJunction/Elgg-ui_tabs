<?php
/**
 * Tabbs
 *
 * @uses $vars['id'] Unique ID
 * @uses $vars['class'] Additional classes
 * @uses $vars['tabs'] Tabs view
 * @uses $vars['content'] Content
 * @uses $vars['module'] Module name if tabs should wrapped
 */

$id = elgg_extract('id', $vars);
if (!$id) {
	elgg_log("'components/tabs' view requires a unique 'id' to work properly", 'WARNING');
}

$class = (array) elgg_extract('class', $vars, []);
$class[] = 'elgg-tabs-container';
$vars['class'] = $class;

$ajax_tabs = elgg_extract('ajax_tabs', $vars, true);
$tabs = elgg_format_element('div', [
	'class' => $ajax_tabs ? 'elgg-tabs-nav' : false,
		], elgg_extract('tabs', $vars, ''));
unset($vars['tabs']);

$content = elgg_format_element('div', [
	'class' => 'elgg-tabs-content',
		], elgg_extract('content', $vars, ''));
unset($vars['content']);

$module = elgg_extract('module', $vars);
if ($module) {
	$class = (array) elgg_extract('class', $vars, array());
	$class[] = 'elgg-module-tabbed';
	$vars['class'] = $class;
	echo elgg_view_module($module, $tabs, $content, $vars);
} else {
	echo elgg_format_element('div', $vars, $tabs . $content);
}
?>
<script>
	require(['components/tabs']);
</script>

