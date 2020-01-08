<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">  
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">SCASi4</a>
            <button type="button" class="navbar-toggle navbar-inverse collapsed" data-toggle="collapse" data-target="#navbar-inner" aria-expanded="false">
                <i class="glyphicon glyphicon-align-center"></i>
            </button>
        </div>
	<div class="navbar-inner navbar-collapse collapse" id="navbar-inner">  
		<ul class="nav navbar-nav">
			<!-- li><a href="inbox.php">Inbox <?php if($inboxCount > 0) echo "($inboxCount)"?></a></li -->
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
					<li><a href="survey.php">Survey</a></li>
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
					<li><a href="monthly_stats.php">Monthly stats</a></li>
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
                                        <li><a target="_blank" href="https://docs.google.com/forms/d/e/1FAIpQLScMNELBGsDfiAyEdQDAL7l8hEOnZjBiMGJv4ilYUCPMsJXA4Q/viewform?usp=sf_link">Client Feedback Survey</a></li>
                                        <li><a target="_blank" href="https://docs.google.com/document/d/1-CI9sYu8SpsKodQDxL0zdc3ZEI3Scc6lIVl-vbnU9Mk/edit?usp=sharing">Email Template for Survey</a></li>
                                        <li><a target="_blank" href="https://docs.google.com/document/d/1iFLuXXV7hj-_xm_ZvYlNHpsTJwpmpzOrMzdg0ZBQIEM/edit?usp=sharing">Phone Script for Survey</a></li>

				</ul>
			</li>
		</ul>
		<ul class="nav navbar-nav pull-right">
			<li><a href="profile.php#top">My Profile</a></li>
			<li><a href="logout.php">Logout</a></li>
		</ul>
	</div>  
</nav>
