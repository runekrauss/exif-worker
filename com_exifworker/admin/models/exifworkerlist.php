<?php

// Disallow the direct calling of this file
defined ( '_JEXEC' ) or die ( "Restricted access" );

// Import Joomla! modellist class
jimport ( 'joomla.application.component.modellist' );

jimport ( 'joomla.filesystem.file' );

/**
 * Model for list of items
 * It will be called by controller and view
 *
 * @author Rune Krauss
 * @version 1.0
 * @since 2015
 * @copyright (c) by Rune Krauss
 */
class ExifworkerModelExifworkerList extends JModelList {
	protected $rss = array ();
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return string SQL query
	 */
	protected function getListQuery() {
		// Refer a database object
		$db = JFactory::getDBO ();
		
		// Refer an empty object
		$query = $db->getQuery ( true );
		
		// From table "exifworker"...
		$query->from ( '#__exifworker' );
		
		// ... Choose a few fields
		$query->select ( 'ExifworkerId, Name, Path' );
		
		return $query;
	}
	/**
	 * Deletes images based on input parameters
	 *
	 * @return void
	 */
	public function deleteImages($jinput) {
		$posts = $jinput->post->getArray ();
		$exifWorkerIds = $posts ["cid"];
		
		// Get a db connection
		$db = JFactory::getDbo ();
		
		foreach ( $exifWorkerIds as $exifWorkerId ) {
			// Create a new query object
			$query = $db->getQuery ( true );
			/*
			 * Select all records from the exifworker table
			 * Refer to ExifworkerId
			 */
			$query->select ( 'Path' );
			$query->from ( $db->quoteName ( '#__exifworker' ) );
			$query->where ( $db->quoteName ( 'ExifworkerId' ) . ' = ' . $exifWorkerId );
			
			// Reset the query using our newly populated query object
			$db->setQuery ( $query );
			$this->rss [] = $db->loadResult ();
		}
		
		// Delete image respectively images
		foreach ( $this->rss as $rs ) {
			JFile::delete ( $rs );
		}
	}
}