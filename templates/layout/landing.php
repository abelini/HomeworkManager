<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $materia ?></title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">
	<meta name="robots" content="noindex">
	<meta name="robots" content="nofollow">
	<meta name="googlebot" content="noindex">
	<?= $this->Html->css([ 'cake']) ?>
	<?= $this->Html->css('https://www.w3schools.com/w3css/4/w3.css') ?>
	<?= $this->fetch('meta') ?>
	<?= $this->fetch('css') ?>
	<?= $this->fetch('script') ?>
	<?= $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js')?>
	<?= $this->Html->script('https://kit.fontawesome.com/1abdbfa7bd.js')?>
    <style>
		html, body{height:100%;}
		.landing{
			height:100%;background-image:url('<?= $this->Url->image($background)?>');background-position:center;
			background-repeat:no-repeat; background-size:cover;background-attachment:fixed;
		}
		.sign {
			display:block; width:900px; height:800px;margin:32px auto;
		}
		h5{margin-bottom:0;} h6{margin-top:0;} h1{margin-top:16px;}
	</style>
	
</head>
<body class="landing">
	<div class="bg">
		<div class="sign w3-white w3-round">
			<?= $this->fetch('content') ?>
		</div>
	</div>
	<style type="text/css">
		h1{letter-spacing:-3px;} #login{height:800px;box-shadow:15px 15px 180px #000;} .w3-display-topleft, .w3-display-middle, .w3-display-bottomleft {padding:16px;} .w3-display-middle{width:100%;}
		.w3-display-topleft{width:100%;} h5,h6{letter-spacing:-1px;}
		.error-message{color:red;} div.input{margin-top:16px;} .historia-logo{width:64px;margin:8px 16px 0 0;} p.w3-margin-top{margin-top:76px !important;} .c{clear:both;}
		.w3-half{height:100%;} p {font-family: "Segoe UI", Arial, sans-serif;}
		.cover{background-image:url('<?= $this->Url->build($cover)?>');background-position: center;  background-repeat: no-repeat;height:800px;}
		@media (280px <= width <= 640px) {
			.sign{width:100%;} .cover{display:none;} #login, .sign{height:auto;} .w3-display-container{height:92vh;} h1{line-height:1.2;}
		}
	</style>
</body>
</html>
