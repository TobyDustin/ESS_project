package Tests;

import static org.junit.jupiter.api.Assertions.*;

import java.awt.Button;
import java.util.concurrent.TimeUnit;

import org.junit.Assert;
import org.junit.jupiter.api.Test;
import org.openqa.selenium.By;
import org.openqa.selenium.JavascriptExecutor;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.htmlunit.HtmlUnitDriver;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

import com.gargoylesoftware.htmlunit.WebClient;
import com.gargoylesoftware.htmlunit.html.HtmlButton;
import com.gargoylesoftware.htmlunit.html.HtmlForm;
import com.gargoylesoftware.htmlunit.html.HtmlPage;

public class CustomerSideTests {
	
	public WebDriver IntiDriver() {
		System.setProperty("webdriver.chrome.driver", "/Users/shanky/eclipse-workspace/chromedriver");
		WebDriver driver = new ChromeDriver();
		driver.get("http://qnow.co.uk/customerLogin.php");
		driver.manage().timeouts().implicitlyWait(30, TimeUnit.SECONDS);
		return driver;
	}
	
	@Test
	public void LoadCustomerPage(){
		WebDriver driver = IntiDriver();
		String title = driver.getTitle();
		Assert.assertEquals(title,"Customer");
		driver.quit();
	}
	@Test
	public void Login(){
		
		WebDriver driver = IntiDriver();
		driver.findElement(By.id("start")).click();
		WebDriverWait wait = new WebDriverWait(driver, 10);
		
		WebElement element = wait.until(ExpectedConditions.visibilityOfElementLocated(By.xpath("//*[@id=\"myModal\"]/div/div")));
		JavascriptExecutor js = (JavascriptExecutor)driver; 
		js.executeScript("arguments[0].style.visibility = 'visible'", element);
		
		driver.findElement(By.xpath("//*[@id=\"userid\"]")).sendKeys("s@n.com");
		driver.findElement(By.xpath("//*[@id=\"passwordinput\"]")).sendKeys("123");
		driver.findElement(By.xpath("//*[@id=\"signinb\"]")).click();
		String greeting = driver.findElement(By.tagName("h")).getText();
		Assert.assertTrue(greeting.contains("Welcome"));
		
		driver.quit();
	}
	@Test
	public void AddProperty(){
		WebDriver driver = IntiDriver();
		driver.findElement(By.id("start")).click();
		WebDriverWait wait = new WebDriverWait(driver, 10);
		
		WebElement loginForm = wait.until(ExpectedConditions.visibilityOfElementLocated(By.xpath("//*[@id=\"myModal\"]/div/div")));
		JavascriptExecutor js = (JavascriptExecutor)driver; 
		js.executeScript("arguments[0].style.visibility = 'visible'", loginForm);
		
		driver.findElement(By.xpath("//*[@id=\"userid\"]")).sendKeys("s@n.com");
		driver.findElement(By.xpath("//*[@id=\"passwordinput\"]")).sendKeys("123");
		driver.findElement(By.xpath("//*[@id=\"signinb\"]")).click();
		driver.findElement(By.xpath("//*[@id=\"addButtonProp\"]")).click();
		WebElement addPropertyForm = wait.until(ExpectedConditions.visibilityOfElementLocated(By.xpath("//*[@id=\"addNewProperty\"]/form")));
		js.executeScript("arguments[0].style.visibility = 'visible'", addPropertyForm);
		
		driver.findElement(By.xpath("//*[@id=\"addNewProperty\"]/form/input[2]")).sendKeys("SO15 5BS");
		driver.findElement(By.xpath("//*[@id=\"addNewProperty\"]/form/input[3]")).sendKeys("21 Avenue");
		driver.findElement(By.xpath("//*[@id=\"addNewProperty\"]/form/input[4]")).sendKeys("Southampton");
		driver.findElement(By.xpath("//*[@id=\"addNewProperty\"]/form/input[5]")).sendKeys("UK");
		driver.findElement(By.xpath("//*[@id=\"addNewProperty\"]/form/input[6]")).click();
		wait.until(ExpectedConditions.visibilityOfElementLocated(By.id("nav")));
		String addresses = driver.findElement(By.id("nav")).getText();
		Assert.assertTrue(addresses.contains("21 Avenue"));
		
		driver.quit();

	}
	@Test
	public void AddTicket(){
		WebDriver driver = IntiDriver();
		driver.findElement(By.id("start")).click();
		WebDriverWait wait = new WebDriverWait(driver, 10);
		
		WebElement loginForm = wait.until(ExpectedConditions.visibilityOfElementLocated(By.xpath("//*[@id=\"myModal\"]/div/div")));
		JavascriptExecutor js = (JavascriptExecutor)driver; 
		js.executeScript("arguments[0].style.visibility = 'visible'", loginForm);
		
		driver.findElement(By.xpath("//*[@id=\"userid\"]")).sendKeys("s@n.com");
		driver.findElement(By.xpath("//*[@id=\"passwordinput\"]")).sendKeys("123");
		driver.findElement(By.xpath("//*[@id=\"signinb\"]")).click();
		driver.findElement(By.xpath("//*[@id=\"nav\"]/a[3]/div")).click();
		driver.findElement(By.xpath("//*[@id=\"newProblem\"]/button")).click();
		WebElement addTicketForm = wait.until(ExpectedConditions.visibilityOfElementLocated(By.xpath("//*[@id=\"newProblem\"]/form")));
		js.executeScript("arguments[0].style.visibility = 'visible'", addTicketForm);
		
		driver.findElement(By.xpath("//*[@id=\"newProblem\"]/form/input[3]")).isSelected();
		driver.findElement(By.xpath("//*[@id=\"newProblem\"]/form/input[7]")).click();
		driver.findElement(By.xpath("//*[@id=\"nav\"]/a[3]/div")).click();
		wait.until(ExpectedConditions.visibilityOfElementLocated(By.id("main")));
		String addresses = driver.findElement(By.id("main")).getText();
		Assert.assertTrue(addresses.contains("Gardening"));
		
		driver.quit();

	}
	
}
