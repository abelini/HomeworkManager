<div class="w3-bar w3-border w3-round">
	<?php
		echo $this->Paginator->first('<i class="fas fa-angle-double-left"></i>',
			[
				'tag' => 'span',
				'class' => 'w3-bar-item w3-button',
				'escape' => false
			]
		);
		echo $this->Paginator->prev('<i class="fas fa-angle-left"></i>',
			[
				'class' => 'w3-bar-item w3-button',
				'tag' => false,
				'escape' => false
			],
			null,
			[
				'tag' => false,
				'class' => 'w3-bar-item w3-light-gray',
				'escape' => false,
				'disabledTag' => 'span'
			]
		);
		echo $this->Paginator->numbers(
			[
				'class' => 'w3-bar-item w3-button',
				'separator' => false,
				'tag' => 'span',
				'currentClass' => 'w3-light-gray disabled',
				'currentTag' => 'span'
			]
		);
		echo $this->Paginator->next('<i class="fas fa-angle-right"></i>',
			[
				'class' => 'w3-bar-item w3-button',
				'tag' => false,
				'escape' => false
			],
			null,
			[
				'tag' => false,
				'class' => 'w3-bar-item w3-light-gray',
				'escape' => false,
				'disabledTag' => 'span'
			]
		);
		echo $this->Paginator->last('<i class="fas fa-angle-double-right"></i>',
			[
				'tag' => 'span',
				'class' => 'w3-bar-item w3-button',
				'escape' => false
			]
		);
	?>
</div>