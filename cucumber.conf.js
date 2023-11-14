const {
  Before,
  BeforeAll,
  AfterAll,
  After,
  setDefaultTimeout,
} = require("@cucumber/cucumber");
const { chromium } = require("playwright");
const { config } = require("./config");
const {
  deleteFolder,
} = require("./tests/cucumber/acceptance/helpers/HttpHelpers");

setDefaultTimeout(60000);
BeforeAll(async function () {
  global.browser = await chromium.launch({
    headless: config.HEADLESS,
    slowMo: config.SLOW_MO,
  });
});

AfterAll(async function () {
  await deleteFolder();
  await global.browser.close();
});

Before(async function () {
  global.context = await global.browser.newContext();
  global.page = await global.context.newPage();
});

After(async function () {
  await global.page.close();
  await global.context.close();
});
