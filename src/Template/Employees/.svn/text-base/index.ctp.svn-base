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
$roleId = $this->request->session()->read('Auth.User.role_id');
?>

<?php echo $this->Html->css('Admin./plugins/cakephp-ajax-pagination/ajaxpagination') ?>
<?php echo $this->Html->css('Admin./plugins/bootstrap-switch/bootstrap-switch_min') ?>

<section class="content-header">
  <h1>
    <?php echo __('Employees') ?>
  </h1>
  <ol class="breadcrumb">
    <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i><?php echo __('Home'); ?></a></li>
    <li class="active"><?php echo __('Employees') ?></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header">
             <div class="box-title">
             <?php if($roleId == 3 || $roleId == 5) { ?>
                <?php echo $this->Html->link(__('<i class="fa fa-fw fa-plus"></i> Add Employee'),['controller' => 'Employees', 'action' => 'add'],['class' => 'btn btn-primary', 'escape' => false]); ?>
                <?php echo $this->Html->link(__('<i class="fa fa-fw fa-file"></i> Upload CSV'),['controller' => 'Employees', 'action' => 'import-csv'],['class' => 'btn btn-primary ajax-modal-popup', 'escape' => false]); ?>
                <?php echo $this->Html->link(__('Sample CSV'),['controller' => 'Employees', 'action' => 'download-csv'],['class' => 'btn btn-primary', 'escape' => false]); ?>
             <?php }?>
             </div>
    	  <?php 
            if(!empty($search) || !empty($department))
              echo $this->Html->link(__('<i class="fa fa-fw fa-refresh"></i> Reset'),['controller' => 'Employees', 'action' => 'index'],['class' => 'btn btn-default', 'escape' => false]); 
          ?>
          <div class="box-tools search box-tools-csv" style="width: 550px;">
            <?php echo $this->Html->link(__('<i class="fa fa-fw fa-download"></i>'),['controller' => 'Employees', 'action' => 'exportLists'],['class' => 'csv-download btn btn-xs btn-info input-group pull-left btn-reset-link', 'title' => ' Export CSV', 'escape' => false]);?>

			<div class="input-group input-group-sm search" style="float: left;margin-right: 10px;">
     			<?php 
     			        echo $this->Form->input('department',[
                            'id' => 'department',
                            'type' => 'select',
                            'label' => false,
                            'value' => $department,
                            'onChange' => 'changeDepartment(this.value)',
                            'options' => $departments,
     			            'empty' => 'Select Department',
                            'class' => 'form-control pull-right select2',
                        ]);
                    ?>
            </div>
            
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
                        <th>Photo</th>
                        <th><?php echo $this->Paginator->sort('email', 'Email') ?></th>
                        <th><?php echo $this->Paginator->sort('full_name','Name') ?></th>
                        <th><?php echo $this->Paginator->sort('employee_role','Employee Role') ?></th>
                        <th><?php echo $this->Paginator->sort('designation','Designation') ?></th>
                        <th><?php echo $this->Paginator->sort('status','Status') ?></th>
                        <th><?php echo __( 'Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($employees->toArray())) { ?>

                      <?php foreach ($employees as $employee): ?>
                        <tr role="row">
                            <td>
                                <?php 
                                    if(!empty($employee->photo) && file_exists(Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_PATH').$employee->photo)){
                                        $photo_url = Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_URL').$employee->photo;
                                    } else {
                                        $photo_url = Configure::read('DEFAULT_USER_IMAGE_URL');
                                    }
                                    echo $this->Html->image($photo_url, [
                                        'class' => 'img img-circle',
                                        'width' => '50',
                                        'height' => '50',
                                        'alt' => $employee->full_name
                                    ]); 
                                ?>
                            </td>
                            <td>
                                <?php echo h($employee->email) ?>
                            </td>
                            <td>
                                <?php echo h($employee->full_name) ?>
                            </td>
                            <td>
                                <?php echo h($employee->employee_role) ?>
                            </td>
                            <td>
                                <?php echo h($employee->designation) ?>
                            </td>
                            <td>
                                <?php 
                                    echo $this->Form->input('is_active',[
                                        'id' => 'switch_'.$employee->id,
                                        'class' => 'switch no-margin',
                                        'data-value' => $employee->id,
                                        'checked' => $employee->status,
                                        'label' => false
                                    ]);
                                ?>
                            </td>
                            <td class="actions">
                            	<?php if((!empty($employee->employees_schedule))) {?>
                            		<?php echo $this->Html->link(__('<i class="fa fa-calendar"></i>'),['controller' => 'EmployeesSchedules', 'action' => 'view', $employee->employees_schedule->id],['class' => 'btn btn-xs btn-primary', 'escape' => false]); ?>
                            	<?php }?>
                            	<?php echo $this->Html->link(__('<i class="fa fa-fw fa-eye"></i>'),['controller' => 'Employees', 'action' => 'view', $employee->id],['class' => 'btn btn-xs btn-info view-remote-modal ajax-modal-popup', 'escape' => false]); ?>
                                <?php if($roleId == 3 || $roleId == 5) { ?>
                                	<?php echo $this->Html->link(__('<i class="fa fa-fw fa-pencil"></i>'),['controller' => 'Employees', 'action' => 'edit', $employee->id],['class' => 'btn btn-xs btn-warning', 'escape' => false]); ?>
								<?php }?>
								<?php echo $this->Html->link(__('<i class="far fa fa-paper-plane-o"></i>'),['controller' => 'Employees', 'action' => 'resetPassword', $employee->id],['class' => 'btn btn-xs btn-primary', 'escape' => false, 'title' => 'Reset Password']); ?>
                                <?php echo $this->Html->link(__('<i class="fa fa-fw fa-trash"></i>'),'javascript:void(0);',['class' => 'btn btn-xs btn-danger','data-href' => $this->Url->build(['controller' => 'Employees', 'action' => 'delete', $employee->id]),'data-target'=> '#confirm-delete','data-toggle' => 'modal','escape' => false]); 
                                  ?>
                            </td>
                      </tr>
                      <?php endforeach; ?>

                      <?php } else { ?>
                      <tr>
                          <th colspan="8">
                            <div class="no-record">
                              <?php echo __(Configure::read('NO_RECORD_FOUND')) ?>
                            </div>
                          </th>
                      </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php if(!empty($employees->toArray())) { ?>
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
<?php echo $this->Html->script('Admin./plugins/select2/select2.full.min'); ?>

<script>
$(function () {
    $(".select2").select2();
});
    $(function () {
        $('.ajax-pagination').cakephpPagination({
            paginateDivId: "pagination-div",
            afterSuccess: function () {
                initMethods();
            }
        });
    });

    function changeStatus(state,id){
        var url = "<?php echo $this->Url->build(['controller' => 'Employees','action' => 'changeStatus']); ?>";
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

    function changeDepartment(name) {
		var url = "<?php echo $this->Url->build(array('action' => 'index')) ?>";
		window.location.href = url + "/index/" + name;				
    }
</script>