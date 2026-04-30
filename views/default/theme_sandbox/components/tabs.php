<?php

$mod = elgg_view('components/tabs', [
	'id' => 'theme-sandbox-tabs',
	'tabs' => elgg_view('theme_sandbox/components/tabs/nav'),
	'content' => elgg_view('theme_sandbox/components/tabs/content'),
]);

echo elgg_view_module('aside', 'AJAX Tabs', $mod);
