<?php

// Use your module's testing namespace such as the one below.
namespace Drupal\Tests\moduleName\ExistingSiteJavascript;

use Behat\Mink\WebAssert;
use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Vocabulary;
use weitzman\DrupalTestTraits\ExistingSiteJavascriptBase;

/**
 * A WebDriver test suitable for testing Ajax and client-side interactions.
 */
class ExampleJavascriptTest extends ExistingSiteJavascriptBase
{
    public function testContentCreation()
    {
        // Create a taxonomy term. Will be automatically cleaned up at the end of the test.
        $vocab = Vocabulary::load('tags');
        $this->createTerm($vocab, ['name' => 'Term 1']);
        $this->createTerm($vocab, ['name' => 'Term 2']);
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
        $tags->setValue('Ter');
        $tags->keyDown('m');
        /** @var \Behat\Mink\Element\NodeElement $result */
        $result = $page->waitFor('1', function () use ($page) {
            $element = $page->find('css', '.ui-autocomplete li');
            if (!empty($element) && $element->isVisible()) {
                return $element;
            }
            return null;
        });
        $this->assertNotNull($result);
        // Select the autocomplete option
        $result->click();
        // Verify that correct the input is selected.
        $web_assert->pageTextContains('Term 1');
        $submit_button = $page->findButton('Save');
        $submit_button->press();
        // Verify the URL and get the nid.
        $this->assertTrue((bool) preg_match('/.+node\/(?P<nid>\d+)/', $session->getCurrentUrl(), $matches));
        $node = Node::load($matches['nid']);
        $this->markEntityForCleanup($node);
        // Verify the text on the page.
        $web_assert->pageTextContains('Article Title');
        $web_assert->pageTextContains('Term 1');
    }
}
