<?php

// Disallow the direct calling of this file
defined ( '_JEXEC' ) or die ();
?>

<tr>
	<th width="5">
        <?php echo JText::_('COM_EXIFWORKER_EXIFWORKERLIST_TMPL_HEADINGNAME'); ?>
    </th>
	<!-- checkall() function from joomla for checkboxes (access) -->
	<th width="20"><input type="checkbox" name="checkall-toggle" value=""
		title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>"
		onclick="Joomla.checkAll(this)" /></th>
	<th>
        <?php echo JText::_('COM_EXIFWORKER_EXIFWORKERLIST_TMPL_HEADINGIMAGE'); ?>
    </th>
</tr>