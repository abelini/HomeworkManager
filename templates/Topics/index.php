<div class="w3-container w3-blue-gray">
	<h4><i class="fa-solid fa-comments"></i> Foro de asesorías</h4>
</div>

<div class="w3-row w3-right w3-margin-top">  	  
	<p><?= $this->Html->link('<i class="fa-solid fa-child-reaching"></i> Iniciar un nuevo tema', ['action' => 'add'], ['class' => 'w3-button w3-round w3-blue', 'escape' => false])?></p>
</div>  

<div class="w3-responsive c">
	<table class="w3-table w3-border w3-bordered w3-striped">
		<tr>
			<th>Tema</th>
			<th class="w3-center">Autor</th>
			<th class="w3-center">Fecha</th>
			<th class="w3-center">Respuestas</th>
			<th>Última actividad</th>
		</tr>
		<?php foreach ($topics as $topic) { ?>
		<tr>
			<td>
				<?= $this->Html->link($topic->name, ['controller'=>'topics', 'action'=>'view', $topic->id], ['escape' => false]);?>
			</td>
			<td class="w3-center">
				<?= $topic->user->get('nombres')?>
			</td>
			<td class="w3-center">
				<?= $topic->created->nice();?>
			</td>
			<td class="w3-center">
			   <?= count($topic->posts)?>
			</td>
			<td class="time-ago">
			 <?php 
			   if(count($topic->posts) > 0) {
					$post = end($topic->posts);
					echo $post->modified->timeAgoInWords(['accuracy' => 'hour']);
			   } else {
					echo $topic->modified->timeAgoInWords(['accuracy' => ['day' => 'hour'], 'end' => '+1 year']);
			   }
			   ?>
			</td>
		</tr>
		<?php } ?>
	</table>
	<div class="w3-center">
		<?= $this->Html->para(null, $this->Paginator->counter('Mostrando temas {{start}} - {{end}} de {{count}}'));?></p>
		<?= $this->element('paginator')?>
	</div>
</div>

<style>
	.time-ago::first-letter{text-transform:capitalize;}
</style>