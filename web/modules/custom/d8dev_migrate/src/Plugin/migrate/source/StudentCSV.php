<?php

namespace Drupal\d8dev_migrate\Plugin\migrate\source;

use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\migrate_source_csv\Plugin\migrate\source\CSV;
use Drupal\migrate\Row;
use Drupal\Component\Serialization\Json;

/**
 * Source for CSV.
 *
 * If the CSV file contains non-ASCII characters, make sure it includes a
 * UTF BOM (Byte Order Marker) so they are interpreted correctly.
 *
 * @MigrateSource(
 *   id = "student_csv",
 *   title = @Translation("Test Student Import")
 * )
 */
class StudentCSV extends CSV {

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, MigrationInterface $migration) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $migration);
    $this->reader = new \XMLReader();
    $configuration['path'] = drupal_get_path('module', 'd8dev_migrate') . $configuration['path'];
    $this->setConfiguration($configuration);
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    static $count = 0;
    $values = $row->getSource();

    // Get the url.
    if (!empty($values['url'])) {
      $data = new \SimpleXMLElement($values['url'], 0, TRUE);
      // Convert to an array.
      $data = Json::decode(Json::encode($data));
      $data = $data['system-index-block']['calling-page']['system-page'];
      $row->setSourceProperty('id', $data['@attributes']['id']);

      $row->setSourceProperty('path', $data['path']);
      $row->setSourceProperty('first_name', $data['system-data-structure']['basic']['first_main']);
      $row->setSourceProperty('last_name', $data['system-data-structure']['basic']['last_main']);
      $row->setSourceProperty('title', $data['system-data-structure']['basic']['first_main'] . ' ' . $data['system-data-structure']['basic']['last_main']);

    }
    return parent::prepareRow($row);
  }

}
