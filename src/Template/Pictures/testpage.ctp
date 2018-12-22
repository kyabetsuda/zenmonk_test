<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script>
$(function() {
    
    $('#testbutton').click(function(e) {
	var script = document.createElement("script");
	script.type = "text/javascript";
	script.innerHTML = $('#jstext').val();
	$('#abc').append(script);
	$('#abc').empty();
    });
    
});
</script>

<div id="abc"></div>

<form name="test">
<textarea id="jstext" rows="15"></textarea>
<input type="button" id="testbutton" value="test">
</form>

