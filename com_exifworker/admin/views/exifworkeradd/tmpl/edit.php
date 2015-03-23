<?php
// Disallow the direct calling of this file
defined ( '_JEXEC' ) or die ();

JText::script( 'COM_EXIFWORKER_ERROR_UNACCEPTABLE' );

// Load tooltip behavior
JHtml::_ ( 'behavior.tooltip' );

// Load formvalidation behavior
JHtml::_ ( 'behavior.formvalidation' );

// Link for the form
$actionLink = JRoute::_('index.php?option=com_exifworker');

?>
<!-- Include placeholder for messages -->
<jdoc:include type="message" />
<form action="<?php echo $actionLink ?>" method="post" name="adminForm"
	id="adminForm" class="form-validate" enctype="multipart/form-data">
	<fieldset class="adminform">
		<legend><?php echo JText::_('COM_EXIFWORKER_EXIFWORKERADD_TMPL_DETAILS'); ?></legend>
 
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
		<input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>