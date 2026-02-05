<?= $this->Html->script('https://www.google.com/recaptcha/api.js?render=6LfxQs4UAAAAAASIykjO16lpd3v_k_eJE0-Kei__', ['block' => true])?>

<div id="login" class="w3-card-4 w3-row">
	
	<div class="w3-half w3-padding w3-display-container">
		<div class="w3-display-topleft">
			<?= $this->Html->image('historia-logo.webp', ['class' => 'w3-left historia-logo'])?>
			<h5>UNIVERSIDAD AUTÓNOMA DE SINALOA</h5>
			<h6>» FACULTAD DE HISTORIA</h6>
			<h1><?= $materia ?></h1>
		</div>
		
		
		<div class="w3-display-middle">
			
			<div class="w3-section w3-padding-large w3-round w3-pale-red w3-text-red w3-border w3-border-red" onclick="this.classList.add('hidden')">
	<i class="fa-solid fa-circle-xmark w3-text-red"></i> Un problema con la conexión SMTP está evitando que el sistema envíe correos. Si tienes problemas para acceder a tu cuenta indícaselo a tu profesor y enseguida se te generará una contraseña nueva.</div>
	
	
			<p class="w3-text-gray">Proporciona el correo que usas para ingresar.</p>
			<?= $this->Flash->render()?>
		
			<?= $this->Form->create() ?>
					
				<?= $this->Form->control('email', ['class' => 'w3-input', 'placeholder' => 'Correo electrónico', 'label' => false]) ?>
				
				<input type="hidden" name="recaptcha" id="recaptchaResponse"/>
				
				<div class="g-recaptcha w3-section" data-sitekey="6LeTDy4UAAAAACnQCW21H8hUG1qWfk_jaISJJs6a"></div>
				
				<?php //echo $this->Html->link('Regístrate', '/users/register', ['escape' => false, 'class' => 'w3-button w3-right w3-round w3-border w3-border-blue'])?>
				
				<?= $this->Form->submit('Enviar', ['class' => 'w3-button w3-blue w3-round w3-left'])?>
			<?= $this->Form->end()?>

			
	    </div>
	    <p class="w3-text-gray w3-small w3-display-bottomleft">Al enviar tu registro aceptas los <strong>términos y condiciones</strong> y la <strong>política de privacidad</strong> de la plataforma académica.</p>
	</div>
	<div class="w3-half">
		<div class="cover"></div>
	</div>
</div>

<script type="text/javascript">
	grecaptcha.ready(function(){
		grecaptcha.execute('6LfxQs4UAAAAAASIykjO16lpd3v_k_eJE0-Kei__', {action: 'retrieve'}).then(function(token){
			$('#recaptchaResponse').val(token);
		});
	});
</script>
<style type="text/css">
	h1{letter-spacing:-3px;} #login{height:800px;} .w3-display-topleft, .w3-display-middle, .w3-display-bottomleft {padding:16px;} .w3-display-middle{width:100%;}
	.error-message{color:red;} div.input{margin-top:16px;} .historia-logo{width:64px;margin:8px 16px 0 0;} p.w3-margin-top{margin-top:76px !important;} .c{clear:both;}
	.w3-half{height:100%;} p {font-family: "Segoe UI", Arial, sans-serif;}
	.cover{background-image:url('<?= $this->Url->build('/img/courses/bg/landing.webp')?>');background-position: center;  background-repeat: no-repeat;height:800px;}
</style>

