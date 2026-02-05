<div class="w3-container w3-light-grey w3-border w3-margin-bottom c" style="padding:0;">
	<?= $this->cell('Avatar::display', [$user, 'w3-left', 92])->render()?>
	<h6 style="margin-left:112px;">Tareas del alumno </h6>
	<h4 style="margin-left:112px;"><span class="name"><?= $user->get('nombre')?></span></h4>
</div>

<div class="w3-row">

	<div class="w3-container">
		<div class="w3-col l8 s12">
			<?php if(!$papers->isEmpty()){ ?>
				<ul class="w3-ul w3-margin-top">
				<?php foreach($papers as $paper){ $done = false; ?>

					<li>
					<?php foreach($homeworks as $homework) { ?>
						<?php if($paper->id == $homework->paper_id) { ?>
						<i class="fa-solid fa-check-double w3-text-green"></i> <?= $this->Html->link($paper->name, ['controller' => 'homeworks', 'action' => 'view', $homework->id], ['escape' => false])?>
						<ul class="w3-ul w3-margin-left">
							<li><i class="fa-solid fa-calendar-day"></i> <span class="w3-text-gray"><?= $homework->created->i18nFormat([\IntlDateFormatter::LONG, \IntlDateFormatter::SHORT])?></span></li>
							<li><i class="fa-solid fa-medal"></i> <span class="w3-text-gray">Calificación obtenida: <strong><?= $homework->getScoreValue() ?></strong></span></li>
						</ul>
						<?php
								$done = true;
								$sum += intval($homework->getScoreINTValue());
								break;
							} else {
								$done = false;
							}
						} ?>
					<?php if(!$done){ ?>
						<i class="fa-solid fa-xmark w3-text-red"></i> <?= $paper->name ?>
					<?php }?>
					</li>
				<?php } ?>
				</ul>
			<?php } else { ?>
				<p>No se han registrado tareas todavía...</p>
			<?php } ?>
		</div>
		<div class="w3-col l4 s12 w3-border-color-light-gray w3-border-left avg">
			<?php if(!$papers->isEmpty()){ ?>
				<h4>Total de tareas</h4>
				<p class="w3-text-red w3-xxlarge"><?= $papers->count() ?></p>
				
				<h4>Tareas realizadas</h4>
				<p class="w3-text-red w3-xxlarge"><?= $homeworks->count() ?></p>
				
				<h4>Promedio</h4>
				<p class="w3-text-red w3-xxlarge"><?= $avg = $this->Number->precision($sum / $papers->count() , 2) ?></p>
				
				<h4>Porcentaje de cumplimiento</h4>
				<p class="w3-text-red w3-xxlarge"><?= $this->Number->toPercentage($homeworks->count() / $papers->count(), 1, ['multiply' => true])?></p>
				
				<h4>Índice de productividad</h4>
				<p class="w3-text-red w3-xxlarge"><?= $user->pr ?></p>
				
				<h4>Final</h4>
				<p class="w3-text-red w3-xxlarge"><?= ($avg + intval($user->pr ))?></p>
			<?php } ?>
		</div>
	</div>
</div>
<style>
	.w3-margin-left{margin-left:32px !important;} .avg h4, .avg p{text-align:center;margin:0 !important;} .avg h4{font-weight:bold;} 
	@media only screen and (max-width:640px) { section{margin:0;}}
</style>