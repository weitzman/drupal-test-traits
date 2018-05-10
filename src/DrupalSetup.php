<?php

namespace weitzman\DrupalTestTraits;

use Drupal\Core\DrupalKernel;
use Drupal\Core\Entity\EntityInterface;
use DrupalFinder\DrupalFinder;
use Symfony\Component\HttpFoundation\Request;

trait DrupalSetup
{
  /**
   * Entities to clean up.
   *
   * @var \Drupal\Core\Entity\EntityInterface[]
   */
  protected $cleanupEntities = [];

  /**
   * Bootstrap Drupal.
   *
   * Due to the annotation below, this method runs automatically when the trait is `use`d.
   *
   * @before
   */
  public function setupDrupal()
  {
    // Bootstrap Drupal so we can use Drupal's built in functions.
    $finder = new DrupalFinder();
    $finder->locateRoot(__DIR__);
    $classLoader = include $finder->getVendorDir() . '/autoload.php';
    $base_url = getenv('DTT_BASE_URL');
    $parsed_url = parse_url($base_url);
    $server = [
      'SCRIPT_FILENAME' => getcwd() . '/index.php',
      'SCRIPT_NAME' => isset($parsed_url['path']) ? $parsed_url['path'] . 'index.php' : '/index.php',
    ];
    $request = Request::create($base_url, 'GET', [], [], [], $server);
    $kernel = DrupalKernel::createFromRequest($request, $classLoader, 'existing-site-testcase', false, $finder->getDrupalRoot());
    chdir(DRUPAL_ROOT);
    $kernel->prepareLegacyRequest($request);

    // Register stream wrappers.
    $kernel->getContainer()->get('stream_wrapper_manager')->register();
  }

  /**
   * @after
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function tearDownDrupal()
  {
    foreach ($this->cleanupEntities as $entity) {
        $entity->delete();
    }
  }

  /**
   * Mark an entity for deletion.
   *
   * Any entities you create when running against an installed site should be
   * flagged for deletion to ensure isolation between tests.
   *
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   Entity to delete.
   */
  protected function markEntityForCleanup(EntityInterface $entity) {
    $this->cleanupEntities[] = $entity;
  }




}