<?php
	function enTete($title)
	{
		echo '<html>
			<head>
				<title> Index </title>
				<link rel="stylesheet" type="text/css" href="style.css" />
			</head>
			<body>
				<div id="site">
					<div id="header">'
						.$title.
					'</div>';
	}
	
	function pied()
	{
		echo '		<div id="footer">
						Footer
					</div>
				<div>
			</body>
			</html>';
	}
?>