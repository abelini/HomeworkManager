<div class="w3-container">
	<h2 class="w3-text-gray w3-center">¿Desea aceptar en la plataforma a<br/><strong><?= $user->get('nombre_completo')?></strong>?</h2>
	<h3 class="w3-text-gray w3-center"><?= $user->group->grupo ?></h3>

	<div class="w3-row" style="margin:48px 0 32px;">
		<div class="w3-col s6 m6 l6">
			<?= $this->Form->postButton('Sí', ['controller' => 'users', 'action' => 'accept', $user->get('id'), '?' => ['_' => 'YES']], ['class' => 'w3-button w3-center w3-green w3-padding-large w3-round'])?>
		</div>
		
		<div class="w3-col s6 m6 l6">
			<?= $this->Form->postButton('No', ['controller' => 'users', 'action' => 'accept', $user->get('id'), '?' => ['_' => 'NO']], ['class' => 'w3-button w3-center w3-red w3-padding-large w3-round'])?>
		</div>
	</div>
</div>

<style>
 button{display:block !important;margin:auto;}
</style>