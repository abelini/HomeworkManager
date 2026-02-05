<?= $this->Html->script('https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js', [
	'block' => true
])?>
<?= $this->Html->css('https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone.css', [
	'block' => true
])?>
<?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js', [
	'integrity' => 'sha512-ooSWpxJsiXe6t4+PPjCgYmVfr1NS5QXJACcR/FPpsdm6kqG1FmQ2SVyg2RXeVuCRBLr0lWHnWJP6Zs1Efvxzww==',
	'crossorigin' => 'anonymous',
	'referrerpolicy' => 'no-referrer',
	'block' => true,
])?>
<?= $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.css', [
	'integrity' => 'sha512-+VDbDxc9zesADd49pfvz7CgsOl2xREI/7gnzcdyA9XjuTxLXrdpuz21VVIqc5HPfZji2CypSbxx1lgD7BgBK5g==',
	'crossorigin' => 'anonymous',
	'referrerpolicy' => 'no-referrer',
	'block' => true,
])?>

<div class="w3-card">
	<div class="w3-container w3-blue-gray">
		<h4><i class="fa-solid fa-address-card"></i> Información básica</h4>
	</div>
    
    
    <div class="w3-container w3-section">
	
        <?= $this->Form->create($user, ['url' => ['action' => 'update'], 'class' => 'w3-container',])?>
			<div class="w3-row">
				<div class="w3-col s12 m12 l9">
					
					<?= $this->Flash->render('profile')?>
				
					<?= $this->Form->control('nombres', ['label' => ['text' => 'Nombre(s)', 'class' => 'w3-label'], 'class' => 'w3-input'])?>
				
					<?= $this->Form->control('apellidos', array('label' => ['text' => 'Apellidos', 'class' => 'w3-label'], 'class' => 'w3-input'))?>
					
					<?= $this->Form->control('email', array('label' => ['text' => 'Correo electrónico', 'class' => 'w3-label'], 'class' => 'w3-input'))?>
			
					<?= $this->Form->control('group_id', ['label' => false, 'options' => $grupos, 'class' => 'w3-input'])?>
				</div>
				<div class="w3-col s12 m12 l3">
					<?= $this->cell('Avatar::display', [$user, 'w3-circle w3-right', 220])->render()?>
				</div>
			</div>

			<p>Foto de perfil, solo archivos JPG de 2MB máximo (podrás recortar la foto una vez que la subas)</p>

			<div id="cabFlashMsg" class="message success w3-hide" onclick="this.classList.add('hidden')"><i class="fa-regular fa-circle-check"></i> Imagen correctamente guardada</div>
			
			<div class="dropzone" id="profileDropzone"></div>
			
			<p class="w3-khaki w3-border-orange w3-round w3-center w3-padding-large">
				<i class="fa-solid fa-circle-info w3-xlarge w3-left"></i>
				También puedes usar el servicio de <?= $this->Html->link('Gravatar', 'https://es.gravatar.com/')?>&reg; para tener una foto de perfil vinculada a tu dirección de correo. Simplemente sube la imagen a Gravatar&reg; y aparecerá automáticamente aquí y en todos los sitios compatibles en Internet. Por cierto, lo único que necesitas es una cuenta de WordPress&reg; y listo.
			</p>

			<?= $this->Form->control('id')?>
			<?= $this->Form->submit('Guardar', ['class' => 'w3-button w3-blue w3-round'])?>
        <?= $this->Form->end()?>
    </div>
</div>

<div class="w3-card" id="password">
    <div class="w3-container w3-blue-gray">
		<h4><i class="fa-solid fa-key"></i> Cambiar contraseña</h4>
	</div>
	
	<div class="w3-container">
	
		<?= $this->Flash->render('password')?>
	
		<div class="w3-container w3-margin-top">
			<p>No uses la misma contraseña para todas tus cuentas. Procura usar mayúsculas, minúsculas, números y símbolos.</p>
		</div>
	
		<?= $this->Form->create($user, ['url' => ['action' => 'password'], 'class' => 'w3-container',])?>
		
			<?= $this->Flash->render('password')?>
			
			<?//= $this->Form->control('password', ['label' => false, 'class' => 'w3-input', 'value' => '', 'div' => false, 'placeholder' => 'Escribe tu nueva contraseña...'])?>
			<div class="password-container">
				<input type="password" name="password" class="w3-input psw" placeholder="Escribe tu nueva contraseña..." required="required" data-validity-message="This field cannot be left empty" oninvalid="this.setCustomValidity(''); if (!this.value) this.setCustomValidity(this.dataset.validityMessage)" oninput="this.setCustomValidity('')" id="InputPassword" aria-required="true" aria-label="Escribe tu nueva contraseña..." value=""/>
				<i class="fa-regular fa-eye" id="togglePassword"></i>
			</div>
			<?= $this->Form->control('id')?>
			
			<?= $this->Form->submit('Guardar', ['class' => 'w3-btn w3-blue w3-round'])?>
        <?= $this->Form->end()?>
	</div>
</div>

<style>
	.input{margin-top:24px;}
	.password-container{position: relative;}
	.password-container input[type="password"], .password-container input[type="text"]{
		width:100%;padding: 12px 36px 12px 12px;	box-sizing: border-box;
	}
	.password-container i{
		position: absolute;top: 28%;right: 4%;cursor:pointer;color:gray;
	}
	@media only screen and (max-width:640px) {
		img.w3-circle{display:block;margin:auto;float:none !important;padding:8px;}
	}
</style>
<script>
	$("#togglePassword").click(function() {
		$(this).toggleClass("fa-eye fa-eye-slash"); 
		const input = $("#InputPassword");
		input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password');
	});
</script>

<script type="text/javascript">
	const profileDropzone = new Dropzone("#profileDropzone", {
		url: '<?= $this->Url->build(['action' => 'thumbnail'])?>',
		dictDefaultMessage: 'Arrastra aquí la imagen',
		acceptedFiles: "image/jpeg, image/webp",
		transformFile: function(file, done){
			dropAndCrop(file, done, this);
		}
	});

	profileDropzone.on('success', function(file) {
		$('#cabFlashMsg').removeClass('w3-hide'); $('#cabFlashMsg').addClass('w3-show');
	});

	function dropAndCrop(file, done, transformFile) {
			// Create Dropzone reference for use in confirm button click handler
			var dropzone = transformFile;
			var editor = document.createElement('div');
			editor.style.position = 'fixed';
			editor.style.left = 0;
			editor.style.right = 0;
			editor.style.top = 0;
			editor.style.bottom = 0;
			editor.style.zIndex = 9999;
			editor.style.backgroundColor = '#000';
			document.body.appendChild(editor);
			
			// Create confirm button at the top left of the viewport
			var buttonConfirm = document.createElement('button');
			buttonConfirm.style.position = 'absolute';
			buttonConfirm.style.left = '10px';
			buttonConfirm.style.top = '10px';
			buttonConfirm.style.zIndex = 9999;
			buttonConfirm.textContent = 'Recortar y continuar';
			editor.appendChild(buttonConfirm);
			buttonConfirm.addEventListener('click', function(){
				// Get the canvas with image data from Cropper.js
				var canvas = cropper.getCroppedCanvas({width:920});
				// Turn the canvas into a Blob (file object without a name)
				canvas.toBlob(function(blob){
					// Create a new Dropzone file thumbnail
					dropzone.createThumbnail(
						blob,
						dropzone.options.thumbnailWidth,
						dropzone.options.thumbnailHeight,
						dropzone.options.thumbnailMethod,
						false, 
						function(dataURL) {
							// Update the Dropzone file thumbnail
							dropzone.emit('thumbnail', file, dataURL);
							// Return the file to Dropzone
							done(blob);
						}
					);
				});
				// Remove the editor from the view
				document.body.removeChild(editor);
			});
			
			// Create an image node for Cropper.js
			var image = new Image();
			image.src = URL.createObjectURL(file);
			editor.appendChild(image);

			// Create Cropper.js
			var cropper = new Cropper(image, {aspectRatio: 1, viewMode:2});
		}
</script>
<style type="text/css">
	.dropzone{border:2px dashed rgba(20, 81, 198, 0.3) !important;}
</style>
