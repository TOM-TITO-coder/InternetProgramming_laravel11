const { test, expect, describe } = require('@playwright/test');

import { name, pwd, email, emailMailtrap, passMailtrap } from './value';

//auth001
test('Register new user', async ({ page }) => {
    await page.goto('http://127.0.0.1:8000/');

    await page.getByRole('link', {name: 'Register'}).click();

    await page.getByRole('textbox', { name: 'Name' }).fill(name);
    await page.getByRole('textbox', { name: 'E-Mail Address' }).fill(email);
    await page.getByRole('textbox', { name: 'Password', exact: true }).fill('12345678');
    await page.getByRole('textbox', { name: 'Confirm Password', exact: true }).fill('12345678');

    await page.getByRole('button', { name: 'Register' }).click();

    await expect(page.getByText('You are logged in!')).toBeVisible();
});

//auth002
test('Test Login', async({page}) =>{
    await page.goto('http://127.0.0.1:8000/');

    await page.getByRole('link', { name: 'Login' }).click();

    await page.getByRole('textbox', { name: 'E-Mail Address' }).fill(email);
    await page.getByRole('textbox', { name: 'Password' }).fill('12345678');

    await page.getByRole('button', { name: 'Login' }).click();

    await expect(page.getByText('You are logged in!')).toBeVisible(); 
});

//auth004
test('Log out User', async ({page}) => {
    await page.goto("http://127.0.0.1:8000/");

    await page.getByRole("link", {name: "Login", exact: true}).click();

    await page.getByRole("textbox", {name: "E-Mail Address", exact: true}).fill(email);
    await page.getByRole("textbox", {name: "Password", exact: true}).fill(pwd);

    await page.getByRole("button", {name: "Login"}).click();

    await expect(page.getByText("You are logged in!")).toBeVisible();

    await page.getByRole("button", {name: name}).click();
    await page.getByRole("link", {name: "Logout"}).click();

    await expect(page.getByText("Your Application's Landing Page.")).toBeVisible();

})

