<?php

namespace Drupal\nutrition_info\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\nutrition_info\Plugin\Field\FieldType\NutritionInfoItem;

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
    $elements = [];
    $field_property = NutritionInfoItem::nutritionItemPropertyField();
    $set_headers = FALSE;

    foreach ($items as $delta => $item) {
      $data = [];
      foreach ($field_property as $field_name => $property) {
        $data[] = $item->{$field_name};
        if (!$set_headers) {
          $priority_class = '';

          switch ($property['priority']) {
            case 2:
              $priority_class = ['priority', 'priority-medium'];
              break;

            case 3:
              $priority_class = ['priority', 'priority-low'];
              break;

            default:
              $priority_class = [];
              break;
          }
          $headers[] = [
            'data' => $property['label'],
            'class' => $priority_class,
          ];
        }
      }
      $set_headers = TRUE;
      $rows[] = [
        'data' => $data,
      ];
    }

    if (!empty($headers)) {
      $elements = [
        '#type' => 'table',
        '#header' => $headers,
        '#rows' => $rows,
        '#attributes' => [
          'id' => 'nutrition-info',
        ],
      ];
    }
    return $elements;
  }

}
