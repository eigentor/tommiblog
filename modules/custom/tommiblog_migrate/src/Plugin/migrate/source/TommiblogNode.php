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

class TommiblogNode extends DrupalSqlBase {

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
  }

}