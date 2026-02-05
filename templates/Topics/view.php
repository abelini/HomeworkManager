<div class="w3-container w3-blue-gray">
	<h4><i class="fa-solid fa-person-chalkboard"></i> Foro de asesorías</h4>
</div>

<div class="w3-row w3-margin-top">
	<p><?= $this->Html->link('<i class="fa-solid fa-house"></i> Inicio', '/forum', ['escape' => false])?> <i class="fa-solid fa-angles-right w3-text-gray"></i> <?= $topic->name ?></p>
</div>

<?= $this->Flash->render('topic_created')?>

<div class="w3-row">
	<div class="w3-container w3-light-gray w3-border">
		<h4><?= $topic->name ?></h4>
	</div>
	<div class="w3-container w3-border-left w3-border-right">
		<div class="w3-col s3 w3-padding">
			<div class="w3-card-3">
				<?= $this->cell('Avatar::display', [$topic->user, 'w3-center', 200]) ?>
				<div class="w3-container w3-center">
					<h5><?= $topic->user->get('nombre')?></h5>
					<h6 class="w3-text-gray"><?= $topic->user->group->grupo ?></h6>
				</div>
			</div>
		</div>
		<div class="w3-col s9 w3-padding">
			<i class="fas fa-quote-left w3-xxlarge w3-text-light-gray"></i>
			<?= $topic->get('full_content') ?>
		</div>
	</div>
	<div class="w3-container w3-light-gray w3-border-left w3-border-right w3-border-bottom">
		<p class="w3-right w3-small"><i class="fa-solid fa-calendar-day"></i> Publicado el <?= $topic->modified->i18nFormat([\IntlDateFormatter::FULL, \IntlDateFormatter::SHORT])?></p>
	</div>
</div>

<div class="w3-row">
	<p class="w3-bold w3-medium w3-center w3-text-gray"><i class="fas fa-comments"></i> <?= $this->Paginator->counter('{{count}} respuesta(s)')?></p>
	<?= $this->Flash->render('post') ?>
</div>

<div class="">
	<?php foreach ($replies as $post) : ?>
		<div class="w3-container w3-row w3-leftbar" id="response-<?= $post->id ?>">
			<div class="w3-col s2 m3 l2 w3-padding">
				<div class="w3-card-3">
					<?= $this->cell('Avatar::display', [$post->user, 'w3-center', 120]) ?>
					<h5 class="w3-center" id="author-<?= $post->id ?>"><?= $post->user->get('nombres')?></h5>
					<h6 class="w3-center w3-text-gray"><?= $post->user->group->grupo ?></h6>
				</div>
			</div>
			<div class="w3-col s10 m9 l10 w3-padding">
				<?php if($post->quoted != 0){ ?>
					<?= $this->cell('Quote::display', [$post->quoted]) ?>
				<?php } ?>
				<div class="w3-margin-bottom" id="Div-<?= $post->id ?>">
					<?= $post->get('formatted_content') ?>
				</div>
			</div>
		</div>
		<div class="w3-container w3-light-gray w3-border-left w3-border-bottom w3-margin-bottom w3-leftbar">
			<?php if($this->Identity->get('id') == $post->user->id ){ ?>
			<p class="w3-left w3-small">
				<?= $this->Html->link('<i class="fa-solid fa-pen-to-square"></i> Editar', ['controller' => 'posts', 'action' => 'edit', $post->id], ['escape' => false])?>
			</p>
			<p class="w3-left w3-small" style="padding:0 8px;"> | </p>
			<?= $this->Form->postLink('<i class="fa-solid fa-trash-can"></i> Eliminar', ['controller' => 'posts', 'action' => 'delete', $post->id], ['class' => 'w3-small w3-left', 'style' => 'margin:12px 0;', 'confirm' => '¿Seguro que deseas eliminar esta respuesta?', 'escape' => false])?>
			
			<?php } ?>
			<p class="w3-left w3-small" style="padding:0 8px;"> | </p>
			<p class="w3-left w3-small">
				<i class="fa-solid fa-quote-left"></i> <a href="#comment-box" onclick="quoteResponse(<?= $post->id ?>)">Citar esta respuesta</a></i>
			</p>
			
			<p class="w3-right w3-small"><i class="fa-regular fa-clock"></i> <?= $post->modified->i18nFormat([\IntlDateFormatter::FULL, \IntlDateFormatter::SHORT])?></p>
		</div>
	<?php endforeach;?>
</div>

<div class="w3-center">
	<?= $this->Html->para(null, $this->Paginator->counter('Mostrando respuestas {{start}}-{{end}} de {{count}}'))?>
	<?= $this->element('paginator')?>
</div>

<div class="w3-container" id="comment-box">
	<h4>Publicar una respuesta</h4>
	<?= $this->Form->create($reply, ['url' => ['controller' => 'posts', 'action' => 'add'], 'class' => 'w3-container'])?>

		<div class="w3-panel w3-card-4 w3-light-grey w3-hide" style="width:75%;margin:0 auto 24px;" id="quotedResponse">
			<p class=" w3-large w3-serif"><em>Citando a</em> <span id="quotedAuthor"></span>:</p>
			<i class="fa fa-quote-left w3-xlarge w3-left"></i>
			<p id="quotedText" style="padding-left:24px;"></p>
		</div> 
		<?= $this->Form->control('content', ['label' => false, 'placeholder' => 'Escribe tu comentario o respuesta', 'class' => 'w3-select', 'id' => 'PostContent'])?>
		<?= $this->Form->hidden('quoted', ['id' => 'PostQuoted'])?>
		<?= $this->Form->hidden('topic_id')?>
		<?= $this->Form->hidden('user_id')?>
		<?= $this->Form->submit('Responder', ['class' => 'w3-button w3-round w3-blue'])?>
	<?= $this->Form->end()?>
</div>


<style type="text/css">
	/*.s3{max-width:200px !important;} .m3{max-width:100px !important;}*/ .w3-card-3 img{max-width:100% !important; border-radius:50%;border:1px #ddd solid;} h4, h5, h6{font-weight:600;}
	em{color:#999;} .w3-small{text-decoration:none;} .disabled{cursor:auto !important;} img.w3-center{margin:auto;display:block;} a{text-decoration:none !important;}
</style>
<script type="text/javascript">
	function quoteResponse(id){
		$('#PostQuoted').val(id);
		$('#quotedText').html($('#'+id).html());
		$('#quotedAuthor').html($('#author-'+id).html());
		$('#quotedResponse').removeClass('w3-hide');
		$('#quotedResponse').addClass('w3-show');
		$('#PostContent').focus();
	}
</script>