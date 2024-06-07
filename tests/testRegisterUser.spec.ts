//1. vist local host 800
// click button register
// fill in:
// name
// email
// password
// click button register
// assert that user can see "You are Register"

import { test, expect } from '@playwright/test';

test('register user', async ({ page }) => {
  await page.goto('http:/127.0.0.1:8000/register');

  await expect(page.getByLabel("Name")).toBeVisible();
  
  await page.getByLabel("Name").fill("Pheakdey")
  await page.getByLabel("E-Mail Address").fill("pheakdey1@gmail.com");
  await page.getByLabel("Password").nth(0).fill("12345678");
  await page.getByLabel("Confirm").fill("12345678");
  await page.getByRole("button", {name: "Register"}).click();

  await expect(page.getByText("You are Logged in!")).toBeVisible();

});