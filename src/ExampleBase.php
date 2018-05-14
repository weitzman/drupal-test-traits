<?php

namespace weitzman\DrupalTestTraits;

use Drupal\KernelTests\AssertLegacyTrait;
use Drupal\Tests\RandomGeneratorTrait;
use PHPUnit\Framework\TestCase;
use weitzman\DrupalTestTraits\Entity\NodeCreationTrait;
use weitzman\DrupalTestTraits\Entity\TaxonomyCreationTrait;
use weitzman\DrupalTestTraits\Entity\UserCreationTrait;

/**
 * You are encouraged to copy the methods here into your own base class. Or if
 * you are lazy like me, you can extend it directly.
 */
abstract class ExampleBase extends TestCase {

  use DrupalSetup;
  use MinkSetup;
  use NodeCreationTrait;
  use UserCreationTrait;
  use TaxonomyCreationTrait;

  // The entity creation traits need this.
  use RandomGeneratorTrait;

  // Core is still using this in role creation, so it must be included here when
  // using the UserCreationTrait.
  use AssertLegacyTrait;

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
