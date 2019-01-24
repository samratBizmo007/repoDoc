<?php echo $this->Html->css('Admin./plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5')?>
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
    <?php echo __('Add Page')?>
  </h1>
	<ol class="breadcrumb">
		<li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i><?php echo __('Home'); ?></a></li>
		<li><a href="javascript:void(0);"><i class="fa fa-newspaper-o"></i><?php echo __('Pages'); ?></a></li>
		<li class="active"><?php echo __('Add Page'); ?></li>
	</ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<!-- Default box -->
		<div class="col-md-12">
            	<div class="box box-primary">
                    <?php echo $this->Form->create($page, ['id'=>'page-add'])?>
				<div class="box-body">
					<!-- Title-->
					<div class="form-group">
                		<?php echo $this->Form->input("title", [
                		      'id' => 'title',
                              'type' => 'text',
                              'class' => 'form-control',
                              'placeholder' => 'Enter Title'
                		]); ?>
                    </div>
					<!-- Slug -->
					<div class="form-group">
						<?php echo $this->Form->input("slug", [
                		      'id' => 'slug',
                              'type' => 'text',
                              'class' => 'form-control',
                              'placeholder' => 'Enter Slug'
                		]); ?>
                    </div>
					<!-- Content -->
					<div class="form-group">
						<?php echo $this->Form->input("content", [
						      'id' => 'content',
                              'type' => 'textarea',
						      'rows' => '7',
						      'cols' => '5',
						      'class' => 'wysihtml5 form-control',
						      'placeholder' => 'Enter Content'
						]); ?>
                    	<label id="content-error" class="error" for="content"></label>
                    </div>

					<!-- Submit Button -->
					<div class="box-footer">
                        <?php 
                            echo $this->Form->button(__('Save'),[
                                'type' => 'submit',
                                'class' => 'btn btn-danger btn-form'
                            ]);

                            echo $this->Html->link(__('Cancel'),'/pages/index',[
                                'class' => 'btn btn-default btn-form'
                            ]);
                        ?>
                    </div>
				<!-- /.box-body -->
                <?php echo $this->Form->end()?>
			</div>
                </div>
	</div>
	<!-- /.box -->
</section>
<!-- /.content -->

<!-- /.content-wrapper -->
<?php echo $this->Html->script('Admin./plugins/jquery-validation/jquery.validate.min'); ?>
<?php echo $this->Html->script('Admin./plugins/jquery-validation/additional-methods.min'); ?>
<?php echo $this->Html->script('Admin./plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all')?>

<script>
  $(function () {
  	//bootstrap WYSIHTML5 - text editor
    $(".wysihtml5").wysihtml5();
  });
  	
  $( "#page-add" ).validate({
	  ignore: ":hidden:not(textarea)",
	  messages :{
		  title: "Please enter title",
		  slug: "Please enter slug",
		  content: "Please enter content",
      },
	  errorPlacement: function(error, element) {
		    if (element.attr("name") == "content" )
		    	error.append($('#content-error'));
		    else
		        error.insertAfter(element);
		}
  });
</script>
