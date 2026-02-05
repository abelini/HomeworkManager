<div class="">
	<div class="w3-container w3-blue-gray">
		<h4 class="w3-left"><i class="fa-solid fa-folder-open"></i> <?= $paper->name ?></h4>
		<h4 class="w3-right"><i class="fa-solid fa-rotate-left"></i> <?= $this->Html->link('Regresar', '/admin/papers/browse');?></h4>
	</div>
	<div class="w3-container w3-light-gray">
		<h4 class="w3-center"><?= $paper->group->icon ?> <?= $paper->group->grupo ?></h4>
	</div>
	<div class="w3-display-container w3-padding-16">
		<?= $this->Form->postButton(
			'<i class="fa-solid fa-file-circle-plus"></i> Agregar tarea faltante',
			['controller' => 'homeworks', 'action' => 'add'],
			['data' => ['paper_id' => $paper->id], 'class' => 'w3-button w3-blue w3-round w3-margin w3-display-right', 'escapeTitle' => false, 'disabled' => $buttonDisable]
		)?>
	</div>
	
	<div class="w3-padding-top-24">
	
		<?= $this->Flash->render()?>
		
		<table class="w3-table-all">
			<?php echo $this->Html->tableHeaders(array(
					['Fecha' => ['width' => 220]],
					['Alumno' => ['colspan' => 2, 'width' => 40]],
					['Calificación' => ['width' => 100]]
				)
			)?>
			
			<?php foreach($paper->homeworks as $hw){ ?>
				<?php echo $this->Html->tableCells([
					[
						[
							'<i class="fa-regular fa-clock"></i> '. $hw->created->nice(),
							['class' => 'w3-cell-middle']
						],
						[
							$this->cell('Avatar::display', [$hw->user, 'w3-left'])->render(),
							['width' => 62]
						],
						$this->Html->link($hw->user->get('nombre_completo'), '/admin/homeworks/view/'.$hw->id, ['class' => ($hw->score == 0)? 'w3-text-red':'']),
						($hw->score == 0)? '-' : $hw->getScoreValue()
					]
				])?>
			<?php } ?>
		</table>
	</div>
</div>

<style type="text/css">
table{margin:15px auto;} .w3-table-all td, .w3-table-all th{vertical-align:middle !important;}
</style>