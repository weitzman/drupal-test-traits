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

## Authoring Tests

See [ExampleTest.php](./tests/ExampleTest.php)

In addition to a test like above, you must extend a base class. [ExistingSiteTestCase.php](src/ExistingSiteTestCase.php) 
serves as a model that you can use directly, extend, or feel free to copy its code into your base class.
  
## Running your tests

- You must specify the URL to your site as an environment variable: `DTT_BASE_URL=http://example.com`. Here are two ways to do that:
    - Enter that line into a .env file. These files are supported by [drupal-project](https://github.com/drupal-composer/drupal-project/blob/8.x/.env.example) and [Docker](https://docs.docker.com/compose/env-file/). 
    - Specify an environment variable at runtime: `DTT_BASE_URL=http://127.0.0.1:8888 vendor/bin/phpunit ...`
- Add --bootstrap option like so: `--bootstrap=web/core/tests/bootstrap.php ` (points at Drupal core). Required when you use NodeCreationTrait. ALternatively, you may specify this in your phpunit.xml.
- Depending on your setup, you may wish to run phpunit as the web server user `su -s /bin/bash www-data -c "vendor/bin/phpunit ..."`

## Available traits

- **DrupalSetup** -- _Bootstrap Drupal (and more)._  
  Bootstraps Drupal so that its API's are available. Also offers an entity cleanup
  API so databases are kept relatively free of testing content.

- **MinkSetup** -- _Create a Mink session._  
  Makes Mink available for browser control, and offers a few helper methods.

- **NodeCreationTrait**  
  Create nodes that are automatically deleted at end of test method.
  
  **TaxonomyCreationTrait**
  Create terms and vocabularies that are deleted at the end of the test method.
  
  **UserCreationTrait**
  Create users and roles that are deleted at the end of the test method.
  
## Contributing

Contributions to the this project are welcome! Please file issues and pull requests.
All pull requests are automatically tested at [CircleCI](https://circleci.com/gh/weitzman/drupal-test-traits).

See .docker/docker-compose.yml for a handy development environment identical to our CircleCI.  

## Colophon

- **Author**: Created by [Moshe Weitzman](http://weitzman.github.io).
- **License**: Licensed under the [MIT license][mit]

[mit]: ./LICENSE.md
[license-badge]: https://img.shields.io/badge/License-MIT-blue.svg
[project-stage-badge]: http://img.shields.io/badge/Project%20Stage-Development-yellowgreen.svg
[project-stage-page]: http://bl.ocks.org/potherca/raw/a2ae67caa3863a299ba0/
