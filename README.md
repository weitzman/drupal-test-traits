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

## Usage

See [ExampleTest.php](./ExampleTest.php)

Add a `use` statement for the desired trait to your PHPUnit test class. Since our
traits have a @before annotation, Drupal and Mink are automatically setup. 

## Running Tests

You must specify the URL to your site as an environment variable: `DTT_BASE_URL=http://example.com`. Here are two ways to do that:

- Enter that line into a .env file. These files are supported by [drupal-project](https://github.com/drupal-composer/drupal-project/blob/8.x/.env.example) and [Docker](https://docs.docker.com/compose/env-file/). 
- Specify an environment variable at runtime: `DTT_BASE_URL=http://127.0.0.1:8888 vendor/bin/phpunit ...`

## Available traits

- **DrupalSetup** -- _Bootstrap Drupal (and more)._  
  Bootstraps Drupal so that its API's are available. Also offers an entity cleanup
  API so databases are kept relatively free of testing content.

- **MinkSetup** -- _Create a Mink session._  
  Makes Mink available for browser control, and offers a few helper methods.
  
## Contributing

Contributions to the this project are welcome! Please file issues and pull requests.
All pull requests are automatically tested at [CircleCI](https://circleci.com/gh/weitzman/drupal-test-traits).  

## Colophon

- **Author**: Created by [Moshe Weitzman](http://weitzman.github.io).
- **License**: Licensed under the [MIT license][mit]

[mit]: ./LICENSE.md
[license-badge]: https://img.shields.io/badge/License-MIT-blue.svg
[project-stage-badge]: http://img.shields.io/badge/Project%20Stage-Development-yellowgreen.svg
[project-stage-page]: http://bl.ocks.org/potherca/raw/a2ae67caa3863a299ba0/