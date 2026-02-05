<div class="w3-container">

	<div class="w3-container w3-blue-gray w3-margin-top">
		<h4><i class="fa-solid fa-table-list"></i> Generar lista de alumnos/tareas</h4>
	</div>

	<div class="w3-container w3-row-padding">
		<?php foreach($groups->take(2) as $g){ ?>
			<div class="w3-half w3-col s6 m6 l6 w3-center w3-padding-large">
				<a class="w3-button w3-round-large w3-light-grey" href="<?= $this->Url->build(['controller' => 'groups', 'action' => 'kardex', $g->id])?>">
					<?= $g->icon ?>
					<p class="w3-bold"><?= $g->grupo ?></p>
				</a>
			</div>
		<?php } ?>
	</div>

	<div class="w3-container w3-blue-gray w3-margin-top">
		<h4><i class="fa-solid fa-users"></i> Administrar alumnos</h4>
	</div>

	<?= $this->Flash->render('lista') ?>

	<div class="">
	<?php foreach($groups->take(3) as $g){ ?>
		<?php $controlID = 1 ?>
		<div class="w3-section">
			<div class="w3-container w3-light-gray w3-border w3-border-grey">
				<h4 class="w3-center"><?= $g->icon ?> <?= $g->grupo ?></h4>
			</div>
			<div class="w3-responsive">
				<table class="w3-table-all">
					<tr><th>No.</th><th colspan="2">Nombre</th><th>Email</th><th>Ver / Modificar</th></tr>
					<?php foreach($g->users as $user){ ?>
						<tr>
							<td><?= $controlID++ ?></td>
							<td><?= $this->cell('Avatar::display', [$user, '', 40])->render()?></td>
							<td><?= $user->get('nombre_completo')?></td>
							<td><?= $user->get('email')?></td>
							<td>
								<?= $this->Html->link('<i class="fa-solid fa-chart-simple"></i>', ['controller' => 'users', 'action' => 'statistics', $user->id], ['title' => 'Estadísticas del alumno', 'escape' => false,])?>
								
								<?php if($user->get('starred') === true){ ?>
									<?= $this->Html->link('<i class="fa-solid fa-star"></i>', ['controller' => 'users', 'action' => 'star', $user->id], ['title' => 'Sacar del Salón de la Fama', 'escape' => false, 'style' => 'margin-left:16px'])?>
								<?php } else { ?>
									<?= $this->Html->link('<i class="fa-regular fa-star"></i>', ['controller' => 'users', 'action' => 'star', $user->id], ['title' => 'Incluir en el Salón de la Fama','escape' => false, 'style' => 'margin-left:16px'])?>
								<?php } ?>
								
								<?= $this->Html->link('<i class="fas fa-edit"></i>', ['controller' => 'users', 'action' => 'edit', $user->id], ['escape' => false, 'style' => 'margin-left:16px'])?>
							</td>
						</tr>
					<?php } ?>
				</table>
			</div>
		</div>
		
	<?php } ?>
	</div>

	<div class="w3-section">
		<p clasS="w3-section w3-padding w3-panel w3-pale-yellow  w3-border-yellow w3-bottombar w3-center">Los alumnos destacados (<i class="fa-solid fa-star"></i>) se listarán en el grupo de <strong>Nerds</strong>, y su información (todas las exposiciones y tareas) se guardarán incluso después de finalizar el semestre.</p>
	</div>

	<div class="">
	<?php foreach($groups->skip(3) as $g){
			usort($g->users, function($a, $b){
				if($a->created->greaterThan($b->created)) return 1;
				else if($a->created->lessThan($b->created)) return -1;
				else return 0;
			});
			$setCiclo = function($date){
				if($date->month >= 1 && $date->month <= 6){
					return ($date->year - 1) .'/'. $date->year . ' - 2 (Ene-Jun)';
				} else {
					return $date->year .'/'. ($date->year + 1) . ' - 1 (Ago-Dic)';
				}
			}
		?>
		<?php $controlID = 1 ?>
		<div class="w3-section">
			<div class="w3-container w3-light-gray w3-border w3-border-grey">
				<h4 class="w3-center"><?= $g->icon ?> <?= $g->grupo ?></h4>
			</div>
			<div class="w3-responsive">
				<table class="w3-table-all">
					<tr><th>No.</th><th>Ciclo</th><th>Nombre</th><th class="w3-hide-small">Email</th><th>Detalles</th></tr>
					<?php foreach($g->users as $user){ ?>
						<tr>
							<td><?= $controlID++ ?></td>
							<td><?= $setCiclo($user->created) ?></td>
							<td><?= $user->get('nombre_completo')?></td>
							<td class="w3-hide-small"><?= $user->get('email')?></td>
							<td>
								<?= $this->Html->link('<i class="fa-solid fa-chart-simple"></i>', ['controller' => 'users', 'action' => 'statistics', $user->id], ['title' => 'Estadísticas del alumno', 'escape' => false,])?>
								
								<?php if($user->group_id != 99){ ?>
									<?= $this->Html->link('<i class="fa-solid fa-star"></i>', ['controller' => 'users', 'action' => 'star', $user->id], ['title' => 'Sacar del Salón de la Fama', 'escape' => false, 'style' => 'margin-left:16px'])?>
								<?php } else { ?>
									<i class="fa-regular fa-star" style="margin-left:12px;"></i>
								<?php } ?>
							</td>
						</tr>
					<?php } ?>
				</table>
			</div>
		</div>
		
	<?php } ?>
	</div>
</div>
<style>
	.bigbutton{padding:12px 128px;}  .bigbutton i, .bigbutton svg{font-size:64px !important;} .w3-half a i{font-size:32px;} .w3-half a{padding:16px;}
	@media (280px <= width <= 640px) {
		.w3-button{white-space:normal !important;}
	}
</style>
