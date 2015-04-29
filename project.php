<?php
/**
 * Authors: Ahmed Ali Makhdoom
 * Created 12-06-14 11:56 PM
 */
ini_set('display_errors','On');
error_reporting(E_ALL);


require_once 'mysql.php';
require_once 'utils.php';

function getAllProjects() {
    global $mysqli;
    $result = $mysqli->query("SELECT projects.*,languages.name AS language,internal_name AS language_internal FROM ".
                PROJECTS_TABLE." LEFT JOIN ".PROJECT_LANGUAGES_TABLE." ON ".PROJECTS_TABLE.".id = ".
                    PROJECT_LANGUAGES_TABLE.".project_id ".
                "LEFT JOIN ".LANGUAGES_TABLE." ON ".PROJECT_LANGUAGES_TABLE.".language_id = ".LANGUAGES_TABLE.".id ".
                "ORDER BY languages.id,projects.name");
    if (!$result) die();

    $projects = array();
    while ($p = $result->fetch_object())
        $projects[$p->language][] = $p;
    return $projects;
}

function getProjectObj($project_id) {
    global $mysqli;
    $project_id = $mysqli->real_escape_string( $project_id );
    //Faster to process result from one big join than send multiple queries
    $result = $mysqli->query(
                "SELECT ".PROJECTS_TABLE.".id AS id,".PROJECTS_TABLE.".name,description,version,directory,image,".
                    LANGUAGES_TABLE.".name AS languages,".EXTENSIONS_TABLE.".name AS extensions,readable ".
                "FROM (".PROJECTS_TABLE." LEFT JOIN ".PROJECT_LANGUAGES_TABLE." ON ".PROJECTS_TABLE.".id=".
                    PROJECT_LANGUAGES_TABLE.".project_id) ".
                "LEFT JOIN ".LANGUAGES_TABLE." ON ".PROJECT_LANGUAGES_TABLE.".language_id=".LANGUAGES_TABLE.".id ".
                "LEFT JOIN ".EXTENSIONS_TABLE." ON ".LANGUAGES_TABLE.".id=".EXTENSIONS_TABLE.".language_id ".
                "WHERE projects.id = $project_id ");
    if (!$result) die($mysqli->error);

    $project = $result->fetch_object();
    $project->languages = array($project->languages);
    $project->extensions = array($project->extensions => $project->readable);
    unset($project->readable);

    $projects = array();
    $curr_id = 0;
    while ($row = $result->fetch_object()) {
        $project->languages[] = $row->languages;
        $project->extensions[$row->extensions] = $row->readable;
    }

    $project->languages = array_unique($project->languages);
    return $project;
}

function listProjectFiles($project) {
	echo '.'.DIRECTORY_SEPARATOR.$project->directory;
    if (empty($project->directory) || !chdir('.'.DIRECTORY_SEPARATOR.$project->directory))
        return;
    global $first_id;
    $first_id = null;
    listDirFiles('.', $project->extensions);
}

/**
 * @param $dir directory to search files in
 * @param $extensions associative array containing all acceptable project file extensions as keys
 * (e.g. for a Java project, array('java'=>1, 'jar'=>1)). Key values are ignored
 */
function listDirFiles($dir, &$extensions) {
    if (!($handle = opendir($dir))) return null; //readability wins

    //Loop through each file
    while (($file = readdir($handle)) !== false) {

        $path = $dir.DIRECTORY_SEPARATOR.$file;
        //HTML < 5 only allows for - _ . : and colons are usually invalid for file names
        $id = substr(str_replace(DIRECTORY_SEPARATOR, ':', $path), 2);

        if (substr($file, 0, 1) != '.') { //Don't want hidden files or "." and ".."
            //If directory, recurse into it
            if(is_dir($path)) {
                echo '<li id="'.$id.'" rel="folder"><a href="#">'.$file.'</a><ul>';
                listDirFiles($path, $extensions);
                echo '</ul></li>';
            }
            //Otherwise, check if the file extension is accepted
            else {
                $ext = strtolower( pathinfo($path, PATHINFO_EXTENSION) );
                if (isset($extensions[$ext])) {
                    echo '<li id="'.$id.'" rel="'.$ext.'"><a href="#">'.$file.'</a></li>';
                }
            }
        }
    }

}

?>