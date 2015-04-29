<?php
/**
 * Ajax script for loading files
 * Authors: Ahmed Ali Makhdoom
 * Created 12-06-13 12:49 AM
 */
require_once 'utils.php';
require_once 'project.php';

$func = _get('func');
switch ($func) {
    case 'get_file':
        $project = getProjectObj( _get('id') );
        $file = str_replace(':', DIRECTORY_SEPARATOR, _get('file'));
        $path = $project->directory . DIRECTORY_SEPARATOR . $file;
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if (isset($project->extensions[$ext]) && $project->extensions[$ext] == true)
            echo htmlentities( file_get_contents($path) );
        break;
}



?>