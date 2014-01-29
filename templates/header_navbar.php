<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">  
	<div class="navbar-inner">  
		<ul class="nav navbar-nav">
			<li><a class="navbar-brand" href="index.php">SCASi4</a></li>
			<li><a href="inbox.php">Inbox <?php if($inboxCount > 0) echo "($inboxCount)"?></a></li>
			<li class="dropdown">
				<a href="cases.php?type=priority" 
					class="dropdown-toggle"
					data-toggle="dropdown">
					List of Cases by
					<b class="caret"></b>
				</a>
				<ul class="dropdown-menu">
					<li><a href="cases.php?type=priority">Priority</a></li>
					<!-- li><a href="../html/cases.php?by_type=category">Category</a></li -->
					<li><a href="cases.php?type=date">Date</a></li>
					<li><a href="cases.php?type=me">Me</a></li>
				</ul>
			</li>
			<li><a href="find_add.php">Find/Add Client</a></li>
			<li class="dropdown">
				<a href="index.php"
					class="dropdown-toggle"
					data-toggle="dropdown">
					Database Items
					<b class="caret"></b>
				</a>
				<ul class="dropdown-menu">							
					<li><a href="leaderboard.php">Leaderboard</a></li>
					<li><a href="profile.php">Profile</a></li>

					<li><a href="users.php">List All Users</a></li>					
					<?php if(!COMPER) : ?>
						<li><a href="add_user.php">Add User</a></li>
					<?php endif; ?>
					<?php if(ADMIN) : ?>
						<li><a href="manage.php?type=users">Manage Users</a></li>
					<?php endif; ?>					
				</ul>
			</li>
			<li class="dropdown">
				<a href="index.php"
					class="dropdown-toggle"
					data-toggle="dropdown">
					Resources
					<b class="caret"></b>
				</a>
				<ul class="dropdown-menu">
					<li><a target="_blank" href="resources/manual.pdf">Manual</a></li>
					<li><a target="_blank" href="http://masmallclaims.wikia.com/wiki/MA_Small_Claims_Wiki">Wiki</a></li>
				</ul>
			</li>
		</ul>
		<ul class="nav navbar-nav pull-right">
			<li><a href="logout.php">Logout</a></li>
		</ul>
	</div>  
</nav>
