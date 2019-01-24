<ul id="pagination-div" class="pagination pagination-sm no-margin pull-right">
	<?php 
		echo $this->Paginator->first('&laquo;', [
			'tag' => 'li', 
			'title' => __('First page'), 
			'escape' => false
		]); 
	?>
	<?php 
		echo $this->Paginator->prev('&lsaquo;',[
			'tag' => 'li', 
			'title' => __('Previous page'), 
			'escape' => false
		]);
	?>
	<?php 
		echo $this->Paginator->numbers([
			'separator' => '', 
			'tag' => 'li' ,
			'currentClass' => 'active', 
			'currentTag' => 'a' , 
			'escape' => false
		]); 
	?>
	<?php 
		echo $this->Paginator->next('&rsaquo;',[
			'tag' => 'li', 
			'title' => __('Next page'), 
			'escape' => false
		]);
	?>
	<?php 
		echo $this->Paginator->last('&raquo;', [
			'tag' => 'li', 
			'title' => __('Last page'), 
			'escape' => false
		]); 
	?>
</ul>