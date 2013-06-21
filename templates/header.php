<!DOCTYPE html>

<html>

    <head>

        <link href="css/bootstrap.css" rel="stylesheet"/>
        <link href="css/bootstrap-responsive.css" rel="stylesheet"/>
        <link href="css/styles.css" rel="stylesheet"/>

        <?php if (isset($title)): ?>
            <title>SCAS i4: <?= htmlspecialchars($title) ?></title>
        <?php else: ?>
            <title>SCAS i4</title>
        <?php endif ?>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
		<!-- script src="js/jquery.js"></script -->
        <script src="js/bootstrap.js"></script>
        <script src="js/scripts.js"></script>

    </head>

    <body>

        <div class="container-fluid">

            <div id="top">
                <a href="/"><img alt="C$50 Finance" src="img/logo.gif"/></a>
            </div>

            <div id="middle">

