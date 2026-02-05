<?= $this->Html->css('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,200,0,0', ['block' => true])?>

<div class="w3-container">
	<div class="w3-container w3-blue-gray">
		<h4><i class="fa-solid fa-book"></i> Libros para consulta</h4>
	</div>

	<div class="w3-container">
		<p>Para tu comodidad, te sugerimos descargar a tu dispositivo el archivo que necesites. Simplemente haz clic en la bibliografía deseada, presiona el botón <span class="material-symbols-outlined">system_update_alt</span> y listo.</p>
	</div>
	<div class="w3-row">
		<div class="w3-col s12 l3">

				<h5 class="w3-text-blue-gray w3-margin-top"><?= $subject->name ?></h5>
					<ul class="w3-ul">
					<?php foreach($subject->books as $b){ ?>
						<li class="w3-text-black"><i class="fas fa-book"></i> <a href="#" onclick="showBook('<?= $b->path ?>', <?= $subject->id ?>)"><?= $b['name']?></a> <span class="w3-text-gray">[<?= $b->humanSize()?>MB]</span></li>
					<?php } ?>
					</ul>

		</div>
		
		<div class="w3-col s12 l9">
			<div class="w3-margin-top w3-light-gray" id="pdfViewer"><i class="fa-solid fa-file-pdf w3-text-white w3-jumbo w3-center" style="padding:128px;margin:auto;display:block;"></i></div>
			
			<div class="w3-section w3-container">
				<h5 class="w3-text-blue-gray w3-margin-top">Material extra:</h5>
				<ul class="w3-ul">
					<li class=""><i class="fa-solid fa-arrow-up-right-from-square"></i> <a href="https://biblioteca-camara-de-diputados-858.app.publica.la/reader/mexico-y-su-tiempo-interpretaciones-de-nuestra-memoria-historica-y-cultural?location=241" target="_blank">MÉXICO Y TIEMPO: INTERPRETACIONES DE NUESTRA MEMORIA HISTÓRICA Y CULTURAL: Los antiguos mexicanos.</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function showBook(book, subject){
		PDFObject.embed("<?= $subject->books_path ?>/" + book, "#pdfViewer");
		return true;
	}
</script>

<style type="text/css">
	.pdfobject-container {height:48rem;border:1rem solid rgba(0,0,0,.1);} .bookfont{font-size:small;} #pdfViewer{min-height:320px;} .w3-text-gray{color:#aaa !important;}
	li a{text-decoration:none;} p span {top:5px;position:relative;}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.min.js"></script>