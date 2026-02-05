<div class="w3-container w3-blue-gray w3-margin-top">
	<h4><i class="fa-solid fa-briefcase"></i> Material escolar (vista de alumno)</h4>
</div>

<div class="w3-container w3-row">
	<div class="w3-half w3-center w3-padding-large">
		<a class="w3-button w3-round-large w3-light-grey bigbutton" href="<?= $this->Url->build('/material/biblioteca/')?>">
			<i class="fa-solid fa-book w3-jumbo"></i>
			<p class="w3-bold">Biblioteca</p>
		</a>
	</div>
	<div class="w3-half w3-center w3-padding-large">
		<a class="w3-button w3-round-large w3-light-grey bigbutton" href="<?= $this->Url->build('/material/videoteca/')?>">
			<i class="fa-solid fa-video w3-jumbo"></i>
			<p class="w3-bold">Videoteca</p>
		</a>
	</div>
</div>

<div class="w3-row">

	<div class="w3-half">
		<div class="w3-container w3-blue-gray w3-margin-top">
			<h4><i class="fa-solid fa-book"></i> Biblioteca digital</h4>
		</div>

		<div class="w3-container">
			<div class="">
				<div class="w3-container w3-margin-top">
					<h4><i class="fa-solid fa-plus"></i> Agregar libro</h4>
				</div>
				
				<?= $this->Flash->render('books-form')?>
				
				<?= $this->Form->create($book, ['url' => ['controller' => 'books', 'action' => 'add'], 'type' => 'file', 'class' => 'w3-container w3-section'])?>
				
					<?= $this->Form->control('subject_id', ['options' => $subjects->combine('id', 'name'), 'value' => $subjectID, 'label' => ['text' => 'Disponible para la clase de:', 'class' => 'w3-label'], 'class' => 'w3-input w3-margin-top', ])?>	
				
					<?= $this->Form->control('pdf', ['type' => 'file', 'class' => 'w3-margin', 'label' => false])?>
				
					<?= $this->Form->control('name', ['label' => ['text' => 'Nombre del libro', 'class' => 'w3-label w3-margin-top'], 'class' => 'w3-input w3-margin'])?>
					
					<?= $this->Form->submit('Guardar libro', ['class' => 'w3-button w3-blue w3-round'])?>
					
				<?= $this->Form->end()?>

			</div>
		</div>
	</div>
	<div class="w3-half">
		<div class="w3-container w3-blue-gray w3-margin-top">
			<h4><i class="fa-brands fa-youtube"></i> Configuración de YouTube&reg;</h4>
		</div>

		<div class="w3-container">
			<?= $this->Flash->render('youtube')?>
			<p>Todos los videos publicados en el siguiente canal de YouTube&reg; aparecerán en la videoteca</p>
			<p class="w3-text-grey"><?= $this->Html->link('<i class="fa-brands fa-youtube"></i> https://www.youtube.com/@uas.historia', 'https://www.youtube.com/channel/'. $channel, ['escape' => false, 'target' => '_blank'])?></p>
			
			<?= $this->Html->script('https://apis.google.com/js/platform.js', ['block' => 'script'])?>
			<div class="g-ytsubscribe w3-margin-top" data-channelid="UCDokoFcraNxdN2ED8shN27A" data-layout="full" data-count="default"></div>
			
			<div class="w3-container w3-margin-top w3-light-gray">
				<h5>Videos extras</h5>
			</div>
			
			<ul class="w3-ul">
				<li class=""><i class="fa-solid fa-video"></i> <a href="#" onclick="embedVideo('TGNKU_KS4-Y')">La etapa lítica en México</a></li>
				<li class=""><i class="fa-solid fa-video"></i> <a href="#" onclick="embedVideo('eewAlcK02so')">La etapa lítica y sus períodos</a></li>
			</ul>
		</div>
	</div>
</div>

<div class="">
	<div class="w3-container w3-margin-top w3-blue-gray">
		<h4><i class="fa-solid fa-bars"></i> Libros en la Biblioteca</h4>
	</div>
	
	<?= $this->Flash->render('books-list')?>
	
	<div class="w3-row">
		<?php foreach($subjects as $subject){ ?>
		
			<div class="w3-half">
				<div class="w3-container w3-light-gray">
					<h5><i class="fa-solid fa-lines-leaning"></i> <?= $subject->name ?></h5>
				</div>
				
				<ul class="w3-ul w3-striped">
					<?php foreach($subject->books as $book){ ?>
						<li onmouseover="showDeleteButton(this)" onmouseout="hideDeleteButton(this)" id="<?= $book->id ?>"><i class="fa-solid fa-book"></i> <?= $book->name ?> <?= $this->Form->postLink('<i class="fa-solid fa-trash-can"></i>', ['controller' => 'books', 'action' => 'delete', $book->id], ['class' => 'w3-hover-text-red', 'style' => 'display:none', 'confirm' => 'Esta acción no se puede deshacer', 'id' => 'Book-'. $book->id, 'method' => 'DELETE', 'escape' => false])?></li>
					<?php } ?>
				</ul>
			</div>
		<?php } ?>
	</div>
</div>

<style>.bigbutton{padding:12px 128px;} li{border-left:1px solid #f1f1f1;}</style>
<script>
function showDeleteButton(li){
	document.getElementById('Book-'+li.id).style.display = 'inline';
}
function hideDeleteButton(li){
	document.getElementById('Book-'+li.id).style.display = 'none';
}
</script>