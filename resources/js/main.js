$(document).ready(function(){

	// disable controls to avoid the search before the load of the apis
	$("input#busca").prop("disabled",true);
	$("#btn-main").prop("disabled",true);

	// attach the event click on button
	$("#btn-main").click(function(){
		var query = $("input#busca").val();
		loading();
		$("div#result").fadeOut();
		googleApiNearbySearch(query);
	});

});

// customize the default events
window.onload = function() {
	googleApiOnWindowLoad();
	mainEnableControls();
}

// enable controls
function mainEnableControls() {
	$("input#busca").prop("disabled",false);
	$("#btn-main").prop("disabled",false);
}

function loading() {
	$("img.loading").toggle();
}