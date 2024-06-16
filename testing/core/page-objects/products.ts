import { By, WebDriver, until } from "selenium-webdriver";
import BasePage from "./base-page";
import { readFileSync } from "fs";
import * as path from "path";

const dataFilePath = path.resolve(__dirname, "../data/data.json");
const testData = JSON.parse(readFileSync(dataFilePath, "utf8"));

export class Products extends BasePage { 
    private allProductsLink = By.id("products"); 
   

    constructor(driver: WebDriver) {
        super(driver);
    }

    async selectAllProducts() {
        await this.driver.findElement(this.allProductsLink).click();
    }

}