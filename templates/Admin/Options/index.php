	<div class="w3-card w3-section">
		<div class="w3-container w3-blue-gray">
			<h4><i class="fa-solid fa-rainbow"></i> Curso</h4>
		</div>
		<div class="w3-container">

			<?= $this->Flash->render('config-name')?>
			
			<?= $this->Form->create(null, ['url' => ['action' => 'setCourse'], 'type' => 'put', 'class' => 'w3-container w3-section'])?>
				<?= $this->Form->control('value', ['options' => $subjects, 'value' => $options['course']->subjectID, 'label' =>  ['text' => 'Nombre', 'class' => 'w3-label'], 'class' => 'w3-input'])?>
				
				<?php echo $this->Html->link('<i class="fa-solid fa-pen-to-square"></i> Establecer el programa de «'.$subjects[$options['course']->subjectID].'»', ['controller' => 'subjects', 'action' => 'edit', $options['course']->subjectID], ['escape' => false, 'class' => 'w3-button w3-right w3-round w3-light-gray', 'style' => 'margin-top:20px'])?>
				
				<?= $this->Form->submit('Guardar', ['class' => 'w3-button w3-blue w3-round w3-left'])?>
			<?= $this->Form->end()?>
		</div>
	</div>
	
	<div class="w3-card w3-section">
		<div class="w3-container w3-blue-gray">
			<h4><i class="fa-solid fa-clock-rotate-left"></i> Tareas</h4>
		</div>
		<div class="w3-container">

			<?= $this->Flash->render('config-homeworks')?>
			
			<?= $this->Form->create(null, ['url' => ['action' => 'setLockHomeworks'], 'type' => 'PUT', 'class' => 'w3-container w3-section'])?>
					<fieldset class="w3-round">
						<legend>Expiración de tareas:</legend>
						<?= $this->Form->radio('Homeworks.fullAccess', 
									[
										['value' => 0, 'text' => 'Todas las tareas expiran según su configuración individual', 'class' => 'w3-radio', 'label' => ['class' => 'w3-block']],
										['value' => 1, 'text' => 'Todas las tareas están accesibles para todos', 'class' => 'w3-radio', 'label' => ['class' => 'w3-block']],
									]
						); ?>
					</fieldset>
					<?= $this->Form->submit('Guardar', ['class' => 'w3-button w3-blue w3-round'])?>
			<?= $this->Form->end()?>
		</div>
	</div>
	
	<div class="w3-card w3-section">
		<div class="w3-container w3-blue-gray">
			<h4><i class="fa-solid fa-lock"></i> Bloqueo de acceso</h4>
		</div>
	
		<div class="w3-container">

			<p>Desde aquí puede bloquear el acceso al portal y dejar un mensaje a quién <em>intente</em> <strong>iniciar sesión</strong></p>

			<?php if($options['lock']->status === true){ ?>
			<div class="message error"><i class="fa-solid fa-lock"></i> El portal se encuentra actualmente bloqueado</div>
			<?php } ?>
			
			<?= $this->Flash->render('config-lock')?>
			
			<?= $this->Form->create(null, ['url' => ['action' => 'setPlatformLock'], 'type' => 'put', 'class' => 'w3-container w3-section'])?>
			
				<fieldset class="w3-round">
					<legend>Acceso:</legend>
					<?= $this->Form->radio('Lock.status', 
									[
										['value' => 0, 'text' => ' Desbloqueado', 'onchange' => 'showMessageInput(this.value)', 'class' => 'w3-radio', 'label' => ['class' => 'w3-block']],
										['value' => 1, 'text' => ' Bloqueado', 'onchange' => 'showMessageInput(this.value)', 'class' => 'w3-radio', 'label' => ['class' => 'w3-block']],
									]
					); ?>
					
					<div id="LockMessageConfig" class="w3-hide w3-section">
						<label for="LockMessage" class="w3-label">Mensaje de aviso de bloqueo</label>
						<?= $this->Form->control('Lock.message', ['value' => $options['lock']->message, 'class' => 'w3-input', 'id' => 'LockMessage', 'label' => false])?>
						
						<div class="w3-group w3-margin-top">
							<label for="LockExpiration" class="w3-label">Fecha del fin del bloqueo</label>
							<?= $this->Form->control('Lock.expiration', ['value' => $options['lock']->expiration, 'class' => 'w3-input', 'id' => 'LockExpiration', 'label' => false])?>
						</div>
					</div>
				</fieldset>
				<?= $this->Form->submit('Guardar', ['class' => 'w3-button w3-blue w3-round'])?>
			<?= $this->Form->end()?>
		</div>
	</div>
	
	<div class="w3-card w3-section">
		<div class="w3-container w3-blue-gray">
			<h4><i class="fa-solid fa-lock"></i> Bloqueo de nuevos registros</h4>
		</div>
	
		<div class="w3-container">
			
			<?= $this->Flash->render('config-signup')?>
			
			<?= $this->Form->create(null, ['url' => ['action' => 'setAllowSignup'], 'type' => 'PUT', 'class' => 'w3-container w3-section'])?>
					<fieldset class="w3-round">
						<legend>¿Permitir que los alumnos nuevos se registren?</legend>
						<?= $this->Form->radio('Register.allow', 
										[
											['value' => 1, 'text' => ' Sí', 'class' => 'w3-radio', 'label' => ['class' => 'w3-block']],
											['value' => 0, 'text' => ' No', 'class' => 'w3-radio', 'label' => ['class' => 'w3-block']],
										]
						); ?>
					</fieldset>
				<?= $this->Form->submit('Guardar', ['class' => 'w3-button w3-blue w3-round'])?>
			<?= $this->Form->end()?>
		</div>
	</div>
	
	<div class="w3-card w3-section">
		<div class="w3-container w3-blue-gray">
			<h4><i class="fa-solid fa-star"></i> Calificaciones</h4>
		</div>

		<div class="w3-container w3-row-padding">
			
			<?= $this->Flash->render('config-score')?>
			
			<?= $this->Form->create(null, ['url' => ['action' => 'setScoreValues'], 'type' => 'PUT', 'class' => 'w3-container w3-section'])?>
				
				<fieldset>
					<legend>Para calcular el promedio</legend>
					<div class="w3-half w3-padding">
						<?= $this->Form->label('scoreConfig.NP', 'Establezca el valor numérico de NP <strong>(No Presentó)</strong>', ['class' => 'w3-label', 'escape' => false]);?>
						<?= $this->Form->select('scoreConfig.NP', $scores, ['value' => $options['scoreConfig']->NP, 'class' => 'w3-input'])?>
					</div>
					<div class="w3-half w3-padding">
						<?= $this->Form->label('scoreConfig.NV', 'Establezca el valor numérico de NV <strong>(No Valorable)</strong>', ['class' => 'w3-label', 'escape' => false]);?>
						<?= $this->Form->select('scoreConfig.NV', $scores, ['value' => $options['scoreConfig']->NV, 'class' => 'w3-input'])?>
					</div>
				</fieldset>
				<?= $this->Form->submit('Guardar', ['class' => 'w3-button w3-blue w3-round'])?>
			<?= $this->Form->end()?>
		</div>
	</div>
	
	<?php debug($options)?>


<?= $this->Html->css('/css/jquery.datetimepicker.min.css')?>
<?= $this->Html->script(['/js/jquery.js', '/js/jquery.datetimepicker.full.min.js']); ?>

<script>
	function showMessageInput(value){
		if(value == 1){
			document.getElementById('LockMessageConfig').classList.add('w3-show');
		}
		else {
			document.getElementById('LockMessageConfig').classList.remove('w3-show');
		}
	}
	<?php if($options['lock']->status == 0){ ?>
	$("#lock-status-0").attr('checked', true);
	<?php } else { ?>
	$("#lock-status-1").attr('checked', true);
	document.getElementById('LockMessageConfig').classList.add('w3-show');
	<?php } ?>
	
	<?php if($options['register']->allow === true){ ?>
	$("#register-allow-1").attr('checked', true);
	<?php } else { ?>
	$("#register-allow-0").attr('checked', true);
	<?php } ?>
	
	<?php if($options['homeworks']->fullAccess === true){ ?>
		$("#homeworks-fullaccess-1").attr('checked', true);
	<?php } else { ?>
		$("#homeworks-fullaccess-0").attr('checked', true);
	<?php } ?>
	jQuery.datetimepicker.setLocale('es');
	jQuery('#LockExpiration').datetimepicker({value:'<?= $options['lock']->expiration ?>', format:'Y-m-d H:i', lang:'es', minDate:0, minTime:0,
			i18n:{es:{
				months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				dayOfWeek:['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab']
			}}
		});
</script>

<style>
	input[type=radio]{margin-right:8px;} select{margin-top:8px;} .message{margin-top:16px;}
</style>