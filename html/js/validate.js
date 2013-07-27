/***********************************************************************
 * validate.js
 *
 * SCASi4
 *
 * Global JavaScript for validation purposes
 **********************************************************************/

// phone validator 10 digits
function isValidPhone(phonenumber) {
	return /^[0-9]{10}$/.test(toNumbers(phonenumber)); 
}

// returns all the digits in string
function toNumbers(phonenumber) {
	return phonenumber.replace(/[^0-9]/g,"");  
}
