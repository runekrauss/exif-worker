<?php

// Disallow the direct calling of this file
defined ( '_JEXEC' ) or die ();

// Import Joomla! JModelAdmin class
jimport ( 'joomla.application.component.modeladmin' );

/**
 * Model for editing an item
 * It will be called by controller and view
 *
 * @author Rune Krauss
 * @version 1.0
 * @since 2015
 * @copyright (c) by Rune Krauss
 */
class ExifworkerModelExifworkerEdit extends JModelAdmin {
	/**
	 * Returns a reference to the Table object, always creating it
	 *
	 * @param string $name
	 *        	The table name. Optional.
	 * @param string $prefix
	 *        	The class prefix. Optional.
	 * @param array $options
	 *        	Configuration array for model. Optional.
	 * @return JTable Table object
	 * @access public
	 */
	public function getTable($name = 'Exifworker', $prefix = 'ExifworkerTable', $options = array()) {
		return JTable::getInstance ( $name, $prefix, $options );
	}
	
	/**
	 * Method to get the record form
	 *
	 * @param array $data
	 *        	Data for the form
	 * @param boolean $loadData
	 *        	True if the form is to load its own data (default case), false if not
	 *        	
	 * @return mixed A JForm object on success, false on failure
	 * @access public
	 */
	public function getForm($data = array(), $loadData = true) {
		// Get the form.
		$form = $this->loadForm ( 'com_exifworker.exifworker', 'exifworkeredit', array (
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
	 * Method to get the script that displays Google Maps
	 *
	 * @return string Script file
	 * @access public
	 */
	public function getMaps() {
		return '/administrator/components/com_exifworker/assets/js/maps.js';
	}
	
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @since 1.6
	 * @return mixed The data for the form.
	 * @access protected
	 */
	protected function loadFormData() {
		// Check the session for previously entered form data.
		$data = JFactory::getApplication ()->getUserState ( 'com_exifworker.edit.exifworker.data' );
		
		if (empty ( $data )) {
			$data = $this->getItem ();
		}
		
		return $data;
	}
	
	/**
	 * Get author from table "exifworker" by ExifworkerId
	 *
	 * @return String Author
	 * @access public
	 */
	public function getAuthor($exifworkerId) {
		// Get a db connection.
		$db = JFactory::getDbo ();
		// Create a new query object.
		$query = $db->getQuery ( true );
		
		// Select all records from the table "exifworker" join the table "users"
		$query->select ( $db->quoteName ( array (
				'a.username' 
		) ) )->from ( $db->quoteName ( '#__users', 'a' ) )->join ( 'INNER', $db->quoteName ( '#__exifworker', 'b' ) . ' ON (' . $db->quoteName ( 'a.id' ) . ' = ' . $db->quoteName ( 'b.UserId' ) . ')' )->where ( $db->quoteName ( 'b.ExifworkerId' ) . ' = ' . $exifworkerId );
		
		// Reset the query using our newly populated query object.
		$db->setQuery ( $query );
		$author = $db->loadResult ();
		
		return $author;
	}
	
	/**
	 * Saves the image data in the table "exifworker"
	 *
	 * @return void
	 * @access public
	 */
	public function saveImage($jinput) {
		$posts = $jinput->post->getArray ();
		$gets = $jinput->get->getArray ();
		
		// Get image name
		$imageName = trim ( htmlspecialchars ( $posts ["jform"] ["imageName"] ) );
		
		// Get exif data from the jform
		$exifArtist = trim ( htmlspecialchars ( $posts ["jform"] ["exifArtist"] ) );
		$exifComment = trim ( htmlspecialchars ( $posts ["jform"] ["exifComment"] ) );
		$exifCopyright = trim ( htmlspecialchars ( $posts ["jform"] ["exifCopyright"] ) );
		$exifDateTime = trim ( htmlspecialchars ( $posts ["jform"] ["exifDateTime"] ) );
		$exifImageLength = trim ( htmlspecialchars ( $posts ["jform"] ["exifImageLength"] ) );
		$exifImageWidth = trim ( htmlspecialchars ( $posts ["jform"] ["exifImageWidth"] ) );
		$exifGPSDateStamp = trim ( htmlspecialchars ( $posts ["jform"] ["exifGPSDateStamp"] ) );
		$exifGPSLatitude = trim ( htmlspecialchars ( $posts ["jform"] ["exifGPSLatitude"] ) );
		$exifGPSLatitudeRef = trim ( htmlspecialchars ( $posts ["jform"] ["exifGPSLatitudeRef"] ) );
		$exifGPSLongitude = trim ( htmlspecialchars ( $posts ["jform"] ["exifGPSLongitude"] ) );
		$exifGPSLongitudeRef = trim ( htmlspecialchars ( $posts ["jform"] ["exifGPSLongitudeRef"] ) );
		$exifImageDescription = trim ( htmlspecialchars ( $posts ["jform"] ["exifImageDescription"] ) );
		$exifMake = trim ( htmlspecialchars ( $posts ["jform"] ["exifMake"] ) );
		$exifModel = trim ( htmlspecialchars ( $posts ["jform"] ["exifModel"] ) );
		$exifSoftware = trim ( htmlspecialchars ( $posts ["jform"] ["exifSoftware"] ) );
		
		// Get ExifworkerId from superglobal parameter GET
		$exifworkerId = trim ( $gets ["id"] );
		
		// Get file name with format
		$fileName = $this->getFileName ( $exifworkerId );
		$absPath = JPATH_ROOT . "/images/exifworker/";
		
		// Create an imagick object with the file name
		$im = new imagick ( $absPath . $fileName );
		
		// Update exif data with the new entries
		$im->setImageProperty ( 'exif:Artist', $exifArtist );
		$im->setImageProperty ( 'exif:Comment', $exifComment );
		$im->setImageProperty ( 'exif:Copyright', $exifCopyright );
		
		$im->setImageProperty ( 'exif:DateTime', $exifDateTime );
		$im->setImageProperty ( 'exif:DateTimeDigitized', $exifDateTime );
		$im->setImageProperty ( 'exif:DateTimeOriginal', $exifDateTime );
		
		$im->setImageProperty ( 'exif:ImageLength', $exifImageLength );
		$im->setImageProperty ( 'exif:ImageWidth', $exifImageWidth );
		$im->setImageProperty ( 'exif:GPSDateStamp', $exifGPSDateStamp );
		$im->setImageProperty ( 'exif:GPSLatitude', $exifGPSLatitude );
		$im->setImageProperty ( 'exif:GPSLatitudeRef', $exifGPSLatitudeRef );
		$im->setImageProperty ( 'exif:GPSLongitude', $exifGPSLongitude );
		$im->setImageProperty ( 'exif:GPSLongitudeRef', $exifGPSLongitudeRef );
		$im->setImageProperty ( 'exif:ImageDescription', $exifImageDescription );
		$im->setImageProperty ( 'exif:Make', $exifMake );
		$im->setImageProperty ( 'exif:Model', $exifModel );
		$im->setImageProperty ( 'exif:Software', $exifSoftware );
		
		// Get the EXIF information
		$exifArray = $im->getImageProperties ( "exif:*" );
		$json = json_encode ( $exifArray );
		
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
				'LastEdited',
				'UserId' 
		);
		
		// Fields to update
		$fields = array (
				$db->quoteName ( 'Name' ) . ' = ' . $db->quote ( $imageName ),
				$db->quoteName ( 'Path' ) . ' = ' . $db->quote ( "../images/exifworker/" . $fileName ),
				$db->quoteName ( 'Exif' ) . ' = ' . $db->quote ( $json ),
				$db->quoteName ( 'LastEdited' ) . ' = ' . $db->quote ( $dateTime ),
				$db->quoteName ( 'UserId' ) . ' = ' . $user->get ( 'id' ) 
		);
		
		// Conditions for which records should be updated
		$conditions = array (
				$db->quoteName ( 'ExifworkerId' ) . ' = ' . $exifworkerId 
		);
		// Prepare the insert query
		$query->update ( $db->quoteName ( '#__exifworker' ) )->set ( $fields )->where ( $conditions );
		
		// Set the query using our newly populated query object and execute it
		$db->setQuery ( $query );
		$db->execute ();
	}
	
	/**
	 * Saves the image data in the table "exifworker"
	 *
	 * @param array $jinput
	 *        	All post parameters
	 * @return void
	 * @access public
	 */
	public function clearImage($jinput) {
		$gets = $jinput->get->getArray ();
		
		$exifworkerId = $gets ["id"];
		
		$fileName = $this->getFileName ( $exifworkerId );
		$absPath = JPATH_ROOT . "/images/exifworker/";
		
		// Remove all exif data from the image
		$img = new imagick ( $absPath . $fileName );
		$img->stripImage ();
		$img->writeImage ( $absPath . $fileName );
		$img->destroy ();
		
		// Create a new imagick object
		$im = new imagick ( $absPath . $fileName );
		
		// Get the EXIF information
		$exifArray = $im->getImageProperties ( "exif:*" );
		$json = json_encode ( $exifArray );
		
		// Load global JUser instance
		$user = JFactory::getUser ();
		
		// Get timestamp
		$dateTime = ExifworkerHelper::getDateTime ();
		
		// Get a db connection
		$db = JFactory::getDbo ();
		// Create a new query object
		$query = $db->getQuery ( true );
		
		// Insert columns.
		$columns = array (
				'Exif',
				'LastEdited',
				'UserId' 
		);
		
		// Fields to update
		$fields = array (
				$db->quoteName ( 'Exif' ) . ' = ' . $db->quote ( $json ),
				$db->quoteName ( 'LastEdited' ) . ' = ' . $db->quote ( $dateTime ),
				$db->quoteName ( 'UserId' ) . ' = ' . $user->get ( 'id' ) 
		);
		
		// Conditions for which records should be updated
		$conditions = array (
				$db->quoteName ( 'ExifworkerId' ) . ' = ' . $exifworkerId 
		);
		
		// Prepare the insert query
		$query->update ( $db->quoteName ( '#__exifworker' ) )->set ( $fields )->where ( $conditions );
		
		// Set the query using our newly populated query object and execute it
		$db->setQuery ( $query );
		$db->execute ();
	}
	
	/**
	 * Get filename by ExifworkerId
	 *
	 * @return String Filename
	 * @access private
	 */
	private function getFileName($exifworkerId) {
		// Get a db connection
		$db = JFactory::getDbo ();
		// Create a new query object
		$query = $db->getQuery ( true );
		
		// Select all records from the exifworker table with the actually ExifworkerId.
		$query->select ( 'Path' );
		$query->from ( $db->quoteName ( '#__exifworker' ) );
		$query->where ( $db->quoteName ( 'ExifworkerId' ) . ' = ' . $exifworkerId );
		
		// Reset the query using our newly populated query object
		$db->setQuery ( $query );
		$imagePath = $db->loadResult ();
		
		$pathParts = explode ( "/", $imagePath );
		$fileName = array_pop ( $pathParts );
		
		return $fileName;
	}
}