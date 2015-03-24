<?php
// Disallow the direct calling of this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );

/**
 * The name of the class must be the name of the component + InstallerScript
 *
 * @author Rune Krauss
 * @version 1.0
 * @since 2015
 * @copyright (c) by Rune Krauss
 */
class com_exifworkerInstallerScript {
	/**
	 * Preflight runs before anything else and while the extracted files are in the uploaded temp folder
	 * If preflight returns false, Joomla will abort the update and undo everything already done
	 *
	 * @param string $type
	 *        	It is the type of change (install, update or discover_install, not uninstall)
	 * @param Object $parent
	 *        	It is the class calling this method
	 *        	
	 * @return void
	 * @access public
	 */
	function preflight($type, $parent) {
		$jversion = new JVersion ();
		
		// Installing component manifest file version
		$this->release = $parent->get ( "manifest" )->version;
		
		// Manifest file minimum Joomla version
		$this->minimum_joomla_release = $parent->get ( "manifest" )->attributes ()->version;
		
		// Show the essential information at the install/update backend
		echo '<p>' . JText::_ ( 'COM_EXIFWORKER_INSTALL_RELEASE' ) . $this->release;
		if (empty ( $this->getParam ( 'version' ) )) {
			echo "<br />" . JText::_ ( 'COM_EXIFWORKER_INSTALL_NORELEASE' );
		} else {
			echo '<br />' . JText::_ ( 'COM_EXIFWORKER_INSTALL_RELEASE2' ) . $this->getParam ( 'version' );
		}
		echo '<br />' . JText::_ ( 'COM_EXIFWORKER_INSTALL_MINIMUMJOOMLARELEASE' ) . $this->minimum_joomla_release;
		echo '<br />' . JText::_ ( 'COM_EXIFWORKER_INSTALL_JOOMLAVERSION' ) . $jversion->getShortVersion ();
		
		// Abort if the current Joomla release is older
		if (version_compare ( $jversion->getShortVersion (), $this->minimum_joomla_release, 'lt' )) {
			Jerror::raiseWarning ( null, JText::_ ( 'COM_EXIFWORKER_INSTALL_MINIMUMJOOMLARELEASEERROR' ) . $this->minimum_joomla_release );
			return false;
		}
		
		if (! extension_loaded ( 'imagick' )) {
			Jerror::raiseWarning ( null, JText::_ ( 'COM_EXIFWORKER_INSTALL_INCORRECTVERSION' ) . $rel );
			return false;
		}
		
		// abort if the component being installed is not newer than the currently installed version
		if ($type == 'update') {
			$oldRelease = $this->getParam ( 'version' );
			$rel = $oldRelease . ' to ' . $this->release;
			if (version_compare ( $this->release, $oldRelease, 'le' )) {
				Jerror::raiseWarning ( null, JText::_ ( 'COM_EXIFWORKER_INSTALL_INCORRECTVERSION' ) . $rel );
				return false;
			}
			if (! extension_loaded ( 'imagick' )) {
				Jerror::raiseWarning ( null, JText::_ ( 'COM_EXIFWORKER_INSTALL_INCORRECTVERSION' ) . $rel );
				return false;
			}
		} else {
			$rel = $this->release;
		}
		
		echo '<p>' . JText::_ ( 'COM_EXIFWORKER_INSTALL_PREFLIGHT' ) . $type . ' ' . $rel . '</p>';
	}
	
	/**
	 * Installation runs after the database scripts are executed
	 * If the extension is new, the install method is run
	 * If install returns false, Joomla will abort the install and undo everything already done
	 *
	 * @param Object $parent
	 *        	It is the class calling this method
	 *        	
	 * @return void
	 * @access public
	 */
	function install($parent) {
		echo '<p>' . JText::_ ( 'COM_EXIFWORKER_INSTALL_RELEASE' ) . $this->release . '</p>';
		// You can have the backend jump directly to the newly installed component configuration page
		// $parent->getParent()->setRedirectURL('index.php?option=com_exifworkerupdate');
		if (! extension_loaded ( 'imagick' )) {
			Jerror::raiseWarning ( null, JText::_ ( 'COM_EXIFWORKER_INSTALL_IMAGICK' ) );
			return false;
		}
	}
	
	/**
	 * Update runs after the database scripts are executed
	 * If the extension exists, then the update method is run
	 * If this returns false, Joomla will abort the update and undo everything already done
	 *
	 * @param Object $parent
	 *        	It is the class calling this method
	 *        	
	 * @return void
	 * @access public
	 */
	function update($parent) {
		echo '<p>' . JText::_ ( 'COM_EXIFWORKER_INSTALL_RELEASE' ) . $this->release . '</p>';
		// You can have the backend jump directly to the newly updated component configuration page
		// $parent->getParent()->setRedirectURL('index.php?option=com_exifworkerupdate');
		if (! extension_loaded ( 'imagick' )) {
			Jerror::raiseWarning ( null, JText::_ ( 'COM_EXIFWORKER_INSTALL_IMAGICK' ) );
			return false;
		}
	}
	
	/**
	 * Postflight is run after the extension is registered in the database
	 *
	 * @param string $type
	 *        	It is the type of change (install, update or discover_install, not uninstall)
	 * @param Object $parent
	 *        	It is the class calling this method
	 *        	
	 * @return void
	 * @access public
	 */
	function postflight($type, $parent) {
		// Always create or modify these parameters
		$params ['my_param0'] = JText::_ ( 'COM_EXIFWORKER_INSTALL_COMPONENTVERSION' ) . $this->release;
		$params ['my_param1'] = JText::_ ( 'COM_EXIFWORKER_INSTALL_OTHERVALUE' );
		
		// Define the following parameters only if it is an original install
		if ($type == 'install') {
			$params ['my_param2'] = '4';
			$params ['my_param3'] = 'Star';
		}
		
		$this->setParams ( $params );
		
		echo '<p>' . JText::_ ( 'COM_EXIFWORKER_INSTALL_POSTFLIGHT' ) . $this->release . '</p>';
		// If wrapper "imagick" can not load by PHP
		if (! extension_loaded ( 'imagick' )) {
			Jerror::raiseWarning ( null, JText::_ ( 'COM_EXIFWORKER_INSTALL_IMAGICK' ) );
			return false;
		}
	}
	
	/**
	 * Uninstall runs before any other action is taken (file removal or database processing)
	 *
	 * @param Object $parent
	 *        	It is the class calling this method
	 *        	
	 * @return void
	 * @access public
	 */
	function uninstall($parent) {
		echo '<p>' . JText::_ ( 'COM_EXIFWORKER_INSTALL_UNINSTALL' ) . '</p>';
	}
	
	/**
	 * Get a variable from the manifest file (actually, from the manifest cache)
	 *
	 * @param string $name
	 *        	Name for manifest
	 *        	
	 * @return array Manifest
	 * @access public
	 */
	function getParam($name) {
		$db = JFactory::getDbo ();
		$db->setQuery ( 'SELECT manifest_cache FROM #__extensions WHERE name = "com_exifworker"' );
		$manifest = json_decode ( $db->loadResult (), true );
		return $manifest [$name];
	}
	
	/*
	 * sets parameter values in the component's row of the extension table
	 */
	/**
	 * Sets parameter values in the component's row of the extension table
	 *
	 * @param array $param_array
	 *        	Array for parameters
	 *        	
	 * @return void
	 * @access public
	 */
	function setParams($param_array) {
		if (count ( $param_array ) > 0) {
			// Read the existing component value(s)
			$db = JFactory::getDbo ();
			$db->setQuery ( 'SELECT params FROM #__extensions WHERE name = "com_exifworker"' );
			$params = json_decode ( $db->loadResult (), true );
			// Add the new variable(s) to the existing one(s)
			foreach ( $param_array as $name => $value ) {
				$params [( string ) $name] = ( string ) $value;
			}
			// Store the combined new and existing values back as a JSON string
			$paramsString = json_encode ( $params );
			$db->setQuery ( 'UPDATE #__extensions SET params = ' . $db->quote ( $paramsString ) . ' WHERE name = "com_exifworker"' );
			$db->query ();
		}
	}
}