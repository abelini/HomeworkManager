<div class="w3-section">
	
	<?= $this->Flash->render() ?>
	
	<div class="w3-row-padding">
	<?php foreach($groups as $group) { ?>
		<?php $homeworkCounter = 0; ?>
		<div class="w3-half">
			<div class="w3-container w3-blue-gray">
				<h4><?= $group->icon ?> <?= $group->grupo ?></h4>
			</div>
			<table class="w3-table-all">
				<?= $this->Html->tableHeaders([
					['No.' => ['class' => 'hw-no w3-center']],
					['Tema' => ['class' => 'w3-cell w3-cell-middle']],
					['Cumplimiento' => ['class' => 'hw-no w3-center']]
				])?>

				<?php foreach($group->papers as $paper){ ?>
					<?php 
						$unrated = $paper->homeworks[0]->unrated ?? 0;
						$totalHws = $paper->homeworks[0]->total ?? 0;

						echo $this->Html->tableCells(
							[
								[
									[++$homeworkCounter, ['class' => 'w3-center w3-border']],
									[$paper->icon() . $this->Html->link($paper->name, '/admin/papers/itemize/'.$paper->id, ['escape' => false]) . $paper->getUndone($unrated), ['class' => 'w3-border']],
									[$this->Number->toPercentage($totalHws / $group->users[0]->total, 1, ['multiply' => true]), ['class' => 'w3-center w3-border']]
								]
							]
						);
					?>
				<?php } ?>
			</table>
		</div>
	<?php } ?>
	</div>
</div>
<style type="text/css">
	.w3-table-all th{vertical-align:middle;} td i{margin-right:12px;}
</style>
