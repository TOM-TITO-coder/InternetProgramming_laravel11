import { test, expect } from '@playwright/test';

test('create a new task', async ({ page }) => {
  await page.goto('http:/127.0.0.1:8000/tasks/create');

  await expect(page.locator(".panel-heading")).toBeVisible();

  await page.getByLabel("E-Mail Address").fill("titotom934@gmail.com");
  await page.getByLabel("Password").fill("12345678");
  await page.getByRole("button", {name: "Login"}).click();

  await expect(page.getByText("Create New Task")).toBeVisible();

});

