<?php

namespace weitzman\DrupalTestTraits;

use PHPUnit\Framework\TestCase;
use weitzman\DrupalTestTraits\Entity\NodeCreationTrait;

/**
 * You are encouraged to copy the methods here into your own base class. All your
 * tests then extend it.
 */
abstract class ExampleBase extends TestCase {

  use DrupalSetup;
  use MinkSetup;
  use NodeCreationTrait;

  public function setUp() {
    parent::setUp();
    $this->setupDrupal();
    $this->setupMinkSession();
  }

  public function tearDown() {
    parent::tearDown();
    $this->tearDownDrupal();
    $this->tearDownMinkSession();
  }
}