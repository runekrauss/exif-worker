<?php

// Disallow the direct calling of this file
defined ( '_JEXEC' ) or die ();

/**
 * General controller for this component
 * At first, this controller is called by the component
 *
 * @author Rune Krauss
 * @version 1.0
 * @copyright (c) by Rune Krauss
 */
class ExifworkerController extends JControllerLegacy {
	/**
	 * display task
	 *
	 * @param bool $cachable
	 *        	If true, the view output will be cache
	 * @param bool $urlparams
	 *        	Parameters of the url
	 *        	
	 * @return void
	 * @access public
	 */
	public function display($cachable = false, $urlparams = false) {
		// Set the default view
		JRequest::setVar ( 'view', JRequest::getCmd ( 'view', 'ExifworkerList' ) );
		
		// Call the display method of parent class
		parent::display ( $cachable, $urlparams );
	}
}