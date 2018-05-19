<?php

namespace weitzman\DrupalTestTraits\Tests;

use Behat\Mink\WebAssert;
use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Vocabulary;
use Drupal\Tests\RandomGeneratorTrait;
use PHPUnit\Framework\TestCase;
use weitzman\DrupalTestTraits\DrupalSetup;
use weitzman\DrupalTestTraits\Entity\TaxonomyCreationTrait;
use weitzman\DrupalTestTraits\WebDriverSetup;

/**
 * Test the node creation trait.
 */
class ExampleFunctionalTest extends TestCase
{

    use DrupalSetup;
    use WebDriverSetup;
    use TaxonomyCreationTrait;

    // The entity creation traits need this.
    use RandomGeneratorTrait;

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

    public function testContentCreation()
    {
        // Create a taxonomy term. Will be automatically cleaned up at the end of the test.
        $vocab = Vocabulary::load('tags');
        $term = $this->createTerm($vocab, ['name' => 'Amsterdam']);
        $session = $this->getSession();
        $web_assert = new WebAssert($session);
        $this->visit('/user/login');
        $web_assert->statusCodeEquals(200);
        $page = $this->getCurrentPage();
        $page->fillField('name', 'admin');
        $page->fillField('pass', 'password');
        $submit_button = $page->findButton('Log in');
        $submit_button->press();
        $web_assert->statusCodeEquals(200);
        // Create an Article.
        $this->visit('/node/add/article');
        $web_assert->statusCodeEquals(200);
        $page = $this->getCurrentPage();
        $page->fillField('title[0][value]', 'Article Title');
        $tags = $page->findField('field_tags[target_id]');
        $tags->setValue('Ams');
        $tags->keyDown('t');
        /** @var \Behat\Mink\Element\NodeElement[] $results */
        $results = $page->waitFor('1', function () use ($page) {
            $element = $page->find('css', '.ui-autocomplete li');
            if (!empty($element) && $element->isVisible()) {
                return $element;
            }
            return null;
        });
        $this->assertNotNull($results);
        // Select the autocomplete option
        $results->click();
        // Verify that correct the input is selected.
        $web_assert->pageTextContains('Amsterdam');
        $submit_button = $page->findButton('Save');
        $submit_button->press();
        // Verify the URL and get the nid.
        $this->assertTrue((bool) preg_match('/.+node\/(?P<nid>\d+)/', $session->getCurrentUrl(), $matches));
        $node = Node::load($matches['nid']);
        $this->markEntityForCleanup($node);
        // Verify the text on the page.
        $web_assert->pageTextContains('Article Title');
        $web_assert->pageTextContains('Amsterdam');
    }
}
