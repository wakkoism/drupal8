<?php

namespace Drupal\nutrition_info\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'nutrition_info' field type.
 *
 * @FieldType(
 *   id = "nutrition_info",
 *   label = @Translation("Nutrition Information"),
 *   description = @Translation("This field stores a nutrition information as define by Microdata spec at http://schema.org/ NutritionInformation."),
 *   default_widget = "nutritioninfo_default",
 *   default_formatter = "nutritioninfo_formatter"
 * )
 */
class NutritionInfoItem extends FieldItemBase {

  /**
   * Returns an array of Nutrition fields.
   *
   * @return array
   *   And array of fields.
   */
  public static function nutritionItemPropertyField() {
    return [
      'calories' => [
        'label' => t('Calories'),
        'description' => t('The number of calories.'),
        'schema' => [
          'type' => 'varchar',
          'length' => 256,
          'not null' => FALSE,
        ],
      ],
      'carbohydrate_content' => [
        'label' => t('Carbohydrate Content'),
        'description' => t('The number of grams of carbohydrates.'),
        'schema' => [
          'type' => 'varchar',
          'length' => 256,
          'not null' => FALSE,
        ],
      ],
      'cholesterol_content' => [
        'label' => t('Cholesterol Content'),
        'description' => t('The number of milligrams of cholesterol.'),
        'schema' => [
          'type' => 'varchar',
          'length' => 256,
          'not null' => FALSE,
        ],
      ],
      'fat_content' => [
        'label' => t('Fat Content'),
        'description' => t('The number of grams of fat.'),
        'schema' => [
          'type' => 'varchar',
          'length' => 256,
          'not null' => FALSE,
        ],
      ],
      'fiber_content' => [
        'label' => t('Fiber Content'),
        'description' => t('The number of grams of fiber..'),
        'schema' => [
          'type' => 'varchar',
          'length' => 256,
          'not null' => FALSE,
        ],
      ],
      'protein_content' => [
        'label' => t('Protein Content'),
        'description' => t('The number of grams of protein.'),
        'schema' => [
          'type' => 'varchar',
          'length' => 256,
          'not null' => FALSE,
        ],
      ],
      'saturated_fat_content' => [
        'label' => t('Saturated Fat Content'),
        'description' => t('he number of grams of saturated fat.'),
        'schema' => [
          'type' => 'varchar',
          'length' => 256,
          'not null' => FALSE,
        ],
      ],
      'serving_size' => [
        'label' => t('Serving size'),
        'description' => t('The serving size, in terms of the number of volume or mass.'),
        'schema' => [
          'type' => 'varchar',
          'length' => 256,
          'not null' => FALSE,
        ],
      ],
      'sodium_content' => [
        'label' => t('Sodium Content'),
        'description' => t('The number of milligrams of sodium.'),
        'schema' => [
          'type' => 'varchar',
          'length' => 256,
          'not null' => FALSE,
        ],
      ],
      'sugar_content' => [
        'label' => t('Sugar Content'),
        'description' => t('he number of grams of sugar.'),
        'schema' => [
          'type' => 'varchar',
          'length' => 256,
          'not null' => FALSE,
        ],
      ],
      'trans_fat_content' => [
        'label' => t('Trans Fat Content'),
        'description' => t('The number of grams of trans fat.'),
        'schema' => [
          'type' => 'varchar',
          'length' => 256,
          'not null' => FALSE,
        ],
      ],
      'unsaturated_fat_content' => [
        'label' => t('Unsaturated fat Content'),
        'description' => t('The number of grams of unsaturated fat.'),
        'schema' => [
          'type' => 'varchar',
          'length' => 256,
          'not null' => FALSE,
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    $field_property = self::nutritionItemPropertyField();
    $schema = [];
    foreach ($field_property as $key => $property) {
      $schema['columns'][$key] = $property['schema'];
    }
    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $field_property = self::nutritionItemPropertyField();
    foreach ($field_property as $key => $property) {
      $properties[$key] = DataDefinition::create('string')
        ->setLabel($property['label'])
        ->setDescription($property['description']);
    }

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $field_property = self::nutritionItemPropertyField();
    $empty = TRUE;
    foreach ($field_property as $key => $property) {
      // Check to see if anyone of the fields are empty.
      if (!empty($this->get($key)->getValue())) {
        $empty = FALSE;
        break;
      }
    }
    return $empty;
  }

}
