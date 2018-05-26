<?php

namespace Drupal\d8dev\Controller;

/**
 * Provides route responses for the d8dev module.
 */
class D8devController {

  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function myPage() {
    $element = [
      '#type' => 'markup',
      '#markup' => t('Hello World!'),
    ];
    return $element;
  }

}
