import { By, WebDriver, until } from "selenium-webdriver";
import BasePage from "./base-page";
import { readFileSync } from "fs";
import * as path from "path";

const dataFilePath = path.resolve(__dirname, "../data/data.json");
const testData = JSON.parse(readFileSync(dataFilePath, "utf8"));




export class Register extends BasePage {
        private first_name=By.id("firstname")
        private last_name=By.id("lastname")
        private registerbtn = By.xpath("//a[@href='#register']");
        private email_register_field=By.xpath("//form[@id='register-form']//input[@id='email']")
        private pass_register_field=By.xpath("//form[@id='register-form']//input[@id='password']")
        private register_btn = By.xpath("//form[@id='register-form']//button[@class='btn btn-primary btn-block mb-4']");
        
        private registermsg=By.xpath("//div[@id='swal2-html-container']")
        
        constructor(driver: WebDriver) {
            super(driver);
        }
        
        async clickOnRegister(){
            await this.waitAndClick(this.registerbtn,50000)
        }
        async fillFirstName(){
            await this.fillInputField(this.first_name,testData.account.first_name)
        }
        async fillLastName(){
            await this.fillInputField(this.last_name,testData.account.last_name)
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