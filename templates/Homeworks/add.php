<?//= $this->Html->css('ckeditor', ['block' => 'css']);?>
<?//= $this->Html->script('ckeditor-5/ckeditor.js', ['block' => 'script']); ?>
<?= $this->Html->css('cke-test', ['block' => 'css']);?>
<?= $this->Html->script('cke-test/ckeditor.js', ['block' => 'script']); ?>

<div class="w3-section">
	<div class="w3-container w3-blue-gray">
		<h4><i class="fa-solid fa-pen-to-square"></i> <?= $action ?></h4>
	</div>
    
    <?= $this->Form->create($homework, ['type' => 'file', 'class' => 'w3-section'])?>
    
        <div class="w3-row">
			<div class="w3-col l9 m6 s12"><h3 class="w3-left notice"><?= $paper->get('name') ?></h3></div>
			<div class="w3-col l3 m6 s12"><button onclick="document.getElementById('PaperDescription').style.display='block'; return false;"
				class="w3-button w3-light-gray w3-border w3-right">Ver descripción de la tarea <i class="fas fa-external-link-alt"></i></button>
			</div>
		</div>
		
		<?= $this->Flash->render()?>
		
		<?= $this->Form->input('titulo', ['value' => $paper->get('name'), 'label' => false, 'class' => 'w3-input w3-section', 'id' => 'HomeworkTitulo'])?>
        
		<?php if($paper->get('slide')){ ?>
			<div class="w3-section w3-container w3-light-gray w3-padding-16">
				<p class="w3-center w3-text-gray">Archivos <i class="fa-solid fa-file-powerpoint"></i> PPTX (PowerPoint&reg;) solamente</p>
				<?= $this->Form->input('slide.file', ['label' => false, 'type' => 'file', 'class' => 'w3-input file'])?>
			</div>
		<?php } else {?>
			<?= $this->Form->input('texto', ['class' => 'w3-input', 'label' => false, 'id' => 'HomeworkTexto'])?>
			<!--
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
			//-->
			<div class="centered">
				<div class="row row-editor">
					<div class="editor-container">
						<div class="editor"></div>
					</div>
				</div>
			</div>
			
			
	   <?php } ?>
        
			<?= $this->Form->hidden('paper_id')?>
			<?= $this->Form->hidden('user_id')?>
			<?= $this->Form->hidden('id')?>
			<?= $this->Form->submit('Guardar tarea', ['class' => 'w3-button w3-round w3-blue', 'id' => 'submit'])?>
		<?= $this->Form->end(['label' => 'Guardar tarea', 'class' => 'w3-button w3-round w3-blue', 'id' => 'submit'])?>
	<p>Puedes guardar la tarea antes de terminarla y modificarla después. Siempre y cuando esté dentro del plazo de entrega.</p>
</div>

 <div id="PaperDescription" class="w3-modal">
  <div class="w3-modal-content w3-animate-zoom">

    <header class="w3-container w3-blue-gray">
      <span onclick="document.getElementById('PaperDescription').style.display='none'" class="w3-button w3-display-topright">&times;</span>
      <h4><?= $paper->get('name') ?></h4>
    </header>

    <div class="w3-container">
      <?= $paper->get('description') ?>
    </div>

    <footer class="w3-container w3-blue-gray" style="margin:0;">
      <p></p>
    </footer>

  </div>
</div> 
<pre>

</pre>

<script type="text/javascript">
	$(function(){
		$('#HomeworkTitulo').focus();
		<?php if($this->request->getParam('action') == 'edit'){ ?>
		editor.setData('<?= $homework->texto ?>');
		<?php } ?>
	});

    const textarea = document.querySelector('#HomeworkTexto');
    /*
	DecoupledDocumentEditor
		.create(document.querySelector('#editor'), {
			licenseKey: '',
			simpleUpload: {
				uploadUrl: '<?= $this->Url->build('/homeworks/imageUpload?pID='.$paper->get('id'))?>&uID=<?= $homework->get('user_id')?>',
				withCredentials: true,
				headers: {
				    'X-CSRF-TOKEN': '<?= $this->request->getAttribute('csrfToken')?>',
				    Authorization: 'Bearer <JSON Web Token>',
				},
			},
			image: {
				//upload: {types: ['jpeg'],}
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
		
		document.getElementById('submit').onclick = () => {
		    textarea.value = editor.getData();
		}
	*/
	
	// beta
	
	ClassicEditor
				.create( document.querySelector( '.editor' ), {
					licenseKey: '',
					simpleUpload: {
						uploadUrl: '<?= $this->Url->build('/homeworks/imageUpload?pID='.$paper->get('id'))?>&uID=<?= $homework->get('user_id')?>',
						withCredentials: true,
						headers: {
						    'X-CSRF-TOKEN': '<?= $this->request->getAttribute('csrfToken')?>',
						    Authorization: 'Bearer <JSON Web Token>',
						},
					},
				} )
				.then( editor => {
					window.editor = editor;
				} )
				.catch( error => {
					console.error( 'Oops, something went wrong!' );
					console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
					console.warn( 'Build id: za92xjapvr3a-g5cc4qj4kxvv' );
					console.error( error );
				} );
				
	document.getElementById('submit').onclick = () => {
		textarea.value = editor.getData();
	}
	
</script>

<style type="text/css">
	#HomeworkTexto{display:none;} h3{margin-top:0;} .w3-modal{z-index:20;} .centered{padding:0;} #footer{margin:0;}
	body[data-editor="DecoupledDocumentEditor"] .collaboration-demo__editable, /*body[data-editor="DecoupledDocumentEditor"] .row-editor .editor{width:calc(21cm + 100px);}*/
	@media screen and (min-device-width: 340px) and (max-device-width: 640px)  {
		/*body[data-editor="DecoupledDocumentEditor"] .row-editor .editor, .centered {width:100%;}*/
	}
	.row-editor .editor, .centered, .ck.ck-editor {width:100%;} a {color:#000 !important;}
</style>