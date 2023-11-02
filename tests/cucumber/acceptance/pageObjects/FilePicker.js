class FilePicker {
    constructor() {
        this.fileUploadSelector = 'span.fp-repo-name:has-text("owncloud")';
        this.fileListSelector ='//div[@class="fp-tableview"]//span[@class="fp-filename"]';
    }
    async selectRepositoryForUpload(){
        await page.locator(this.fileUploadSelector).click();
    }
}
module.exports = FilePicker;