import { test, expect } from '@playwright/test';
import { loginAs } from '../helpers/elgg';

test.describe('ui_tabs plugin settings page', () => {
  test('admin settings page renders without errors', async ({ page }) => {
    await loginAs(page, 'admin');
    await page.goto('/admin/plugin_settings/ui_tabs');

    await expect(page.locator('form.elgg-form-settings, form#elgg-form-plugins-settings, form').first()).toBeVisible();
    await expect(page.locator('select[name="params[ajax_page_tabs]"]')).toBeVisible();
    await expect(page.locator('.elgg-system-messages .elgg-message-error')).toHaveCount(0);
  });

  test('saving plugin setting persists and reloads', async ({ page }) => {
    await loginAs(page, 'admin');
    await page.goto('/admin/plugin_settings/ui_tabs');

    await page.selectOption('select[name="params[ajax_page_tabs]"]', '0');
    await page.locator('form button[type="submit"], form input[type="submit"]').first().click();

    await page.goto('/admin/plugin_settings/ui_tabs');
    await expect(page.locator('select[name="params[ajax_page_tabs]"]')).toHaveValue('0');

    // Restore default
    await page.selectOption('select[name="params[ajax_page_tabs]"]', '1');
    await page.locator('form button[type="submit"], form input[type="submit"]').first().click();
  });
});
