<?php

namespace Drupal\nutrition_info\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

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
class  NutritioninfoDefaultWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = [];
    return $element;
  }

}
