<?php

/**
 * Layout body with ui_tabs wrapping.
 *
 * In Elgg 5.x the default layout uses page/layouts/elements/body instead of
 * page/layouts/content. This override intercepts pages that have a filter and
 * wraps the filter + content in the tabs layout (same as page/layouts/content
 * did in Elgg 4.x).
 *
 * @uses $vars['title']        Optional title for main content area
 * @uses $vars['header']       Optional override for the header
 * @uses $vars['content']      Content
 * @uses $vars['footer']       Optional footer
 * @uses $vars['filter']       Filter tabs — false/'' disables tabs, null auto-builds
 * @uses $vars['filter_value'] Selected filter tab name
 * @uses $vars['context']      Page context
 * @uses $vars['ajax_tabs']    Whether to use AJAX to load tab content
 */

$context = elgg_extract('context', $vars, elgg_get_context());

// register the default content filters (all / mine / friends) when logged in
// — mirrors page/layouts/content/filter.php for the 5.x default layout path
if (!isset($vars['filter']) && elgg_is_logged_in() && $context) {
	$username = elgg_get_logged_in_user_entity()->username;
	$filter_context = elgg_extract('filter_value', $vars, 'all');

	$tabs = [
		'all' => [
			'text' => elgg_echo('all'),
			'href' => isset($vars['all_link']) ? $vars['all_link'] : "{$context}/all",
			'selected' => ($filter_context == 'all'),
			'priority' => 200,
		],
		'mine' => [
			'text' => elgg_echo('mine'),
			'href' => isset($vars['mine_link']) ? $vars['mine_link'] : "{$context}/owner/{$username}",
			'selected' => ($filter_context == 'mine'),
			'priority' => 300,
		],
		'friend' => [
			'text' => elgg_echo('friends'),
			'href' => isset($vars['friend_link']) ? $vars['friend_link'] : "{$context}/friends/{$username}",
			'selected' => ($filter_context == 'friends'),
			'priority' => 400,
		],
	];

	foreach ($tabs as $name => $tab) {
		$tab['name'] = $name;
		elgg_register_menu_item('filter', $tab);
	}
}

$filter  = elgg_view('page/layouts/elements/filter', $vars);
$content = elgg_view('page/layouts/elements/content', $vars);
$footer  = elgg_view('page/layouts/elements/footer', $vars);

if ($filter) {
	// wrap filter + content in the tabs layout so .elgg-layout-tabs is present
	$body = elgg_view_layout('tabs', [
		'id' => $context ? "elgg-page-{$context}-nav" : 'elgg-page-layout-nav',
		'tabs' => $filter,
		'ajax_tabs' => elgg_extract('ajax_tabs', $vars, elgg_get_plugin_setting('ajax_page_tabs', 'ui_tabs', true)),
		'content' => $content . $footer,
	]);
} else {
	$body = $filter . $content . $footer;
}

echo elgg_format_element('div', ['class' => ['elgg-main', 'elgg-body', 'elgg-layout-body']], $body);
