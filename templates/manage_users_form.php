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
	var handler = (function($) {
		var Module = {};
		var space = $("#putUsersHere"); 	
		var searchBar = $("#userSearchForm"); 
		
		Module.init = init; 
		init(); 
		
		function init() {
			fillSpace("<p class='well'>Search for users above!</p>"); 
			searchBar.val(""); 
		}
		
		function fillSpace(str, showButtons) {
			space.html(str); 		
			if(showButtons) {
				space.append(
					"<button id='graduate' class='btn action-btn'>Graduate</button>"
					+ "<button id='ungraduate' class='btn action-btn'>Ungraduate</button>"
					+ "<button id='hide' class='btn action-btn'>Hide</button>"
					+ "<button id='unhide' class='btn action-btn'>Unhide</button>"); 
					
					$(".action-btn").on("click", update); 
			}				
		}		
		
		function reduce_users(fun) {
			$(".user_row").each(function() {
				var user = {}; 
				user.UserName = $(this).find(".user_name").text(); 
				user.Email = $(this).find(".user_email").text(); 
				user.UserID = $(this).attr("id"); 
				user.checked = $(this).find("input[name='select_user']").is(":checked"); 
				fun(user); 
			}); 
		}		
			
		searchBar.on("keyup", delay_action); 
		var last; 
		// delay for typing
		function delay_action(ev, rec) {
			if(!rec) {
				fillSpace("<div class='well'><img src='img/ajax-loader.gif'></img></div>");			
				searchBar.off("keyup", delay_action); 		
			}
			
			var tmp = getInputs().search; 
			if(last == tmp) {
				searchBar.on("keyup", delay_action); 
				action_handler(); 
			} else {
				last = tmp; 
				setTimeout(function() {delay_action(ev, true)}, 500); 
			}
		}
			
		function update() {
			var data = {
				"type" : "list", 
				"action" : $(this).attr("id"), 
				"users" : [], 
			}; 
		
			reduce_users(function(user) {
				if(user.checked) {
					data.users.push(user.UserID); 
				}
			}); 
		
			if(data.users.length < 1) 
				return; // don't do anything
			
			ajaxBot.sendAjax({
				REQ : "editUsers", 
				data: data, 
				success : function(r) {
					if(r) {
						alert(r); 
						return; 
					}

					alert("Success! About to refresh now."); 					
					init(); 
				}, 
				error : function(r) {
					alert("There was an error: " + r); 
				}
			}); 
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
				init(); 
			} else {	
				ajaxBot.sendAjax({
					REQ : "searchUsers", 
					data : data, 
					success : function(r) {
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
					}, 
					error : function(r) {
						fillSpace("<p class='well'>Something went wrong with your " + 
							"ajax request.</p>"); 					
					}, 
				}); 
			}
		}
		

		
		function displayUsers(r) {
			var html = "<table class='table table-striped'><thead><tr>"
				+ "<th><input name='select_all' type='checkbox'></input></th>"
				+ "<th>User Name</th>"
				+ "<th>Email</th>"
				+ "</tr></thead>"; 
			for(var i in r) {
				html += makeHtml(r[i]); 
			}
			
			fillSpace(html, true); 
			

			$("input[name='select_all']").on("click", function() {
				if($(this).is(":checked")) {
					$("input[name='select_user']").each(function() {
						$(this).prop("checked", true); 
					}); 
				} else {
					$("input[name='select_user']").each(function() {
						$(this).prop("checked", false); 
					}); 
				}
			}); 
		}
		
		function makeHtml(user) {
			var html = "<tr id='" + user.UserID + "' class='user_row'>"; 
			html += "<td><input name='select_user' type='checkbox'></input></td>"; 
			html += "<td class='user_name' onclick='document.location=\"manage_user.php?type=user&UserID=" 
				+ user.UserID + "\"' >" + user.UserName + "</td>"; 
			html += "<td class='user_email' onclick='document.location=\"manage_user.php?type=user&UserID=" 
				+ user.UserID + "\"' >" + user.Email + "</td>";
			html += "</tr>"; 
			return html; 
		}
				
		return Module; 
	})(jQuery); 
</script>