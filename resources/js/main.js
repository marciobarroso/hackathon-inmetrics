$(document).ready(function(){

	// disable controls to avoid the search before the load of the apis
	$("#input-search").prop("disabled",true);
	$("#button-search").prop("disabled",true);

	// attach the event click on button
	$("#button-search").click(function(){
		var query = $("#input-search").val();
		googleApiNearbySearch(query);
	});

	$("#input-search").keypress(function(e){
		if (e.which == 13){
			e.preventDefault();
    		console.log("enter click");
    		$("#button-search").click();
		}
	});

	$("#input-search").keyup(function() {
		if( $(this).val().length > 2 ) {
			console.log("enable search button");
			$("#button-search").prop("disabled",false);
		} else {
			console.log("disable search button");
			$("#button-search").prop("disabled",true);
		}
	});
});

// customize the default events
window.onload = function() {
	googleApiOnWindowLoad();
}

// customize the default events
window.onload = function() {
	googleApiOnWindowLoad();
	mainEnableControls();
}

// enable controls
function mainEnableControls() {
	$("#input-search").prop("disabled",false);
}