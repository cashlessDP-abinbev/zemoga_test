<?php

namespace Drupal\zemoga_haspe\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'fname' formatter.
 *
 * @FieldFormatter(
 *   id = "fname",
 *   label = @Translation("Random text"),
 *   field_types = {
 *     "Random"
 *   }
 * )
 */
class UserFirstNameFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $summary[] = $this->t('Displays the random string.');
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];

    foreach ($items as $delta => $item) {
      // Render each element as markup.
      $element[$delta] = ['#markup' => $item->value];
    }

    return $element;
  }

}