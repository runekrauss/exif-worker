<?php

// Disallow the direct calling of this file
defined ( '_JEXEC' ) or die ();

/**
 * View for editing an item
 * It will be called by controller
 *
 * @author Rune Krauss
 * @version 1.0
 * @since 2015
 * @copyright (c) by Rune Krauss
 */
class ExifworkerViewExifworkerEdit extends JViewLegacy {
	/**
	 * Includes all exif data
	 *
	 * @var array
	 * @access private
	 */
	private $exifData = array ();
	
	/**
	 * Flag for displaying all exif data
	 *
	 * @var boolean
	 * @access private
	 */
	private $allExifData = "";
	
	/**
	 * Main Javascript file
	 *
	 * @var array
	 * @access private
	 */
	private $script = "";
	
	/**
	 * Google Maps
	 *
	 * @var array
	 * @access private
	 */
	private $maps = "";
	
	/**
	 * View display method
	 * It is called by the related controller
	 *
	 * @param JTemplate $tpl        	
	 * @see ExifworkerControllerExifworkerEdit
	 * @return void
	 */
	public function display($tpl = null) {
		// Call method "getItem()" to recieve the data from the db
		$this->item = $this->get ( 'Item' );
		
		// Decode the json from the field "Exif"
		$this->exifData = json_decode ( $this->item->Exif, true );
		
		// Get exif keys
		$exifArtist = isset ( $this->exifData ["exif:Artist"] ) ? $this->exifData ["exif:Artist"] : "";
		$exifComment = isset ( $this->exifData ["exif:Comment"] ) ? $this->exifData ["exif:Comment"] : "";
		$exifCopyright = isset ( $this->exifData ["exif:Copyright"] ) ? $this->exifData ["exif:Copyright"] : "";
		$exifDateTime = isset ( $this->exifData ["exif:DateTime"] ) ? $this->exifData ["exif:DateTime"] : "";
		$exifExifImageLength = isset ( $this->exifData ["exif:ExifImageLength"] ) ? $this->exifData ["exif:ExifImageLength"] : "";
		$exifExifImageWidth = isset ( $this->exifData ["exif:ExifImageWidth"] ) ? $this->exifData ["exif:ExifImageWidth"] : "";
		$exifGPSDateStamp = isset ( $this->exifData ["exif:GPSDateStamp"] ) ? $this->exifData ["exif:GPSDateStamp"] : "";
		$exifGPSLatitude = isset ( $this->exifData ["exif:GPSLatitude"] ) ? $this->exifData ["exif:GPSLatitude"] : "";
		$exifGPSLatitudeRef = isset ( $this->exifData ["exif:GPSLatitudeRef"] ) ? $this->exifData ["exif:GPSLatitudeRef"] : "";
		$exifGPSLongitude = isset ( $this->exifData ["exif:GPSLongitude"] ) ? $this->exifData ["exif:GPSLongitude"] : "";
		$exifGPSLongitudeRef = isset ( $this->exifData ["exif:GPSLongitudeRef"] ) ? $this->exifData ["exif:GPSLongitudeRef"] : "";
		$exifImageDescription = isset ( $this->exifData ["exif:ImageDescription"] ) ? $this->exifData ["exif:ImageDescription"] : "";
		$exifMake = isset ( $this->exifData ["exif:Make"] ) ? $this->exifData ["exif:Make"] : "";
		$exifModel = isset ( $this->exifData ["exif:Model"] ) ? $this->exifData ["exif:Model"] : "";
		$exifSoftware = isset ( $this->exifData ["exif:Software"] ) ? $this->exifData ["exif:Software"] : "";
		
		// Get parameters, see "config.xml"
		$this->params = JComponentHelper::getParams ( 'com_exifworker' );
		$isAllExif = ( boolean ) $this->params->get ( 'allExif' );
		$this->googleMaps = ( boolean ) $this->params->get ( 'maps' );
		
		// Call method "getForm()" to get the generated Code from XML
		$this->form = $this->get ( 'Form' );
		
		// Check for output regarding all exif data
		if ($isAllExif == true) {
			$a = count ( $this->exifData );
			$b = 0;
			foreach ( $this->exifData as $name => $property ) {
				if (! empty ( $property )) {
					$this->allExifData .= strtoupper ( $name ) . ": " . $property;
					if (++ $b < $a)
						$this->allExifData .= "\n";
				}
			}
			$str = str_replace ( "EXIF:", "", $this->allExifData );
			$this->form->setFieldAttribute ( 'exifData', 'readonly', 'true' );
			$this->form->setValue ( 'exifData', null, $str );
		} else {
			$this->form->removeField ( 'exifData' );
			$this->form->removeField ( 'spacerExifData' );
		}
		
		// Set values for fields in the form
		$this->form->setValue ( 'imageName', null, $this->item->Name );
		
		$this->form->setValue ( 'exifArtist', null, $exifArtist );
		$this->form->setValue ( 'exifComment', null, $exifComment );
		$this->form->setValue ( 'exifCopyright', null, $exifCopyright );
		$this->form->setValue ( 'exifDateTime', null, $exifDateTime );
		$this->form->setValue ( 'exifImageLength', null, $exifExifImageLength );
		$this->form->setValue ( 'exifImageWidth', null, $exifExifImageWidth );
		$this->form->setValue ( 'exifGPSDateStamp', null, $exifGPSDateStamp );
		$this->form->setValue ( 'exifGPSLatitude', null, $exifGPSLatitude );
		$this->form->setValue ( 'exifGPSLatitudeRef', null, $exifGPSLatitudeRef );
		$this->form->setValue ( 'exifGPSLongitude', null, $exifGPSLongitude );
		$this->form->setValue ( 'exifGPSLongitudeRef', null, $exifGPSLongitudeRef );
		$this->form->setValue ( 'exifImageDescription', null, $exifImageDescription );
		$this->form->setValue ( 'exifMake', null, $exifMake );
		$this->form->setValue ( 'exifModel', null, $exifModel );
		$this->form->setValue ( 'exifSoftware', null, $exifSoftware );
		
		$this->form->setValue ( 'exifworkerId', null, $this->item->ExifworkerId );
		
		$this->longitude = 0;
		$this->latitude = 0;
		
		// Create coords for Google Maps
		if ($this->googleMaps == true) {
			$latitude = explode ( "/", $exifGPSLatitude );
			$longitude = explode ( "/", $exifGPSLongitude );
			if (preg_match ( "/^\d+/", $latitude [0] ) && preg_match ( "/^\d+/", $longitude [0] )) {
				$this->latitude = intval ( $latitude [0] );
				$this->longitude = intval ( $longitude [0] );
				if ($exifGPSLatitudeRef == "S") {
					$this->latitude = - 1 * abs ( $this->latitude );
				}
				if ($exifGPSLongitudeRef == "W") {
					$this->longitude = - 1 * abs ( $this->longitude );
				}
				if ($this->latitude >= - 90 && $this->latitude <= 90 && $this->longitude >= - 180 && $this->longitude <= 180) {
					$this->form->setValue ( 'latitude', null, $this->latitude );
					$this->form->setValue ( 'longitude', null, $this->longitude );
				}
			}
		}
		
		// Get author from db
		$model = $this->getModel ();
		$this->author = $model->getAuthor ( $this->item->ExifworkerId );
		
		// Get Javascript for validating the form
		$this->script = $this->get ( 'Script' );
		
		// Get Google Maps
		$this->maps = $this->get ( 'Maps' );
		
		// Check for errors
		if (count ( $errors = $this->get ( 'Errors' ) )) {
			JError::raiseError ( 500, implode ( '<br />', $errors ) );
			return false;
		}
		
		// Add toolbar
		$this->addToolBar ();
		
		// Call template "edit.php"
		parent::display ( $tpl );
		
		// Set the document
		$this->setDocument ();
	}
	
	/**
	 * Setting the toolbar
	 *
	 * @access protected
	 * @return void
	 */
	protected function addToolBar() {
		JRequest::setVar ( 'hidemainmenu', true );
		
		JToolBarHelper::title ( JText::_ ( 'COM_EXIFWORKER_EXIFWORKEREDIT_VIEW_TITLE' ), "exifworker" );
		
		JToolBarHelper::apply ( 'exifworkeredit.applyImage' );
		
		JToolBarHelper::save ( 'exifworkeredit.saveImage' );
		
		JToolBarHelper::save ( 'exifworkeredit.clearImage', JText::_ ( 'COM_EXIFWORKER_EXIFWORKEREDIT_VIEW_CLEANING' ) );
		
		JToolBarHelper::cancel ( 'exifworkeredit.cancel', 'JTOOLBAR_CLOSE' );
	}
	
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 * @access protected
	 */
	protected function setDocument() {
		$isNew = ($this->item->ExifworkerId < 1);
		
		// Get head data and remove validate.js because of many bugs
		$document = JFactory::getDocument ();
		$headData = $document->getHeadData ();
		$scripts = $headData ['scripts'];
		$base = JURI::base ( true );
		$baseEx = explode ( "/", $base );
		array_pop ( $baseEx );
		$docPath = implode ( "/", $baseEx );
		unset ( $scripts [$docPath . '/media/system/js/validate.js'] );
		
		/*
		 * Add new "validate.js" for validating the form
		 * Add CSS for 2-column-layout and Responsive Webdesign
		 */
		$headData ['scripts'] = $scripts;
		$document->setHeadData ( $headData );
		$document->addStyleSheet ( JURI::root ( true ) . '/administrator/components/com_exifworker/assets/css/exifworkeredit.css' );
		$document->addScript ( JURI::root ( true ) . '/administrator/components/com_exifworker/assets/js/validate.js' );
		$document->setTitle ( JText::_ ( 'COM_EXIFWORKER_EXIFWORKEREDIT_VIEW_EDITING' ) );
		
		$document->addScript ( JURI::root ( true ) . $this->script );
		
		if ($this->googleMaps == true) {
			$document->addScript ( JURI::root ( true ) . $this->maps );
		}
		
		// Fix bugs for managing validating regarding the submit button
		$document->addScript ( JURI::root ( true ) . '/administrator/components/com_exifworker/assets/js/submitbutton.js' );
	}
}