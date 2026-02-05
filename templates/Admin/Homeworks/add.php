<?= $this->Html->css('ckeditor', ['block' => 'css']);?>
<?= $this->Html->script('ckeditor-5/ckeditor.js', ['block' => 'script']); ?>

<div class="w3-section">
	<div class="w3-container w3-blue-gray">
		<h4><i class="fa-solid fa-pen-to-square"></i> Subir una tarea en nombre de un alumno</h4>
	</div>
    
    <?= $this->Form->create($homework, ['url' => ['action' => 'save'], 'type' => 'file', 'class' => 'w3-section'])?>
    
        <div class="w3-row">
			<div class="w3-col"><h3 class="w3-left notice"><?= $paper->name ?></h3></div>
		</div>
		
		<?= $this->Flash->render()?>
		
		<?= $this->Form->hidden('titulo', ['value' => $paper->name, 'label' => false, 'class' => 'w3-input w3-section',])?>
        
		<?= $this->Form->select('user_id', $alumnos, ['id' => 'HomeworkUserId', 'label' => false, 'class' => 'w3-input w3-section', 'empty' => 'Seleccione un alumno'])?>
	  
		<?php if($paper->requireSlide()){ ?>
			<div class="w3-section w3-container w3-light-gray w3-padding-16">
				<p class="w3-center w3-text-gray">Archivos <i class="fa-solid fa-file-powerpoint"></i> PPTX (PowerPoint&reg;) solamente</p>
				<?= $this->Form->file('slide.file', array('label' => false, 'class' => 'w3-input file'))?>
			</div>
		<?php } else {?>
			
			<?= $this->Form->input('texto', ['id' => 'HomeworkTexto', 'class' => 'w3-input', 'label' => false,])?>
			<div class="centered">
				<div class="row">
					<div class="document-editor__toolbar"></div>
				</div>
				<div class="row row-editor">
					<div class="editor-container">
						<div id="editor" class="editor"></div>
					</div>
				</div>
			</div>
       
	   <?php } ?>
        
			<?= $this->Form->hidden('paper_id')?>
			<?= $this->Form->submit('Guardar tarea', ['class' => 'w3-button w3-round w3-blue', 'id' => 'submit'])?>
		<?= $this->Form->end()?>
</div>


<script type="text/javascript">
	var userID = 3;
	DecoupledDocumentEditor
		.create(document.querySelector('#editor'), {
			licenseKey: '',
			simpleUpload: {
				uploadUrl: '<?= $this->Url->build('/homeworks/multipleImageUpload?pID='.$paper->get('id'))?>&uID=<?= $this->Identity->get('id')?>',
				withCredentials: true,
				headers: {
				    'X-CSRF-TOKEN': '<?= $this->request->getAttribute('csrfToken')?>',
				    Authorization: 'Bearer <JSON Web Token>',
				},
			},
			image: {
				upload: {
					types: ['jpeg'],
				}
			},
		})
		.then(editor => {
			window.editor = editor;
			document.querySelector( '.document-editor__toolbar' ).appendChild( editor.ui.view.toolbar.element );
			document.querySelector( '.ck-toolbar' ).classList.add( 'ck-reset_all' );
		})
		.catch(error => {
			console.error(error);
		});
		
		$('#HomeworkUserId').change(function() {
			console.log(userID);
			userID = $('#HomeworkUserId').val();
			console.log(userID);
		});
		
		$('#submit').click(function(){
			let error = false, style = {'border':'2px red solid'};
			$('#HomeworkTexto').val(editor.getData());
			if($('#HomeworkTexto').val() == ''){
				$('#editor').css(style);
				error = true;
			} else $('#editor').css({'border':'none'});
			if($('#HomeworkUserId').val() == ''){
				$('#HomeworkUserId').css(style);
				error = true;
			} else $('#HomeworkUserId').css({'border':'none'});
			return !error;
		});
</script>

<style type="text/css">
	#HomeworkTexto, #HomeworkTitulo{display:none;} h3{margin-top:0;} .w3-modal{z-index:20;} .centered{padding:0;} #footer{margin:0;}
	body[data-editor="DecoupledDocumentEditor"] .collaboration-demo__editable, body[data-editor="DecoupledDocumentEditor"] .row-editor .editor{width:calc(21cm + 100px);}
</style>