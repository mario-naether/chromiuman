# chromiumman
Codeception Extension for automatically starting and stoping Chromedriver when running tests

## Minimum Requirements

- Codeception 2.3
- PHP 7.0

## Install
```bash
$ composer require mario-naether/chromiuman
```

## Install a newer version of chromium driver
```bash
"extra": {
    "lbaey/chromedriver": {
      "bypass-select" : true,
      "chromedriver-version": "74.0.3729.6"
    }
}
```

### Enabling Chromiuman with defaults

```yaml
extensions:
    enabled: 
        - Codeception\Extension\Chromiuman
```

### Enabling Chromiuman with settings

```yaml
extensions:
    enabled: 
        - Codeception\Extension\Chromiuman
    config: 
        Codeception\Extension\Chromiuman
            logDir: '/var/logs/chromedriver/'
            path: '/usr/bin/chromedriver'
```


### Enabling Chrome/Chromium in acceptance.suite.yml

```yaml
modules:
    enabled:
        - WebDriver:
            url: http://www.google.de
            browser: chrome
            capabilities:
                chromeOptions:
                  args: ["disable-infobars", "headless","disable-gpu", "window-size=1920x1080"]
                  #binary: "path/to/chrome.exe"
```