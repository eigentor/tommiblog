<?php
/**
 * @file
 * Contains \Drupal\tommiblog_migrate\Plugin\migrate\source\TommiblogNode.
 */

namespace Drupal\tommiblog_migrate\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\DrupalSqlBase;
use Drupal\migrate\Row;

/**
 * Drupal 8 node source from database.
 *
 * @MigrateSource(
 *   id = "tommiblog_node"
 * )
 */

class TommiblogNode extends DrupalSqlBase {

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
      ));
    $query->orderBy('nid');
  return $query;
  }

     /**
     * {@inheritdoc}
     */
    public function fields() {
      $fields = $this->baseFields();
      $fields = array(
        'body_format'=> $this->t('Input Format of the body field.'),
        'body_value'=> $this->t('Value of the full body field.'),
        'body_summary'=> $this->t('Value of the body teaser field.'),
      );
      return $fields;
    }


  /**
   * Returns the user base fields to be migrated.
   *
   * @return array
   *   Associative array having field name as key and description as value.
   */
  protected function baseFields() {
    $fields = array(
      'nid' => $this->t('Node ID'),
      'vid' => $this->t('Version ID'),
      'uuid' => $this->t('UUID'),
      'type' => $this->t('Type'),
      'langcode' => $this->t('Language (fr, en, ...)'),
      'default_langcode' => $this->t('Default Language (fr, en, ...)'),
      'title' => $this->t('Title'),
      'uid' => $this->t('uid'),
      'format' => $this->t('Format'),
      'teaser' => $this->t('Teaser'),
      'node_uid' => $this->t('Node authored by (uid)'),
      'revision_uid' => $this->t('Revision authored by (uid)'),
      'created' => $this->t('Created timestamp'),
      'changed' => $this->t('Modified timestamp'),
      'status' => $this->t('Published'),
      'promote' => $this->t('Promoted to front page'),
      'sticky' => $this->t('Sticky at top of lists'),
      'revision' => $this->t('Create new revision'),
      'timestamp' => $this->t('The timestamp the latest revision of this node was created.'),
    );
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