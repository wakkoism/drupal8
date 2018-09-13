<?php

namespace Drupal\d8dev_migrate\Plugin\migrate_plus\data_fetcher;

use Drupal\migrate_plus\Plugin\migrate_plus\data_fetcher\File;

/**
 * Retrieve data from a local path or general URL for migration.
 *
 * @DataFetcher(
 *   id = "relative_path",
 *   title = @Translation("Relative Path")
 * )
 */
class RelativePath extends File {

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    // Change to the relative path.
    $configuration['path'] = drupal_get_path('module', 'd8dev_migrate') . $configuration['path'];
    var_dump($configuration['path']);
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

}
