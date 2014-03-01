$(function() {

	// Initialise dragging of drag children
	$('.drag').draggable({
		containment: "parent"	
	});

	// Initialise resizing of wrapper
	$('div#wrap').resizable({
		containment: "parent",
		resize : function() {
			// Callbacks to ensure that we don't resize smaller than our beloved children
			$(this).resizable('option', 'minWidth', get_content_size('width'));
			$(this).resizable('option', 'minHeight', get_content_size('height'));
		}
	});

	// Resize the children divs
	$('.drag').resizable({
		containment: "parent"
	});

});


// Return the furthest (x) or highest (y) position of our children
function get_content_size(type) {
	// Set our counter to 0
	var value = 0;

	// Iterate through our draggables
	$('.drag').each(function(key, element) {
		// Store the element
		$element = $(element);

		// calulation for width
		if (type == "width") {
			var calc = $element.offset().left + $element.width();
		}
		// calulation for height
		if (type == "height") {
			var calc = $element.offset().top + $element.height();
		}

		// if our calculation is bigger than our last, take value
		if (calc > value) { value = calc; }
	});

	return value;
}