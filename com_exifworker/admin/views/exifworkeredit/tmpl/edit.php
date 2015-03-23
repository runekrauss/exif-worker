<?php
// Disallow the direct calling of this file
defined ( '_JEXEC' ) or die ();

// Load tooltip behavior
JHtml::_ ( 'behavior.tooltip' );

// Load formvalidation behavior
JHtml::_ ( 'behavior.formvalidation' );

// Loads API for Google Maps
if ($this->googleMaps == true) {
	JHtml::script ( "http://maps.googleapis.com/maps/api/js" );
}

// Activates i18n for Javascript
JText::script ( 'COM_EXIFWORKER_ERROR_UNACCEPTABLE' );

// Link for the form
$actionLink = JRoute::_ ( 'index.php?option=com_exifworker&layout=edit&id=' . ( int ) $this->item->ExifworkerId );
?>
<div class="exifworkereditLeft">
	<form action="<?php echo $actionLink; ?>" method="post"
		name="adminForm" id="adminForm" class="form-validate">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_EXIFWORKER_EXIFWORKEREDIT_TMPL_DETAILS'); ?></legend>
 
        <?php foreach ($this->form->getFieldset() as $field): ?>
        <?php if (!$field->hidden): ?>
            <?php
										
										echo $field->label;
										?>
									<?php endif; ?> <?php
									echo $field->input;
									?>
        <?php endforeach; ?>
    </fieldset>
		<div>
			<input type="hidden" name="task" value="exifworker.edit" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
	</form>
</div>
<div class="exifworkereditRight">
	<img src="<?php echo $this->item->Path; ?>"
		alt="<?php echo $this->item->Name; ?>" height="200" width="200">
	<p>
		<b><?php echo JText::_('COM_EXIFWORKER_EXIFWORKEREDIT_TMPL_CREATIONDATE'); ?></b><br> <?php echo $this->item->CreationDate ?><br>
		<b><?php echo JText::_('COM_EXIFWORKER_EXIFWORKEREDIT_TMPL_LASTEDITED'); ?></b><br> <?php echo $this->item->LastEdited ?><br>
		<b><?php echo JText::_('COM_EXIFWORKER_EXIFWORKEREDIT_TMPL_USER'); ?></b><br> <?php echo $this->author?><br>
	
	<?php
	// Check for output regarding Google Maps
	if ($this->googleMaps == true && $this->longitude != 0 && $this->latitude != 0 ) {
		?>

	<div id="map"></div>
<?php
	} else {
		?>
		<div id="nomap"><b><?php echo JText::_('COM_EXIFWORKER_EXIFWORKEREDIT_TMPL_NOMAP'); ?></b></div>
	<?php
	}
	?>

	</div>