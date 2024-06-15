import { By, WebDriver, until } from "selenium-webdriver";
import BasePage from "./base-page";
import { readFileSync } from "fs";
import * as path from "path";
const dataFilePath = path.resolve(__dirname, "../data/data.json");
const testData = JSON.parse(readFileSync(dataFilePath, "utf8"));




export class SportLogin2 extends BasePage {
    
    private loginbtn=By.xpath("//a[@href='#login']")
    private email_login_field=By.id("email")
    private pass_login_field=By.id("password")
    private prijava_btn=By.xpath("//form[@id='loginForm']//button[@type='submit']")
    private dropdownicon=By.id("userDropdown")
    constructor(driver: WebDriver) {
        super(driver);
    }
    
    async clickOnLogin(){
        await this.waitAndClick(this.loginbtn,50000)
    }

    async fillEmailLogin(){
        await this.fillInputField(this.email_login_field,testData.account.email)
    }
    async fillPasswordLogin(){
        await this.fillInputField(this.pass_login_field,testData.account.password)
    }
    async clickPrijava(){
        await this.findElementAndClick(this.prijava_btn)
    }

    async checkDropdown(){
        await this.findElement(this.dropdownicon)
    }
    
}