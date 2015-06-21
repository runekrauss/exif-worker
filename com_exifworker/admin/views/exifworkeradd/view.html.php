<?php
// Disallow the direct calling of this file
defined ( '_JEXEC' ) or die ();

// Import component helper
jimport('joomla.application.component.helper');

/**
 * View for adding an item
 * It will be called by controller
 *
 * @author Rune Krauss
 * @version 1.0
 * @copyright (c) by Rune Krauss
 */
class ExifworkerViewExifworkerAdd extends JViewLegacy {
	/**
	 * Main Javascript file
	 *
	 * @var array
	 * @access private
	 */
	private $script = "";
	
	public function display($tpl = null) {
		// Die Daten werden bezogen.
		$this->item = $this->get ( 'Item' );
		
		// Das Formular.
		$this->form = $this->get ( 'Form' );
		
		// JavaScript
		$this->script = $this->get ( 'Script' );
		
		// Check for errors.
		if (count ( $errors = $this->get ( 'Errors' ) )) {
			JError::raiseError ( 500, implode ( '<br />', $errors ) );
			return false;
		}
		
		// Die Toolbar hinzufügen.
		$this->addToolBar ();
		
		//ExifworkerHelper::hello();
		
		// Das Template wird aufgerufen.
		parent::display ( $tpl );
		
		// Set the document
		$this->setDocument ();
	}
	
	/**
	 * Setting the toolbar.
	 */
	protected function addToolBar() {
		JRequest::setVar ( 'hidemainmenu', true );
		
		JToolBarHelper::title ( JText::_ ('COM_EXIFWORKER_EXIFWORKERADD_VIEW_TITLE'), "exifworker" );
		
		JToolBarHelper::save ( 'exifworkeradd.addImage' );
		
		JToolBarHelper::save ( 'exifworkeradd.addImageAndNew', JText::_ ( 'COM_EXIFWORKER_EXIFWORKERADD_VIEW_SAVEANDNEW' ) );
		
		JToolBarHelper::cancel ( 'exifworkeradd.cancel', 'JTOOLBAR_CANCEL');
	}
	
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 * @access protected
	 */
	protected function setDocument() {
		// Get head data and remove validate.js because of many bugs
		$document = JFactory::getDocument ();
		$headData = $document->getHeadData ();
		$scripts = $headData ['scripts'];
		
		$base = JURI::base( true );
		$baseEx = explode("/", $base);
		array_pop($baseEx);
		$docPath = implode("/", $baseEx);
		
		unset ( $scripts [$docPath . '/media/system/js/validate.js'] );
		
		/*
		 * Add new "validate.js" for validating the form
		 * Add CSS for 2-column-layout and Responsive Webdesign
		 */
		$headData ['scripts'] = $scripts;
		$document->setHeadData ( $headData );
		$document->addScript ( JURI::root ( true ) . '/administrator/components/com_exifworker/assets/js/validate.js' );
		$document->setTitle ( JText::_ ( 'COM_EXIFWORKER_EXIFWORKERADD_VIEW_ADDING')  );
		
		$document->addScript ( JURI::root ( true ) . $this->script );
		
		// Fix bugs for managing validating regarding the submit button
		$document->addScript ( JURI::root ( true ) . '/administrator/components/com_exifworker/assets/js/submitbutton.js' );
	}
}