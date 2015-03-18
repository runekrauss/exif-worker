<?php

// Disallow the direct calling of this file
defined ( '_JEXEC' ) or die ();

// Import Joomla! JControllerForm class
jimport ( 'joomla.application.component.controllerform' );

/**
 * Controller for editing an item
 * It will be performed by the list view
 *
 * @author Rune Krauss
 * @version 1.0
 * @since 2015
 * @copyright (c) by Rune Krauss
 */
class ExifworkerControllerExifworkerEdit extends JControllerForm {
	/**
	 * View list of this controller
	 * We have to declare a view list because we not follow the pluralization "s" regarding Joomla!
	 *
	 * @var string
	 * @access protected
	 */
	protected $view_list = 'ExifworkerList';
	
	/**
	 * Save an edited item of the list
	 *
	 * @return void
	 * @access public
	 */
	public function saveImage() {
		$jinput = JFactory::getApplication ()->input;
		$posts = $jinput->post->getArray ();
		// Get name from input
		$name = $posts ["jform"] ["imageName"];
		
		if (preg_match ( "/^[^0-9]+$/", $name )) {
			$model = $this->getModel ();
			$model->saveImage ( $jinput );
			$this->setredirect ( JRoute::_ ( 'index.php?option=com_exifworker' ), JText::_ ( 'COM_EXIFWORKER_EXIFWORKEREDIT_CONTROLLER_NOERROR' ) );
		} else {
			$link = JRoute::_ ( JURI::getInstance (), false );
			// Get a handle to the Joomla! application object
			$application = JFactory::getApplication ();
			$this->setRedirect ( $link, $application->enqueueMessage ( JText::_ ( 'COM_EXIFWORKER_EXIFWORKEREDIT_CONTROLLER_ERROR' ), 'error' ) );
		}
	}
	
	/**
	 * Clear all exif data from an item
	 *
	 * @return void
	 * @access public
	 */
	public function clearImage() {
		$jinput = JFactory::getApplication ()->input;
		$posts = $jinput->post->getArray ();
		// Get name from input
		$name = $posts ["jform"] ["imageName"];
		
		if (preg_match ( "/^[^0-9]+$/", $name )) {
			$model = $this->getModel ();
			$model->clearImage ( $jinput );
			$this->setredirect ( JRoute::_ ( 'index.php?option=com_exifworker' ), JText::_ ( 'COM_EXIFWORKER_EXIFWORKEREDIT_CONTROLLER_NOERROR' ) );
		} else {
			$link = JRoute::_ ( JURI::getInstance (), false );
			// Get a handle to the Joomla! application object
			$application = JFactory::getApplication ();
			$this->setRedirect ( $link, $application->enqueueMessage ( JText::_ ( 'COM_EXIFWORKER_EXIFWORKEREDIT_CONTROLLER_ERROR' ), 'error' ) );
		}
	}
	public function applyImage() {
		$jinput = JFactory::getApplication ()->input;
		$posts = $jinput->post->getArray ();
		// Get name from input
		$name = $posts ["jform"] ["imageName"];
		
		if (preg_match ( "/^[^0-9]+$/", $name )) {
			$link = JRoute::_ ( JURI::getInstance (), false );
			$model = $this->getModel ();
			$model->saveImage ( $jinput );
			$link = JRoute::_ ( "index.php?option=com_exifworker&view=exifworkeredit&layout=edit&ExifworkerId=" . $posts ["jform"] ["exifworkerId"], false );
			$this->setRedirect ( $link, JText::_ ( 'COM_EXIFWORKER_EXIFWORKEREDIT_CONTROLLER_NOERROR' ) );
		} else {
			$link = JRoute::_ ( "index.php?option=com_exifworker&view=exifworkeredit&layout=edit&ExifworkerId=" . $posts ["jform"] ["exifworkerId"], false );
			// Get a handle to the Joomla! application object
			$application = JFactory::getApplication ();
			$this->setRedirect ( $link, $application->enqueueMessage ( JText::_ ( 'COM_EXIFWORKER_EXIFWORKEREDIT_CONTROLLER_ERROR' ), 'error' ) );
		}
	}
}