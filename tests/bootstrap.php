<?php
/**
 * PHPUnit bootstrap for Elgg ui_tabs plugin tests.
 * Plugin must be installed at {elgg_root}/mod/ui_tabs/
 */

// tests/ -> mod/ui_tabs/ -> mod/ -> elgg_root/
$elggRoot = dirname(__DIR__, 3);

require_once $elggRoot . '/vendor/autoload.php';

// Load Elgg test classes (UnitTestCase, IntegrationTestCase, etc.)
$testClassesDir = $elggRoot . '/vendor/elgg/elgg/engine/tests/classes';
spl_autoload_register(function ($class) use ($testClassesDir) {
    $file = $testClassesDir . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

\Elgg\Application::loadCore();
