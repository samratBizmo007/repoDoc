<?php 
use Cake\Core\Configure;
$roleId = $this->request->session()->read('Auth.User.role_id');
?>
<section class="content-header">
  <h1>
    <?php echo __('Pages') ?>
  </h1>
  <ol class="breadcrumb">
    <li><a href="javascript:void(0);"><i class="fa fa-newspaper-o"></i> <?php echo __('Pages') ?></a></li>
    <li class="active"><?php echo __('Manage Pages') ?></li>
  </ol>
</section>

<section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
             <?php 
                if (! empty($search))
                echo $this->Html->link(__('<i class="fa fa-fw fa-refresh"></i> Reset'), [
                    'controller' => 'pages',
                    'action' => 'index'
                ], [
                    'class' => 'btn btn-default',
                    'escape' => false
                ]);
            ?>
			 <div class="box-tools search">

            <?php echo $this->Form->create('',['type' => 'get']); ?>
            <div class="input-group input-group-sm search">
              <?php 
                  echo $this->Form->input('search',[
                      'id' => 'search',
                      'type' => 'text',
                      'class' => 'form-control pull-right',
                      'placeholder' => 'Search',
                      'required' => true,
                      'label' => false,
                      'value' => $search,
                      'templates' => [
                          'inputContainer' => '{{content}}'
                      ],
                  ]);
              ?>
              <div class="input-group-btn">
                <?php 
                    echo $this->Form->button(__('<i class="fa fa-search"></i>'),[
                        'type' => 'submit',
                        'class' => 'btn btn-default'
                    ]);
                ?>
              </div>
            </div>
            <?php echo $this->Form->end(); ?>
          </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover table-vertical-align ajax-pagination layout-fixed">
                <thead>
                    <tr>
                    	<th><?php echo $this->Paginator->sort('title') ?></th>
                        <th><?php echo $this->Paginator->sort('slug') ?></th>
                        <th class="actions"><?php echo __('Actions') ?></th>
                    </tr>
    			</thead>
                <tbody>
                	<?php if(!$pages->isEmpty()) { ?>
                    	<?php foreach ($pages as $page): ?>
                        	<tr>
                            	<td><?php echo h($page->title) ?></td>
                                <td><?php echo h($page->slug) ?></td>
                                <td class="actions">
                                	<?php echo $this->Html->link(__('<i class="fa fa-fw fa-eye"></i>'),['controller' => 'pages', 'action' => 'view', $page->id],['class' => 'btn btn-xs btn-info  view-remote-modal ajax-modal-popup', 'escape' => false]); ?>
                                    <?php if($roleId == 1 || $roleId == 2) { ?>
                                    <?php echo $this->Html->link(__('<i class="fa fa-fw fa-pencil"></i>'),['controller' => 'pages', 'action' => 'edit', $page->id],['class' => 'btn btn-xs btn-warning', 'escape' => false]); ?>
                                    <?php }?>
                                    <?php //echo $this->Html->link(__('<i class="fa fa-fw fa-trash"></i>'),['controller' => 'pages', 'action' => 'delete', $page->id], array_merge(Configure::read('BTN_DELETE_OPTIONS'), ['data-content' => "This will flush the page permanently."])); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php } else { ?>
                      <tr>
                          <th colspan="5">
                            <div class="no-record">
                              <?php echo __(Configure::read('NO_RECORD_FOUND')) ?>
                            </div>
                          </th>
                      </tr>
                    <?php } ?>    
                 </tbody>
                 </table>
            </div>
            <?php if(!$pages->isEmpty()) { ?>
                <div class="box-footer clearfix">
                      <?php echo $this->element('Admin.pagination'); ?>
                </div>
            <?php } ?>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
      <!-- /.row -->
    </section>

<?php echo $this->Html->script('Admin./plugins/cakephp-ajax-pagination/ajaxpaginate.min')?>
<?php echo $this->Html->script('Admin./plugins/bootstrap-confirmation/bootstrap-confirmation.min')?>
<script>
  $(function () {
    $('.ajax-pagination').cakephpPagination({
    	paginateDivId: "pagination-div"
    });
  });

  $('[data-toggle=confirmation]').confirmation({
      rootSelector: '[data-toggle=confirmation]',
      container: 'body'
  });
</script> 
