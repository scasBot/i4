<?php
include("connect.php");
?>
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
		
									<title>By Survey</title>
					
							<script type="text/javascript">
				var ajax_authentication = {
					id : 2010, 
					hash : "qxddvseixldkwJKDFl",  
				}
			</script>
				<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="js/bootstrap_typeahead.js"></script>
<script src="js/tinymce/tinymce.min.js"></script>
<script src="js/jquery-scrollto.js"></script>
<!-- script src="js/date_helpers.js"></script>
<script src="js/validate.js"></script -->
<script src="js/scripts.js"></script>
	
	<script src="js/emailBot.js"></script>
	<script src="js/ajaxBot.js"></script>

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
			<?php include('../templates/header_navbar.php'); ?>
					</div>
            <div id="top">
			</div>

            <div id="middle">
			<br/>
<div id="find">
	<section class="top">
		<form class="form-inline" style="padding-left: 10px">
			<input id="instantSearch" 
				style="width: 40%" 
				class="form-control" 
				type="text" 
				placeholder="Search clients..." />
		</form>
	</section>
			<script>
				$(document).ready(function() {
					$("#instantSearch").focus(); 
				}); 

				function instantHandler() {
					if ($(this).val() == "") {
						$("tr[name='client']").each(function() {
							$(this).show(); 
						}); 
					} else {
						showRows($(this).val()); 
					}
				}
				
				function showRows(val) {
					$("tr[name='client']").each(function() {
						if($(this).html().toUpperCase().indexOf(val.toUpperCase()) > -1) {
							$(this).show(); 
						} else {
							$(this).hide(); 
						}
					}); 
				}
				
				$("#instantSearch").on("keydown", instantHandler); 
				$("#instantSearch").on("keyup", instantHandler);
				$("#instantSearch").on("click", instantHandler); 		
			</script>
	<section class="bottom" style="margin-top: 0">
		<div class="row">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Name</th>
						<th>Phone Number</th>
						<th>Email</th>
						<th>Priority</th>
						<th>Language</th>
					</tr>
				</thead>
				<tbody>	

					<?php

					function checkzero($m)
					{
						if ($m == 0)
						{
							$m = 12;
						}

						return $m;
					}

					function addzero($m)
					{

						if ($m < 10)
						{
							$m = "0".$m;
						}

						return strval($m);

					}

					$year = date("Y");
					$month = intval(date("m"));
					$thismonth = addzero($month);
					$lastmonth = addzero(checkzero(($month - 1) % 12));
					$twolastmonth = addzero(checkzero(($month - 2) % 12));

					// prepare and execute
					$sth = $dbh->prepare('SELECT db_Clients.*, db_CaseTypes.Description as Priority FROM db_Clients INNER JOIN db_CaseTypes ON db_CaseTypes.CaseTypeID=db_Clients.CaseTypeID WHERE (db_Clients.CaseTypeID = 61 OR db_Clients.CaseTypeID = 98) AND (db_Clients.LastEditTime LIKE "'.$year.'-'.$thismonth.'-%" OR db_Clients.LastEditTime LIKE "'.$year.'-'.$lastmonth.'-%" OR db_Clients.LastEditTime LIKE "'.$year.'-'.$twolastmonth.'-%")');
					$sth->execute();

					// iterate through rows
					foreach ($sth as $row) {
					?>

						<tr name='client' id='<?php echo $row['ClientID']; ?>' style='cursor : pointer'> 
						<td><?php echo $row['FirstName'] . ", " . $row['LastName']; ?>&nbsp</td>
						<td><?php echo "(" . $row['Phone1AreaCode'] . ") " . $row['Phone1Number']; ?></td> 
						<td><?php echo $row['Email']; ?></td>
						<td><?php echo $row['Priority']; ?></td>
						<td><?php echo $row['Language']; ?></td>
						</tr> 	

					<?php
					}
					?>


				</tbody>
			</table>
			<form id='javascript-form' method='post' style='display: none'>
			</form>
		</div>
	</section>
</div>
<script>
	// disable enter
	$("input").keypress(function (evt) {
		//Determine where our character code is coming from within the event
		var charCode = evt.charCode || evt.keyCode;
		if (charCode  == 13) { //Enter key's keycode
			return false;
		}
	});

	// for the clients now
	$("tr[name='client']").click(function () {		
		window.location.href = "client.php?ClientID=" + $(this).attr('id')
	}); 

	</script>

            </div>
			<div id='bottom'>
								<div class='row' style="padding-top: 10px">
											<p class='pull-left' style='font-size: 13px'>Logged in as <a href='profile.php'>Vojtech Drmota</a>.</p>
										<p class='pull-left' style='text-align: left; font-size: 13px'>Disclaimer: For informational purposes only. The members of the Small Claims Advisory Service are undergraduate students at Harvard College, and are not lawyers. No aspect of this system is designed or intended to dispense legal advice; any actions you may choose to take or not to take in or out of court are at your own discretion.</p> 
					<p class='pull-left'>Questions, concerns, bugs? Notify <a href='mailto:klim01@college.harvard.edu'>klim01@college.harvard.edu</a>.</p>
				</div>
							</div>

    </body>

</html>