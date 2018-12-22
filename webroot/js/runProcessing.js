$(function() {
    
	var script = document.createElement("script");
	script.type = "text/javascript";
	script.innerHTML = $('#codejs').data('codejs'); 
	$('#abc').append(script);
	$('#abc').empty();
	    
});
