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
      'uid' => $this->t('Node author UID'),
      'status' => $this->t('Published or not'),
      'created' => $this->t('Created timestamp'),
      'changed' => $this->t('Modified timestamp'),
      'promote' => $this->t('Promoted to front page'),
      'sticky' => $this->t('Sticky at top of lists'),
      'revision' => $this->t('Create new revision'),
      'timestamp' => $this->t('The timestamp the latest revision of this node was created.'),
    );
    return $fields;

  }


  public function prepareRow(Row $row) {
    $nid = $row->getSourceProperty('nid');

    // Get all the base fields from node_field_data
    $result = $this->getDatabase()->query('
      SELECT
        nd.langcode,
        nd.default_langcode,
        nd.title,
        nd.uid,
        nd.status,
        nd.created,
        nd.changed,
        nd.promote,
        nd.sticky
      FROM
        {node_field_data} nd
      WHERE
        nd.nid = :nid
    ', array(':nid' => $nid));
    foreach ($result as $record) {
      $row->setSourceProperty('langcode', $record->langcode );
      $row->setSourceProperty('default_langcode', $record->langcode );
      $row->setSourceProperty('title', $record->title );
      $row->setSourceProperty('uid', $record->uid );
      $row->setSourceProperty('status', $record->status );
      $row->setSourceProperty('created', $record->created );
      $row->setSourceProperty('changed', $record->changed );
      $row->setSourceProperty('promote', $record->promote );
      $row->setSourceProperty('sticky', $record->sticky );
    }

    // body (compound field with value, summary, and format)
    $result = $this->getDatabase()->query('
      SELECT
        fld.body_value,
        fld.body_summary,
        fld.body_format
      FROM
        {node__body} fld
      WHERE
        fld.entity_id = :nid
    ', array(':nid' => $nid));
    foreach ($result as $record) {
      $row->setSourceProperty('body_value', $record->body_value );
      $row->setSourceProperty('body_summary', $record->body_summary );
      $row->setSourceProperty('body_format', $record->body_format );
    }

    // images
    $result = $this->getDatabase()->query('
      SELECT
        fld.langcode,
        fld.delta,
        fld.field_image_target_id,
        fld.field_image_alt,
        fld.field_image_title,
        fld.field_image_width,
        fld.field_image_height
      FROM
        {node__field_image} fld
      WHERE
        fld.entity_id = :nid
    ', array(':nid' => $nid));
    // Create an associative array for each row in the result. The keys
    // here match the last part of the column name in the field table.
    $images = [];
    foreach ($result as $record) {
      $images[] = [
        'langcode' => $record->langcode,
        'delta' => $record->delta,
        'target_id' => $record->field_image_target_id,
        'alt' => $record->field_image_alt,
        'title' => $record->field_image_title,
        'width' => $record->field_image_width,
        'height' => $record->field_image_height,
      ];
    }
    $row->setSourceProperty('images', $images);

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
    //$row->setSourceProperty('data', unserialize($row->getSourceProperty('data')));
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