<?php

/**
 * @file
 * Contains Drupal\tommiblog_migrate\Plugin\migrate\source\TommiblogTags.
 */

namespace Drupal\tommiblog_migrate\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Taxonomy: Tags.
 *
 * @MigrateSource(
 *   id = "tommiblog_tags"
 * )
 */
class TommiblogTags extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('taxonomy_term_data', 'td');
    $query->join('taxonomy_index', 'ti', 'ti.tid = td.tid');
    $query->fields('td', ['tid', 'vid', 'name', 'description__value', 'weight'])
      ->distinct()
      ->condition('td.vid', 'tags');
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    return [
      'name'        => $this->t('Category name'),
      'description__value' => $this->t('Description'),
      'weight'      => $this->t('Weight'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return [
      'tid' => [
        'type'  => 'integer',
        'alias' => 'td',
      ],
    ];
  }

}