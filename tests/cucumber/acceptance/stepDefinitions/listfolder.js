const {Given, When, Then} = require('@cucumber/cucumber')
// import expect for assertion
const { expect } = require("@playwright/test");
const Login = require("../pageObjects/Login");
const MyCourse = require("../pageObjects/MyCourse");
const FilePicker = require("../pageObjects/FilePicker");

const login = new Login();
const myCourse = new MyCourse();
const filePicker = new FilePicker();

Given('a user has uploaded these <{string}> and <{string}> to the ownCloud', function (string, string2, dataTable) {
    // Write code here that turns the phrase above into concrete actions
    return 'pending';
});

Given('a user has logged in', async function () {
    await login.goToLoginPage();
    await expect(page).toHaveURL(login.loginPageUrl);
    await login.loginUser();
    await expect(page).toHaveURL(login.homePageUrl);
});

Given('the user has navigated to add a new course page', async function () {
    await myCourse.navigateToMyCourseMenu();
    await expect(page).toHaveURL(myCourse.myCourseUrl);
});
When('the user clicks file-picker', async function () {
    await myCourse.navigateToFilePicker();
});

When('the user selects Owncloud from the sidebar menu', async function () {
    await filePicker.selectRepositoryForUpload();
});

Then('these files should be seen on the webUI', async function () {
    await expect(page.locator(filePicker.fileListSelector)).toBeVisible();
});