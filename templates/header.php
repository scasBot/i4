<!DOCTYPE html>

<html>

    <head>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	
		<!-- open graph tags -->
		<meta name="title" content="SCAS i4 : The Next Gen" />
		<meta name="description" content="The next generation database to better serve SCAS clients." />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
        <link href="css/bootstrap.css" rel="stylesheet"/>
        <!-- link href="css/bootstrap-responsive.css" rel="stylesheet"/ -->
        <link href="css/styles.css" rel="stylesheet"/>

		<link rel="icon" type="image/ico" href="img/favicon.ico">
		
        <?php if (isset($title)): ?>
            <title>SCASi4: <?php echo htmlspecialchars($title) ?></title>
        <?php else: ?>
            <title>SCASi4</title>
        <?php endif ?>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
		<!-- script src="js/jquery.js"></script -->
        <script src="js/bootstrap.js"></script>
        <script src="js/scripts.js"></script>
		<script src="js/validate.js"></script>
		<script src="js/ajax_helpers.js"></script>
		
		<?php if (isset($_SESSION["id"])) : ?>
			<script>
				var ajax_authentication = {
					id : <?php echo $_SESSION["id"] ?>, 
					hash : "<?php echo AJAX_HASH ?>",  
				}
			</script>
		<?php endif; ?>

    </head>

    <body>
		<div class="container">
			<?php if (isset($_SESSION["id"])) : ?>
			<div class="navbar">  
					<div class="navbar-inner">  
						<ul class="nav">
							<li><a href="../html">SCASi4-beta</a></li>
							<li class="dropdown">
								<a href="../html/cases.php?by_type=priority" 
									class="dropdown-toggle"
									data-toggle="dropdown">
									List of Cases by
									<b class="caret"></b>
								</a>
								<ul class="dropdown-menu">
									<li><a href="../html/cases.php?type=priority">Priority</a></li>
									<!-- li><a href="../html/cases.php?by_type=category">Category</a></li -->
									<li><a href="../html/cases.php?type=date">Date</a></li>
								</ul>
							</li>
							<li><a href="../html/find_add.php">Find/Add Client</a></li>
							<li class="dropdown">
								<a href="../html"
									class="dropdown-toggle"
									data-toggle="dropdown">
									Database Items
									<b class="caret"></b>
								</a>
								<ul class="dropdown-menu">							
									<li><a href="../html/leaderboard.php">Leaderboard</a></li>
									<li><a href="../html/profile.php">Profile</a></li>
								</ul>
							</li>
						</ul>
						<ul class="nav pull-right">
							<li><a href="../html/logout.php">Logout</a></li>
						</ul>
					</div>  
				</div>
			<?php endif; ?>
		</div>
        <div class="container">
            <div id="top" class="row">
				<div class="span12">
				<a href="/"><img alt="SCAS i4: The Next Generation" src="img/logo.jpg" style="padding: 10px"/></a>
				</div>
			</div>

            <div id="middle">
			<br/>
