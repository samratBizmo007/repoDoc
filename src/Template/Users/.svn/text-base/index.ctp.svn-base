<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Core\Configure;
?>

<?php echo $this->Html->css('Admin./plugins/cakephp-ajax-pagination/ajaxpagination') ?>
<?php echo $this->Html->css('Admin./plugins/bootstrap-switch/bootstrap-switch_min') ?>

<section class="content-header">
  <h1>
    <?php echo __('Admin') ?>
  </h1>
  <ol class="breadcrumb">
    <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i><?php echo __('Home'); ?></a></li>
	<li class="active"><?php echo __('Admins') ?></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header">
         <div class="box-title">
         	<?php echo $this->Html->link(__('<i class="fa fa-fw fa-plus"></i> Add Admin'),['controller' => 'users', 'action' => 'add'],['class' => 'btn btn-primary', 'escape' => false]); ?>
         </div>
	
          <?php 
            if(!empty($search))
              echo $this->Html->link(__('<i class="fa fa-fw fa-refresh"></i> Reset'),['controller' => 'users', 'action' => 'index'],['class' => 'btn btn-default', 'escape' => false]); 
          ?>
          <div class="box-tools search box-tools-csv">
			<?php //echo $this->Html->link(__('<i class="fa fa-fw fa-download"></i>'),['controller' => 'users', 'action' => 'exportLists'],['class' => 'csv-download btn btn-xs btn-info input-group pull-left btn-reset-link', 'title' => ' Export CSV', 'escape' => false]);?>

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
                        <th><?php echo $this->Paginator->sort('Users.email', 'Email') ?></th>
                        <th><?php echo $this->Paginator->sort('Users.firstname', 'Full Name') ?></th>
                        <th><?php echo $this->Paginator->sort('Users.role_id', 'Role') ?></th>
                        <th><?php echo __( 'Status') ?></th>
                        <th><?php echo __( 'Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($users)) { ?>

                      <?php foreach ($users as $user): ?>
                      <tr role="row">
                          <td>
                              <?php echo h($user->email) ?>
                          </td>
                          <td>
                              <?php echo h($user->full_name) ?>
                          </td>
                          <td>
                              <?php echo h($user->role->name) ?>
                          </td>
                          <td>
                            <?php 
                                if($current_user['id'] == $user->id || $current_user['role_id'] > $user->role_id) { 
                                    echo $user->is_active == 1 ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>';
                                } else {
                                    echo $this->Form->input('is_active',[
                                        'id' => 'switch_'.$user->id,
                                        'class' => 'switch no-margin',
                                        'data-value' => $user->id,
                                        'checked' => $user->is_active,
                                        'label' => false
                                    ]);
                                }
                            ?>
                          </td>
                          <td class="actions">
                              <?php if($current_user['id'] == $user->id || $current_user['role_id'] > $user->role_id) { ?>
								  <?php echo $this->Html->link(__('<i class="fa fa-fw fa-eye"></i>'),['controller' => 'users', 'action' => 'view', $user->id],['class' => 'btn btn-xs btn-info view-remote-modal ajax-modal-popup', 'escape' => false]); ?>

                                  <?php echo $this->Html->link(__('<i class="fa fa-fw fa-pencil"></i>'),['controller' => 'users', 'action' => 'edit', $user->id],['class' => 'btn btn-xs btn-warning', 'escape' => false]); ?>
								  <?php echo $this->Html->link(__('<i class="far fa fa-paper-plane-o"></i>'),['controller' => 'users', 'action' => 'resetPassword', $user->id],['class' => 'btn btn-xs btn-primary', 'escape' => false, 'title' => 'Reset Password']); ?> 	
                                  <?php //echo $this->Html->link(__('<i class="fa fa-fw fa-eye"></i>'),'javascript:void(0);',['class' => 'btn btn-xs btn-info view-remote-modal', 'escape' => false,'disabled' => true]); ?>

                                  <?php //echo $this->Html->link(__('<i class="fa fa-fw fa-pencil"></i>'),'javascript:void(0);',['class' => 'btn btn-xs btn-warning', 'escape' => false, 'disabled' => true]); ?>

                                  <?php echo $this->Html->link(__('<i class="fa fa-fw fa-trash"></i>'),'javascript:void(0);',['class'=>'btn btn-xs btn-danger','escape' => false, 'disabled' => true]); 
                              ?>
                              <?php } else { ?>
                                  <?php echo $this->Html->link(__('<i class="fa fa-fw fa-eye"></i>'),['controller' => 'users', 'action' => 'view', $user->id],['class' => 'btn btn-xs btn-info view-remote-modal ajax-modal-popup', 'escape' => false]); ?>
								  <?php echo $this->Html->link(__('<i class="fa fa-fw fa-pencil"></i>'),['controller' => 'users', 'action' => 'edit', $user->id],['class' => 'btn btn-xs btn-warning', 'escape' => false]); ?>
                                  <?php echo $this->Html->link(__('<i class="far fa fa-paper-plane-o"></i>'),['controller' => 'users', 'action' => 'resetPassword', $user->id],['class' => 'btn btn-xs btn-primary', 'escape' => false, 'title' => 'Reset Password']); ?>
                                  <?php echo $this->Html->link(__('<i class="fa fa-fw fa-trash"></i>'),'javascript:void(0);',['class' => 'btn btn-xs btn-danger','data-href' => $this->Url->build(['controller' => 'users', 'action' => 'delete', $user->id]),'data-target'=> '#confirm-delete','data-toggle' => 'modal','escape' => false]); 
                                  ?>
                              <?php } ?>

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
        <?php if(!empty($users)) { ?>
        <div class="box-footer clearfix">
            <?php echo $this->element('Admin.pagination'); ?>
            <?php echo $this->element('Admin.delete-confirmation',['data' => ['title' => 'Are you sure ?','message'=>'This will flush all the data.']]); ?>
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
<?php echo $this->Html->script('Admin./plugins/bootstrap-switch/bootstrap-switch_min')?>

<script>
  $(function () {
    $('.ajax-pagination').cakephpPagination({
    	paginateDivId: "pagination-div",
    	afterSuccess: function () {
            initMethods();
        }
    });
  });

  function changeStatus(state,id){
      var url = "<?php echo $this->Url->build(['controller' => 'Users','action' => 'changeStatus']); ?>";
      $.ajax({
          url: url,
          type:'POST',
          data : { id:id,state:state}
      }).done(function(data) {
          if(data)
            toastr.success('Status has been changed.');
          else
            toastr.error('Status has not been changed. Please try again.');
      });
  }
</script> 

