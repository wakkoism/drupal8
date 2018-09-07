<?php

namespace Drupal\d8dev_migrate\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * Add prefix to URL aliases.
 *
 * @MigrateProcessPlugin(
 *   id = "event_custom_fields"
 * )
 */
class EventCustomFields extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {

    $field_type = $this->configuration['eventCustomFieldType'];
    if (is_array($value) && !empty($value['type'])) {
      switch ($value['type']) {
        // The register link.
        case 6:
          // Parse out the value
          $dom = new \DOMDocument();
          $dom->loadHTML($value['value']);

          $anchor_tag = $dom->getElementsByTagName('a');
          if (empty($anchor_tag[0]->nodeValue)) {
            return [
              'uri' => $anchor_tag[0]->getAttribute('src'),
              'title' => $anchor_tag[0]->nodeValue,
            ];
          }
      }
    }
  }

}
