<?php
ini_set('display_errors','On');
error_reporting(E_ALL);

/**
 * Authors: Ahmed Ali Makhdoom
 * Created 12-06-17 10:09 PM
 *
 * Useful functions
 */

/**
 * Gets specified GET/POST parameter value or dies trying
 */
function _get($var) {
    if (empty($_REQUEST[$var]))
        die();
    else
        return $_REQUEST[$var];
}

?>