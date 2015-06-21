<?php
// Disallow the direct calling of this file
defined ( '_JEXEC' ) or die ();

/**
 * Model displaying images in the frontend
 *
 * @author Rune Krauss
 * @version 1.0
 * @copyright (c) by Rune Krauss
 */
class ExifworkerModelExifworker extends JModelItem {
	/**
	 *
	 * @var string
	 */
	protected $test = 'Test';
	
	/**
	 * Returns a test
	 *
	 * @return string Test
	 */
	function getTest() {
		return $this->test;
	}
}