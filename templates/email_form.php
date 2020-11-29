<?php
function htmlInputField($name, $type, $class = null, 
	$val = null, $required = false) {
	
	$html = "<input " ; 
	$html .= "name='" . $name . "' "; 
	$html .= "type='" . $type . "' ";
	$html .= (is_null($class) ? "" : "class='" . $class . "' "); 
	$html .= (is_null($val) ? "" : "value='" . $val . "' "); 
	$html .= (is_null($required) ? "" : "required "); 	
	$html .= " />"; 
	
	return $html; 
}
?>

<div class="row">
	<div class="span3"></div>
	<div class="span6">
		<form id="emailForm" action="email.php" method="POST" class="form-horizontal">

			<legend>SCAS Assistance Request</legend>
			<?php if(!empty($warning)) : ?>
				<p style="color: #FF2222; font-size: 15px" > <?php echo $warning ?> </p>
			<?php endif; ?>			
			<p>*(denotes required field)</p>
			<div class="control-group">
				<label class="control-label">First Name: *</label>
				<div class="controls">
					<input name="FirstName" type="text" class="input-large" 
						value="<?php echo $FirstName ?>" required />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Last Name: *</label>
				<div class="controls">
					<input name="LastName" type="text" class="input-large" 
						value="<?php echo $LastName ?>" required />
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<label class="checkbox">
						<input name="Contacted" type="checkbox" 
							<?php echo (!empty($Contacted) ? "checked" : "") ?> />
							Have you contacted us before?
					</label>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">E-mail Address: *</label>
				<div class="controls">

					<input name="Email" type="email" class="input-large" 
						value="<?php echo $Email ?>" required/>
				</div>
				<!--type e-mail incompatible with safari-->
			</div>
			<div class="control-group">
				<label class="control-label">Phone Number:</label>
				<div class="controls">
					<input name="Phone" type="tel" class="input-large" 
						value="<?php echo $Phone ?>" />
				</div>
				<!-- type "tel" act same as "text" as of now.-->
			</div>
			<div class="control-group">
				<label class="control-label">Zip Code:</label>
				<div class="controls">
					<input name="Zip" type="text" class="input-large" maxlength=5 
						value="<?php echo $Zip ?>" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Language: </label>
				<div class="controls">
					<select name="Language" class="input-large">
						<option value=""></option>
						<?php 
							$languages = array(
								"English" => "English", 
								"Cantonese" => "Cantonese", 
								"Korean" => "Korean", 
								"Mandarin" => "Mandarin", 
								"Spanish" => "Spanish", 
								"Other" => "Other"
							); 

							try {
								echo htmlOptions($languages, $Language); 
							} catch(Exception $e) {
								echo htmlOptions($languages); 
							}							
						?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Subject: *</label>
				<div class="controls">
					<input name="Subject" type="text" class= "input-large" 
						value="<?php echo $Subject ?>" required/>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Message: *</label>
				<div class="controls">
					<textarea name="Message" rows=10 class="input-large" placeholder="Please summarize the issue..." required><?php echo $Message ?></textarea>
				</div>
			</div>
			<!-- a verification code needs to be inserted here-->
			<!-- <?php echo $captcha ?> -->
			<br />
			<button id="emailFormSubmit" class="btn btn-primary">Submit</button>
		</form>
	</div>
	<div class="span3"></div>
</div>