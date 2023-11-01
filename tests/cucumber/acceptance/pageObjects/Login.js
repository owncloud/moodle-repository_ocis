class Login{
    constructor(){
        this.baseUrl = 'http://localhost:8000';
        this.loginPageUrl = this.baseUrl+'/login/index.php';
        this.username = 'admin';
        this.password = 'admin';
        this.usernameSelector = '//div[@class="login-form-username form-group"]//input[@class="form-control form-control-lg"]';
        this.passwordSelector = '//div[@class="login-form-password form-group"]//input[@class="form-control form-control-lg"]';
        this.loginButton = '//button[@class = "btn btn-primary btn-lg"]';
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