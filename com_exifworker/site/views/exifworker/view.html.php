<?php

// Disallow the direct calling of this file
defined ( '_JEXEC' ) or die ();

/**
 * HTML View class for the component "exifworker"
 *
 * @author Rune Krauss
 * @version 1.0
 * @since 2015
 * @copyright (c) by Rune Krauss
 */
class ExifworkerViewExifworker extends JViewLegacy {
	/**
	 * A test
	 *
	 * @var string Test
	 */
	protected $test = '';
	
	// Die JViewLegacy::display() Methode wird �berschrieben
	public function display($tpl = null) {
		// Die Daten werden vom Model bezogen.
		$this->test = $this->get ( 'Test' );
		
		// Der View wird angezeigt.
		parent::display ( $tpl );
	}
}