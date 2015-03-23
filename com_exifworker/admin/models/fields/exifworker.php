<?php

// Disallow the direct calling of this file
defined ( '_JEXEC' ) or die ();

// Import Joomla! form helper
jimport ( 'joomla.form.helper' );

JFormHelper::loadFieldClass ( 'list' );

/**
 * Exifworker form field class for the exifworker component
 *
 * @author Rune Krauss
 * @version 1.0
 * @since 2015
 * @copyright (c) by Rune Krauss
 */
class JFormFieldExifworker extends JFormFieldList {
	/**
	 * The field type
	 *
	 * @var string
	 */
	protected $type = 'Exifworker';
	
	/**
	 * Method to get a list of options for a list input
	 *
	 * @return array An array of JHtml options
	 */
	protected function getOptions() {
		$db = JFactory::getDBO ();
		
		$query = $db->getQuery ( true );
		
		$query->from ( '#__exifworker AS h' );
		$query->select ( 'h.id AS id, h.hallo, h.catid, c.title AS category' );
		$query->leftJoin ( '#__categories AS c on h.catid=c.id' );
		
		$db->setQuery ( ( string ) $query );
		
		$messages = $db->loadObjectList ();
		
		$options = array ();
		
		if ($messages) {
			foreach ( $messages as $message ) {
				$options [] = JHtml::_ ( 'select.option', $message->id, $message->hallo . ($message->catid ? ' (' . $message->category . ')' : '') );
			}
		}
		
		$options = array_merge ( parent::getOptions (), $options );
		
		return $options;
	}
}