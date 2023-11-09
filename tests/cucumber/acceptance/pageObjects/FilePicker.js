const { format } = require("util");

class FilePicker {
  constructor() {
    this.fileUploadSelector = 'span.fp-repo-name:has-text("%s")';
    this.fileListSelector =
      '//div[@class="fp-tableview"]//span[@class="fp-filename"]';
    this.viewByListFileSelector =
      'a[role="button"][title="Display folder with file details"]';
  }

  async selectRepository(repository) {
    await page.locator(format(this.fileUploadSelector, repository)).click();
  }

  async viewFilesByList() {
    await page.locator(this.viewByListFileSelector).click();
  }

  async getFileName() {
    return await page.locator(this.fileListSelector).allInnerTexts();
  }
}

module.exports = FilePicker;
