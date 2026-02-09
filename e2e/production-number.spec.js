import { test, expect } from '@playwright/test';

test.describe('Find Your Production Number', () => {
  test.beforeEach(async ({ page }) => {
    await page.goto('/findyourproductionnumber/');
  });

  test('page loads with correct title', async ({ page }) => {
    await expect(page).toHaveTitle(/Production Number/);
    await expect(page.locator('h1')).toContainText('How to Find Your Production Number');
  });

  test('has patio door instructions', async ({ page }) => {
    await expect(page.locator('text=For a patio door')).toBeVisible();
    await expect(page.locator('img[src="/patio-1.jpg"]')).toBeVisible();
    await expect(page.locator('img[src="/patio-pid.jpg"]')).toBeVisible();
  });

  test('has entrance door instructions', async ({ page }) => {
    await expect(page.locator('text=For an Entrance Door')).toBeVisible();
    await expect(page.locator('img[src="/entrance-1.jpg"]')).toBeVisible();
    await expect(page.locator('img[src="/entrance-pid.jpg"]')).toBeVisible();
  });

  test('all images load successfully', async ({ page }) => {
    const images = page.locator('main img');
    const count = await images.count();
    
    expect(count).toBe(4);
    
    for (let i = 0; i < count; i++) {
      const img = images.nth(i);
      await expect(img).toBeVisible();
      // Check image actually loaded (naturalWidth > 0)
      const naturalWidth = await img.evaluate(el => el.naturalWidth);
      expect(naturalWidth).toBeGreaterThan(0);
    }
  });
});
