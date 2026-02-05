	<div class="w3-container">
		<?= $this->Flash->render('AccessDenied') ?>
	</div>

	<div class="w3-container">
		<div class="w3- w3-left">
			<h3>
				<?= $this->cell('Avatar::display', [$user, 'w3-circle', 72])->render()?>
				Bienvenido <?= $this->Html->link($user->get('nombres'), '/profile')?> <?php if(is_null($user->photo)){ echo $this->Html->link('<i class="fa-solid fa-camera"></i>', '/profile', ['class' => 'w3-text-red', 'title' => '¡Por favor sube una foto de perfil!', 'escape' => false]); } ?>
				<span class="w3-medium" style="display:block;margin:-24px 0 0 80px;color:#d4d4d4;"><span style="letter-spacing:6px;"><?= $group->get('UCGroup') ?></span> [A#<?= $user->id ?>]</span>
			</h3>
		</div>

		<div class="w3-panel w3-right w3-text-white w3-<?= ($fullAccess)? 'green' : (($papers->count() > 0)? 'deep-orange':'green'); ?>">
			<h4><i class="fa-solid fa-<?= ($papers->count() > 0)? 'arrow-down':'check-circle';?>"></i> Tienes <?= $papers->count()?> tarea(s) pendiente(s)
			<?php if($fullAccess){ ?>
				<br/><span>¡Aprovecha que el profesor desbloqueó la expiración!</span>
			<?php } ?>
			</h4>
		</div>
	</div>
	
	<?php if($papers->count() > 0 && !$fullAccess){ ?>
	
	<div class="w3-panel w3-display-container <?= $colorClass ?> w3-right w3-sticky">
		<span onclick="this.parentElement.style.display='none'" class="w3-button w3-display-topright" style="padding:6px;">&times;</span> 
		<p class="w3-center" id="timer"><i class="fas fa-stopwatch"></i> Te quedan<br/><span class="days"></span> <span class="w3-xlarge"><span class="hours"></span>:<span class="minutes"></span>:<span class="seconds"></span></span><br/> para entregar<br/>tu próxima tarea</p>
	</div>
	<div class="c"></div>
	<?php } ?>
	

		<?php if(!$papers->isEmpty()) { ?>
			<table class="w3-table-all w3-section">
			<?= $this->Html->tableHeaders(['<i class="fa-solid fa-file-lines"></i> Tarea', '<i class="fa-solid fa-clock"></i> Expira el'], ['class' => 'w3-orange'])?>
			<?php foreach($papers as $paper) { ?>
				<?php $icon = boolval($paper->slide)? '<i class="fa-regular fa-file-powerpoint"></i> ' : '<i class="fa-solid fa-file-word"></i> ';?>
				<?= $this->Html->tableCells([
                       $icon.$this->Html->link($paper->name, ['controller' => 'homeworks', 'action' => 'add', '?' => ['PaperID' => $paper->id, 'ref' => 'home']], ['escape' => false]),
					($fullAccess)? 'Sin expiración...' : $paper->expiration->i18nFormat([\IntlDateFormatter::FULL, \IntlDateFormatter::SHORT])
                  ])?>
			<?php }?>
			</table>
		<?php } ?>

	<div class="c"></div>
	
	<div class="w3-container">
	
		<div class="w3-row">
			<div class="w3-twothird w3-section">
				
				<div class="w3-container w3-blue-gray">
					<h4><?= ($welcomeMessage)? 'Mensaje del profesor' : '<i class="fas fa-list"></i> Esta es la última tarea asignada a tu grupo'; ?></h4>
				</div>
				<div class="w3-container w3-display-container w3-light-gray">
					<? /*<h3 title="<?= $hwDone['title']?>" class="w3-text-<?= $hwDone['color']?> w3-right"><?= $hwDone['icon']?></h3> */?>
					<h3 class="w3-left"><?= $lastPaper->name ?></h3>
				</div>
				<div class="w3-container w3-display-container w3-border-left w3-border-light-gray">
					
					<p><?= $lastPaper->description ?></p>
					
					<?php if($lastPaper->isExpirable()) { ?>
						<?php if($lastPaper->expiration->isPast()) { ?>
						<div class="w3-panel w3-pale-red w3-border w3-border-red">
							<p class="hw-expiration">La tarea expiró el: <?= $lastPaper->expiration->i18nFormat("eeee d 'de' MMMM 'a las' h:mm a") ?></p>
						</div>
						<?php } else { ?>
						<div class="w3-panel w3-pale-green w3-border w3-border-green">
							<p class="hw-expiration">La tarea expira el: <?= $lastPaper->expiration->i18nFormat("eeee d 'de' MMMM 'a las' h:mm a") ?></p>
						</div>
						<?php } ?>
					<?php } ?>
					
					<p class="w3-right w3-padding-32">
						<?= $this->cell('Avatar::display', [$profe, 'w3-circle', 120])->render()?>
					</p>
					<p class="w3-display-bottomright w3-margin">M.C. Wilfrido Ibarra</p>
					<p class="w3-display-bottomleft w3-margin w3-text-gray"><?= $lastPaper->created->i18nFormat([\IntlDateFormatter::FULL, \IntlDateFormatter::SHORT])?></p>
				</div>

				<a name="comments"></a>

			  <div class="w3-container w3-blue-gray">
				    <h4><i class="fas fa-question-circle"></i> ¿Tienes una duda sobre esto?</h4>
				</div>
				
				<?php if(!$welcomeMessage){ ?>
					<div class="w3-container w3-section">
					    <?= $this->Form->create($noteComment, ['url' => ['controller' => 'notecomments', 'action' => 'add']])?>
							<?= $this->Form->textarea('comment', ['label' => false, 'rows' => 3, 'class' => 'w3-input'])?>
							<?= $this->Form->hidden('user_id')?>
							<?= $this->Form->hidden('paper_id')?>
							<?= $this->Form->submit('Preguntar', ['class' => 'w3-button w3-blue w3-round'])?>
						<?= $this->Form->end()?>
					</div>
				<?php } else { ?>
					<p class="w3-center">Comentarios desactivados</p>
				<?php } ?>
				
				<div class="w3-container" id="PaperID-<?= $lastPaper->get('id')?>">

					<?= $this->Flash->render('comments') ?>
					
					<div class="comments">
						<?php foreach($lastPaper->notecomments as $comentario) { ?>
							<?php
								$deleteButton = ($this->Identity->get('id') == $comentario->user->id)?
												'<div class="w3-right">'.
													$this->Form->postLink(
														'<i class="fa-regular fa-trash-can"></i>',
														['controller' => 'notecomments', 'action' => 'delete', 'prefix' => false, $comentario->id],
														['escape' => false, 'confirm' => '¿Seguro que deseas eliminar el comentario?']
													).
												'</div>':'';
							?>
							<div class="w3-container w3-padding w3-padding-16 comment">
								<?= $deleteButton ?>
								<?= $this->cell('Avatar::display', [$comentario->user, 'w3-left w3-circle w3-margin-right'])->render() ?>
								<p class="w3-text-dark-grey w3-bold cn">
									<?= $comentario->user->get('nombres')?>
								</p>
								<p class="w3-margin w3-text-dark-grey ct">
									<?= $comentario->comment ?>
								</p>
								<p class="w3-right w3-small w3-text-grey">
									<?= $comentario->created->i18nFormat([\IntlDateFormatter::LONG, \IntlDateFormatter::SHORT])?>
								</p>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		
			<div class="w3-third  w3-section">
				<div class="w3-container w3-blue-gray">
					<h4><i class="fas fa-users"></i> Actualmente en línea</h4>
				</div>
				<table class="w3-table w3-striped w3-bordered">
				<?php if(!$onlineUsers->isEmpty()){ ?>
					<?php foreach($onlineUsers as $user){ ?>
						<?= $this->Html->tableCells(['<i class="fas fa-user"></i> '. $user->get('nombres')])?>
					<?php } ?>
				<?php } else { ?>
						<?= $this->Html->tableCells(['Crii crii...'])?>
				<?php } ?>
				</table>
			</div>
		</div>
	</div>
		<style type="text/css">
		<?php if(isset($showDays) && $showDays == true){ ?>
			.days::after{content:" días";font-weight:normal;} .days{font-weight:bold;} /*.w3-xxlarge{font-size:18px !important;}*/
		<?php } else { ?>
			.days{display:none;}
		<?php } ?>
			.cn{margin-top:0;} .ct{padding-left:60px;} .comment:nth-child(odd){background-color:#f1f1f1}
			.w3-sticky {position:fixed;bottom:1px;right:1px;margin-bottom:0;} h4 span{font-size:14px;} tr.w3-orange{border:1px #ff5722 solid;}
			<?php if($fullAccess){ ?> .hw-expiration{text-decoration:line-through;} <?php } ?>
		</style>
		<?php if($papers->count() > 0){ ?>
		<script type="text/javascript">
			function getTimeRemaining(endtime) {
				const t = Date.parse(endtime) - Date.parse(new Date());
				const seconds = Math.floor((t / 1000) % 60);
				const minutes = Math.floor((t / 1000 / 60) % 60);
				const hours = Math.floor((t / (1000 * 60 * 60)) % 24);
				const days = Math.floor(t / (1000 * 60 * 60 * 24));
				return {'total':t,'days':days,'hours':hours,'minutes':minutes,'seconds':seconds};
			}
			function initializeClock(id, endtime) {
				const clock = document.getElementById(id);
				const daysSpan = clock.querySelector('.days');
				const hoursSpan = clock.querySelector('.hours');
				const minutesSpan = clock.querySelector('.minutes');
				const secondsSpan = clock.querySelector('.seconds');
				function updateClock(){
					const t = getTimeRemaining(endtime);
					daysSpan.innerHTML = t.days;
					hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
					minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
					secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);
					if (t.total <= 0){clearInterval(timeinterval);}
				}
				updateClock();
				const timeinterval = setInterval(updateClock, 1000);
			}
			const deadline = new Date('<?= $papers->first()->expiration->i18nFormat('yyyy-MM-dd HH:mm:ss')?>');
			initializeClock('timer', deadline);
		</script>
		<?php } ?>

<?php $this->assign('title', 'Inicio')?>