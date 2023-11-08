const { config } = require('../../../../config')
class Login{
    constructor(){
        this.loginPageUrl = config.hostUrl+'/login/index.php';
        this.homePageUrl = config.hostUrl+'/my/';
        this.username = config.adminUser;
        this.password = config.adminPassword;
        this.usernameSelector = '#username';
        this.passwordSelector = '#password';
        this.loginButton = '#loginbtn';
    }

    async loginUser(){
        await page.goto(this.loginPageUrl);
        await page.fill(this.usernameSelector,this.username);
        await page.fill(this.passwordSelector,this.password);
        await page.click(this.loginButton);
    }
}

module.exports = Login;