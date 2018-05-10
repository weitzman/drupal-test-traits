<?php

namespace Drupal\Tests\mass_media\ExistingSite;

use Drupal\file\Entity\File;
use Drupal\node\Entity\Node;
use PHPUnit\Framework\TestCase;
use weitzman\DrupalTestTraits\DrupalSetup;
use weitzman\DrupalTestTraits\Entity\NodeCreationTrait;
use weitzman\DrupalTestTraits\MinkSetup;

/**
 * A model test class using 2 traits from Drupal Test Traits.
 */
class ExampleTest extends TestCase {

  /**
   * Make Mink and Drupal available to this class.
   */
  use MinkSetup;
  use DrupalSetup;

    /**
     * Automatically cleanup nodes created via `$this->createNode()`.
     */
    use NodeCreationTrait;

  /**
   * An example test method; note that Drupal API's and Mink are available.
   */
  public function testLlama() {
    // Create a file to upload.
    $destination = 'public://llama-23.txt';
    $file = File::create(['uri' => $destination]);
    $file->setPermanent();
    $file->save();
    // Nothing copied the file so we do so.
    $src = 'core/tests/Drupal/Tests/Component/FileCache/Fixtures/llama-23.txt';
    file_unmanaged_copy($src, $destination, TRUE);

    // Create a "Llama" article.

    $node = Node::create([
      'title' => 'Llama',
      'type' => 'article',
      'field_image' => [
        'target_id' => $file->id(),
      ],
    ]);
    $node->setPublished(TRUE)->save();
    // If directly creating entities in tests, they can be marked for cleanup.
    $this->markEntityForCleanup($node);

    $this->visit($file->url());
    $this->assertEquals($this->getSession()->getStatusCode(), 200);

    // Nodes are automatically added for cleanup when using `weitzman\DrupalTestTraits\Entity\NodeCreationTrait`.
    $node = $this->createNode(['type' => 'article']);
    $this->visit($node->toUrl()->toString());
    $this->assertEquals(200, $this->getSession()->getStatusCode());
  }

}
