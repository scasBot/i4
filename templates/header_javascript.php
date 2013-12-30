<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="js/bootstrap_typeahead.js"></script>
<script src="js/tinymce/tinymce.min.js"></script>
<script src="js/jquery-scrollto.js"></script>
<!-- script src="js/date_helpers.js"></script>
<script src="js/validate.js"></script -->
<script src="js/scripts.js"></script>
	
<?php if(LOGGED_IN) : ?>
	<script src="js/emailBot.js"></script>
	<script src="js/ajaxBot.js"></script>
	<script>
		constants.addConstants({
			userName : "<?php echo $_SESSION["username"] ?>", 
			userEmail : "<?php echo $_SESSION["useremail"] ?>",
			userId : "<?php echo $_SESSION["id"] ?>", 
			legalResearchEmail : "<?php echo LEGAL_RESEARCH_EMAIL ?>"
		})	
	</script>
<?php endif; ?>
