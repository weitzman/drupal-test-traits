<?php

# Use your module's namespace such as the one below.
# namespace Drupal\Tests\mass_media\ExistingSite;

use Drupal\taxonomy\Entity\Vocabulary;
use weitzman\DrupalTestTraits\ExampleBase;

/**
 * A model test case using traits from Drupal Test Traits.
 *
 * The code in ExampleBase.php should be incorporated into your own test base class.
 */
class ExampleTest extends ExampleBase {

  /**
   * An example test method; note that Drupal API's and Mink are available.
   */
  public function testLlama() {
    // Creates a user. Will be automatically cleaned up at the end of the test.
    $author = $this->createUser();

    // Create a taxonomy term. Will be automatically cleaned up at the end of the test.
    $vocab = Vocabulary::load('tags');
    $term = $this->createTerm($vocab);

    // Create a "Llama" article. Will be automatically cleaned up at end of test.
    $node = $this->createNode([
      'title' => 'Llama',
      'type' => 'article',
      'field_tags' => [
        'target_id' => $term->id(),
      ],
      'uid' => $author->id(),
    ]);
    $node->setPublished(TRUE)->save();
    $this->assertEquals($author->id(), $node->getOwnerId());
    $url = $node->toUrl()->toString();

    // We can use Mink to browse pages.
    $this->visit($url);
    $this->assertEquals($this->getSession()->getStatusCode(), 200);
  }

}
