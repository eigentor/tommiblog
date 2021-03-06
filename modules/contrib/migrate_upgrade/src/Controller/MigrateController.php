<?php

/**
 * @file
 * Contains \Drupal\migrate_upgrade\Controller\MigrateController.
 */

namespace Drupal\migrate_upgrade\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Provides controller methods for the migration.
 */
class MigrateController extends ControllerBase {

  /**
   * Sets a log filter and redirects to the log.
   *
   * @return \Symfony\Component\HttpFoundation\RedirectResponse
   *   A redirect response object that may be returned by the controller.
   */
  public function showLog() {
    $_SESSION['dblog_overview_filter'] = [];
    $_SESSION['dblog_overview_filter']['type'] = ['migrate_upgrade' => 'migrate_upgrade'];
    return $this->redirect('dblog.overview');
  }

}
