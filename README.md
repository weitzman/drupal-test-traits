# Drupal Test Traits

[![CircleCI](https://circleci.com/gh/weitzman/drupal-test-traits.svg?style=svg)](https://circleci.com/gh/weitzman/drupal-test-traits)
[![project-stage-badge]][project-stage-page]
[![license-badge]][mit]

## Introduction

Traits for testing Drupal sites that have user content (versus unpopulated sites).

[Behat](http://behat.org) is great for facilitating conversations between 
business managers and developers. Those are useful conversations, but many 
organizations simply can't/wont converse via Gherkin. When you are on the hook for 
product quality and not conversations, this is a testing approach for you. 

## Installation

    composer require 'weitzman/drupal-test-traits'

## Authoring tests

Pick a test type:
1. **ExistingSite**. See [ExampleTest.php](./tests/ExampleTest.php). These tests can be small unit tests up to larger Functional tests (via [Goutte](http://goutte.readthedocs.io/en/latest/)).
2. **ExistingSiteJavascript**. See [ExampleJavascriptTest.php](./tests/ExampleJavascriptTest.php). These tests make use of a real Chrome browser, so are suited to testing Ajax and similar client side interactions. These tests run slower than ExistingSite.  

In addition to a test like above, you must extend a base class. You can extend 
[ExistingSiteTestBase.php](src/ExistingSiteBase.php) or [ExistingJavascriptBase.php](src/ExistingSiteJavascriptBase.php) 
from your own base classes or directly from your tests.

  
## Running tests

- You must specify the URL to your site as an environment variable: `DTT_BASE_URL=http://example.com`. For ExistingSiteJavascript also specify `DTT_API_URL=http://localhost:9222`. Here are three ways to do that:
    - Specify in a phpunit.xml. [See example](docs/phpunit.xml).
    - Enter that line into a .env file. These files are supported by [drupal-project](https://github.com/drupal-composer/drupal-project/blob/8.x/.env.example) and [Docker](https://docs.docker.com/compose/env-file/). 
    - Specify environment variables at runtime: `DTT_BASE_URL=http://127.0.0.1:8888;DTT_API_URL=http://localhost:9222 vendor/bin/phpunit ...`
- Add --bootstrap option like so: `--bootstrap=web/core/tests/bootstrap.php ` ([points into Drupal core](https://github.com/drupal/drupal/blob/8.6.x/core/tests/bootstrap.php))). Alternatively, specify in a [phpunit.xml](docs/phpunit.xml).
- Depending on your setup, you may wish to run phpunit as the web server user `su -s /bin/bash www-data -c "vendor/bin/phpunit ..."`
- For quick debugging in ExistingSiteJavascript use `file_put_contents('public://screenshot.png', $this->getSession()->getScreenshot());` to take screenshot of the current page.

## Available traits

- **DrupalTrait**  
  Bootstraps Drupal so that its API's are available. Also offers an entity cleanup
  API so databases are kept relatively free of testing content.

- **GoutteTrait**  
  Makes Goutte available for browser control, and offers a few helper methods.

- **WebDriverTrait** --   
  Make [ChromeDriver]([ChromeDriver](https://gitlab.com/DMore/chrome-mink-driver/)) available for browser control without the overhead of Selenium. Suitable for functional javascript testing.

- **NodeCreationTrait**  
  Create nodes that are automatically deleted at end of test method.
  
- **TaxonomyCreationTrait**
  Create terms and vocabularies that are deleted at the end of the test method.
  
- **UserCreationTrait**
  Create users and roles that are deleted at the end of the test method.
  
## Contributing

Contributions to the this project are welcome! Please file issues and pull requests.
All pull requests are automatically tested at [CircleCI](https://circleci.com/gh/weitzman/drupal-test-traits).

See docker-compose.yml for a handy development environment identical to our CircleCI.

See the [#testing channel on Drupal Slack](https://drupal.slack.com/messages/C223PR743) for discussion about this project. 

## Colophon

- **Author**: Created by [Moshe Weitzman](http://weitzman.github.io).
- **Maintainers**: Maintained by [Moshe Weitzman](http://weitzman.github.io), [Rob Bayliss](https://github.com/rbayliss), and the Community.
- **License**: Licensed under the [MIT license][mit]

[mit]: ./LICENSE.md
[license-badge]: https://img.shields.io/badge/License-MIT-blue.svg
[project-stage-badge]: http://img.shields.io/badge/Project%20Stage-Development-yellowgreen.svg
[project-stage-page]: http://bl.ocks.org/potherca/raw/a2ae67caa3863a299ba0/
