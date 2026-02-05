<?php
if(! $tareas->isEmpty()) {
?>

<div class="">
	
	<div class="w3-container w3-blue-gray">
		<h4><?= $grupo->icon ?> <?= $grupo->grupo ?></h4>
	</div>
	
	<div class="w3-container">
		
		<?= $this->Flash->render('rating')?>
		
		<?= $this->Html->link('<i class="fas fa-print w3-medium"></i> Generar lista en formato PDF', ['action' => 'lista', 'ext' => 'pdf', '?' => ['grupo' => $grupo->id]], ['class' => 'w3-right w3-btn w3-light-grey w3-round w3-section', 'escape' => false])?>
		
		<div class="w3-responsive c">
			<table class="w3-table w3-small">
				<tr>
					<th class="w3-center w3-border" colspan="2">Alumno</th>
					<th class="w3-center w3-border" colspan="<?= $tareas->count() ?>">Tareas</th>
					<th class="w3-center w3-border" colspan="3">Promedio</th>
				</tr>
				<tr>
					<th class="No w3-border">No</th>
					<th class="w3-border">Nombre</th>
					<?php foreach($tareas->toList() as $id => $paper) { ?>
					<th class="Hw w3-border"><span title="<?= strip_tags($paper->name )?>">T<?= ++$id ?></span></th>
					<?php } ?>
					<th class="Av w3-border" title="Promedio">AVG</th>
					<th class="Pr w3-border" title="Productividad y rendimiento">P/R</th>
					<th class="T w3-border">Total</th>
				</tr>
				
				<?php foreach($alumnos as $alumno){ $sum = 0; ?>
				<tr class="<?//= $alumno['Status']['class']?>">
					<td class="w3-border"><?= $hwCounter++ ?></td>
					<td class="w3-border"><?= $alumno->get('nombre_completo') ?></td>
					
					<?php foreach($tareas as $tarea){ $done = false; ?>

						<?php foreach($alumno->homeworks as $hw){ ?>
							
							<?php if($tarea->id == $hw->paper_id){ ?>
					
								<td class="w3-border">
									<?= $this->Html->link($score($hw->score), ['controller' => 'homeworks', 'action' => 'view', $hw->id], ['escape' => false])?>
								</td>
								
								<?php
									$done = true;
									if($hw->score == 'NV') {
										$sum += $nvValue;
									} else if($hw->score == 'NP'){
										$sum += $npValue;
									} else {
										$sum += intval($hw->score);
									}
									break;
								?>
								
							<?php } else { continue; } ?>
								
						<?php } ?>
						<?php if(!$done){ ?>
							<td class="w3-border">
								<?= $this->Html->link('<i class="fa-solid fa-xmark"></i>', ['controller' => 'homeworks', 'action' => 'untimely', '?' => ['a' => $alumno->id, 'g' => $alumno->group_id, 'hw' => $tarea->id]], ['escape' => false])?>
							</td>
						<?php } ?>

					<?php } ?>
					<td class="w3-border avg"><?= $avg = round(floatval($sum / $tareas->count()), 1) ?></td>
					<td class="w3-border"><?= $this->Html->link($alumno->pr, $this->Url->build(['controller' => 'users', 'action' => 'pr', '?' => ['a' => $alumno->id]])) ?></td>
					<td class="w3-border total"><?= (($avg + $alumno->pr) >= 10)? 10 : ($avg + $alumno->pr)?></td>
				</tr>
				<?php } ?>
			</table>
			
			<div class="w3-row w3-margin-top">
				<div class="w3-col l1">&nbsp;</div>
				<ul class="w3-col l11 w3-ul">
					<li><i class="fa-solid fa-question w3-text-red w3-margin-right"></i> Tarea registrada, pero sin calificación</li>
					<li><i class="fa-solid fa-xmark w3-margin-right"></i> Tarea NO registrada, se puede asignar una calificación arbitraria</li>
					<li><span class="w3-margin-right">NV</span> No valorable, para efectos de cálculo de promedio, se toma como un <?= $nvValue ?></li>
					<li><span class="w3-margin-right">NP</span> No presentó, para efectos de cálculo de promedio, se toma como un <?= $npValue ?></li>
					<li><span class="w3-margin-right">AVG</span> Promedio de tareas</li>
					<li><span class="w3-margin-right">P/R</span> Índice de productividad y rendimiento, se puede aplicar un valor entre 1, 2 o 3 a cualquier alumno</li>
					<li><span class="w3-margin-right">Total</span> Es la suma del promedio (AVG) más el Índice de productividad y rendimiento (P/R)</li>
				</ul>
			</div>
		</div>
		<style type="text/css">
			.Hw{width:40px;} .No, .Av, .Pr, T{width:30px;} a{font-weight:normal;} .avg, .total{font-weight:bold;}
		</style>
	</div>
</div>

<?php  } else { ?>
	<h3>No se puede generar una lista</h3>
	<h4>Por el momento no hay ninguna tarea asignada al grupo</h4>
	<a href="javascript:history.back()">Regresar</a>
<?php } ?>
