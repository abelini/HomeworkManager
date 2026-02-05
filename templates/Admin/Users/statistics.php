<div class="w3-container w3-light-grey w3-border w3-margin-bottom c" style="padding:0;">
	<?= $this->cell('Avatar::display', [$user, 'w3-left', 92])->render()?>
	
	<h6 style="margin-left:112px;">Tareas del alumno </h6>
	<h4 style="margin-left:112px;"><span class="name"><?= $user->get('nombre')?></span></h4>
	
</div>

<div class="w3-row">
	<div class="w3-col l8 s12">

		<ul class="w3-ul w3-margin-top">
		<?php foreach($papers as $paper){ $done = false; ?>

			<li class="hw">
			<?php foreach($user->homeworks as $homework) { ?>
				<?php if($paper->id == $homework->paper_id) { ?>
				<i class="fa-solid fa-check-double w3-text-green"></i> <?= $this->Html->link($paper->name, ['controller' => 'homeworks', 'action' => 'view', $homework->id], ['escape' => false])?>
				<ul class="w3-ul w3-margin-left">
					<li><i class="fa-solid fa-calendar-day"></i> <span class="w3-text-gray"><?= $homework->created->i18nFormat([\IntlDateFormatter::LONG, \IntlDateFormatter::SHORT]);?></span></li>
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
			<?php if(!$done && $user->group_id != 99){ ?>
				<i class="fa-solid fa-xmark w3-text-red"></i> <?= $paper->name ?>
			<?php }?>
			</li>
		<?php } ?>
		</ul>
	</div>
	
	<div class="w3-col l4 s12 w3-border-color-light-gray w3-border-left avg">
		<h4>Total de tareas</h4>
		<p class="w3-text-red w3-xxlarge"><?= $totalHws ?></p>
		
		<h4>Tareas realizadas</h4>
		<p class="w3-text-red w3-xxlarge"><?= count($user->homeworks) ?></p>
		
		<?php $totalHws = ($totalHws == 0)? 1 : $totalHws; /* Avoid DIVISION BY ZERO error */ ?>
		
		<h4>Promedio</h4>
		<p class="w3-text-red w3-xxlarge"><?= $avg = $this->Number->precision($sum / $totalHws, 2) ?></p>
		
		<h4>Porcentaje de cumplimiento</h4>
		<p class="w3-text-red w3-xxlarge"><?= $this->Number->toPercentage(count($user->homeworks) / $totalHws, 1, ['multiply' => true])?></p>
		
		<h4>Índice de productividad</h4>
		<p class="w3-text-red w3-xxlarge"><?= $user->pr ?></p>
		
		<h4>Final</h4>
		<p class="w3-text-red w3-xxlarge"><?= ($avg + intval($user->pr ))?></p>
		
		<?php if($user->group_id == 99) : ?>
			<?= $this->Form->postButton('Eliminar alumno', ['controller' => 'Users', 'action' => 'delete', $user->id], ['method' => 'DELETE', 'class' => 'w3-button w3-red', 'disabled' => true, 'form' => ['class' => 'w3-margin w3-center']])?>
		<?php endif; ?>
	</div>
</div>

<style type="text/css">
	/*.w3-ul li:blank, .w3-ul li:-moz-only-whitespace{display:none !important;}*/
	.w3-margin-left{margin-left:32px !important;} .avg h4, .avg p{text-align:center;margin:0 !important;} .avg h4{font-weight:bold;} 
</style>
<script>
	var treeWalker = document.createTreeWalker(document.body, NodeFilter.SHOW_ELEMENT);
	var currentNode = treeWalker.currentNode;
	var emptyNodes = [];

	// test if a node has no text, regardless of whitespaces
	var isNodeEmpty = node => !node.textContent.trim();

	// find all empty nodes
	while(currentNode) {
	  isNodeEmpty(currentNode) && emptyNodes.push(currentNode)
	  currentNode = treeWalker.nextNode()
	}

	// remove found empty nodes
	emptyNodes.forEach(function(node, i, a){
		if(node.className == 'hw'){
			node.parentNode.removeChild(node);
		}
	});
	//emptyNodes.forEach(node => node.parentNode.removeChild(node));
	//console.log(document.body.firstElementChild.outerHTML);
</script>