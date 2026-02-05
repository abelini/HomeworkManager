<?= $this->Flash->render()?>

<div class="w3-container">
	<ul class="w3-ul">
		<li>
			<?= $notStarredUsersNO ?> alumnos eliminados.
			<ul>
				<li>Los alumnos destacados y sus trabajos se movieron al Salón de la Fama.</li>
			</ul>
		</li>
		<li>
			Todos los comentarios de las tareas se han eliminadas.
			<ul>
				<li>Los comentarios y publicaciones del Foro permanecen en el sistema.</li>
			</ul>
		</li>
		<li><?= $papersWithNoHwsNO ?> tareas sin trabajos eliminadas.</li>
		<li><?= $imagesDeletedCount ?> imágenes huérfanas eliminadas.</li>
		
		<li><?= $orphanSlides->count() ?> diapositivas huérfanas eliminadas.</li>
		<li>Hay <?= count($moreThanOneParent) ?> fotos repetidas (deben revisarse manualmente).</li>
	</ul>
</div>

<div class="w3-container w3-row">
	<div class="w3-third">

	</div>
	<div class="w3-third">

	</div>
	<div class="w3-third">

	</div>
</div>