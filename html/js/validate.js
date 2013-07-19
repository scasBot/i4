/***********************************************************************
 * validate.js
 *
 * SCASi4
 *
 * Global JavaScript for validation purposes
 **********************************************************************/

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
