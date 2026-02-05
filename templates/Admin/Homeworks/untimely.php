<div>
	<div class="w3-container w3-blue-gray">
		<h4><i class="fa-solid fa-star"></i> Asignación directa de calificación</h4>
		<h6>(El alumno no la subió)</h6>
	</div>
	
	<?= $this->Flash->render('rating')?>
	
	<?= $this->Form->create($tarea, ['url' => ['action' => 'save'], 'class' => 'w3-container w3-section'])?>
	
		<label class="w3-label w3-margin-top">Alumno</label>
		<input type="text" value="<?= $alumno->get('nombre')?>" disabled class="w3-input w3-margin-bottom"/>
		
		<label class="w3-label w3-margin-top">Tarea</label>
		<input type="text" value="<?= $paper->name ?>" disabled class="w3-input w3-margin-bottom"/>
		
		<?= $this->Form->control('score', ['label' => ['text' => 'Calificación', 'class' => 'w3-label'], 'class' => 'w3-input', 'options' => $calificaciones])?>

		<?= $this->Form->hidden('paper_id')?> 
		<?= $this->Form->hidden('user_id')?>
		<?= $this->Form->hidden('titulo', ['value' => 'TAREA EXTEMPORÁNEA'])?>
		
		<?= $this->Form->submit('Calificar', ['class' => 'w3-button w3-round w3-blue'])?>
		
	<?= $this->Form->end()?>
</div>