import { test, expect } from '@playwright/test';
import { loginAs } from '../helpers/elgg';

// The ui_tabs plugin extends theme_sandbox/components with a tabs demo.
// This verifies the sandbox page renders the tabs container and the
// inline / ajax / page tab behavior works end-to-end.

test.describe('ui_tabs theme sandbox', () => {
  test('sandbox tabs component renders with nav and inline content', async ({ page }) => {
    await loginAs(page, 'admin');
    await page.goto('/theme_sandbox/components/tabs');

    const container = page.locator('#theme-sandbox-tabs.elgg-tabs-container');
    await expect(container).toBeVisible();

    await expect(container.locator('.elgg-tabs-nav')).toBeVisible();
    await expect(container.locator('.elgg-tabs-content')).toBeVisible();

    // Inline tab 1 is selected by default
    await expect(page.locator('#inline-tab1')).toBeVisible();
    await expect(page.locator('#inline-tab1')).toContainText('Inline content');

    // Inline tab 2 should be hidden
    await expect(page.locator('#inline-tab2')).toBeHidden();
  });

  test('clicking inline tab 2 toggles inline content visibility', async ({ page }) => {
    await loginAs(page, 'admin');
    await page.goto('/theme_sandbox/components/tabs');

    await page.locator('.elgg-tabs-nav a[href="#inline-tab2"]').click();

    await expect(page.locator('#inline-tab2')).toBeVisible();
    await expect(page.locator('#inline-tab2')).toContainText('Inline content 2');

    // The clicked tab's <li> should be marked selected
    const tab2Li = page.locator('.elgg-tabs-nav li:has(a[href="#inline-tab2"])');
    await expect(tab2Li).toHaveClass(/elgg-state-selected/);
  });

  test('clicking AJAX view tab loads remote content into the content panel', async ({ page }) => {
    await loginAs(page, 'admin');
    await page.goto('/theme_sandbox/components/tabs');

    const contentPanel = page.locator('#theme-sandbox-tabs .elgg-tabs-content');
    await page.locator('.elgg-tabs-nav a[href="/ajax/view/theme_sandbox/components/tabs/ajax"]').click();

    // tabs.js fetches via elgg/Ajax and appends the response with data-ajax
    await expect(contentPanel.locator('[data-ajax]')).toBeVisible({ timeout: 10000 });
    await expect(contentPanel).toContainText('AJAX content');
  });
});
