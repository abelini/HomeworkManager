<div class="w3-container">
	<div class="w3-container w3-blue-gray">
		<h4><i class="fa-solid fa-boxes-packing"></i> El material escolar incluye libros y algunos videos o películas</h4>
	</div>

	<div class="w3-container w3-row w3-section">
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
</div>
<style>
	.bigbutton{padding:32px 64px;}
</style>