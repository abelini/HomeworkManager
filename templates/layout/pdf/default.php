<?php header("Content-type: application/pdf");?>
<!doctype html>
<html>
	<head>
		<title>Kardex del <?= $grupo->grupo ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		
	</head>
	<body class="w3-padding-large">
		<?= $this->fetch('content') ?>
		
		<style>
			html,body{font-family:Verdana,sans-serif;font-size:14px;line-height:1.2}
			.b{font-weight:bold;} .header{height:150px;}
			h1{font-size:28px;}
			h2{font-size:20px;}
			h3{font-size:18px;}
		</style>
	</body>
</html>
