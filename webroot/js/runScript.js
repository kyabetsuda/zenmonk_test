$(function() {
    
    $('#testbutton').click(function(e) {
	var script = document.createElement("script");
	script.type = "text/javascript";
	script.innerHTML = $('#code').val();
	$('#abc').append(script);
	$('#abc').empty();
    });
    
});
