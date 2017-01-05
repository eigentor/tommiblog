<?php
/**
 * @file
 * Contains \Drupal\tommiblog_migrate\Plugin\migrate\source\TommiblogNode.
 */

namespace Drupal\tommiblog_migrate\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;

/**
 * Drupal 8 node source from database.
 *
 * @MigrateSource(
 *   id = "tommiblog_node"
 * )
 */

class TommiblogNode extends SqlBase {

  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('node', 'n')
      ->condition('n.type', 'article')
      ->fields('n', array(
        'nid',
        'vid',
        'uuid',
        'langcode',
        'default_langcode',
        'title',
        'status',
        'created',
        'changed',
        'promote',
        'sticky',
      ));
    $query->orderBy('nid');
  return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = $this->baseFields();
    $fields['body/format'] = $this->t('Format of body');
    $fields['body/value'] = $this->t('Full text of body');
    $fields['body/summary'] = $this->t('Summary of body');
    return $fields;
  }


  public function prepareRow(Row $row) {

    // Aus ChapterThree Blogpost
    // https://www.chapterthree.com/blog/drupal-to-drupal-8-via-migrate-api
    // Migrate URL alias.
//    $alias = db_select('url_alias', 'ua')
//      ->fields('ua', ['alias'])
//      ->condition('ua.source', 'node/' . $nid)
//      ->execute()
//      ->fetchField();
//    if (!empty($alias)) {
//      $row->setSourceProperty('alias', '/' . $alias);
//    }
    $row->setSourceProperty('data', unserialize($row->getSourceProperty('data')));
    return parent::prepareRow($row);
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return array(
      'nid' => array(
        'type' => 'integer',
        'alias' => 'n',
      ),
    );
  }

}