<?php
/**
 * Authors: Ahmed Ali Makhdoom
 * Created 12-06-15 12:25 AM
 */
require_once 'config.php';

define('PROJECTS_TABLE', 'projects');
define('LANGUAGES_TABLE', 'languages');
define('PROJECT_LANGUAGES_TABLE', 'project_languages');
define('EXTENSIONS_TABLE', 'extensions');

$mysqli = new mysqli(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);

?>