function show_float_left() {
    var content = document.getElementById('float_content_left');
    var hide = document.getElementById('hide_float_left');
    if (content.style.display == "none")
    {
    	content.style.display = "block";
		hide.innerHTML = '<a href="javascript:show_float_left()">Chúng tôi có thể giúp bạn? [X]</a>'; 
	}
    else {
        content.style.display = "none"; 
        hide.innerHTML = '<a href="javascript:show_float_left()">Chúng tôi có thể giúp bạn?</a>';
	}
}