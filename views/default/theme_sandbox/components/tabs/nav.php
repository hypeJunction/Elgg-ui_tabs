<?php

echo elgg_view('navigation/tabs', array(
	'tabs' => array(
		'inline' => array(
			'text' => 'Inline Content',
			'href' => '#inline-tab1',
			'selected' => true,
		),
		'page' => array(
			'text' => 'Activity Page',
			'href' => '/activity',
		),
		'view' => array(
			'text' => 'Ajax View',
			'href' => '/ajax/view/theme_sandbox/components/tabs/ajax',
		),
		'inline2' => array(
			'text' => 'Inline Content 2',
			'href' => '#inline-tab2',
		)
	),
));
