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

<?php echo $this->Html->css('Admin./plugins/cakephp-ajax-pagination/ajaxpagination')?>

<section class="content-header">
  <h1>
    <?php echo __('Admin Roles') ?>
  </h1>
  <ol class="breadcrumb">
    <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i><?php echo __('Home'); ?></a></li>
    <li class="active"><?php echo __('Admin Roles') ?></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header">
         <div class="box-title">
            <?php echo $this->Html->link(__('<i class="fa fa-fw fa-plus"></i> Add New'),['controller' => 'roles', 'action' => 'add'],['class' => 'btn btn-primary ajax-modal-popup', 'escape' => false]); ?>
         </div>
    
          <?php 
            if(!empty($search))
              echo $this->Html->link(__('<i class="fa fa-fw fa-refresh"></i> Reset'),['controller' => 'roles', 'action' => 'index'],['class' => 'btn btn-default', 'escape' => false]); 
          ?>
          <div class="box-tools search">
            <?php echo $this->Html->link(__('<i class="fa fa-fw fa-download"></i>'),['controller' => 'roles', 'action' => 'exportLists'],['class' => 'csv-download btn btn-xs btn-info input-group pull-left btn-reset-link', 'title' => ' Export CSV', 'escape' => false]);?>

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
                        <th><?php echo $this->Paginator->sort('name', 'Name') ?></th>
                        <th><?php echo __( 'Status') ?></th>
                        <th><?php echo __( 'Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($roles)) { ?>

                      <?php foreach ($roles as $role): ?>
                      <tr role="row">
                          <td>
                              <?php echo h($role->name) ?>
                          </td>
                          <td>
                              <?php echo $role->is_active == 1 ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>'; ?>
                          </td>
                          <td class="actions">
                                <?php if($current_user['role_id'] != 1 && $current_user['role_id'] != 2) { ?>
                                    
                                    <?php echo $this->Html->link(__('<i class="fa fa-fw fa-pencil"></i>'),'javascript:void(0);',['class' => 'btn btn-xs btn-warning', 'escape' => false, 'disabled' => true]); ?>

                                    <?php echo $this->Html->link(__('<i class="fa fa-fw fa-trash"></i>'),'javascript:void(0);', ['class' => 'btn btn-xs btn-danger','escape' => false,'disabled' => true]); ?>

                                <?php } else { ?>
                                
                                    <?php echo $this->Html->link(__('<i class="fa fa-fw fa-pencil"></i>'),['controller' => 'roles', 'action' => 'edit', $role->id],['class' => 'btn btn-xs btn-warning', 'escape' => false]); ?>

                                    <?php echo $this->Html->link(__('<i class="fa fa-fw fa-trash"></i>'),['controller' => 'roles', 'action' => 'delete', $role->id], Configure::read('BTN_DELETE_OPTIONS')); ?>
                                <?php } ?>

                          </td>
                      </tr>
                      <?php endforeach; ?>

                      <?php } else { ?>
                      <tr>
                          <th colspan="3">
                            <div class="no-record">
                              <?php echo __(Configure::read('NO_RECORD_FOUND')) ?>
                            </div>
                          </th>
                      </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php if(!empty($roles)) { ?>
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

