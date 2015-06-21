<?php

// Disallow the direct calling of this file
defined ( '_JEXEC' ) or die ();

// Import Joomla! JControllerAdmin class
jimport ( 'joomla.application.component.controlleradmin' );

/**
 * Controller for list of items
 * It will be run by front controller
 *
 * @author Rune Krauss
 * @version 1.0
 * @copyright (c) by Rune Krauss
 */
class ExifworkerControllerExifworkerList extends JControllerAdmin {
	
	/**
	 * Proxy for getModel
	 *
	 * @param String $name
	 *        	Name of Model ExifworkerEdit
	 * @param String $prefix
	 *        	Prefix of Model ExifworkerEdit
	 * @param array $config
	 *        	List of ignore requests
	 * @access protected
	 */
	public function getModel($name = 'ExifworkerEdit', $prefix = 'ExifworkerModel', $config = array('ignore_request' => true)) {
		return parent::getModel ( $name, $prefix, $config );
	}
	
	/**
	 * Delete item or items of the list
	 *
	 * @param String $name
	 *        	Name of Model ExifworkerEdit
	 * @param String $prefix
	 *        	Prefix of Model ExifworkerEdit
	 * @param array $config
	 *        	List of ignore requests
	 * @return void
	 * @access public
	 */
	public function delete() {
		// Get input parameters
		$jinput = JFactory::getApplication ()->input;
		// Get model of this controller
		$model = $this->getModel ( "ExifworkerList" );
		$model->deleteImages ( $jinput );
		parent::delete ();
	}
}