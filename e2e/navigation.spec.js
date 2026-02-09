import { test, expect } from '@playwright/test';

test.describe('Navigation', () => {
  test('homepage loads with correct title', async ({ page }) => {
    await page.goto('/');
    await expect(page).toHaveTitle('Standard Doors Forms');
    await expect(page.locator('h1')).toContainText('Service & Support');
  });

test('homepage has both main card links', async ({ page }) => {
    await page.goto('/');
    // Check the card links in main content area
    await expect(page.locator('main a[href="/service/"]')).toBeVisible();
    await expect(page.locator('main a[href="/findyourproductionnumber/"]')).toBeVisible();
  });

  test('logo links to homepage', async ({ page }) => {
    await page.goto('/service/');
    await page.click('a[href="/"]');
    await expect(page).toHaveURL('/');
  });

  test('nav links work from any page', async ({ page }) => {
    await page.goto('/');
    
    // Go to service form
    await page.click('nav a[href="/service/"]');
    await expect(page).toHaveURL('/service/');
    
    // Go to find production number
    await page.click('nav a[href="/findyourproductionnumber/"]');
    await expect(page).toHaveURL('/findyourproductionnumber/');
  });
});
