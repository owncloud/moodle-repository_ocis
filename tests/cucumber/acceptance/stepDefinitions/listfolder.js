const { Given, When, Then } = require("@cucumber/cucumber");
const { expect } = require("@playwright/test");
const Login = require("../pageObjects/Login");
const MyCourse = require("../pageObjects/MyCourse");
const FilePicker = require("../pageObjects/FilePicker");
const { createFolder } = require("../helpers/HttpHelpers");

const login = new Login();
const myCourse = new MyCourse();
const filePicker = new FilePicker();

Given(
  "administrator has created the following folders in oCIS server",
  async function (dataTable) {
    for (const value of dataTable.rawTable) {
      await createFolder(value.toString());
    }
  },
);

Given("a user has logged into moodle", async function () {
  await login.loginUser();
  await expect(page).toHaveURL(login.homePageUrl);
});

Given("the user has navigated to add a new course page", async function () {
  await myCourse.navigateToMyCourseMenu();
  await expect(page).toHaveURL(myCourse.myCourseUrl);
});

When("the user opens file-picker", async function () {
  await myCourse.navigateToFilePicker();
});

When("the user selects the repository {string}", async function (repository) {
  await filePicker.selectRepository(repository);
});

Then(
  "the following folder should be listed on the webUI",
  async function (dataTable) {
    await filePicker.viewFilesByList();
    const fileNameList = await filePicker.getFileName();
    for (const value of dataTable.rawTable) {
      const checkForFileVisibility = fileNameList.includes(value.toString());
      expect(checkForFileVisibility).toBe(true);
    }
  },
);
