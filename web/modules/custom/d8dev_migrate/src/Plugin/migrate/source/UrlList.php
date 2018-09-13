<?php

namespace Drupal\d8dev_migrate\Plugin\migrate\source;

use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\migrate_plus\Plugin\migrate\source\SourcePluginExtension;

/**
 * Source plugin for retrieving data via URLs.
 *
 * @MigrateSource(
 *   id = "url_list"
 * )
 */
class UrlList extends SourcePluginExtension {

  /**
   * The source URLs to retrieve.
   *
   * @var array
   */
  protected $sourceUrls = [];

  /**
   * The data parser plugin.
   *
   * @var \Drupal\migrate_plus\DataParserPluginInterface
   */
  protected $dataParserPlugin;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, MigrationInterface $migration) {
    if (!is_array($configuration['urls'])) {
      $configuration['urls'] = [$configuration['urls']];
    }
    $new_url = [];
    // Read each line in the response.
    foreach ($configuration['urls'] as $url) {
      $response = file_get_contents($url);
      if ($response) {
        $new_url = array_merge($new_url, explode(PHP_EOL, $response));
      }
    }
    // Merge each line of links into their own urls.
    $configuration['urls'] = $new_url;

    parent::__construct($configuration, $plugin_id, $plugin_definition, $migration);

    $this->sourceUrls = $configuration['urls'];
  }

  /**
   * Return a string representing the source URLs.
   *
   * @return string
   *   Comma-separated list of URLs being imported.
   */
  public function __toString() {
    // This could cause a problem when using a lot of urls, may need to hash.
    $urls = implode(', ', $this->sourceUrls);
    return $urls;
  }

  /**
   * Returns the initialized data parser plugin.
   *
   * @return \Drupal\migrate_plus\DataParserPluginInterface
   *   The data parser plugin.
   */
  public function getDataParserPlugin() {
    if (!isset($this->dataParserPlugin)) {
      $this->dataParserPlugin = \Drupal::service('plugin.manager.migrate_plus.data_parser')->createInstance($this->configuration['data_parser_plugin'], $this->configuration);
    }
    return $this->dataParserPlugin;
  }

  /**
   * Creates and returns a filtered Iterator over the documents.
   *
   * @return \Iterator
   *   An iterator over the documents providing source rows that match the
   *   configured item_selector.
   */
  protected function initializeIterator() {
    return $this->getDataParserPlugin();
  }

}
