<?= $this->Html->script('https://www.google.com/recaptcha/api.js?render=6LfxQs4UAAAAAASIykjO16lpd3v_k_eJE0-Kei__', ['block' => true])?>

<div id="login" class="w3-card-4 w3-row">
	
	<div class="w3-half w3-padding">
		<?= $this->Html->image('historia-logo.webp', ['class' => 'w3-left historia-logo'])?>
		<h5>UNIVERSIDAD AUTÓNOMA DE SINALOA</h5>
		<h6>FACULTAD DE HISTORIA</h6>
		<h1><?= $materia ?></h1>
		
		<p class="w3-text-gray">¡Bienvenido a la plataforma de tareas para la clase de historia!</p>
		<p class="w3-text-gray">Por favor rellena los campos para completar tu registro. Una vez enviado, el profesor validará la información y de ser aceptado, recibirás un correo de notificación.</p>
		
		<?= $this->Flash->render()?>
		
		<?php if($register->allow) { ?>
			<?= $this->Form->create($user, ['class' => 'w3-container w3-margin-top w3-margin-bottom'])?>
					
				<?= $this->Form->control('email', ['label' => false, 'class' => 'w3-input', 'placeholder' => 'Correo electrónico'])?></dd>
				
				<?= $this->Form->control('password.0', ['type' => 'password', 'label' => false, 'placeholder' => 'Contraseña', 'class' => 'w3-input'])?>
					
				<?= $this->Form->control('password.1', ['type' => 'password', 'label' => false, 'placeholder' => 'Confirmar contraseña', 'class' => 'w3-input'])?>
				
				<?= $this->Form->control('group_id', ['options' => $grupos, 'label' => false, 'empty' => 'Selecciona tu grupo', 'class' => 'w3-input'])?>
				
				<?= $this->Form->control('nombres', ['label' => false, 'placeholder' => 'Nombre(s)', 'class' => 'w3-input'])?>
				
				<?= $this->Form->control('apellidos', ['label' => false, 'placeholder' => 'Apellidos', 'class' => 'w3-input'])?></dd>
				
				<input type="hidden" name="recaptcha_response" id="recaptchaResponse"/>
				
				<div class="g-recaptcha w3-section" data-sitekey="6LeTDy4UAAAAACnQCW21H8hUG1qWfk_jaISJJs6a"></div>
				
				<?= $this->Form->submit('Enviar registro', ['class' => 'w3-button w3-blue w3-round'])?>
			<?= $this->Form->end()?>
			
			<p class="w3-text-gray w3-small w3-margin-top">Al enviar tu registro aceptas los <?= $this->Html->link('términos y condiciones', '/terms/conditions')?> y la <?= $this->Html->link('política de privacidad', '/terms/privacy')?> de la plataforma académica.</p>
	    <?php } else { ?>
	    
			<div class="message error"><i class="fa-solid fa-lock"></i> El portal se encuentra actualmente cerrado para nuevos registros</div>
	    
	    <?php } ?>
	</div>
	<div class="w3-half cover">
		<div class="cccc"></div>
	</div>
</div>

<script type="text/javascript">
	grecaptcha.ready(function(){
		grecaptcha.execute('6LfxQs4UAAAAAASIykjO16lpd3v_k_eJE0-Kei__', {action: 'signup'}).then(function(token){
			var recaptchaResponse = document.getElementById('recaptchaResponse');
			recaptchaResponse.value = token;
		});
	});
</script>
<style type="text/css">
	h1{letter-spacing:-3px;}
	.error-message{color:red;margin:0;} div.input{margin-top:16px;} .historia-logo{width:64px;margin:8px 16px 0 0;} p.w3-margin-top{margin-top:56px !important;}

	.w3-half{height:100%;} p {font-family: "Segoe UI", Arial, sans-serif;}
	.cover{background-image:url('<?= $this->Url->build('/img/courses/bg/landing.webp')?>');background-position: center;  background-repeat: no-repeat;height:800px;}
</style>