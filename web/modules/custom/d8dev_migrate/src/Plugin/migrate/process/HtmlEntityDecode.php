<?php

namespace Drupal\d8dev_migrate\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * Decode the HTML.
 *
 * @MigrateProcessPlugin(
 *   id = "html_entity_decode"
 * )
 */
class HtmlEntityDecode extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    return html_entity_decode($value);
  }

}
