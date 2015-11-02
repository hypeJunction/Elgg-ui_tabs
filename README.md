AJAX Tabs component for Elgg
============================
![Elgg 2.0](https://img.shields.io/badge/Elgg-2.0.x-orange.svg?style=flat-square)

## Features

* Standardized UI/UX for displaying and updating tabbed modules
* Support for browser history states

## Usage

* The plugin will automatically AJAXify all pages built using `content` layout and
have a `filter`

* An example of custom usage can be found in `theme_sandbox/components`:

![Tabs](https://raw.github.com/hypeJunction/Elgg-ui_tabs/master/screenshots/tabs.png "Tabs")

```php

// in my/module/content.php
<div id="inline-tab1" class="elgg-content">
	<h3>Inline content</h3>
	<p><?= elgg_view('developers/ipsum') ?></p>
</div>

<div id="inline-tab2" class="elgg-content hidden">
	<h3>Inline content 2</h3>
	<p><?= elgg_view('developers/ipsum') ?></p>
</div>
```

```php

// in my/module/tabs.php
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
			'href' => '/ajax/view/my/module/ajax_context',
		),
		'inline2' => array(
			'text' => 'Inline Content 2',
			'href' => '#inline-tab2',
		)
	),
));
```

```php

// in my/module.php

echo elgg_view('components/tabs', array(
	'id' => 'my-module-tabs',
	'tabs' => elgg_view('my/module/tabs'),
	'content' => elgg_view('my/module/content'),
));
```

* In order to update the browser state on AJAX requests, wrap your content with
`data-title` and `data-url` attributes.

```php

// my/module/ajax_content.php

echo elgg_format_element('div', array(
    'class' => > 'elgg-content',
	'data-title' => 'New page title',
    'data-url' => 'http://example.com/new-page-url',
    'data-title-selector' => '.elgg-heading-main,.my-module-title', // update text of these selectors
));
```