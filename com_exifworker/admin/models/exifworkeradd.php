<?php

// Disallow the direct calling of this file
defined ( '_JEXEC' ) or die ();

// Import Joomla! JModelAdmin class
jimport ( 'joomla.application.component.modeladmin' );

jimport ( 'joomla.filesystem.file' );

/**
 * Model for adding an item
 * It will be called by controller and view
 *
 * @author Rune Krauss
 * @version 1.0
 * @copyright (c) by Rune Krauss
 */
class ExifworkerModelExifworkerAdd extends JModelAdmin {
	/**
	 * Returns a reference to the a table object, always creating it
	 *
	 * @param string $name
	 *        	The table name. Optional.
	 * @param string $prefix
	 *        	The class prefix. Optional.
	 * @param array $options
	 *        	Configuration array for model. Optional.
	 *        	
	 * @return JTable
	 * @access public
	 */
	public function getTable($name = 'Exifworker', $prefix = 'ExifworkerTable', $options = array()) {
		return JTable::getInstance ( $name, $prefix, $options );
	}
	
	/**
	 * Method to get the record form.
	 *
	 * @param array $data
	 *        	Data for the form.
	 * @param boolean $loadData
	 *        	True if the form is to load its own data (default case), false if not.
	 *        	
	 * @return mixed A JForm object on success, false on failure
	 * @access public
	 */
	public function getForm($data = array(), $loadData = true) {
		// Get the form.
		$form = $this->loadForm ( 'com_exifworker.exifworker', 'exifworkeradd', array (
				'control' => 'jform',
				'load_data' => $loadData 
		) );
		
		if (empty ( $form )) {
			return false;
		}
		
		return $form;
	}
	
	/**
	 * Method to get the script that have to be included on the form
	 *
	 * @return string Script file
	 * @access public
	 */
	public function getScript() {
		return '/administrator/components/com_exifworker/assets/js/exifworker.js';
	}
	
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @since 1.6
	 * @return mixed The data for the form
	 * @access protected
	 */
	protected function loadFormData() {
		// Check the session for previously entered form data
		$data = JFactory::getApplication ()->getUserState ( 'com_exifworker.add.exifworker.data' );
		
		if (empty ( $data )) {
			$data = $this->getItem ();
		}
		
		return $data;
	}
	
	/**
	 * Check if the image already exists
	 *
	 * @param array $jinput
	 *        	All post parameters
	 * @return boolean Path
	 * @access public
	 */
	public function checkPath($jinput) {
		$files = $jinput->files->get ( 'jform' );
		$file = $files ['addImage'];
		
		// Get a db connection
		$db = JFactory::getDbo ();
		// Create a new query object
		$query = $db->getQuery ( true );
		
		// Select all records from the exifworker table
		$query->select ( 'COUNT(*)' );
		$query->from ( $db->quoteName ( '#__exifworker' ) );
		$query->where ( $db->quoteName ( 'Path' ) . ' = ' . $db->quote ( "../images/exifworker/" . trim ( htmlspecialchars ( $file ["name"] ) ) ) );
		
		// Reset the query using our newly populated query object
		$db->setQuery ( $query );
		$count = $db->loadResult ();
		
		return $count;
	}
	
	/**
	 * Uploads the image and inserts into the db
	 *
	 * @param array $jinput
	 *        	All post parameters
	 * @return boolean Path
	 * @access public
	 */
	public function addImage($jinput) {
		// Get filepath
		$files = $jinput->files->get ( 'jform' );
		$file = $files ['addImage'];
		$filename = trim ( htmlspecialchars ( $file ["name"] ) );
		
		$filePath = "../images/exifworker/" . $filename;
		$absPath = JPATH_ROOT . "/images/exifworker/" . $filename;
		
		// Upload image
		JFile::upload ( $file ["tmp_name"], $filePath );
		
		// Create the object
		$im = new imagick ( $absPath );
		
		// Get the EXIF information
		$exifArray = $im->getImageProperties ( "exif:*" );
		$json = json_encode ( $exifArray );
		
		$posts = $jinput->post->getArray ();
		// Get name from the input
		$name = $posts ["jform"] ["imageName"];
		
		// Load global JUser instance
		$user = JFactory::getUser ();
		
		// Get timestamp
		$dateTime = ExifworkerHelper::getDateTime ();
		
		// Get a db connection
		$db = JFactory::getDbo ();
		
		// Create a new query object
		$query = $db->getQuery ( true );
		
		// Insert columns
		$columns = array (
				'Name',
				'Path',
				'Exif',
				'CreationDate',
				'LastEdited',
				'UserId' 
		);
		
		// Insert values
		$values = array (
				$db->quote ( $name ),
				$db->quote ( $filePath ),
				$db->quote ( $json ),
				$db->quote ( $dateTime ),
				$db->quote ( $dateTime ),
				$user->get ( 'id' ) 
		);
		
		// Prepare the insert query
		$query->insert ( $db->quoteName ( '#__exifworker' ) )->columns ( $db->quoteName ( $columns ) )->values ( implode ( ',', $values ) );
		
		// Set the query using our newly populated query object and execute it
		$db->setQuery ( $query );
		$db->execute ();
		
		return $filePath;
	}
	
	/**
	 * Get ExifworkerId by filepath
	 *
	 * @param String $filePath
	 *        	Image path
	 * @return int ExifworkerId
	 * @access public
	 */
	public function getExifworkerId($filePath) {
		// Get a db connection
		$db = JFactory::getDbo ();
		// Create a new query object
		$query = $db->getQuery ( true );
		
		// Select all records from the exifworker table
		$query->select ( 'ExifworkerId' );
		$query->from ( $db->quoteName ( '#__exifworker' ) );
		$query->where ( $db->quoteName ( 'Path' ) . ' = ' . $db->quote ( $filePath ) );
		
		// Reset the query using our newly populated query object
		$db->setQuery ( $query );
		$exifworkerId = $db->loadResult ();
		
		return $exifworkerId;
	}
}