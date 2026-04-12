import { test, expect } from '@playwright/test';
import { loginAs } from '../helpers/elgg';

// The ui_tabs plugin overrides page/layouts/content to wrap the filter
// in an elgg-tabs-container and registers default all/mine/friend filters.

test.describe('ui_tabs content layout filter', () => {
  test('activity page uses the tabbed content layout', async ({ page }) => {
    await loginAs(page, 'admin');
    await page.goto('/activity');

    // The override wraps the filter tabs in .elgg-tabs-container
    const tabsContainer = page.locator('.elgg-layout-tabs, .elgg-tabs-container').first();
    await expect(tabsContainer).toBeVisible();
  });

  test('default filter menu items are registered when logged in', async ({ page }) => {
    await loginAs(page, 'admin');
    await page.goto('/activity');

    const filter = page.locator('.elgg-menu-filter, .elgg-tabs-nav').first();
    await expect(filter).toBeVisible();

    // At least the "all" filter menu item should be rendered
    await expect(filter.locator('a', { hasText: /^All$/i }).first()).toBeVisible();
  });
});
