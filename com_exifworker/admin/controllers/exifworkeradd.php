<?php

// Disallow the direct calling of this file
defined ( '_JEXEC' ) or die ();

// Import Joomla! JControllerForm class
jimport ( 'joomla.application.component.controllerform' );

/**
 * Controller for adding an item
 * It will be performed by the list view
 *
 * @author Rune Krauss
 * @version 1.0
 * @copyright (c) by Rune Krauss
 */
class ExifworkerControllerExifworkerAdd extends JControllerForm {
	/**
	 * View list of this controller
	 * We have to declare a view list because we not follow the pluralization "s" regarding Joomla!
	 *
	 * @var string
	 * @access protected
	 */
	protected $view_list = 'ExifworkerList';
	
	/**
	 * Method to add an item
	 *
	 * @return void
	 * @access public
	 */
	public function addImage() {
		// Get model
		$jinput = JFactory::getApplication ()->input;
		$model = $this->getModel ();
		
		// Get name of item
		$files = $jinput->files->get ( 'jform' );
		$file = $files ['addImage'];
		
		// If the image is already exists set value to "false"
		$pathStatus = $model->checkPath ( $jinput );
		
		// Get image name with format
		$posts = $jinput->post->getArray ();
		$name = $posts ["jform"] ["imageName"];
		
		if ($pathStatus != "0" && preg_match ( "/^[^0-9]+$/", $file ["name"] ) && preg_match ( "/.jpg$/", $name )) {
			$application = JFactory::getApplication ();
			$link = JRoute::_ ( 'index.php?option=com_exifworker&view=exifworkeradd&layout=edit', false );
			$this->setRedirect ( $link, $application->enqueueMessage ( JText::_ ( 'COM_EXIFWORKER_EXIFWORKERADD_CONTROLLER_ERROR' ), 'error' ) );
		} else {
			// Add image
			$filePath = $model->addImage ( $jinput );
			// Get ExifworkerId
			$exifworkerId = $model->getExifworkerId ( $filePath );
			$link = JRoute::_ ( 'index.php?option=com_exifworker&view=exifworkeredit&layout=edit&ExifworkerId=' . $exifworkerId, false );
			$this->setredirect ( $link, JText::_ ( 'COM_EXIFWORKER_EXIFWORKERADD_CONTROLLER_NOERROR' ) );
		}
	}
	
	/**
	 * Method to add an item with Redirecting to upload an new image
	 *
	 * @return void
	 * @access public
	 */
	public function addImageAndNew() {
		// Get model
		$jinput = JFactory::getApplication ()->input;
		$model = $this->getModel ();
	
		// Get name of item
		$files = $jinput->files->get ( 'jform' );
		$file = $files ['addImage'];
	
		// If the image is already exists set value to "false"
		$pathStatus = $model->checkPath ( $jinput );
	
		// Get image name with format
		$posts = $jinput->post->getArray ();
		$name = $posts ["jform"] ["imageName"];
	
		if ($pathStatus != "0" && preg_match ( "/^[^0-9]+$/", $file ["name"] ) && preg_match ( "/.jpg$/", $name )) {
			$application = JFactory::getApplication ();
			$link = JRoute::_ ( 'index.php?option=com_exifworker&view=exifworkeradd&layout=edit', false );
			$this->setRedirect ( $link, $application->enqueueMessage ( JText::_ ( 'COM_EXIFWORKER_EXIFWORKERADD_CONTROLLER_ERROR' ), 'error' ) );
		} else {
			// Add image
			$filePath = $model->addImage ( $jinput );
			$link = JRoute::_ ( 'index.php?option=com_exifworker&view=exifworkeradd&layout=edit', false );
			$this->setredirect ( $link, JText::_ ( 'COM_EXIFWORKER_EXIFWORKERADD_CONTROLLER_NOERROR' ) );
		}
	}
}