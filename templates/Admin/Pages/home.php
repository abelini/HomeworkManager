<div class="w3-row">
	<div class="w3-container w3-half w3-left">
		<div class="w3- w3-left">
			<h3>
				<?= $this->cell('Avatar::display', [$profe, 'w3-circle', 84])->render()?>
				<?= $this->Html->link($profe->get('nombre'), '/profile')?>
				<span class="w3-medium" style="display:block;margin:-30px 0 0 92px;letter-spacing:6px;color:#d4d4d4;">PROFESOR</span>
			</h3>
		</div>
	</div>
	
	<?php if($fullAccess) { ?>
	<div class="w3-container w3-half w3-right">
		<div class="message w3-khaki w3-border-orange">
			<i class="fa-solid fa-circle-exclamation w3-text-orange w3-xlarge w3-right" style="padding-left:24px;"></i> Las tareas están configuradas para ignorar su expiración. Por lo tanto <em>todas están accessibles para los alumnos</em>. No olvides desactivar esto en <?= $this->Html->link('<i class="fa-solid fa-cogs"></i> Configuración', ['controller' => 'options'], ['escape' => false])?>.
		</div>
	</div>
	<?php } ?>

</div>

<?php if(!$unacceptedStudents->isEmpty()){ ?>
<div class="w3-container w3-section">
	<div class="message w3-khaki w3-border-orange">
		<i class="fa-solid fa-bell w3-text-orange w3-xxxlarge w3-right"></i> Los siguientes alumnos están pendientes de autorizar:
		<ul class="w3-ul">
		<?php foreach($unacceptedStudents as $student){ ?>
			<li><i class="fa-solid fa-user"></i> <?= $this->Html->link($student->get('nombre_completo'), ['controller' => 'users', 'action' => 'accept', $student->get('id')])?></li>
		<?php } ?>
		</ul>
	</div>
</div>
<?php } ?>



<div class="w3-container w3-section">
	<div class="w3-row">
		<?php foreach($grupos as $grupo) { ?>
	    <div class="w3-half ">
			<div class="w3-container w3-blue-gray">
				<h4><?= $grupo->HW->group->icon ?> <?= $grupo->grupo ?></h4>
			</div>
			<div class="w3-container  w3-light-gray">
				<h4><i class="fa-solid fa-file-pen"></i> <?= $this->Html->link($grupo->HW->name, ['admin' => true, 'controller' => $grupo->HW->getSource(), 'action' => 'edit', '?' => ['id' => $grupo->HW->id]], ['escape' => false])?></h4>
			</div>
			<div class="w3-container w3-display-container w3-border-left w3-border-light-gray">
				<div class="w3-section"><?= $grupo->HW->description?></div>
				
				<?php if($grupo->HW->isExpirable()) { ?>
					<?php if($grupo->HW->expiration->isPast()){ ?>
						<div class="w3-panel w3-pale-red w3-border w3-border-red">
							<p><i class="fa-solid fa-circle-xmark w3-text-red"></i> La tarea expiró el: <?= $grupo->HW->expiration->i18nFormat("eeee d 'de' MMMM 'a las' h:mm a") ?></p>
						</div>
					<?php } else { ?>
						<div class="w3-panel w3-pale-green w3-border w3-border-green">
							<p><i class="fa-solid fa-circle-check w3-text-green"></i> La tarea expira el: <?= $grupo->HW->expiration->i18nFormat("eeee d 'de' MMMM 'a las' h:mm a") ?></p>
						</div>
					<?php } ?>
				<?php } ?>
				<p class="w3-right w3-padding-32 w3-margin"><?= $this->cell('Avatar::display', [$profe, 'w3-left w3-circle', 120])->render()?></p>
				<p class="w3-display-bottomright w3-margin">M.C. Wilfrido Ibarra</p>
				<p class="w3-display-bottomleft w3-margin" style="color:#ddd;font-style:italic;">Última edición: <?= $grupo->HW->modified->i18nFormat([\IntlDateFormatter::LONG, \IntlDateFormatter::SHORT]); ?></p>
			</div>
			
			
			<div class="w3-container w3-blue-gray" id="PaperID-<?= $grupo->HW->id ?>">
				<h4><i class="fa-solid fa-comments"></i> Dudas del grupo</h4>
			</div>
			
			<?php if($grupo->HW instanceof \App\Model\Entity\Paper){ ?>
				
			<div class="w3-container w3-section">
				<?= $this->Form->create($grupo->comment, ['url' => ['controller' => 'Notecomments', 'action' => 'add', 'prefix' => false],])?>
					<?= $this->Form->control('comment', ['label' => false, 'rows' => 3, 'class' => 'w3-input'])?>
					<?= $this->Form->hidden('user_id')?>
					<?= $this->Form->hidden('paper_id')?>
					<?= $this->Form->button('Preguntar', ['class' => 'w3-button w3-blue w3-round w3-right w3-margin-top'])?>
				<?= $this->Form->end()?>
			</div>
			
			<?php } else { ?>
			<p class="w3-center"><i class="fa-solid fa-comment-slash"></i> Comentarios desactivados</p>
			<?php } ?>
			
			<?= $this->Flash->render('Paper-'. $grupo->HW->id) ?>

			<div class="comments">
				<?php foreach($grupo->HW->notecomments as $comentario) { ?>
					<?php
						$deleteButton = ($this->Identity->get('id') == $comentario->user->id)?
										'<div class="w3-right">'.
											$this->Form->postLink(
												'<i class="fa-regular fa-trash-can"></i>',
												['controller' => 'notecomments', 'action' => 'delete', 'prefix' => false, $comentario->id],
												['escape' => false, 'confirm' => '¿Seguro que deseas eliminar el comentario?']
											).
										'</div>':'';
					?>
					<div class="w3-container w3-padding w3-padding-16 comment">
						<?= $deleteButton ?>
						<?= $this->cell('Avatar::display', [$comentario->user, 'w3-left w3-circle w3-margin-right'])->render() ?>
						<p class="w3-text-dark-grey w3-bold cn">
							<?= $comentario->user->get('nombres')?>
						</p>
						<p class="w3-margin w3-text-dark-grey ct">
							<?= $comentario->comment ?>
						</p>
						<p class="w3-right w3-small w3-text-grey">
							<?= $comentario->created->i18nFormat([\IntlDateFormatter::LONG, \IntlDateFormatter::SHORT])?>
						</p>
					</div>
				<?php } ?>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
<style type="text/css">
	.w3-third{width:32%;} .w3-cn::after{clear:none !important;} .timer{display:block;} .w3-third a{text-decoration:none} a{text-decoration:none;}
	.cn{margin-top:0;} .ct{padding-left:60px;} .comment:nth-child(odd){background-color:#f1f1f1}
</style>

