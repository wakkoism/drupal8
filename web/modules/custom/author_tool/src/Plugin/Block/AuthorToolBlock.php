<?php

namespace Drupal\author_tool\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;

/**
 * Provides a custom block.
 *
 * Drupal\Core\Block\BlockBase gives us a very useful set of basic functionality
 * for this configurable block. We can just fill in a few of the blanks with
 * defaultConfiguration(), blockForm(), blockSubmit(), and build().
 *
 * @Block(
 *   id = "author_tool_block",
 *   admin_label = @Translation("Author tool block")
 * )
 */
class AuthorToolBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $link = [
      '#type' => 'link',
      '#title' => $this->t('Add another recipe'),
      '#url' => Url::fromRoute('node.add', ['node_type' => 'recipe']),
    ];
    return $link;
  }

}
