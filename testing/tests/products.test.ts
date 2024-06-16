import { Builder, By, WebDriver } from "selenium-webdriver";
import { createDriver,quitDriver } from "../core/config/driver-setup";
import { readFileSync } from "fs";
import * as path from "path";
import { Products } from "../core/page-objects/products";

const dataFilePath = path.resolve(__dirname , "../core/data/data.json")
const testData = JSON.parse(readFileSync(dataFilePath, "utf8"));


let driver: WebDriver;
let productsPage: Products;

beforeAll(async () => {
    driver = await createDriver(testData.url.sporturl);
    productsPage = new Products(driver);
},100000);


test("View All Products", async () => {
    await productsPage.selectAllProducts();
    await driver.navigate().refresh();
    await productsPage.selectOption();
    await productsPage.delay();

    await productsPage.checkIfLoaded();

}, 100000);


afterAll(async () => {
    await quitDriver(driver);
},10000);

