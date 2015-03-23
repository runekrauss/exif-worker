/*
 * Validates the fields "imageName" and "addImage" from the XML
 */
window.addEvent('domready', function() {
	document.formvalidator.setHandler('imageName', function(value) {
		regex = /^[^0-9]+$/;
		return regex.test(value);
	});

	document.formvalidator.setHandler('addImage', function(value) {
		regex = /.jpg$/;
		return regex.test(value);
	});
});