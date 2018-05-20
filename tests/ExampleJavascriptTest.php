<?php

// Use your module's testing namespace such as the one below.
namespace Drupal\Tests\moduleName\ExistingSiteJavascript;

use weitzman\DrupalTestTraits\ExistingSiteJavascriptBase;

/**
 * A WebDriver test suitable for testing Ajax and client-side interactions.
 */
class ExampleJavascriptTest extends ExistingSiteJavascriptBase
{
    public function testHomepage()
    {
        $this->visit('');
        $this->assertEquals($this->getSession()->getStatusCode(), 200);
    }
}
