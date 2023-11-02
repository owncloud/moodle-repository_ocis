require('dotenv').config();
class Login{
    constructor(){
        this.loginPageUrl = process.env.BASE_URL+'/login/index.php';
        this.homePageUrl = process.env.BASE_URL+'/my/';
        this.username = process.env.USER_NAME;
        this.password = process.env.USER_PASSWORD;
        this.usernameSelector = '#username';
        this.passwordSelector = '#password';
        this.loginButton = '#loginbtn';
    }
    async goToLoginPage(){
        await page.goto(this.loginPageUrl);
    }
    async loginUser(){
        await page.fill(this.usernameSelector,this.username);
        await page.fill(this.passwordSelector,this.password);
        await page.click(this.loginButton);
    }
}

module.exports = Login;