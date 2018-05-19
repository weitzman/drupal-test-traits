<?php

namespace weitzman\DrupalTestTraits\Tests;

use PHPUnit\Framework\TestCase;
use weitzman\DrupalTestTraits\DrupalSetup;
use weitzman\DrupalTestTraits\WebDriverSetup;

/**
 * Test the node creation trait.
 */
class ExampleFunctionalTest extends TestCase
{

    use DrupalSetup;
    use WebDriverSetup;

    public function setUp()
    {
        parent::setUp();
        $this->setupDrupal();
        $this->setupMinkSession();
    }

    /**
     * @throws \Drupal\Core\Entity\EntityStorageException
     */
    public function tearDown()
    {
        parent::tearDown();
        $this->tearDownDrupal();
        $this->tearDownMinkSession();
    }

    public function testHomepage()
    {
        $this->visit('');
        $this->assertEquals($this->getSession()->getStatusCode(), 200);
    }
}
