<div class="w3-row-padding">
	<div class="w3-col s12 m4 l4">
		<div class="w3-container w3-blue-gray">
			<h3>Lista (<?= $papers->count()?> tareas en total)</h3>
		</div>
		<div class="w3-container w3-border-left">
			<ul class="w3-ul">
			<?php foreach($papers as $paper){ ?>
				<li class="pl">
					<p>
						<span class="pn">
							<?= $this->Html->link($paper->getName(), ['#' => $paper->id], ['class' => '', 'data-paper-id' => $paper->id, 'escape' => false]) ?>
						</span>
						<span class="w3-right w3-text-gray">
							<i class="fa-solid fa-folder-open"></i> <?= $paper->homeworks[0]->total ?> <i class="fa-regular fa-calendar ml" title="<?= $paper->created->i18nFormat("d 'de' MMMM 'de' YYYY")?>"></i>
						</span>
					</p>
				</li>
			<?php } ?>
			</ul>
		</div>
	</div>
	<div class="w3-col s12 m8 l8">
		
		<?php foreach($papers as $paper){ ?>
			<div id="<?= $paper->id ?>" class="w3-container w3-blue-gray collapsible">
				<h4 class="w3-left"><?= $paper->getName() ?></h4>
				<p class="w3-right"><i class="fa-solid fa-plus"></i></p>
			</div>
			<div class="w3-card w3-border-bottom w3-border-gray w3-margin-bottom collaps-content">
				<p class="w3-right w3-no-margin w3-xlarge w3-text-blue-gray w3-padding-16">
					<?= $this->Html->link('<i class="fa-solid fa-folder-open"></i> '. $paper->homeworks[0]->total, ['action' => 'itemize', $paper->id], ['escape' => false]) ?>
				</p>
				<div class="w3-margin">
					<?= $paper->description ?>
				</div>
				<p class="w3-left small w3-text-gray cl"><?= $this->Html->link('<i class="fa-solid fa-folder-plus"></i>', ['controller' => 'papers', 'action' => 'index', '?' => ['duplicate' => $paper->id]], ['title' => 'Duplicar', 'escape' => false])?></p>
				<p class="w3-right w3-text-gray cr date"><em><?= $paper->created->i18nFormat("MMM d, YYYY")?></em></p>
			</div>
		<?php } ?>
	</div>
</div>

<script>
	$('.pn a').click(function() {
		$('#' + $(this).attr('data-paper-id'))[0].scrollIntoView({behavior:"smooth"});
		return false;
	});
</script>
<script>
	var coll = document.getElementsByClassName("collapsible");
	var i;

	for (i = 0; i < coll.length; i++) {
		coll[i].addEventListener("click", function() {
			this.classList.toggle("active");
			var content = this.nextElementSibling;
			if (content.style.maxHeight){
				content.style.maxHeight = null;
			} else {
				content.style.maxHeight = content.scrollHeight + "px";
			} 
		});
	}
</script>
<style>
.w3-sidebar{position:absolute !important;height:auto !important;} p.w3-no-margin{margin:0;clear:right;} .date{text-transform:capitalize;}
.ml{margin-left:12px;} li.pl {padding:8px 0 !important;} li p{margin:0;} li a{text-decoration:none;} .cl{clear:left} .cr{clear:right}
.w3-margin{margin-top:24px !important;} p.w3-large{margin:16px 0 8px !important;} .c{display:block;padding:0 0 20px;} .pn{max-width:75%;display:inline-block;}

.collaps-content {
  padding: 0 18px;
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.2s ease-out;
  background-color: #f1f1f1;
}

.active, .collapsible:hover {
  background-color: #555; cursor:pointer;
}
</style>

