<?php

namespace UiTabs;

use Elgg\IntegrationTestCase;

/**
 * Verifies that ui_tabs plugin views render and produce expected markup.
 */
class ViewsTest extends IntegrationTestCase {

    public function up() {
    }

    public function down() {
    }

    /**
     * @return string
     */
    public function getPluginID(): string {
        return 'ui_tabs';
    }

    /**
     * @return void
     */
    public function testComponentsTabsViewExists(): void {
        $this->assertTrue(\elgg_view_exists('components/tabs'));
    }

    /**
     * @return void
     */
    public function testPageLayoutTabsViewExists(): void {
        $this->assertTrue(\elgg_view_exists('page/layouts/tabs'));
    }

    /**
     * @return void
     */
    public function testPageLayoutContentViewExists(): void {
        $this->assertTrue(\elgg_view_exists('page/layouts/content'));
    }

    /**
     * @return void
     */
    public function testPageLayoutContentFilterViewExists(): void {
        $this->assertTrue(\elgg_view_exists('page/layouts/content/filter'));
    }

    /**
     * @return void
     */
    public function testPluginSettingsViewExists(): void {
        $this->assertTrue(\elgg_view_exists('plugins/ui_tabs/settings'));
    }

    /**
     * @return void
     */
    public function testThemeSandboxViewExists(): void {
        $this->assertTrue(\elgg_view_exists('theme_sandbox/components/tabs'));
        $this->assertTrue(\elgg_view_exists('theme_sandbox/components/tabs/nav'));
        $this->assertTrue(\elgg_view_exists('theme_sandbox/components/tabs/content'));
        $this->assertTrue(\elgg_view_exists('theme_sandbox/components/tabs/ajax'));
    }

    /**
     * @return void
     */
    public function testComponentsTabsJsFileExists(): void {
        $this->assertTrue(\elgg_view_exists('components/tabs.js'));
    }

    /**
     * @return void
     */
    public function testComponentsTabsRendersContainer(): void {
        $output = \elgg_view('components/tabs', [
            'id' => 'test-tabs',
            'tabs' => '<ul><li>A</li></ul>',
            'content' => '<div>Hello</div>',
        ]);
        $this->assertIsString($output);
        $this->assertNotEmpty($output);
        $this->assertStringContainsString('elgg-tabs-container', $output);
        $this->assertStringContainsString('elgg-tabs-nav', $output);
        $this->assertStringContainsString('elgg-tabs-content', $output);
        $this->assertStringContainsString('Hello', $output);
        $this->assertStringContainsString('test-tabs', $output);
    }

    /**
     * @return void
     */
    public function testComponentsTabsNonAjaxOmitsNavClass(): void {
        $output = \elgg_view('components/tabs', [
            'id' => 'static-tabs',
            'tabs' => '<ul><li>X</li></ul>',
            'content' => '<div>Y</div>',
            'ajax_tabs' => false,
        ]);
        $this->assertStringNotContainsString('elgg-tabs-nav', $output);
    }

    /**
     * @return void
     */
    public function testComponentsTabsWithModuleWrapping(): void {
        $output = \elgg_view('components/tabs', [
            'id' => 'mod-tabs',
            'tabs' => '<ul><li>A</li></ul>',
            'content' => '<div>B</div>',
            'module' => 'info',
        ]);
        $this->assertStringContainsString('elgg-module', $output);
        $this->assertStringContainsString('elgg-module-tabbed', $output);
    }

    /**
     * @return void
     */
    public function testPageLayoutTabsFallsBackToContentWhenNoTabs(): void {
        $output = \elgg_view_layout('tabs', [
            'content' => 'just content',
        ]);
        $this->assertStringContainsString('just content', $output);
        $this->assertStringNotContainsString('elgg-tabs-container', $output);
    }

    /**
     * @return void
     */
    public function testPageLayoutTabsRendersTabsWhenProvided(): void {
        $output = \elgg_view_layout('tabs', [
            'id' => 'pl-tabs',
            'tabs' => '<ul><li>Nav</li></ul>',
            'content' => '<div>Body</div>',
        ]);
        $this->assertStringContainsString('elgg-tabs-container', $output);
        $this->assertStringContainsString('Body', $output);
    }

    /**
     * @return void
     */
    public function testThemeSandboxTabsRenders(): void {
        $output = \elgg_view('theme_sandbox/components/tabs');
        $this->assertIsString($output);
        $this->assertNotEmpty($output);
        $this->assertStringContainsString('AJAX Tabs', $output);
        $this->assertStringContainsString('elgg-tabs-container', $output);
    }

    /**
     * @return void
     */
    public function testPluginSettingsViewRenders(): void {
        $plugin = \elgg_get_plugin_from_id('ui_tabs');
        if (!$plugin) {
            $this->markTestSkipped('ui_tabs plugin not installed in test env');
        }
        $output = \elgg_view('plugins/ui_tabs/settings', ['entity' => $plugin]);
        $this->assertIsString($output);
        $this->assertStringContainsString('ajax_page_tabs', $output);
    }
}
