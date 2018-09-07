<?php

namespace Drupal\d8dev_migrate\Plugin\migrate\source;

use Drupal\migrate\Row;

/**
 * Extract content from Wordpress site.
 *
 * @MigrateSource(
 *   id = "wordpress_content"
 * )
 */
class Content extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $prefix = $this->getPrefix();
    $query = $this->select($prefix . '_posts', 'p');
    $query
      ->fields('p', [
        'id',
        'post_date',
        'post_title',
        'post_content',
        'post_excerpt',
        'post_modified',
        'post_name'
      ]);
    $query->condition('p.post_status', 'publish');
    $query->condition('p.post_type', $this->getPostType());
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    return [
      'id'            => $this->t('Post ID'),
      'post_title'    => $this->t('Title'),
      'thumbnail'     => $this->t('Post Thumbnail'),
      'post_excerpt'  => $this->t('Excerpt'),
      'post_content'  => $this->t('Content'),
      'post_date'     => $this->t('Created Date'),
      'post_modified' => $this->t('Modified Date'),
      'path_alias'    => $this->t('URL Alias'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return [
      'id' => [
        'type'  => 'integer',
        'alias' => 'p',
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    // This will generate path alias using WP alias settings.
    $row->setSourceProperty('path_alias', $this->generatePathAlias($row));
    // Get thumbnail ID and pass it to the wp_media migration plugin.
    $row->setSourceProperty('thumbnail', $this->getPostThumbnail($row));
  }

}
