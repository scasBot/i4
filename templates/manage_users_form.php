<?php
/*******************************
manage_users_form.php

By: Willy Xiao
willy@chenxiao.us

Developed for SCAS i4
masmallclaims@gmail.com

To use code, please contact SCAS or
Willy at the above emails. 

August 2013
***********************************/
?>
<div class="row">
	<div class="span3"></div>
	<div class="span6">
		<form id="searchForm" class='form-horizontal' >
		<div class='control-group'>
			<label for="userSearchForm" class="control-label">Search:</label>
			<div class='controls'>
				<input id="userSearchForm" type="text" placeholder="Search for users here..." />
			</div>
		</div>
		<div class='control-group'>
			<label for="YOG" class="control-label">Year of Graduation:</label>
			<div class='controls'>
				<select id="YOG">
					<option value="0"></option>
					<?php 
						echo htmlOption('Before ' . (date("Y") - 1), 1);  
						for($i = date("Y") - 1; $i < date("Y") + 4; $i++) {
							echo htmlOption($i, $i); 
						}					
					?>
				</select>
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<label for="userHidden" class='checkbox' >
					<input id="userHidden" type="checkbox" />Include hidden users?
				</label>
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				<label for="onlyCompers" class='checkbox' >
					<input id="onlyCompers" type="checkbox" />Include only compers?
				</label>
			</div>
		</div>
		</form>
	</div>
	<div class="span3"></div>
</div>
<div id="putUsersHere">
</div>
<script type="text/javascript" >
	var handler = new UserSearchHandler(); 
	function UserSearchHandler() {
		$("#userSearchForm").on("keyup", action_handler); 
		var handler = this; 
/*		var dictionary = {}; // this can be used later to optimize code
		function toKey(obj) {
			var key = (obj.hidden ? "1" : "0"); 
			key += (obj.compers ? "1" : "0"); 
			key += obj.yog.toString(); 
			key += obj.search; 
			return key; 
		}*/
		
		function fillSpace(str) {
			$("#putUsersHere").html(str); 
		}
		function initialize() {
			fillSpace("<p class='well'>Search for users above!</p>"); 
		}
		this.initialize = initialize; 
		initialize(); 
		
		function searchLength() {
			return $("#userSearchForm").val().length; 
		}
		function getInputs() {
			return {
				hidden : $("#userHidden").is(":checked"), 
				compers : $("#onlyCompers").is(":checked"), 
				yog : $("#YOG").val(), 
				search : $("#userSearchForm").val(), 
			}; 
		}
		
		function action_handler() {
			data = getInputs(); 
			if(data.search.length < 1) {
				initialize(); 
			} else {	
				function onSuccess(r) {
					if(!r) {
						fillSpace("<p class='well'>No matches found, try refining your search.</p>"); 
					} else if(r == "1") { // 1 means too long
						fillSpace("<p class='well'>Too many results, try refining your search.</p>"); 
					} else {
						try {
							r = $.parseJSON(r); 
							displayUsers(r); 
						} catch (e) {
							fillSpace("<p class='well'>Sorry, there was an error " + e + "</p>"); 
						}
					}
				}
				function onError(r) {
					fillSpace("<p class='well'>Something went wrong with your " + 
						"ajax request.</p>"); 
				}
				
				ajaxBot.sendAjax({
					REQ : "searchUsers", 
					data : data, 
					success : onSuccess, 
					error : onError
				}); 
			}
		}
		
		function displayUsers(r) {
			
		}
	}
</script>