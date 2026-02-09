import { test, expect } from '@playwright/test';

test.describe('Service Request Form', () => {
  test.beforeEach(async ({ page }) => {
    await page.goto('/service/');
  });

  test('page loads with correct title', async ({ page }) => {
    await expect(page).toHaveTitle(/Service Request Form/);
    await expect(page.locator('h1')).toContainText('Service Request Form');
  });

  test('form has all required sections', async ({ page }) => {
    await expect(page.locator('text=Product information')).toBeVisible();
    await expect(page.locator('text=Dealer Information')).toBeVisible();
    await expect(page.locator('text=Homeowner Information')).toBeVisible();
    await expect(page.locator('text=Reason For Service')).toBeVisible();
  });

  test('date field defaults to today', async ({ page }) => {
    const today = new Date().toISOString().split('T')[0];
    const dateValue = await page.inputValue('input[name="today"]');
    expect(dateValue).toBe(today);
  });

  test('country selection shows correct address fields', async ({ page }) => {
    // Canada fields hidden by default
    await expect(page.locator('#canadaAddress')).toBeHidden();
    await expect(page.locator('#usaAddress')).toBeHidden();

    // Select Canada
    await page.selectOption('#country', 'Canada');
    await expect(page.locator('#canadaAddress')).toBeVisible();
    await expect(page.locator('#usaAddress')).toBeHidden();

    // Select USA
    await page.selectOption('#country', 'United States');
    await expect(page.locator('#canadaAddress')).toBeHidden();
    await expect(page.locator('#usaAddress')).toBeVisible();
  });

  test('homeowner email section toggles correctly', async ({ page }) => {
    await expect(page.locator('#homeownerEmailSection')).toBeHidden();

    // Select Yes
    await page.click('#notifyYes');
    await expect(page.locator('#homeownerEmailSection')).toBeVisible();

    // Select No
    await page.click('#notifyNo');
    await expect(page.locator('#homeownerEmailSection')).toBeHidden();
  });

  test('submit button is present', async ({ page }) => {
    await expect(page.locator('button[type="submit"]')).toBeVisible();
    await expect(page.locator('button[type="submit"]')).toContainText('Submit Service Request');
  });

  test('link to find production number exists', async ({ page }) => {
    const link = page.locator('a[href="/findyourproductionnumber/"]').first();
    await expect(link).toBeVisible();
  });
});
