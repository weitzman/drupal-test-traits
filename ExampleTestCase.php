<?php

namespace Drupal\Tests\mass_media\ExistingSite;

use Drupal\file\Entity\File;
use Drupal\media_entity\Entity\Media;
use PHPUnit\Framework\TestCase;
use weitzman\DrupalTestTraits\DrupalSetup;
use weitzman\DrupalTestTraits\MinkSetup;

/**
 * Verify media functionality.
 *
 * @group mass_media
 */
class ExampleTestCase extends TestCase {

  /**
   * Make Mink and Drupal available to this class.
   */
  use MinkSetup;
  use DrupalSetup;

  /**
   * An example test class, illustrating that Drupal API's and Mink are available.
   */
  public function testMediaDelete() {
    // Create a file to upload.
    $destination = 'public://llama-23.txt';
    $file = File::create([
      'uri' => $destination,
    ]);
    $file->setPermanent();
    $file->save();
    // Nothing copied the file so we do so.
    $src = 'core/tests/Drupal/Tests/Component/FileCache/Fixtures/llama-23.txt';
    file_unmanaged_copy($src, $destination, TRUE);

    // Create a "Llama" article.
    $node = \Drupal\node\Entity\Node::create([
      'title' => 'Llama',
      'bundle' => 'article',
      'field_upload_file' => [
        'target_id' => $file->id(),
      ],
    ]);
    $node->setPublished(TRUE)->save();
    $this->markEntityForCleanup($node);

    $this->visit($file->url());
    $this->assertEquals($this->getSession()->getStatusCode(), 200);
  }

}
