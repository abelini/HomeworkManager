<div class="w3-row-padding w3-section">

	<div class="w3-container w3-blue-gray">
		<h4><i class="fa-solid fa-folder-plus"></i> <?= $formLegend ?></h4>
	</div>
	
	<?= $this->Form->create($paper, ['url' => ['action' => 'add'], 'class' => 'w3-container w3-section'])?>
	
		<div class="w3-third">

			<?= $this->Flash->render();?>
			
			<?= $this->Form->label('group_id', 'Dirigida a')?>
			<?= $this->Form->control('group_id', ['options' => $groups->combine('id', 'grupo'), 'class' => 'w3-select', 'label' => false])?>
			
			<?= $this->Form->control('slide', ['type' => 'checkbox', 'class' => 'w3-checkbox', 'label' => '¿Se requieren diapositivas?'])?>
			
			<?= $this->Form->label('name', 'Título para la tarea')?>
			<?= $this->Form->control('name', ['class' => 'w3-input w3-light-gray', 'label' => false])?>
			
			<?= $this->Form->label('expiration', 'Fecha límite de recepción')?>
			<?= $this->Form->control('expiration', ['id' => 'datetime', 'class' => 'w3-input w3-light-gray', 'type' => 'text', 'label' => false])?>

			<?= $this->Form->hidden('id')?>
			
			<?= $this->Form->submit($formSubmit, ['class' => 'w3-button w3-blue w3-round'])?>
			
		</div>
		
		<div class="w3-twothird">
			<?= $this->Form->input('description', ['label' => false, 'id' => 'PaperDescription', 'type' => 'textarea'])?>
		</div>
	<?= $this->Form->end()?>
		
		<div class="w3-third">
			<div class=" w3-container">
			<?php if(isset($edit) && $edit === true){ ?>
				<?= $this->Form->postButton('<i class="fa-solid fa-trash-can"></i> Eliminar tarea',
											['action' => 'delete', '?' => ['id' => $paper->id]],
											[
												'data' => ['id' => $paper->id],
												'method' => 'DELETE',
												'class' => 'w3-button w3-red w3-round',
												'confirm' => '¿Desea eliminar esta tarea? Si algún alumno ya la hizo, se le eliminará de su cuenta también.',
												'escapeTitle' => false
											]
										)?>
			<?php } ?>
			</div>
		</div>
</div>


<div class="w3-section w3-row-padding">
	<div class="w3-container w3-blue-gray">
		<h4><i class="fa-solid fa-folder-open"></i> Tareas guardadas</h4>
	</div>
	
	<?php foreach($groups as $group){ ?>
		<div class="w3-half">
			<div class="w3-light-gray w3-border w3-border-gray w3-center w3-margin-top">
				<p><?= $group->icon .' '. $group->grupo ?></p>
			</div>
			
			<ul class="w3-ul">
				<?php foreach($group->papers as $hw){ ?>
					<li class="">
						<?= $this->Html->link(
								'<i class="fa-solid fa-caret-right"></i> '.$hw->getName(),
								['action' => 'edit', '?' => ['id' => $hw->id]],
								['class' => '', 'escape' => false]
						)?>
					</li>
				<?php } ?>
			</ul>
		</div>
    <?php } ?>
</div>

<div class="w3-section w3-row-padding">
	<div class="w3-container w3-blue-gray">
		<h4><i class="fa-solid fa-clock-rotate-left"></i> Archivo</h4>
	</div>
	<div class="w3-container">
		<p><?= $this->Html->link('<i class="fa-solid fa-arrow-up-right-from-square"></i> Tareas archivadas de semestres anteriores', ['action' => 'archive'], ['escape' => false])?></p>
	</div>
</div>

<?= $this->Html->css('jquery.datetimepicker.min.css')?>
<?= $this->Html->script('jquery.datetimepicker.full.min.js')?>
<?= $this->Html->script('https://cdn.ckeditor.com/ckeditor5/35.2.0/super-build/ckeditor.js')?>
<?= $this->Html->script('https://cdn.ckeditor.com/ckeditor5/35.2.0/super-build/translations/es.js')?>

<script type="text/javascript">
	jQuery.datetimepicker.setLocale('es');
	jQuery('#datetime').datetimepicker({format:'Y-m-d H:i', lang:'es', minDate:0, minTime:'06:00', step:30,
			value:'<?= ($paper->expiration !== null)? $paper->expiration->format('Y-m-d H:i:s') : '' ?>',
			i18n:{
				es:{
					months:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
					dayOfWeek:['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
				}
			}
		});
</script>
<script type="text/javascript">
	CKEDITOR.ClassicEditor.create(document.getElementById("PaperDescription"), {
		toolbar: {
		  items: [
			'heading', '|','fontSize','|','fontColor','|',
			'bold', '|','italic','|', 'underline','|','horizontalLine','|','blockQuote','|',
			'bulletedList', '|','numberedList','|','alignment',
			//'outdent','|', 'indent', '|',
			//'|','undo', '|','redo', '|',
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
		placeholder: 'Descripción de la tarea...',
		removePlugins: [
		  'ExportPdf','ExportWord','CKBox','CKFinder','EasyImage','Base64UploadAdapter','RealTimeCollaborativeComments','RealTimeCollaborativeTrackChanges','RealTimeCollaborativeRevisionHistory','PresenceList','Comments','TrackChanges','TrackChangesData','RevisionHistory','Pagination','WProofreader','MathType',
		]
	});
</script>
<style type="text/css">
	.w3-row-padding .w3-third, .w3-row-padding .w3-twothird {padding:0 8px;} .select{margin-bottom:2rem;} input[type=text]{margin-bottom:2rem;}
</style>