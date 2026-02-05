<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Homework $homework
 * @var string[]|\Cake\Collection\CollectionInterface $users
 * @var string[]|\Cake\Collection\CollectionInterface $papers
 */
?>
<div class="row">
    <div class="column-responsive">
        <div class="homeworks form content">
            <?= $this->Form->create($homework) ?>
            <fieldset>
                <legend><?= __('Edit Homework') ?></legend>
				<?= $this->Form->control('paper_id', ['options' => $papers->combine('id', 'name'), 'class' => 'w3-input'])?>

				<?= $this->Form->control('titulo', ['class' => 'w3-input'])?>
				<?= $this->Form->control('texto', ['class' => 'w3-input'])?>
				<?= $this->Form->hidden('user_id')?>
				
				<pre>
					<?php print_r($homework)?>
					<?php print_r($user)?>
				</pre>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<style>
 pre img{max-width:80%;}
</style>