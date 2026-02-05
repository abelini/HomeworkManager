<!DOCTYPE html>
<html>
	<head>
		<title><?= $materia ?></title>
		<?= $this->Html->charset(); ?>
		<?= $this->Html->meta('icon') ?>
		<?= $this->Html->css(['normalize.min', 'cake', 'bootstrap-grid.min', 'custom', 'w3']) ?>
		<?= $this->fetch('meta') ?>
		<?= $this->fetch('css') ?>
		<?= $this->fetch('script') ?>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="robots" content="noindex">
		<meta name="robots" content="nofollow">
		<script src="https://kit.fontawesome.com/1abdbfa7bd.js" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
			integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
			crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">
		<style type="text/css">
			#header{background:url('<?= $this->Url->image($headerIMG) ?>') no-repeat;} .mobile-menu{display:none;margin-top:44px;}
			@media only screen and (max-width:640px) {
				.container{display:flex;flex-direction:column; min-height:100vh;} section{padding:0 !important;flex:1;} .container{padding:0 !important;} footer{width:100vw;}
				.spacer{padding:22px;} .site-name{text-transform:uppercase;}
				.w3-blue-gray{background-color:#889ba4 !important} .w3-blue-grey{background-color:#516b78 !important;} h4{font-size:18px !important;} .nav-text{font-size:18px;}
			}
			@media only screen and (max-width:640px) {
				.container{display:flex;flex-direction:column; min-height:100vh;} section{padding:0 !important;flex:1;} .container{padding:0 !important;} footer{width:100vw;}
				.spacer{padding:22px;} .site-name{text-transform:uppercase;}
				.w3-blue-gray{background-color:#889ba4 !important} .w3-blue-grey{background-color:#516b78 !important;} h4{font-size:18px !important;} .nav-text{font-size:18px;}
			}
		</style>
		<?php if($unansweredTopics == 0){ ?>
		<style type="text/css">.not-answered{display:none}</style>
		<?php } ?>
	</head>
	<body data-editor="DecoupledDocumentEditor" data-collaboration="false" data-revision-history="false">
		<div class="container">
			<header id="header" class="w3-hide-small"></header>
			<nav>
				<?php if($isMobile) { ?>
				<ul class="w3-bar w3-blue-grey" id="NavBar">
					<li class="w3-bar-item w3-right"><a href="javascript:void(0);" id="Bars"><i class="fa-solid fa-bars nav-text"></i></a></li>
					<li class="w3-bar-item w3-button w3-monospace nav-text site-name"><?= $this->Html->link($materia, '/', ['escape' => false])?></li>
				<?php } else { ?>
				<ul class="w3-bar w3-light-grey" id="NavBar">
					<li class="w3-bar-item w3-button"><?= $this->Html->link('<i class="fa-solid fa-home"></i> Inicio', '/', ['escape' => false])?></li>
				<?php } ?>
					<li class="w3-bar-item w3-button w3-hide-small"><?= $this->Html->link('<i class="fas fa-comments"></i> Foro <span class="not-answered"><i class="fa-solid fa-circle-exclamation w3-text-red w3-large "></i></span>', '/forum', ['escape' => false])?></li>
					<li class="w3-bar-item w3-button w3-hide-small"><?= $this->Html->link('<i class="fas fa-book"></i> Material', '/material', ['escape' => false])?></li>
					<li class="w3-bar-item w3-button w3-hide-small"><?= $this->Html->link('<i class="fas fa-folder-open"></i> Tareas', '/homeworks', ['escape' => false])?></li>
					<li class="w3-bar-item w3-button w3-hide-small"><?= $this->Html->link('<i class="fa-solid fa-list-ol"></i> Programa', '/programas/'.$subjectID.'/'.urlencode($materia), ['escape' => false])?></li>
					<li class="w3-bar-item w3-button w3-hide-small"><?= $this->Html->link('<i class="fa-regular fa-calendar-days"></i> Calendario', '/calendario/', ['escape' => false])?></li>
					<li class="w3-bar-item w3-right w3-hover-red w3-hide-small"><?= $this->Html->link('<i class="fas fa-sign-out-alt"></i>', '/users/logout', ['escape' => false])?></li>
				</ul>
				<?php if($isMobile) { ?>
				<div id="MobileMenu" class="mobile-menu">
				  <ul class="w3-bar w3-light-grey">
					<li class="w3-bar-item w3-mobile w3-button w3-left-align"><?= $this->Html->link('<i class="fas fa-folder-open"></i> Tareas', '/homeworks', ['escape' => false])?></li>
					<li class="w3-bar-item w3-mobile w3-button w3-left-align"><?= $this->Html->link('<i class="fas fa-book"></i> Material', '/material', ['escape' => false])?></li>
					<li class="w3-bar-item w3-mobile w3-button w3-left-align"><?= $this->Html->link('<i class="fas fa-comments"></i> Asesorías', '/forum', ['escape' => false])?></a></li>
					<li class="w3-bar-item w3-mobile w3-button w3-left-align"><?= $this->Html->link('<i class="fa-solid fa-list-ol"></i> Programa', '/programas/'.$subjectID.'/'.urlencode($materia), ['escape' => false])?></li>
					<li class="w3-bar-item w3-mobile w3-button w3-left-align"><?= $this->Html->link('<i class="fas fa-sign-out-alt"></i> Salir', '/users/logout', ['escape' => false])?></li>
				  </ul>
				</div>
				<?php } ?>
			</nav>

			<section id="content" class="">
				<div class="spacer"></div>
				<div class="w3-container">
					<?= $this->Flash->render()?>
				</div>
				<div class="">
					<?= $this->fetch('content'); ?>
				</div>
			</section>
			<footer id="footer" class="w3-container w3-blue-grey">
				<span class="w3-left w3-text-light-gray" style="padding-top:5px;">Hora del servidor: <?= $today->i18nFormat(\IntlDateFormatter::FULL)?></span>
				<?= $this->Html->link($this->Html->image('https://autumn.ws/wp-content/uploads/2015/10/banner-mini-menu.png', ['alt' => 'Autumn Web Solutions']), 'https://autumn.ws', ['target' => '_blank', 'escape' => false, 'class' => 'w3-right']);?>
			</footer>
		</div>
		<?php if($isMobile){ ?>
		<script>
			$("#Bars").click(function(){
				$("#MobileMenu").toggle(); $(".spacer").toggle();
			});
			$("#NavBar").addClass("w3-top");
		</script>
		<?php } ?>
</body>
</html>