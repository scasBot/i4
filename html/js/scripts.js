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

// zero pads a number with x amount of zeros
function zeroPad(num, size) { 
	var numString = "" + num; 
	assert(numString.length <= size, "zeroPad failure"); 
	var needed = numString.length; 
	
	for(var i = 0; i < (size - needed); i++) {
		numString = "0" + numString; 
	}
	
	return numString; 
}

// returns the sql date from a date object 
function toSqlDate(now) {
	var dd = zeroPad(now.getDate(), 2); 
	var mm = zeroPad(now.getMonth()+1, 2); 
	var yyyy = zeroPad(now.getFullYear(), 4); 
	var HH = zeroPad(now.getHours(), 2); 
	var MM = zeroPad(now.getMinutes(), 2); 
	var SS = zeroPad(now.getSeconds(), 2); 

	return yyyy + "-" + mm + "-" + dd + " " 
		+ HH + ":" + MM + ":" + SS; 
}

// returns the current date in mysql format
function currentSqlDate() { 
	return toSqlDate(new Date()); 	
}

// selectOption in dropdown
function selectOption(selectObject, key) {
	selectObject.find("option").each(function () {
		var text = $(this).text(); 
		if (text == key) {
			$(this).prop('selected', true); 
		}
	}); 
}