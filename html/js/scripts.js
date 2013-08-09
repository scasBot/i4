/***********************************************************************
 * scripts.js
 *
 * SCASi4
 *
 * Global JavaScript, if any.
 **********************************************************************/

 /*========================================ConstantBot.js================================*/
	// store any constants inside of constants so it isn't taking up global namespace
	var constants = new constantBot(); 
	
	// respect the abstraction barrier and use constants.addConstants({constantName : constantValue, cn2 : cv2 ...})
	function constantBot(obj) {
		var constantBot = this; 
		if(obj) {
			addConstants(obj); 
		}
		
		var allowedTypes = ["string", "boolean", "number", "object"]
		
		function addConstants(obj) {
			foreach(obj, function(key, val) {
				var type = typeof val; 
				if(allowedTypes.indexOf(type) < 0) {
					throw new Error("That type of constant is not allowed"); 
				} else if (typeof constantBot[key] !== "undefined") {
					throw new Error("That constant has already been defined"); 
				}
				constantBot[key] = val;
			});
		}
		
		this.addConstants = addConstants; 
	}
	
/*=======================================Helpers.js========================================*/
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
		if ($(this).text() == key || $(this).val() == key) {
			$(this).prop('selected', true); 
			return; 
		}
	}); 
}

// emulates the php foreach loop
function foreach(obj, fun) {
	function error(msg) {
		alert(msg); 
		return; 
	}

	if(arguments.length < 2) {
		return error("foreach loop must be called with both arguments."); 
	} else if ((typeof obj !== "object") || !obj) {
		return error("First argument of foreach loop must be an object."); 
	} 
	
	for(var key in obj) {
		if(obj.hasOwnProperty(key)) {
			fun(key, obj[key]); 
		}
	}
}
/*=======================================DateHelpers.js========================================*/
// returns a new date object, if the datstring is mysql syntax
// will format the date correctly (compatability with firefox, IE, 
// Safari). 
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

// given a valid SqlSyntax date, returns the date object
function parseSqlDate(sqlDate) {
	assert(isValidMysqlSyntax(sqlDate), "Invalid mysql syntax passed into " + 
		"parseSqlDate function"); 

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
	
	// if the date is different than the input, then it must be invalid
	if(! (date[0] == r.getFullYear() && 
		date[1] == (r.getMonth() + 1) &&
		date[2] == r.getDate())) {
		return "Invalid Date"; 
	} else {
		return r; 
	}
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
	return toSqlDate(myDate()); 	
}

// checks if a number is valid mysql syntax for a date
function isValidMysqlSyntax(date) {
	return /^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])\s([0-1][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/.test(date); 
}

// checks if a date is valid
function isValidDate(date) {
	var dateObject = myDate(date); 	
	return dateObject.toString() != "Invalid Date"; 
}

// checks both mysql date and date object
function isValidMysqlDate(datestring) {
	return isValidMysqlSyntax(datestring) && isValidDate(datestring); 
}
/*=======================================Validate.js========================================*/

// email validator - http://www.w3resource.com/javascript/form/email-validation.php#sthash.YaiMT7Vz.dpuf
function isValidEmail(email) {  
	return (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)); 
}

// phone validator 10 digits
function isValidPhone(phonenumber) {
	return /^[0-9]{10}$/.test(toNumbers(phonenumber)); 
}

// returns all the digits in string
function toNumbers(phonenumber) {
	return phonenumber.replace(/[^0-9]/g,"");  
}
