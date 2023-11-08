const {format} = require("util");

class FilePicker {
    constructor() {
        this.fileUploadSelector = 'span.fp-repo-name:has-text("owncloud")';
        // this.fileListSelector ='//span[@class="fp-filename" and text()="%s"]';
        // this.selector = '//div[@class="fp-tableview"]//span[@class="fp-filename"]';
        this.fileListSelector = '//span[contains(@class, "fp-filename") and text()="%s"]'
        //div[contains(text(), "${folderName}")]`
        this.viewByListFileSelector = 'a[role="button"][title="Display folder with file details"]'
    }

    async selectRepository(){
        await page.locator(this.fileUploadSelector).click();
    }

    async viewFilesByList(){
        await page.locator(this.viewByListFileSelector).click();
    }

    async checkFileVisibility(value){
        return await page.locator(format(this.fileListSelector,value)).isVisible();
    }

    // async checkFileVisibility(value){
    //     const selector =  await page.locator(this.selector).innerText();
    //     const elementHandle = await page.$('span.fp-filename');
    //     const textContent = await elementHandle.textContent();
    //
    //     console.log(textContent);
    // }
}

module.exports = FilePicker;