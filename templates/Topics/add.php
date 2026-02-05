<div class="">
	<div class="w3-container w3-blue-gray">
		<h4><i class="fa-solid fa-folder-open"></i> Crear un nuevo tema</h4>
	</div>
	
	<div class="w3-container w3-padding-large">
		
		<?= $this->Form->create($topic, [], ['class' => 'w3-container'])?>
		
			<?= $this->Form->control('name', ['class' => 'w3-input w3-margin', 'label' => ['text' => 'Asunto', 'class' => 'w3-label']])?>
			
			<?= $this->Form->control('content', ['class' => 'w3-input w3-margin', 'label' => false, 'placeholder' => 'Escribe tu comentario, pregunta, o inquietud...'])?>
			
			<?= $this->Form->hidden('user_id')?>
			
			<?= $this->Form->submit('Crear nuevo tema', ['class' => 'w3-blue w3-button w3-round'])?>
			
		<?= $this->Form->end()?>
	</div>
</div>