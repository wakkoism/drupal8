<?php

namespace Drupal\d8dev_migrate\Plugin\migrate\source;

use Drupal\migrate\Row;

/**
 * Extract content thumbnails.
 *
 * @MigrateSource(
 *   id = "wordpress_thumbnail"
 * )
 */
class Thumbnail extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $prefix = $this->getPrefix();
    $query = $this->select($prefix . '_postmeta', 'pm', ['target' => 'migrate']);
    $query->innerJoin($prefix . '_posts', 'p', 'p.id = pm.post_id');
    $query->fields('pm', ['post_id']);
    $query->fields('p', ['post_date']);
    $query->addField('pm', 'post_id', 'file_id');
    $query->addField('pm', 'meta_value', 'filepath');
    $query
      ->condition('pm.meta_key', '_wp_attached_file')
      ->condition('p.post_type', 'attachment');
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    return [
      'post_id'   => $this->t('Post ID'),
      'post_date' => $this->t('Media Uploaded Date'),
      'file_id'   => $this->t('File ID'),
      'filepath'  => $this->t('File Path'),
      'filename'  => $this->t('File Name'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return [
      'post_id' => [
        'type'  => 'integer',
        'alias' => 'pm',
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    $row->setSourceProperty('filename', basename($row->getSourceProperty('filepath')));
  }

}
