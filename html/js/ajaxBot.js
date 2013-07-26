var ajaxBot = new AjaxBot(); 

// sendAjax calls with validation
/*
	params should be of type: 
	{data : data, 
	 request : request_page, 
	 success : function_on_success, 
	 error : function_on_error
	}
*/
function AjaxBot () {
	var authId = ajax_authentication.id; 
	var authHash = ajax_authentication.hash;

	this.sendAjax = function(params) {
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
}
