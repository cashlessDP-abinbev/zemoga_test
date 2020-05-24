<?php

namespace Drupal\zemoga_haspe\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Provides a field type of baz.
 * 
 * @FieldType(
 *   id = "fname",
 *   label = @Translation("First name"),
 *   default_formatter = "fn_formatter",
 *   default_widget = "fn_widget",
 * )
 */

class UserFirstNameField extends FieldItemBase {

	/**
	 * {@inheritdoc}
	 */
	public static function schema(FieldStorageDefinitionInterface $field_definition) {
	  return array(
	    // columns contains the values that the field will store
	    'columns' => array(
	      // List the values that the field will save. This
	      // field will only save a single value, 'value'
	      'value' => array(
	        'type' => 'text',
	        'size' => 'tiny',
	        'not null' => FALSE,
	      ),
	    ),
	  );
	}

	/**
	 * {@inheritdoc}
	 */
	public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
	  $properties = [];
	  $properties['value'] = DataDefinition::create('string');

	  return $properties;
	}

	/**
	 * {@inheritdoc}
	 */
	public function isEmpty() {
	  $value = $this->get('value')->getValue();
	  return $value === NULL || $value === '';
	}

}
