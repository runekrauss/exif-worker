<?php

// Disallow the direct calling of this file
defined ( '_JEXEC' ) or die ();
?>
 
<?php foreach ($this->items as $i => $item): ?>
<tr>
	<td>
            <?php echo $item->Name; ?>
        </td>
	<td>
		<!-- JHTML is a helper which loads additional html classes -->
            <?php echo JHtml::_('grid.id', $i, $item->ExifworkerId); ?>
        </td>
	<td><img src="<?php echo $item->Path; ?>"
		alt="<?php echo $item->Name; ?>" height="30" width="30"></td>
</tr>
<?php endforeach;