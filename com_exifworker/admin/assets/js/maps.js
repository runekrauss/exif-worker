function initialize() {
	var latitude = document.getElementById("jform_latitude").value;
	var longitude = document.getElementById("jform_longitude").value;
	var mapProp = {
		center : new google.maps.LatLng(latitude, longitude),
		zoom : 8,
		mapTypeId : google.maps.MapTypeId.ROADMAP
	};
	var map = new google.maps.Map(document.getElementById("map"), mapProp);
}
google.maps.event.addDomListener(window, 'load', initialize);