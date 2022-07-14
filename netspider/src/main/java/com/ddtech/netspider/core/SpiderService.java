package com.ddtech.netspider.core;

import cn.hutool.core.date.DateUtil;
import cn.hutool.core.util.StrUtil;
import com.ddtech.netspider.enums.JobStatus;
import com.ddtech.netspider.jpa.entity.spider.JobLog;
import com.ddtech.netspider.jpa.entity.spider.JobTask;
import com.ddtech.netspider.jpa.entity.spider.LinkResource;
import com.ddtech.netspider.jpa.repo.spider.JobLogRepo;
import com.ddtech.netspider.jpa.repo.spider.JobTaskRepo;
import com.ddtech.netspider.service.SpiderDBService;
import org.jsoup.Connection;
import org.jsoup.Jsoup;
import org.openqa.selenium.PageLoadStrategy;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.chrome.ChromeOptions;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.firefox.FirefoxOptions;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

import javax.annotation.PostConstruct;

import org.jsoup.nodes.Element;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.scheduling.annotation.Async;

import java.io.File;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.Date;

public abstract class SpiderService {


    Logger logger = LoggerFactory.getLogger(SpiderService.class);
    public static int TIME_OUT = 5000;

    @Autowired
    private JobLogRepo jobLogRepo;

    @Autowired
    public SpiderDBService spiderService;


    private String driverVersion = "96.0.4664.45";
    private String driverUrl = "\\webdrivers\\chromedriver_win32\\chromedriver.exe";

    @PostConstruct
    public void init() {
        System.setProperty("webdriver.chrome.driver", getDriverDir("102"));
        System.setProperty("webdriver.firefox.driver", "/usr/local/spider/geckodriver");
    }


    public String getDriverDir(String version) {
        try {
            File file = new File("");
            return file.getCanonicalPath() + "\\webdrivers\\chromedriver_win32\\" + version + "\\chromedriver.exe";
        } catch (Exception es) {
            logger.error(" getDriverDir error:" + es.getMessage());
            return "";
        }
    }

    public WebDriver getChromeDriver() {
        return getChromeDriver(PageLoadStrategy.NORMAL, true);
    }

    public WebDriver getFireFoxDriver() {
        return getFireFoxDriver(PageLoadStrategy.EAGER, true);
    }

    //
    public WebDriver getChromeDriver(PageLoadStrategy pageLoadStrategy, boolean isHeadLess) {
        ChromeOptions chromeOptions = new ChromeOptions();
        chromeOptions.setAcceptInsecureCerts(true);
        chromeOptions.setPageLoadStrategy(pageLoadStrategy);
        if (isHeadLess) {
            chromeOptions.addArguments("--headless");
            chromeOptions.addArguments("--user-agent=Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.0 Safari/537.36");
        }
        chromeOptions.addArguments("--disable-dev-shm-usage");
        chromeOptions.addArguments("disable-infobars");
//        chromeOptions.addArguments("blink-settings=imagesEnabled=false");
//        chromeOptions.addArguments("--disable-gpu");
        chromeOptions.addArguments("--lang=en-US");
        WebDriver driver = new ChromeDriver(chromeOptions);
        driver.manage().window().minimize();
        return driver;
    }

    public WebDriver getFireFoxDriver(PageLoadStrategy pageLoadStrategy, boolean isHeadLess) {
        FirefoxOptions firefoxOptions = new FirefoxOptions();
        firefoxOptions.setAcceptInsecureCerts(true);
        firefoxOptions.setPageLoadStrategy(pageLoadStrategy);
        if (isHeadLess) {
            firefoxOptions.addArguments("--headless");
            firefoxOptions.addArguments("--user-agent=Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.0 Safari/537.36");
        }
        firefoxOptions.addArguments("--disable-dev-shm-usage");
        firefoxOptions.addArguments("disable-infobars");
        firefoxOptions.addArguments("--disable-gpu");
        firefoxOptions.addArguments("--lang=en-US");
        WebDriver driver = new FirefoxDriver(firefoxOptions);
        return driver;
    }

    public void saveResStatus(LinkResource linkResource,String status){
        spiderService.saveResStatus(linkResource, status);
    }


    public static void initDriver(String driver) {

        try {
            //加载驱动程序
            Class.forName(driver);
        } catch (ClassNotFoundException e) {
            e.printStackTrace();
        }
    }

    public Date getNowDate() {
        return DateUtil.parse(DateUtil.today());
    }


    public static String filterEmoji(String source) {
        if(StrUtil.isNotBlank(source)){
            return source.replaceAll("[\ud800\udc00-\udbff\udfff\ud800-\udfff]", "*");
        }else{
            return source;
        }
    }

    public String filterUrl(String url) {
        if (StrUtil.isNotEmpty(url)) {
            if (url.startsWith("http") || url.startsWith("https")) {
                return url;
            } else {
                return "https://" + url;
            }
        }
        return "";
    }

    public String getElementText(Element element) {
        if (element == null) {
            return "";
        }
        return StrUtil.trim(element.text());
    }

    public String getElementHtml(Element element) {
        if (element == null) {
            return "";
        }
        return element.html();
    }

    public String getElementAttr(Element element, String attr) {
        if (element == null) {
            return "";
        }
        return element.attr(attr);
    }

    public String getWebElementText(WebElement element) {
        if (element == null) {
            return "";
        }
        return element.getText();
    }

    public String getWebElementHtml(WebElement element) {
        if (element == null) {
            return "";
        }
        return element.getAttribute("innerHtml");
    }

    public String getWebElementAttr(WebElement element, String attr) {
        if (element == null) {
            return "";
        }
        return element.getAttribute(attr);
    }



    public String getUrlPath(String urlStr) {
        try {
            URL url = new URL(urlStr);
            return url.getPath();
        } catch (Exception es) {
            logger.error(" getUrlPath error:" + es.getMessage());
        }
        logger.error(" getUrlPath return urlStr:" + urlStr);
        return urlStr;
    }

    public String getUrlPathReplace(String urlStr, String replaceStr, String toStr) {
        try {
            URL url = new URL(urlStr);
            return url.getPath().replace(replaceStr, toStr);
        } catch (Exception es) {
            logger.error(" getUrlPath error:" + es.getMessage());
        }
        logger.error(" getUrlPath return urlStr:" + urlStr);
        return urlStr;
    }

    public Connection getJsoupConnect(String url) {

        Connection conn = Jsoup.connect(url).timeout(5000);
        return conn;
    }


    public String getJumpUrl(String url) throws Exception {
        HttpURLConnection conn = null;
        try {
            URL Url = new URL(url);
            conn = (HttpURLConnection) Url.openConnection();
            conn.setConnectTimeout(10000);
            conn.setReadTimeout(10000);
            conn.getResponseCode();
            return conn.getURL().toString();
        } catch (Exception es) {
            //跳转后所返回的链接
            throw es;
        } finally {
            if (conn != null) {
                conn.disconnect();
            }
        }

    }

    public static Integer str2Integer(String views) {
        if (StrUtil.isEmpty(views)) {
            return 0;
        }
        views = views.replace(",", "");
        views = views.trim();
        try {
            return Integer.parseInt(views);
        } catch (Exception es) {
            return 0;
        }

    }


    public void saveTaskLog(JobTask jobTask, String jobStatus, String log){
        saveTaskLog(jobTask,jobStatus,log,null);
    }
    public void saveTaskLog(JobTask jobTask, String jobStatus, String log, LinkResource linkResource){
        JobLog jobLog=new JobLog();
        jobLog.setJobTask(jobTask);
        jobLog.setJobStatus(jobStatus);
        jobLog.setJobLog(log);
        if (linkResource!=null){
            jobLog.setLinkResource(linkResource);
        }
        jobLogRepo.save(jobLog);
    }

    @Async
    public abstract void startTask(JobTask jobTask);


}
