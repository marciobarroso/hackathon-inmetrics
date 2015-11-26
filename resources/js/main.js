$(document).ready(function(){

	$("#btn-minimal").click(function(){
		$("div.minimal").hide();
		$("div.main").show();
	});

	$("#btn-main").click(function(){
		$("div.minimal").show();
		$("div.main").hide();
	});

});