<?php

namespace weitzman\DrupalTestTraits\Tests;

use weitzman\DrupalTestTraits\ExistingSiteJavascriptBase;

/**
 * A WebDriver test suitable for testing Ajax and client-side interactions.
 */
class ExampleTestJavascript extends ExistingSiteJavascriptBase
{
    public function testHomepage()
    {
        $this->visit('');
        $this->assertEquals($this->getSession()->getStatusCode(), 200);
    }
}
