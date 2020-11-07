function hidden(){
$(document).ready(function(){
	$("td").find('dd').hide().end().find('dt').click(function() {
		 var info = $(this).next();
		 if (info.is(':visible')) {
		 info.slideUp();
		 } else {
		 info.slideDown();
		 }
	})
});
}

function getIdtable(){
$(document).ready(function() {
$('table').click(function () { 
	var id = $(this).attr("id");
		alert(id);
		});
	});
}

function pickupfoto(){
	$(document).ready(function(){
		$('#foto3x4').click(function() {
			
		});
	});
}