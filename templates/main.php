<div class="banner home">
<img src="img/scas_logo.png" style="width: 600px; margin-top: -65px;"/>
</div>
<div class="banner-after" style="margin-bottom: 50px">
<?
	// extrapolate person and quote from given string
	$index = strpos($quote, " - ");
	$person = substr($quote, $index + 2);
	$quote = substr($quote, 1, $index - 2);
?>

<h3 class="quote"><?php echo $quote ?></h3>
<p> - <?php echo $person;?> </p>
</div>
