<?php

namespace Drupal\d8dev_migrate\Plugin\migrate\source;

use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\migrate_source_csv\Plugin\migrate\source\CSV;
use Drupal\migrate\Row;

/**
 * Source for CSV.
 *
 * If the CSV file contains non-ASCII characters, make sure it includes a
 * UTF BOM (Byte Order Marker) so they are interpreted correctly.
 *
 * @MigrateSource(
 *   id = "concentration_csv",
 *   title = @Translation("Concentration Page Import")
 * )
 */
class ConcentrationCSV extends CSV {

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
    if (trim($values['url'])) {
      $recent_electives = $this->parseHTML($values['url'], '//*[@id="main"]/div/div/h2[text() = "RECENTLY OFFERED ELECTIVES"]/../ul');
      if ($recent_electives) {
        $recent_electives = array_filter($recent_electives);
        var_dump($recent_electives);
        $row->setSourceProperty('recent_electives', $recent_electives);
      }
    }

    return parent::prepareRow($row);
  }

  /**
   * Parse the HTML URL using xpath.
   */
  protected function parseHTML($url, $xpath_query) {
    $value = [];
    $doc = new \DOMDocument();
    $doc->loadHTMLFile($url, LIBXML_NOWARNING | LIBXML_NOERROR);
    $doc->preserveWhiteSpace = FALSE;
    $xpath = new \DOMXpath($doc);
    $elements = $xpath->query($xpath_query);
    if (!is_null($elements)) {
      foreach ($elements as $element) {
        $nodes = $element->childNodes;
        foreach ($nodes as $node) {
          $node_value = trim($node->nodeValue);
          if ($node_value) {
            $value[] = $node_value;
          }
        }
      }
    }
    return $value;
  }

}
