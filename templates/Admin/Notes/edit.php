<div class="">
	<div class="w3-container w3-blue-gray">
		<h4><i class="fa-solid fa-handshake"></i> Mensaje de bienvenida para el: <strong><?= $note->group->grupo ?></strong></h4>
	</div>
	
	<div class="w3-container w3-padding-large">
		
		<?= $this->Form->create($note, [], ['class' => 'w3-container'])?>
			
			<?= $this->Form->hidden('group_id');?>
            
			<?= $this->Form->control('name', ['class' => 'w3-input w3-margin', 'label' => ['text' => 'Título', 'class' => 'w3-label']])?>
            
			<?= $this->Form->control('description', ['id' => 'WelcomeMessage', 'class' => 'w3-input w3-margin', 'label' => false]);?>

			
			
			
			
			
			<?//= $this->Form->control('name', ['class' => 'w3-input w3-margin', 'label' => ['text' => 'Nombre', 'class' => 'w3-label']])?>
			
			<?//= $this->Form->control('program', ['id' => 'ProgramContent', 'class' => 'w3-input w3-margin', 'label' => false])?>
			
			<?//= $this->Form->hidden('id')?>
			
			<?= $this->Form->submit('Guardar mensaje de bienvenida', ['class' => 'w3-blue w3-button w3-round'])?>
			
		<?= $this->Form->end()?>
	</div>
</div>

<?= $this->Html->script('https://cdn.ckeditor.com/ckeditor5/35.2.0/super-build/ckeditor.js')?>
<?= $this->Html->script('https://cdn.ckeditor.com/ckeditor5/35.2.0/super-build/translations/es.js')?>
<script type="text/javascript">
	CKEDITOR.ClassicEditor.create(document.getElementById("WelcomeMessage"), {
		toolbar: {
		  items: [
			'heading', '|','fontSize','|','fontColor','|',
			'bold', '|','italic','|', 'underline','|','horizontalLine','|','blockQuote','|',
			'bulletedList', '|','numberedList','|','alignment',
			'outdent','|', 'indent', '|',
			'|','undo', '|','redo', '|',
			'sourceEditing',
		  ],
		  shouldNotGroupWhenFull: false
	    },
	    htmlSupport: {
		    allow: [
			  {
				name: /.*/,
				attributes: true,
				classes: true,
				styles: true
			  }
		    ]
		},
	    language: 'es',
	    list: {
			properties: {
				styles: true,
				startIndex: true,
				reversed: true
			}
		},
		placeholder: 'Contenido...',
		removePlugins: [
		  'ExportPdf','ExportWord','CKBox','CKFinder','EasyImage','Base64UploadAdapter','RealTimeCollaborativeComments','RealTimeCollaborativeTrackChanges','RealTimeCollaborativeRevisionHistory','PresenceList','Comments','TrackChanges','TrackChangesData','RevisionHistory','Pagination','WProofreader','MathType',
		]
	});
</script>
