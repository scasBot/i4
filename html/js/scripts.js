/***********************************************************************
 * scripts.js
 *
 * SCASi4
 *
 * Global JavaScript, if any.
 **********************************************************************/

 /***************
 ConstantBot.js
 ****************/
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
/**************** CONSTANTS END HERE *************************/

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