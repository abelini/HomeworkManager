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
			<p class="w3-text-gray">Hola. Por favor inicia sesión para continuar.</p>
			<?= $this->Flash->render()?>
		
		<?php if(true /* plataforma no bloqueada */){ ?>
			<?= $this->Form->create() ?>
					
				<?= $this->Form->control('email', ['class' => 'w3-input', 'placeholder' => 'Correo electrónico', 'label' => false]) ?>
				
				<div class="input password password-container">
					<input type="password" name="password" class="w3-input" placeholder="Contraseña" id="password" aria-label="Contraseña">
					<i class="fa-regular fa-eye" id="togglePassword"></i>
				</div>
				
				<input type="hidden" name="recaptcha" id="recaptchaResponse"/>
				
				<div class="g-recaptcha w3-section" data-sitekey="6LeTDy4UAAAAACnQCW21H8hUG1qWfk_jaISJJs6a"></div>
				
				<?php echo $this->Html->link('Regístrate', '/users/register', ['escape' => false, 'class' => 'w3-button w3-right w3-round w3-border w3-border-blue'])?>
				
				<?= $this->Form->submit('Iniciar sesión', ['class' => 'w3-button w3-blue w3-round w3-left'])?>
			<?= $this->Form->end()?>
			
			<p class="w3-text-gray w3-margin-top w3-center"><?= $this->Html->link('<i class="fa-regular fa-circle-question"></i> ¿Olvidaste tu contraseña?', '/users/retrieve?_=password', ['escape' => false])?></p>
			
	    <?php } else { ?>
	    
			<div class="message error"><i class="fa-solid fa-lock"></i> El portal se encuentra actualmente cerrado para nuevos registros</div>
	    
	    <?php } ?>
	    </div>
	    <p class="w3-text-gray w3-small w3-margin-top w3-display-bottomleft">Al enviar tu registro aceptas los <?= $this->Html->link('términos y condiciones', '/terms/conditions')?> y la <?= $this->Html->link('política de privacidad', '/terms/privacy')?> de la plataforma académica.</p>
	</div>
	<div class="w3-half cover">
		<div class="cccccc"></div>
	</div>
</div>

<script type="text/javascript">
	grecaptcha.ready(function(){
		grecaptcha.execute('6LfxQs4UAAAAAASIykjO16lpd3v_k_eJE0-Kei__', {action: 'login'}).then(function(token){
			$('#recaptchaResponse').val(token);
		});
	});
</script>
<style>
	.input{margin-top:24px;}
	.password-container{position: relative;}
	.password-container input[type="password"], .password-container input[type="text"]{
		width:100%;box-sizing: border-box;
	}
	.password-container i{
		position: absolute;top: 28%;right: 4%;cursor:pointer;color:gray;
	}
</style>
<script>
	$("#togglePassword").click(function() {
		$(this).toggleClass("fa-eye fa-eye-slash"); 
		const input = $("#password");
		input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password');
	});
</script>

