const {Given, When, Then} = require('@cucumber/cucumber')
// import expect for assertion
const { expect } = require("@playwright/test");
const Login = require("../pageObjects/Login");

const login = new Login();
const pageExpandSelector = '//div[@class="d-print-block"]';
const fileSelector = 'icon fa fa-file-o fa-fw';
const ownCloudSelector = '.fp-repo nav-item even active';
const items = '.ygtvitem';
const mycourseSelector = '//li[@data-key = "mycourses"]';
const createcourseSelector = '.nocourseslink';

Given('a user has logged in', async function () {
    await login.goToLoginPage();
    await login.loginUser();
});

Given('a user has navigated to my course page', async function () {
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

