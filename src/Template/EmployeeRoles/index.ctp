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
use Cake\Routing\Router;

$clinicalRole = !empty($this->request->getParam('pass')) ? $this->request->getParam('pass')[0] : 1;

?>

<?php echo $this->Html->css('Admin./plugins/cakephp-ajax-pagination/ajaxpagination') ?>
<?php echo $this->Html->css('Admin./plugins/bootstrap-switch/bootstrap-switch_min') ?>

<section class="content-header">
  <h1>
    <?php echo __('Employee Roles') ?>
  </h1>
  <ol class="breadcrumb">
    <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i><?php echo __('Home'); ?></a></li>
    <li class="active"><?php echo __('Employee Roles') ?></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="nav-tabs-custom">
            <?php echo $this->element('Admin.tabs'); ?>
            <div class="tab-content">
              <div class="tab-pane active" id="settings">
                 <div class="box-header">
                     <div class="box-title">
                        <?php echo $this->Html->link(__('<i class="fa fa-fw fa-plus"></i> Add New'),['controller' => 'EmployeeRoles', 'action' => 'add'],['class' => 'btn btn-primary ajax-modal-popup', 'escape' => false]); ?>
                      	<?php echo $this->Html->link(__('<i class="fa fa-fw fa-file"></i> Upload CSV'),['controller' => 'EmployeeRoles', 'action' => 'import-csv'],['class' => 'btn btn-primary ajax-modal-popup', 'escape' => false]); ?>
                      	<?php echo $this->Html->link(__('Sample CSV'),['controller' => 'EmployeeRoles', 'action' => 'download-csv'],['class' => 'btn btn-primary', 'escape' => false]); ?>
                     </div>
                
                      <?php 
                        if(!empty($search))
                          echo $this->Html->link(__('<i class="fa fa-fw fa-refresh"></i> Reset'),['controller' => 'EmployeeRoles', 'action' => 'index'],['class' => 'btn btn-default', 'escape' => false]); 
                      ?>
                      <div class="box-tools search box-tools-csv">
                        <?php echo $this->Html->link(__('<i class="fa fa-fw fa-download"></i>'),['controller' => 'EmployeeRoles', 'action' => 'exportLists'],['class' => 'csv-download btn btn-xs btn-info input-group pull-left btn-reset-link', 'title' => ' Export CSV', 'escape' => false]);?>

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
                    <ul class="nav nav-tabs tabs-primary">
                      <li class='<?php if($clinicalRole == 1) { echo "active" ; } ?>'>
                          <a style="color: #555;"  href="<?php echo $this->Url->build(['controller' => 'EmployeeRoles','action' => 'index', 1]); ?>" aria-expanded="false">
                              Clinical Roles
                          </a>
                      </li class='<?php if($clinicalRole == 0) { echo "active" ; } ?>'>
                      <li>
                          <a style="color: #555;" href="<?php echo $this->Url->build(['controller' => 'EmployeeRoles','action' => 'index', 0]); ?>" aria-expanded="false">
                              Non Clinical Roles
                          </a>
                      </li>
                    </ul>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover table-vertical-align ajax-pagination layout-fixed">
                            <thead>
                                <tr>
                                    <th><?php echo $this->Paginator->sort('name', 'Name') ?></th>
                                    <th><?php echo $this->Paginator->sort('short_name', 'Short Name') ?></th>
                                    <th><?php echo __( 'Actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($employeeRoles->toArray())) { ?>

                                  <?php foreach ($employeeRoles as $employeeRole): ?>
                                  <tr role="row">
                                      <td>
                                          <?php echo h($employeeRole->name) ?>
                                      </td>
                                      <td>
                                          <?php echo h($employeeRole->short_name) ?>
                                      </td>
                                      <td class="actions">
                                          <?php echo $this->Html->link(__('<i class="fa fa-fw fa-pencil"></i>'),['controller' => 'EmployeeRoles', 'action' => 'edit', $employeeRole->id],['class' => 'btn btn-xs btn-warning ajax-modal-popup', 'escape' => false]); ?>

                                          <?php echo $this->Html->link(__('<i class="fa fa-fw fa-trash"></i>'),'javascript:void(0);',['class' => 'btn btn-xs btn-danger','data-href' => $this->Url->build(['controller' => 'EmployeeRoles', 'action' => 'delete', $employeeRole->id]),'data-target'=> '#confirm-delete','data-toggle' => 'modal','escape' => false]); 
                                              ?>
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
                    <?php if(!empty($employeeRoles->toArray())) { ?>
                    <div class="box-footer clearfix">
                        <?php echo $this->element('Admin.pagination'); ?>
                        <?php echo $this->element('Admin.delete-confirmation',['data' => ['title' => 'Are you sure ?','message'=>'This will flush all the data.']]); ?>
                    </div>
                    <?php } ?>
                    <!-- /.box-body -->
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
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

