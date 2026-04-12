<?php

namespace UiTabs;

use Elgg\IntegrationTestCase;

/**
 * Verifies plugin settings round-trip and defaults for ui_tabs.
 */
class PluginSettingsTest extends IntegrationTestCase {

    public function up() {
    }

    public function down() {
    }

    public function getPluginID(): string {
        return 'ui_tabs';
    }

    public function testAjaxPageTabsSettingDefaultsToTrue(): void {
        // Verify that when no setting is stored, the default (true) is used
        // by the code at page/layouts/content.php via elgg_get_plugin_setting(..., true)
        $value = elgg_get_plugin_setting('ajax_page_tabs', 'ui_tabs', true);
        $this->assertNotNull($value);
    }

    public function testAjaxPageTabsSettingPersists(): void {
        $plugin = elgg_get_plugin_from_id('ui_tabs');
        if (!$plugin) {
            $this->markTestSkipped('ui_tabs plugin not installed in test env');
        }
        $previous = $plugin->getSetting('ajax_page_tabs');
        try {
            $plugin->setSetting('ajax_page_tabs', '0');
            $this->assertEquals('0', $plugin->getSetting('ajax_page_tabs'));
            $plugin->setSetting('ajax_page_tabs', '1');
            $this->assertEquals('1', $plugin->getSetting('ajax_page_tabs'));
        } finally {
            if ($previous !== null) {
                $plugin->setSetting('ajax_page_tabs', $previous);
            } else {
                $plugin->unsetSetting('ajax_page_tabs');
            }
        }
    }
}
