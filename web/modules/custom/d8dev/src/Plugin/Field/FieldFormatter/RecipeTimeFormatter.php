<?php

namespace Drupal\d8dev\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'recipe_time' formatter.
 *
 * @FieldFormatter(
 *   id = "recipe_time",
 *   label = @Translation("Duration"),
 *   field_types = {
 *     "integer",
 *     "decimal",
 *     "float"
 *   }
 * )
 */
class RecipeTimeFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $hours = floor($item->value / 60);

      $minutes = $item->value % 60;

      $minutes_gcd = $this->gcd($minutes, 60);

      $minutes_fraction = $minutes / $minutes_gcd . '/' . 60 / $minutes_gcd;

      $markup = $hours > 0
        ? $hours . ' and ' . $minutes_fraction . 'hours'
        : $minutes_fraction . ' hours';
      // The text value has no text format assigned to it, so the user input
      // should equal the output, including newlines.
      $elements[$delta] = [
        '#theme' => 'recipe_time_display',
        '#value' => $markup,
      ];
    }

    return $elements;
  }

  /**
   * Helper function to get greatest common denominator.
   *
   * @param int $a
   *   The first number of the greatest common denominator.
   * @param int $b
   *   The second number of the greatest common denominator.
   */
  private function gcd($a, $b) {
    $b = ($a == 0) ? 0 : $b;
    return ($a % $b ) ? $this->gcd($b, abs($a - $b)) : $b;
  }

}
