const {Given, When, Then} = require('@cucumber/cucumber')
// import expect for assertion
const { expect } = require("@playwright/test");

const url = 'http://localhost:8000/login/index.php';
const username = 'admin';
const password = 'admin';
const usernameSelector = '//div[@class="login-form-username form-group"]//input[@class="form-control form-control-lg"]'
const passwordSelector = '//div[@class="login-form-password form-group"]//input[@class="form-control form-control-lg"]'
const pageExpandSelector = '//div[@class="d-print-block"]';
const fileSelector = 'icon fa fa-file-o fa-fw';
const ownCloudSelector = '.fp-repo nav-item even active';
const items = '.ygtvitem';
const loginButton = '//button[@class = "btn btn-primary btn-lg"]';
const mycourseSelector = '//li[@data-key = "mycourses"]';
const createcourseSelector = '//button[@class="btn btn-primary"]';


Given('a user has logged in', async function () {
    await page.goto(url);
    await page.fill(usernameSelector,username);
    await page.fill(passwordSelector,password);
    await page.click(loginButton);
});

Given('a user has navigated to the course addition page', async function () {
    await page.locator(mycourseSelector).click();
    await page.click(createcourseSelector);
});

When('the user clicks file-picker', async function () {
    await page.locator(pageExpandSelector).click()
    await page.locator(fileSelector).click();
});

When('the user chooses own-cloud', async function () {
    await page.click(ownCloudSelector);
});

Then('files should be listed on the webUI', function () {
    const locator = page.locator(items);
    expect(locator).toBeVisible();
});

