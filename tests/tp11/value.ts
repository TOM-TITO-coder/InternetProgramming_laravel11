const { test, expect } = require('@playwright/test');

export const name = "tito";
export const email = name + "@gmail.com";
export const pwd = "12345678";

export const emailMailtrap = "titotom934@gmail.com";
export const passMailtrap = "a79da9b620e816";

export async function login(page, url, email, pwd){
    await page.goto(url);

    await page.getByRole('link', { name: 'Login' }).click();

    await page.getByRole('textbox', { name: 'E-Mail Address' }).fill(email);
    await page.getByRole('textbox', { name: 'Password' }).fill(pwd);

    await page.getByRole('button', { name: 'Login' }).click();
}