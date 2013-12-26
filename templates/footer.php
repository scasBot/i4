
            </div>
			<div id='bottom'>
				<div class='row' style="padding-top: 10px">
					<?php if(LOGGED_IN) : ?>
						<p class='pull-left' style='font-size: 13px'>Logged in as <a href='profile.php'><?php echo $_SESSION["username"] ?></a>.</p>
					<?php endif; ?>
					<p class='pull-left' style='text-align: left; font-size: 13px'>Disclaimer: For informational purposes only. The members of the Small Claims Advisory Service are undergraduate students at Harvard College, and are not lawyers. No aspect of this system is designed or intended to dispense legal advice; any actions you may choose to take or not to take in or out of court are at your own discretion.</p> 
					<p class='pull-left'>Questions, concerns, bugs? Notify <a href='mailto:<?php echo ADMIN_EMAIL ?>'><?php echo ADMIN_EMAIL ?></a>.</p>
				</div>
			</div>
		</div>

    </body>

</html>
