<?php
// Disallow the direct calling of this file
defined ( '_JEXEC' ) or die ();

// Get instance of controller with prefix "Exifworker"
$controller = JControllerLegacy::getInstance ( 'Exifworker' );

$task = JFactory::getApplication ()->input->getCmd ( 'task' );

// Execute each task of the request
$controller->execute ( $task );

// If a redirect is set in controller, then run it
$controller->redirect ();