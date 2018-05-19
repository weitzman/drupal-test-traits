<?php

namespace weitzman\DrupalTestTraits;

use Drupal\KernelTests\AssertLegacyTrait;
use Drupal\Tests\RandomGeneratorTrait;
use PHPUnit\Framework\TestCase;
use weitzman\DrupalTestTraits\Entity\NodeCreationTrait;
use weitzman\DrupalTestTraits\Entity\TaxonomyCreationTrait;
use weitzman\DrupalTestTraits\Entity\UserCreationTrait;

/**
 * You may use this class in any of these ways:
 * - Copy its code into your own base class.
 * - Have your base class extend this class.
 * - Your tests may extend this class directly.
 */
abstract class ExistingSiteTestCase extends TestCase
{

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
}
