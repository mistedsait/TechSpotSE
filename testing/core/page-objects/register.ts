import { By, WebDriver, until } from "selenium-webdriver";
import BasePage from "./base-page";
import { readFileSync } from "fs";
import * as path from "path";

const dataFilePath = path.resolve(__dirname, "../data/data.json");
const testData = JSON.parse(readFileSync(dataFilePath, "utf8"));




export class Register extends BasePage {
        private registerbtn = By.xpath("//a[@href='#register']");
        private email_register_field=By.id("email")
        private pass_register_field=By.id("password")
        private pass_repeat_field = By.id("password-repeat");

        private register_btn = By.xpath("//form[@id='register-form']//button[@type='submit']");
        
        private registermsg=By.id("swal2-html-container")
        
        constructor(driver: WebDriver) {
            super(driver);
        }
        
        async clickOnRegister(){
            await this.waitAndClick(this.registerbtn,50000)
        }
    
        async fillEmailRegister(){
            await this.fillInputField(this.email_register_field,testData.account.email)
        }
        async fillPasswordRegister(){
            await this.fillInputField(this.pass_register_field,testData.account.password)
        }
        async clickRegister(){
            await this.findElementAndClick(this.register_btn)
        }
        
        async checkSuccessfullRegister(){
            await this.checkMatchingElements(this.registermsg,testData.verification_message.register_message)
        }




}