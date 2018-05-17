<?php

namespace weitzman\DrupalTestTraits;

trait MinkSetup
{
  protected $minkBaseUrl;

  /**
   * @var \Behat\Mink\Session
   */
  protected $minkSession;

  /**
   *
   * Setup a Mink session. Call this from your setUp() method.
   *
   */
  public function setupMinkSession()
  {
    $this->minkBaseUrl = getenv('DTT_BASE_URL') ?: 'http://localhost:8000';

    $driver = new \Behat\Mink\Driver\GoutteDriver();
    $this->minkSession= new \Behat\Mink\Session($driver);
    $this->minkSession->start();

    // Create the artifacts directory if necessary (not functional yet).
    $output_dir = getenv('DTT_OUTPUT_DIR');
    if ($output_dir && !is_dir($output_dir)) {
      mkdir($output_dir, 0777, TRUE);
    }

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

  /**
   * Stop session. Call this from your tearDown() method.
   */
  public function tearDownMinkSession() {
    $this->getSession()->stop();
  }

  public function getSession() {
    return $this->minkSession;
  }

  public function getCurrentPage()
  {
    return $this->minkSession->getPage();
  }

  public function getCurrentPageContent()
  {
    return $this->getCurrentPage()->getContent();
  }

  public function visit($url)
  {
    if (!parse_url($url, PHP_URL_SCHEME)) {
        $url = $this->minkBaseUrl . $url;
    }
    $this->minkSession->visit($url);
  }
}