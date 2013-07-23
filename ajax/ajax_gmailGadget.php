<?php if($_GET["password"] == "SCAS1965") : ?>
<?xml version="1.0" encoding="UTF-8" ?>
<Module>
	<ModulePrefs>
		<Require feature="google.contentmatch">
		  <Param name="extractors">
			google.com:HelloWorld
		  </Param>
		</Require>
	</ModulePrefs>


  <Content type="html" view="card">
        <script type="text/javascript" src="http://example.com/gadgets/sso.js"></script>
	  <![CDATA[ 

	  ]]> 
  </Content>
</Module>
<?php endif; ?>
There's literally nothing here yet. 