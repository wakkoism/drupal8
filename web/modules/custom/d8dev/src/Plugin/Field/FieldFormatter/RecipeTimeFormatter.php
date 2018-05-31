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

      // The text value has no text format assigned to it, so the user input
      // should equal the output, including newlines.
      $elements[$delta] = [
        '#theme' => 'recipe_time_display',
        '#hours' => $hours,
      ];
      if ($minutes_gcd !== FALSE) {
        $elements[$delta]['#fraction'] = [
          'top' => $minutes / $minutes_gcd,
          'bottom' => 60 / $minutes_gcd,
        ];
      }
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
    // Avoid non zero numbers.
    if ($b === 0) {
      return FALSE;
    }
    return ($a % $b) ? $this->gcd($b, abs($a - $b)) : $b;
  }

}
