<?php

// Disallow the direct calling of this file
defined ( '_JEXEC' ) or die ();

/**
 * View for list of items
 * It will be called by controller
 *
 * @author Rune Krauss
 * @version 1.0
 * @since 2015
 * @copyright (c) by Rune Krauss
 */
class ExifworkerViewExifworkerList extends JViewLegacy {
	/**
	 * Keeps the items from the table "com_exifworker"
	 *
	 * @var array
	 * @access protected
	 */
	protected $items = array ();
	
	/**
	 * Pagination for this view
	 *
	 * @var JPagination
	 * @access protected
	 */
	protected $pagination;
	
	/**
	 * Main Javascript file
	 *
	 * @var array
	 * @access private
	 */
	private $script = "";
	
	/**
	 * View display method
	 * It is called by the related controller
	 *
	 * @param JTemplate $tpl        	
	 * @see ExifworkerControllerExifworkerList
	 * @return void
	 */	
	public function display($tpl = null) {
		
		// Get data from model
		$this->items = $this->get ( 'Items' );
		
		// Get JPagination object
		$this->pagination = $this->get ( 'Pagination' );
		
		// Add toolbar
		$this->addToolBar ();
		
		// Call template
		parent::display ( $tpl );
		
		// Set the document, title in user agent
		$this->setDocument ();
	}
	
	/**
	 * Setting the toolbar
	 *
	 * @access protected
	 * @return void
	 */
	protected function addToolBar() {
		$canDo = ExifworkerHelper::getActions ();
		
		// Second parameter creates the css class "exifworker"
		JToolBarHelper::title ( JText::_ ( 'COM_EXIFWORKER_EXIFWORKERLIST_VIEW_TITLE' ), "exifworker" );
		
		if ($canDo->get ( 'core.delete' )) {
			JToolBarHelper::deleteList ( JText::_ ( 'COM_EXIFWORKER_EXIFWORKERLIST_VIEW_REALLYDELETE' ), 'exifworkerlist.delete' );
		}
		
		if ($canDo->get ( 'core.edit' )) {
			// For example, it calls by execution the method "edit" from controller "exifworkeredit"...
			JToolBarHelper::editList ( 'exifworkeredit.edit' );
		}
		
		if ($canDo->get ( 'core.create' )) {
			JToolBarHelper::addNew ( 'exifworkeradd.add' );
		}
		
		if ($canDo->get ( 'core.admin' )) {
			
			JToolBarHelper::divider ();
			
			JToolBarHelper::preferences ( 'com_exifworker' );
		}
		
		JToolBarHelper::help ( 'COM_EXIFWORKER_EXIFWORKERLIST_VIEW_HELP', true );
	}
	
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() {
		$document = JFactory::getDocument ();
		$document->setTitle ( JText::_ ( 'COM_EXIFWORKER_EXIFWORKERLIST_VIEW_ADMINISTRATION' ) );
	}
}