// sendAjax calls with validation
/*
	params should be of type: 
	{data : data, 
	 request : request_page, 
	 success : function_on_success, 
	 error : function_on_error
	}
*/
var ajaxBot = (function($) {
	var Module = {}; 

	var authId = ajax_authentication.id; 
	var authHash = ajax_authentication.hash;

	Module.sendAjax = function(params) {
		var auth = {
			id : authId, 
			hash : authHash, 
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
	}; 
	
	return Module; 
})(jQuery); 
