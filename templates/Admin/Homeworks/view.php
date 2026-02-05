<?= $this->Html->link('<i class="fa-solid fa-rotate-left"></i> Regresar a la lista de tareas', ['controller' => 'papers', 'action' => 'itemize', $homework->paper->id], ['class' => 'w3-button w3-blue w3-right w3-margin','escape' => false])?>

<div class="w3-container w3-light-grey w3-border w3-margin-top c" style="padding:0;">
	<?= $this->cell('Avatar::display', [$homework->user, 'w3-left', 92])->render()?>
	<h4 style="margin-left:112px;"><span class="name"><?= $homework->user->nombre ?></span></h4>
	<h6 style="margin-left:112px;">Grupo <?= $homework->user->group->grupo ?></h6>
</div>

<div class="w3-container c">
    <h3><?= $homework->paper->name ?></h3>
</div>
<div class="text">
    <?php
		if($homework->paper->slide == 0) {
			echo '<div class="w3-container w3-border w3-border-light-gray w3-margin-bottom w3-padding">';
			echo $homework->texto;
			echo '</div>';
		}
		else { ?>

		<div style="position:relative;overflow:hidden;width:100%;padding-top:56.25%;">
			<iframe src="https://view.officeapps.live.com/op/embed.aspx?src=<?= DOMAIN . urlencode($this->Url->build(SLIDES_PATH .$homework->slide->file))?>" class="w3-margin-bottom ppt-doc" style="position:absolute;top:0;left:0;bottom:0;right:0;width:100%;height:100%;"></iframe>
		</div>
	
		<p>Si no puedes visualizar la presentación, <?= $this->Html->link('<i class="fa-solid fa-file-arrow-down"></i> <span>puedes descargarlo ['.$this->Number->toReadableSize($homework->slide->getSize()).']</span>', $homework->slide->getDownloadableUri(), ['escape' => false])?> para abrirlo manualmente.</p>
	<?php } ?>
</div>

<div class="w3-row">

	<div class="w3-twothird" id="comments">
		<div class="w3-container w3-blue-gray">
			<h4><i class="fa-solid fa-comments"></i> Comentarios</h4>
		</div>
		
		<?= $this->Form->create($comment, ['url' => ['controller' => 'comments', 'action' => 'add'], 'class' => 'w3-container w3-section'])?>
			<?= $this->Form->control('comment', ['label' => false, 'rows' => 3, 'class' => 'w3-input', 'placeholder' => 'Escribe un comentario'])?>
			<?= $this->Form->hidden('user_id')?>
			<?= $this->Form->hidden('homework_id')?>
			<?= $this->Form->submit('Publicar', [ 'class' => 'w3-button w3-blue w3-round'])?>
		<?= $this->Form->end()?>
		
		<div class="w3-container">
			
			<?= $this->Flash->render('comments') ?>
			
			<table class="w3-table w3-bordered w3-striped">
				<?php foreach($homework->comments as $comentario){ ?>
					<?php 
						$delete = ($this->Identity->get('id') == $comentario->user_id)?
										
										$this->Form->postLink(
											'<i class="fas fa-trash-alt w3-right"></i>',
											['controller' => 'comments', 'action' => 'delete', $comentario->id],
											['escape' => false, 'method' => 'DELETE', 'confirm' => '¿Seguro que deseas eliminar el comentario?']
										)
										:'';
						echo $this->Html->tableCells(
							[
								[
									[
										$delete .
										$this->cell('Avatar::display', [$comentario->user, 'w3-left w3-circle w3-margin-right'])->render().
										'<p class="w3-text-dark-grey w3-bold w3-margin-0" style="margin-top:0;">'.$comentario->user->nombres .'</p>'.
										'<p class="w3-margin w3-text-dark-grey">'. $comentario->get('body') .'</p>'.
										'<p class="w3-right w3-small w3-text-grey w3-margin-0">'.
										$comentario->created->i18nFormat([\IntlDateFormatter::LONG, \IntlDateFormatter::SHORT]).
										'</p>',
										['class' => 'w3-pad-8', 'data-id' => $comentario->id]
									]
								]
							]
						);
						?>
				<?php }?>
			</table>
		</div>
	</div>
	<div class="w3-third" id="score">
		<div class="w3-container w3-blue-gray w3-margin-bottom">
			<h4><i class="fa-solid fa-star"></i> Calificación</h4>
		</div>
		
		<?= $this->Flash->render('score') ?>

		<?= $this->Form->create($homework, ['url' => ['action' => 'score'], 'class' => 'w3-container w3-section'])?>
			<?= $this->Form->control('score', ['class' => 'w3-select', 'label' => false, 'options' => $scoreValues, 'empty' => ' Seleccione'])?>
			<?= $this->Form->hidden('id')?> 
			<?= $this->Form->submit('Calificar', ['class' => 'w3-button w3-round w3-blue'])?>
		<?= $this->Form->end()?>
		
		<div class="w3-container w3-blue-gray">
			<h4><i class="fa-solid fa-trash-can"></i> Eliminar tarea</h4>
		</div>
		
		<?= $this->Form->postLink('<i class="fa-solid fa-trash"></i> Sí, eliminar', ['controller' => 'homeworks', 'action' => 'delete', $homework->id], ['class' => 'w3-button w3-red w3-center w3-margin w3-round','escape' => false, 'confirm' => 'SE ELIMINARÁ LA TAREA. Esta acción no se puede deshacer'])?>
		
	</div>
</div>

<style>
	.text img{width:auto !important;height:auto !important;max-width:100%;} a span{text-decoration:underline;}
</style>