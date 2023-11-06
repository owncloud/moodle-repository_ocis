class FilePicker {
    constructor() {
        this.fileUploadSelector = 'span.fp-repo-name:has-text("owncloud")';
        this.fileListSelector ='//div[@class="fp-tableview"]//span[@class="fp-filename"]';
        this.viewByListFileSelector = 'a[role="button"][title="Display folder with file details"]'
    }

    async selectRepositoryForUpload(){
        await page.locator(this.fileUploadSelector).click();
    }

    async viewFilesByList(){
        await page.locator(this.viewByListFileSelector).click();
    }
}

module.exports = FilePicker;