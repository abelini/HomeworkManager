<table class="w3-table-all">
	<tr>
		<th colspan="<?= (2 + $tareas->count() * 2 + 3 )?>" class="w3-border-right">
			<div class="w3-display-container header">
				<div class="w3-display-topleft">
					<?= $this->Html->image('uas.png', ['style' => 'max-height:140px;', 'fullBase' => true])?>
				</div>
				<div class="w3-center w3-margin-top">
					<h1>UNIVERSIDAD AUTÓNOMA DE SINALOA</h1>
					<h2>FACULTAD DE HISTORIA</h2>
					<h3><?= $title ?></h3>
					<p><?= $getCiclo($alumnos->first()->created)?></p>
				</div>
				<div class="w3-display-topright">
					<?= $this->Html->image('historia-logo.jpg', ['style' => 'max-height:120px;', 'fullBase' => true])?>
				</div>
			</div>
		</th>
	</tr>
	
	<tr>
		<td colspan="<?= (1 + $tareas->count() + 1 )?>" class="w3-border-right">
			<strong>Asignatura:</strong> <?= $title ?> <strong class="w3-margin-left">Docente:</strong> M.C. Wilfrido Ibarra Escobar <strong class="w3-margin-left">Grupo:</strong> <?= $grupo->grupo ?>
			<span class="w3-right"><strong>Fecha:</strong> <?= $fecha->i18nFormat([\IntlDateFormatter::LONG, \IntlDateFormatter::SHORT])?></span>
		</td>
	</tr>
	<tr class="b">
		<td colspan="1" class="w3-border-left w3-center">Alumno</td>
		<td colspan="<?= $tareas->count() ?>" class="w3-border-left w3-center">Tareas</td>
		<td colspan="1" class="w3-border-left w3-border-right w3-center">Final</td>
	</tr>
	<tr class="b">
		<!--<td class="w3-center">No</td>-->
		<td class="w3-border-left">Nombre</td>
	<?php for($i = 1; $i <= $tareas->count(); $i++) { ?>
		<td class="w3-border-left"><?= $i ?></td>
	<?php } ?>
		<!--<td class="w3-border-left w3-center">AVG</td>
		<td class="w3-border-left w3-center">P/R</td>
		<td class="w3-border-left w3-center">Total</td>-->
		<td colspan="1" class="w3-border-left w3-border-right w3-center">Promedio</td>
	</tr>
	
	<?php
    foreach($alumnos as $alumno) {
		$sum = 0;
		$counter++;
	?>
	<tr class="<?//= $alumno['Status']['class']?> w3-white">
		<!--<td class="w3-center"><?= $counter ?></td>-->
		<td class="w3-border-left"><?= $alumno->get('nombre_completo')?></td>
		
	<?php
        foreach($tareas as $tarea) {
	?>
		<td class="w3-border-left">
		<?php
			$done = false;
			foreach($alumno->homeworks as $hw) {
				if($tarea->id == $hw->paper_id) {
					//$html .= "<td>{$hw['rating']}</td>";
					$done = true;
					if($hw->score == 'NP') {
						$sum += $npValue;
						echo $npValue;
					} else if($hw->score == 'NV'){
						$sum += $nvValue;
						echo $nvValue;
					} else {
						$sum += intval($hw->score);
						echo $hw->score;
					}
					break;
				} else {
					continue;
				}
			}
			if(!$done){
                echo 0;
			}
		?>
		</td>
	<?php }
	
		$avg = round(floatval($sum / $tareas->count()), 1);
		$totalRating = (($avg + $alumno->pr) > 10)? 10 : ($avg + $alumno->pr);
	?>
		<!--<td class="w3-border-left"><?= $avg ?></td>
		<td class="w3-border-left"><?= $alumno->pr ?></td>-->
		<td class="w3-border-left w3-border-right w3-center"><?= $totalRating ?></td>
	</tr>
   <?php } ?>
</table>