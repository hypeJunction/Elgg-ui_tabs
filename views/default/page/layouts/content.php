<?php

/**
 * Main content area layout
 *
 * @uses $vars['content']        HTML of main content area
 * @uses $vars['sidebar']        HTML of the sidebar
 * @uses $vars['header']         HTML of the content area header (override)
 * @uses $vars['nav']            HTML of the content area nav (override)
 * @uses $vars['footer']         HTML of the content area footer
 * @uses $vars['filter']         HTML of the content area filter (override)
 * @uses $vars['title']          Title text (override)
 * @uses $vars['context']        Page context (override)
 * @uses $vars['filter_context'] Filter context: everyone, friends, mine
 * @uses $vars['class']          Additional class to apply to layout
 */

$context = elgg_extract('context', $vars, elgg_get_context());

$vars['title'] = elgg_extract('title', $vars, '');
if (!$vars['title'] && $vars['title'] !== false) {
	$vars['title'] = elgg_echo($context);
}

$filter = elgg_view('page/layouts/content/filter', $vars);
if ($filter) {
	$content = elgg_extract('content', $vars);
	$vars['content'] = elgg_view_layout('tabs', [
		'id' => $context ? "elgg-page-$context-nav" : "elgg-page-layout-nav",
		'tabs' => $filter,
		'content' => elgg_format_element('div', [
			'class' => 'elgg-content',
			'data-title' => $vars['title'],
			'data-title-selector' => '.elgg-heading-main',
			'data-url' => current_page_url(),
				], $content),
	]);
}

echo elgg_view_layout('one_sidebar', $vars);
