<?php

// Disallow the direct calling of this file
defined ( '_JEXEC' ) or die ();

// Load tooltip behavior from bootstrap
JHtml::_ ( 'bootstrap.tooltip' );

$actionLink = JRoute::_ ( 'index.php?option=com_exifworker' );
?>

<form action="<?php echo $actionLink; ?>" method="post" name="adminForm"
	id="adminForm">
	<table class="table table-bordered table-striped table-hover">
		<thead><?php echo $this->loadTemplate('head');?></thead>
		<tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
		<tbody><?php echo $this->loadTemplate('body');?></tbody>
	</table>

	<div>
		<input type="hidden" name="task" value="" /> <input type="hidden"
			name="boxchecked" value="0" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>