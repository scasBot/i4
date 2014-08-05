<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>	
		<!-- open graph tags -->
		<meta name="title" content="SCAS i4 : The Next Gen" />
		<meta name="description" content="The next generation database to better serve SCAS clients." />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
        <link href="css/bootstrap.min.css" rel="stylesheet"/>
		<link href="css/jquery-ui-1.10.3.custom.min.css" rel="stylesheet"/>
        <link href="css/styles.css" rel="stylesheet"/>
        <link href="css/animate.min.css" rel="stylesheet"/>
		<link href='http://fonts.googleapis.com/css?family=Lato|Playfair+Display|Balthazar' rel='stylesheet' type='text/css'>

		<link rel="icon" type="image/ico" href="img/favicon.ico">
		
		<?php if(!LOCAL_HOST) :  ?>
			<?php if (isset($title)): ?>
				<title><?php echo htmlspecialchars($title) ?></title>
			<?php else: ?>
				<title>SCAS i4</title>
			<?php endif ?>
		<?php else : ?> 
			<?php if (isset($title)): ?>
				<title>LOCAL: <?php echo htmlspecialchars($title) ?></title>
			<?php else: ?>
				<title>LOCAL: SCASi4</title>
			<?php endif ?>
		<?php endif ?>

		<?php if (isset($javascript)) : ?>
			<script>
				<?php
					foreach($javascript as $variable) {
						echo $variable; 
					}
				?>
			</script>
		<?php endif; ?>
		<?php if (LOGGED_IN) : ?>
			<script type="text/javascript">
				var ajax_authentication = {
					id : <?php echo $_SESSION["id"] ?>, 
					hash : "<?php echo AJAX_HASH ?>",  
				}
			</script>
		<?php endif; ?>
		<?php require("header_javascript.php") ?>


        <script>
              (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

              ga('create', 'UA-6751081-1', 'auto');
              ga('send', 'pageview');

        </script>
    </head>
    <body>
		<div class="container">
			<?php if (LOGGED_IN) : ?>
				<?php require("header_navbar.php"); ?>
			<?php endif;?>
		</div>
            <div id="top">
			</div>

            <div id="middle">
			<br/>
