import { By, WebDriver, until } from "selenium-webdriver";
import BasePage from "./base-page";
import { readFileSync } from "fs";
import * as path from "path";

const dataFilePath = path.resolve(__dirname, "../data/data.json");
const testData = JSON.parse(readFileSync(dataFilePath, "utf8"));

export class Products extends BasePage { 
    private allProductsLink = By.xpath("//a[@href='#products']");
    private choseOption=By.xpath("//option[@value='phones']")
    private product=By.xpath("//div[@class='text-center']//h5[@class='fw-bolder']")


    constructor(driver: WebDriver) {
        super(driver);
    }

    async selectAllProducts() {
        await this.waitAndClick(this.allProductsLink,50000)
    }
    async selectOption(){
        await this.findElementAndClick(this.choseOption)
    }
    async delay(){
        await this.driver.sleep(2000)
    }

    async checkIfLoaded(){
        await this.checkMatchingElements(this.product,testData.products.product_name)
    }
}
