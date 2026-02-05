<div class="w3-card">
	<div class="w3-container w3-blue-gray">
		<h4><i class="fa-solid fa-star"></i> Establecer el índice de Productividad y Rendimiento</h4>
	</div>
	
	<div class="w3-container w3-row">
	
		<?= $this->Flash->render() ?>
		
		<div class="w3-col l8 s12">
			<?= $this->Form->create($alumno, ['url' => ['action' => 'edit', $alumno->id], 'class' => 'w3-container w3-section'])?>
				
				<?= $this->Form->label('nombre', 'Nombre')?>
				<?= $this->Form->control('nombre', ['value' => $alumno->get('nombre'), 'label' => false, 'class' => 'w3-input w3-margin', 'disabled' => true])?>
				
				<?= $this->Form->label('pr', 'Índice de Productividad y Rendimiento')?>
				<?= $this->Form->control('pr', ['class' => 'w3-input w3-margin', 'label' => false, 'options' => $prValues])?>

				<?= $this->Form->hidden('id')?>
				
				<?= $this->Form->submit('Establecer', ['class' => 'w3-button w3-round w3-blue'])?>

			<?= $this->Form->end()?>
		</div>
		
		<div class="w3-col l4 s12">
			<?= $this->cell('Avatar::display', [$alumno->id, 'w3-circle w3-center', 340])->render()?>
		</div>
	</div>
</div>

<style>
	img.w3-circle{max-width:100%;padding:24px;margin:auto;display:block;}
</style>