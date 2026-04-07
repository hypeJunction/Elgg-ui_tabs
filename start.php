<?php

/**
 * AJAX tabs
 *
 * @author Ismayil Khayredinov <info@hypejunction.com>
 * @copyright Copyright (c) 2015, Ismayil Khayredinov
 */
require_once __DIR__ . '/autoloader.php';
elgg_register_event_handler('init', 'system', function () {
    elgg_extend_view('theme_sandbox/components', 'theme_sandbox/components/tabs');
});