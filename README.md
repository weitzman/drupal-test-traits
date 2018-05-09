# Drupal Test Traits

[![project-stage-badge]][project-stage-page]
[![license-badge]][mit]

## Introduction

Traits for testing Drupal sites that have user content (versus unpopulated sites).

## Installation

    composer require 'weitzman/drupal-test-traits'

## Example Usage

Add a `use` statement for the desired trait to your PHPUnit test class. Since our
traits have a @before annotation, Drupal and Mink are automatically setup. 

[An example TestCase](./ExampleTestCase.php)

## Available traits

- **DrupalSetup** -- _Bootstrap Drupal (and more)._  
  Bootstraps Drupal so that its API's are available. Also offers an entity cleanup
  API so databases are kept relatively free of testing content.

- **MinkSetup** -- _Create a Mink session._  
  Makes Mink available for browser control, and offers a few helper methods.


## Colophon

- **Author**: Created by [Moshe Weitzman](http://weitzman.github.io).
- **License**: Licensed under the [MIT license][mit]

[mit]: ./LICENSE.md
[license-badge]: https://img.shields.io/badge/License-MIT-blue.svg
[project-stage-badge]: http://img.shields.io/badge/Project%20Stage-Development-yellowgreen.svg
[project-stage-page]: http://bl.ocks.org/potherca/raw/a2ae67caa3863a299ba0/