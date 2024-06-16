import { Builder, By, WebDriver } from "selenium-webdriver";
import { createDriver,quitDriver } from "../core/config/driver-setup";
import { readFileSync } from "fs";
import * as path from "path";
import { SportLogin2 } from "../core/page-objects/login";

const dataFilePath = path.resolve(__dirname , "../core/data/data.json")
const testData = JSON.parse(readFileSync(dataFilePath, "utf8"));


let driver: WebDriver;
let loginPage: SportLogin2;

beforeAll(async () => {
    driver = await createDriver(testData.url.sporturl);
    loginPage = new SportLogin2(driver);
},100000);


test("user login", async () => {
    await loginPage.clickOnLogin();
    await loginPage.fillEmailLogin();
    await loginPage.fillPasswordLogin();
    await loginPage.clickPrijava();
    await loginPage.checkSuccessfullLogin();
    
},100000);


afterAll(async () => {
    await quitDriver(driver);
},10000);


