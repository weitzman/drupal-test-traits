<?php

namespace weitzman\DrupalTestTraits\Tests\Entity;

use PHPUnit\Framework\TestCase;
use weitzman\DrupalTestTraits\DrupalSetup;
use weitzman\DrupalTestTraits\Entity\NodeCreationTrait;

/**
 * Test the node creation trait.
 */
class NodeCreationTraitTest extends TestCase
{
  use DrupalSetup;
  use NodeCreationTrait;

  public function testAutoCleanup()
  {
    $node = $this->createNode(['type' => 'article']);
    $this->assertCount(1, $this->cleanupEntities);
    $this->assertEquals($node->id(), $this->cleanupEntities[0]->id());
  }
}