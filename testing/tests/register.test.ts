import { Builder, By, WebDriver } from "selenium-webdriver";
import { createDriver,quitDriver } from "../core/config/driver-setup";
import { readFileSync } from "fs";
import * as path from "path";
import { Register } from "../core/page-objects/register";

const dataFilePath = path.resolve(__dirname , "../core/data/data.json")
const testData = JSON.parse(readFileSync(dataFilePath, "utf8"));


let driver: WebDriver;
let registerPage: Register;

beforeAll(async () => {
    driver = await createDriver(testData.url.sporturl);
    registerPage = new Register(driver);
},100000);


test("user registration", async () => {
    await registerPage.clickOnRegister();
    await registerPage.fillEmailRegister();
    await registerPage.fillPasswordRegister();
    await registerPage.clickRegister();
    await registerPage.checkSuccessfullRegister();





    
},100000);


afterAll(async () => {
    await quitDriver(driver);
},10000);

