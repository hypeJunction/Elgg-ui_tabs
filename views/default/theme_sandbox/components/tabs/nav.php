<?php

echo elgg_view('navigation/tabs', [
	'tabs' => [
		'inline' => [
			'text' => 'Inline Content',
			'href' => '#inline-tab1',
			'selected' => true,
		],
		'page' => [
			'text' => 'Activity Page',
			'href' => '/activity',
		],
		'view' => [
			'text' => 'Ajax View',
			'href' => '/ajax/view/theme_sandbox/components/tabs/ajax',
		],
		'inline2' => [
			'text' => 'Inline Content 2',
			'href' => '#inline-tab2',
		]
	],
]);
