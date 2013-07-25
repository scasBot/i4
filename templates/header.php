<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>	
		<!-- open graph tags -->
		<meta name="title" content="SCAS i4 : The Next Gen" />
		<meta name="description" content="The next generation database to better serve SCAS clients." />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
        <link href="css/bootstrap.css" rel="stylesheet"/>
        <link href="css/styles.css" rel="stylesheet"/>

		<link rel="icon" type="image/ico" href="img/favicon.ico">
		
        <?php if (isset($title)): ?>
            <title><?php echo htmlspecialchars($title) ?></title>
        <?php else: ?>
            <title>SCASi4</title>
        <?php endif ?>
		<?php if (isset($_SESSION["id"])) : ?>
			<script>
				var ajax_authentication = {
					id : <?php echo $_SESSION["id"] ?>, 
					hash : "<?php echo AJAX_HASH ?>",  
				}
			</script>
		<?php endif; ?>
		<?php if (isset($javascript)) : ?>
			<script>
				<?php
					foreach($javascript as $variable) {
						echo $variable; 
					}
				?>
			</script>
		<?php endif; ?>

		<?php require("header/javascript.php") ?>
    </head>
    <body>
		<div class="container">
			<?php 
				if (isset($_SESSION["id"])) {
					require("header/navbar.php"); 
				}			
			?>
		</div>
        <div class="container">
            <div id="top" class="row">
				<div class="span12">
				<a href="/"><img alt="SCAS i4: The Next Generation" src="img/logo.jpg" style="padding: 10px"/></a>
				</div>
			</div>

            <div id="middle">
			<br/>
