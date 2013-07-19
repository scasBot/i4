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

function myDate(datestring) {
	if(arguments.length < 1) {
		return (new Date()); 
	} else if (arguments.length == 1) {
		if(isValidMysqlSyntax(datestring)) {
			return parseSqlDate(datestring); 
		} else {
			return new Date(datestring); 
		}
	} else {
		throw "Error, too many arguments passed into myDate function";  
	}
}

function parseSqlDate(sqlDate) {
	var split = sqlDate.split(" "); 
	var date = split[0].split("-"); 
	var time = split[1].split(":"); 
	
	var r = new Date(); 
	r.setFullYear(date[0]); 
	r.setMonth(date[1] - 1); // month for some reason is 0-indexed 
	r.setDate(date[2]); 
	r.setHours(time[0]); 
	r.setMinutes(time[1]); 
	r.setSeconds(time[2]); 
	
	return r; 
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