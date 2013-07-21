
var ajax = {}; 

// these can be edited later to update in a different way
ajax.authentication = {}; 
$(document).ready(function() {
	ajax.authentication.id = ajax_authentication.id; 
	ajax.authentication.hash = ajax_authentication.hash; 
}); 

// sendAjax calls with validation
/*
	params should be of type: 
	{data : data, 
	 request : request_page, 
	 success : function_on_success, 
	 error : function_on_error
	}
*/
ajax.sendAjax = function(params) {

	var auth = {
		id : ajax.authentication.id,
		hash : ajax.authentication.hash, 
	}

	$.ajax({
		url : "ajax.php",
		type: "POST",
		data : {
			auth : auth, 
			REQ : params.REQ, 
			data : params.data,
		},
		success : params.success, 
		error : params.error
	});
}