require('dotenv').config();
class MyCourse{
    constructor() {
        this.myCourseUrl = process.env.BASE_URL + '/course/edit.php';
        this.fileSelector = '.filemanager-toolbar .fp-btn-add'
    }
    async navigateToMyCourseMenu(){
        await page.goto(this.myCourseUrl);
    }

    async navigateToFilePicker(){
        await page.locator(this.fileSelector).click();
    }
}
module.exports = MyCourse;