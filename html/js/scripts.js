/***********************************************************************
 * scripts.js
 *
 * SCASi4
 *
 * Global JavaScript, if any.
 **********************************************************************/

// if statement is wrong then end everything
function assert(statement, description) {
	if(!statement) {
		alert("Assert Failure" + 
			(arguments.length < 2 ? "." : ": " + description)); 
		window.location.href="js_assert_failure.php"; 
	}
}

// zero pads a number with size - num.length amount of zeros
function zeroPad(num, size) { 
	var numString = "" + num; 
	assert(numString.length <= size, "zeroPad failure"); 
	var needed = numString.length; 
	
	for(var i = 0; i < (size - needed); i++) {
		numString = "0" + numString; 
	}
	
	return numString; 
}

// selectOption in dropdown
function selectOption(selectObject, key) {
	selectObject.find("option").each(function () {
		if ($(this).text() == key) {
			$(this).prop('selected', true); 
			return; 
		}
	}); 
}