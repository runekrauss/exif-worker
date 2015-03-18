<?php

// Disallow the direct calling of this file
defined ( '_JEXEC' ) or die ();

// Access check
if (! JFactory::getUser ()->authorise ( 'core.manage', 'com_exifworker' )) {
	return JError::raiseWarning ( 404, JText::_ ( 'COM_EXIFWORKER_JERROR_ALERTNOAUTHOR' ) );
}

// Register helper for access actions
JLoader::register ( 'ExifworkerHelper', JPATH_COMPONENT . '/helpers/exifworker.php' );

// Set some global property
$document = JFactory::getDocument ();
$document->addStyleDeclaration ( '.icon-exifworker {background-image: url(../media/com_exifworker/images/exif-16x16.png);}' );

// Import Joomla! Controller library
jimport ( 'joomla.application.component.controller' );

// Get instance of controller with prefix "Exifworker"
$controller = JControllerLegacy::getInstance ( 'Exifworker' );

$task = JFactory::getApplication ()->input->getCmd ( 'task' );

// Execute each task of the request
$controller->execute ( $task );

// If a redirect is set in controller, then run it
$controller->redirect ();