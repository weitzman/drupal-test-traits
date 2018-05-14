<?php

# Use your module's namespace such as the one below.
# namespace Drupal\Tests\mass_media\ExistingSite;

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

    // Create a "Llama" article. Will be automatically cleaned up at end of test.
    $node = $this->createNode([
      'title' => 'Llama',
      'type' => 'article',
      'field_image' => [
        'target_id' => $file->id(),
      ],
    ]);
    $node->setPublished(TRUE)->save();

    $url = $file->url();
    $this->visit($url);
    $this->assertEquals($this->getSession()->getStatusCode(), 200);

    $url = $node->toUrl()->toString();
    $this->visit($url);
    $this->assertEquals($this->getSession()->getStatusCode(), 200);
  }

}
