<?php

// Disallow the direct calling of this file
defined ( '_JEXEC' ) or die ();

/**
 * Helper for often used methods and access rights
 * It will be performed by Controllers, Models...
 *
 * @author Rune Krauss
 * @version 1.0
 * @copyright (c) by Rune Krauss
 * @abstract
 *
 */
abstract class ExifworkerHelper {
	/**
	 * Configure the Linkbar and get the actions
	 *
	 * @return Object Access rights
	 * @static
	 *
	 * @access public
	 */
	public static function getActions($messageId = 0) {
		$user = JFactory::getUser ();
		$result = new JObject ();
		
		if (empty ( $messageId )) {
			$assetName = 'com_exifworker';
		} else {
			$assetName = 'com_exifworker.message.' . ( int ) $messageId;
		}
		
		$actions = array (
				'core.admin',
				'core.manage',
				'core.create',
				'core.edit',
				'core.delete' 
		);
		
		foreach ( $actions as $action ) {
			$result->set ( $action, $user->authorise ( $action, $assetName ) );
		}
		
		return $result;
	}
	
	/**
	 * Get timestamp "Y-m-d H:i:s"
	 *
	 * @return String Timestamp
	 * @static
	 *
	 * @access private
	 */
	public static function getDateTime() {
		$timestamp = time ();
		$date = date ( "Y-m-d H:i:s", $timestamp );
		return $date;
	}
}