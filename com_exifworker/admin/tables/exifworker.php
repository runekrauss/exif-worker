<?php
// Disallow the direct calling of this file
defined ( '_JEXEC' ) or die ();

// Import JTable class
jimport ( 'joomla.database.table' );

/**
 * Table for database operations
 *
 * @author Rune Krauss
 * @version 1.0
 * @copyright (c) by Rune Krauss
 */
class ExifworkerTableExifworker extends JTable {
	/**
	 * Constructor for this table
	 *
	 * @param JDatabase $db
	 *        	JDatabase connector object
	 * @access public
	 */
	public function __construct(&$db) {
		parent::__construct ( '#__exifworker', 'ExifworkerId', $db );
	}
	
	/**
	 * Method to bind elements
	 *
	 * @return Object Elements
	 * @access public
	 */
	public function bind($array, $ignore = '') {
		if (isset ( $array ['params'] ) && is_array ( $array ['params'] )) {
			// Convert the params field to a string.
			$parameter = new JRegistry ();
			$parameter->loadArray ( $array ['params'] );
			$array ['params'] = ( string ) $parameter;
		}
		
		return parent::bind ( $array, $ignore );
	}
	
	/**
	 * Method to compute the default name of the asset.
	 * The default name is in the form `table_name.id`
	 * where id is the value of the primary key of the table.
	 *
	 * @return string Asset
	 */
	protected function _getAssetName() {
		$k = $this->_tbl_key;
		
		return 'com_exifworker.message.' . ( int ) $this->$k;
	}
}