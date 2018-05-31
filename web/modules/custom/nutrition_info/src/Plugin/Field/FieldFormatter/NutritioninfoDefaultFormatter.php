<?php

namespace Drupal\nutrition_info\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'nutritioninfo_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "nutritioninfo_formatter",
 *   label = @Translation("Nutritioninfo Formatter"),
 *   field_types = {
 *     "nutrition_info"
 *   }
 * )
 */
class NutritioninfoDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {

    return '';
  }
}
