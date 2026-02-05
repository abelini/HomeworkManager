
	<div class="w3-container w3-blue-gray">
		<h4><i class="fa-solid fa-pen-to-square"></i> Modificar respuesta<h4>
	</div>
	
	<div class="w3-panel w3-container w3-card-4">
		<h3><?= $post->topic->name ?></h3>
		
		<?= $post->topic->get('full_content') ?>
	</div> 

	<div class="w3-container w3-padding-large">
		
		<?php if($quote !== null){ ?>
		<div class="w3-panel w3-container w3-light-gray">
			<h5>Respuesta citada:</h5>
			<p><i class="fa fa-quote-left w3-xlarge"></i> <?= $quote->get('content') ?></p>
		</div> 
		<?php } ?>
		
		<?= $this->Form->create($post, [], ['class' => 'w3-container'])?>
		
			<?//= $this->Form->control('name', ['class' => 'w3-input w3-margin', 'label' => ['text' => 'Asunto', 'class' => 'w3-label']])?>
			
			<?= $this->Form->control('content', ['class' => 'w3-input w3-margin', 'label' => false, 'placeholder' => 'Escribe tu comentario, pregunta, o inquietud...', 'rows' => 10])?>
			
			<?= $this->Form->hidden('user_id')?>
			
			<?= $this->Form->hidden('topic_id')?>
			
			<?= $this->Form->submit('Guardar', ['class' => 'w3-blue w3-button w3-round'])?>
			
		<?= $this->Form->end()?>
	</div>
