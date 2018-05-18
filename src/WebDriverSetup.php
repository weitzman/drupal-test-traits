<?php

namespace weitzman\DrupalTestTraits;

trait WebDriverSetup
{
    use MinkSetup;

    /**
     * API url for chrome headless.
     *
     * @var string
     */
    protected $webDriverApiUrl;

    /**
     * Setup the web driver.
     */
    public function setupMinkSession()
    {
        $this->minkBaseUrl = getenv('DTT_BASE_URL') ?: 'http://127.0.0.1';
        $driverApiUrl = getenv('DTT_API_URL') ?: 'http://127.0.0.1:9222';
        $driver = new \DMore\ChromeDriver\ChromeDriver($driverApiUrl, null, $this->minkBaseUrl);
        $mink = new \Behat\Mink\Mink([
            'browser' => new \Behat\Mink\Session($driver),
        ]);
        $mink->setDefaultSessionName('browser');
        $this->minkSession = $mink->getSession();
        $this->minkSession->start();

        // According to the W3C WebDriver specification a cookie can only be set if
        // the cookie domain is equal to the domain of the active document. When the
        // browser starts up the active document is not our domain but 'about:blank'
        // or similar. To be able to set our User-Agent and Xdebug cookies at the
        // start of the test we now do a request to the front page so the active
        // document matches the domain.
        // @see https://w3c.github.io/webdriver/webdriver-spec.html#add-cookie
        // @see https://www.w3.org/Bugs/Public/show_bug.cgi?id=20975
        $this->minkSession->visit($this->minkBaseUrl . '/core/misc/druplicon.png');
    }
}
