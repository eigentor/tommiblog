This module provides database export functionality with help from a php version of mysqldump. The library (https://github.com/ifsnop/mysqldump-php) supports the following features.

 - output binary blobs as hex.
 - resolves view dependencies (using Stand-In tables).
 - output compared against original mysqldump. Linked to travis-ci testing system.
 - dumps stored procedures.
 - does extended-insert and/or complete-insert.
 
This module depends upon Composer Manager to install the mysqldump-php library; please follow the installation section below.

Installation (@ref, http://cgit.drupalcode.org/address/tree/README.md)

1. Download [composer_manager](https://drupal.org/project/composer_manager) into your
   `modules` directory.

2. From the Drupal root directory, initialize composer_manager, and run it for the first time:
php modules/composer_manager/scripts/init.php
composer drupal-update

This will download the required libraries into the root vendor/ directory.

3. Enable the Backup Database module.

More information
 - https://www.drupal.org/node/2405811
 
Credits
 - ifsnop (https://github.com/ifsnop)
 