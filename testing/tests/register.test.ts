import { Builder, By, WebDriver } from "selenium-webdriver";
import { createDriver,quitDriver } from "../core/config/driver-setup";
import { readFileSync } from "fs";
import * as path from "path";
import { Register } from "../core/page-objects/register";
import { SportLogin2 } from "../core/page-objects/login";


const dataFilePath = path.resolve(__dirname , "../core/data/data.json")
const testData = JSON.parse(readFileSync(dataFilePath, "utf8"));


let driver: WebDriver;
let registerPage: Register;
let loginPage: SportLogin2;

beforeAll(async () => {
    driver = await createDriver(testData.url.sporturl);
    registerPage = new Register(driver);
    loginPage = new SportLogin2(driver);
},100000);


test("user registration", async () => {
    await loginPage.clickOnLogin();
    await registerPage.clickOnRegister();
    await registerPage.fillFirstName();
    await registerPage.fillLastName();
    await registerPage.fillEmailRegister();
    await registerPage.fillPasswordRegister();
    await registerPage.clickRegister();
    await registerPage.checkSuccessfullRegister();


},100000);


afterAll(async () => {
    await quitDriver(driver);
},10000);

