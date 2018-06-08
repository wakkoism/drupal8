<?php

namespace Drupal\nutrition_info\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\nutrition_info\Plugin\Field\FieldType\NutritionInfoItem;

/**
 * Plugin implementation of the 'nutritioninfo_default' widget.
 *
 * @FieldWidget(
 *   id = "nutritioninfo_default",
 *   label = @Translation("Nutrition Field Widget"),
 *   field_types = {
 *      "nutrition_info"
 *   }
 * )
 */
class NutritioninfoDefaultWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = [];
    $field_property = NutritionInfoItem::nutritionItemPropertyField();

    foreach ($field_property as $field_name => $property) {
      $element[$field_name] = [
        '#title' => $property['label'],
        '#description' => $property['description'],
        '#type' => 'textfield',
        '#default_value' => isset($items[$delta]->{$field_name}) ? $items[$delta]->{$field_name} : NULL,
      ];
    }
    return $element;
  }

}
