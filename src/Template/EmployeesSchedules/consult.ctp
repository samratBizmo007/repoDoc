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
<style>
.select2-container--default .select2-selection--single, .select2-selection .select2-selection--single {
    border: 1px solid #d2d6de;
    border-radius: 0;
    height: 30px;
    padding: 5px 10px;
}
</style>
<?php echo $this->Html->css('Admin./plugins/cakephp-ajax-pagination/ajaxpagination') ?>
<?php echo $this->Html->css('Admin./plugins/bootstrap-switch/bootstrap-switch_min') ?>

<section class="content-header">
  <h1>
    <?php echo !empty($departmentName) ? 'Consult Schedules - '.$departmentName : 'Consult Schedules'; ?>
  </h1>
  <ol class="breadcrumb">
    <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i><?php echo __('Home'); ?></a></li>
    <li class="active"><?php echo __('Employees Schedules') ?></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="nav-tabs-custom">
      	<?php echo $this->element('Admin.schedule-tabs'); ?>
      	<div class="tab-content">
        	<div class="tab-pane active" id="settings">
                <div class="box-header">
                 <div class="box-title">
                 <?php if($roleId == 3 || $roleId == 5) { ?>
                    <?php echo $this->Html->link(__('<i class="fa fa-fw fa-file"></i> Upload CSV'),['controller' => 'EmployeesSchedules', 'action' => 'consult-import-csv'],['class' => 'btn btn-primary ajax-modal-popup', 'escape' => false]); ?>
                 	<?php echo $this->Html->link(__('Sample CSV'),['controller' => 'EmployeesSchedules', 'action' => 'download-consult-csv'],['class' => 'btn btn-primary', 'escape' => false]); ?>
                 <?php }?>
                 </div>
            	  <?php 
                    if(!empty($search) || !empty($department))
						echo $this->Html->link(__('<i class="fa fa-fw fa-refresh"></i> Reset'),['controller' => 'EmployeesSchedules', 'action' => 'consult'],['class' => 'btn btn-default', 'escape' => false]); 
                  ?>
                  <div class="box-tools search box-tools-csv" style="width: 510px;">
                    <?php //echo $this->Html->link(__('<i class="fa fa-fw fa-download"></i>'),['controller' => 'EmployeesSchedules', 'action' => 'exportLists'],['class' => 'csv-download btn btn-xs btn-info input-group pull-left btn-reset-link', 'title' => ' Export CSV', 'escape' => false]);?>
        
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
                <div class="box-body no-padding">
                    <table class="table table-hover table-vertical-align ajax-pagination">
                        <thead>
                            <tr>
                                <th class='th_photo'>Photo</th>
                                <th class='th_detail'>Detail</th>
                                <th>Schedule</th>
                                <th class='th_action'><?php echo __( 'Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($employeesSchedules->toArray())) { $j = 0; ?>
        
                              <?php foreach ($employeesSchedules as $employee): ?>
                                <tr role="row">
                                    <td>
                                        <?php 
                                            if(!empty($employee->employee->photo)){
                                                $photo_url = Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_URL').$employee->employee->photo;
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
                                        <?php echo h($employee->employee->email) ?>
                                        <br/>
                                        <?php echo h($employee->employee->full_name) ?>
                                         <br/>
                                        <?php echo h($employee->timezone) ?>
                                    </td>
                                    <td class="element">
                                    <table>
                                        <tbody>
                                        <tr class='input-min-width'>
                                        <?php if(!empty($employee->consult_schedule)) {?>
                                        <td>
                                        	<div class="input text form-control"><label>Department</label></div>
                                        	<div class="input text form-control"><label>Subdepartment</label></div>
                                        	<div class="input text form-control"><label>First Call</label></div>
                                        	<div class="input text form-control"><label>Attending</label></div>
                                        	<div class="input text form-control"><label>Time</label></div>
                                       		<div class="input text form-control"><label>Date</label></div>
                                       	</td>
                                       		<?php echo $this->Form->create(null, [
                                       		        'id'=>'edit-schedule-'.$j,
                                                    'url' => ['controller' => 'EmployeesSchedules', 'action' => 'editConsult', $employee->id]
                                                ]); ?>
                                            <?php 
                                            $i = 0;
                                            $schedules = json_decode($employee->consult_schedule, true);
                                            foreach ($schedules as $sched_key => $sched_val):
                                                unset($sched_val['service_team']);
                                                foreach ($sched_val as $s_key => $s_val):
                                                
                                                ?>
                                                	
                                                	<td>
                                                	    <?php 
                                                            echo $this->Form->input('department[]',[
                                                                'type' => 'text',
                                                                'class' => 'form-control required',
                                                                'label' => false,
                                                                'readonly' => true,
                                                                'value' => $s_val['department']
                                                            ]);
                                                        ?>
                                                        
                                                        <?php 
                                                            echo $this->Form->input('subdepartment[]',[
                                                                'type' => 'text',
                                                                'class' => 'form-control required',
                                                                'label' => false,
                                                                'readonly' => true,
                                                                'value' => $s_val['subdepartment']
                                                            ]);
                                                        ?>
                                                        
                                                        <?php 
                                                            echo $this->Form->input('is_first_call[]',[
                                                                'type' => 'text',
                                                                'class' => 'form-control required',
                                                                'label' => false,
                                                                'value' => $s_val['is_first_call']
                                                            ]);
                                                        ?>
                                                        
                                                        <?php 
                                                            echo $this->Form->input('is_attending[]',[
                                                                'type' => 'text',
                                                                'class' => 'form-control required',
                                                                'label' => false,
                                                                'value' => $s_val['is_attending']
                                                            ]);
                                                        ?>
                                                        
                                                        <?php 
                                                            echo $this->Form->input('time[]',[
                                                                'autocomplete' => 'false',
                                                                'class' => 'form-control required',
                                                                'label' => false,
                                                                'value' => $s_val['time']
                                                            ]);
                                                        ?>
                                                  
                                                        <?php 
                                                            echo $this->Form->input('date[]',[
                                                                'id' => 'date'.$i,
                                                                'autocomplete' => 'false',
                                                                'class' => 'form-control required',
                                                                'label' => false,
                                                                'value' => $sched_key
                                                            ]);
                                                        ?>
                                                    </td>
                                            <?php 
                                            $i++;
                                            	endforeach;
                                            endforeach; ?>
                                         <?php echo $this->Form->end(); ?>
                                         <?php }?>
                                        </tr>
                                        </tbody>
                                        </table>
                                    </td>
                                    <td class="actions">
                                    	<a href="javascript:void(0)" title="Save" onclick="saveSchedule(<?php echo $j; ?>)" class="btn btn-xs btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>
                                    	<?php echo $this->Html->link(__('<i class="fa fa-fw fa-eye"></i>'),['controller' => 'EmployeesSchedules', 'action' => 'consultView', $employee->id],['class' => 'btn btn-xs btn-info', 'escape' => false, 'title' => 'View']); ?>
                                      <?php echo $this->Html->link(__('<i class="fa fa-fw fa-trash"></i>'),'javascript:void(0);',['class' => 'btn btn-xs btn-danger','data-href' => $this->Url->build(['controller' => 'EmployeesSchedules', 'action' => 'delete', 'consult', $employee->id]),'data-target'=> '#confirm-delete','data-toggle' => 'modal','escape' => false]); 
                                      ?>
                                    </td>
                                    
                              </tr>
                              <?php $j++; endforeach; ?>
        
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
                <?php if(!empty($employeesSchedules->toArray())) { ?>
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
<?php echo $this->Html->script('Admin./plugins/select2/select2.full.min'); ?>

<script>
    $(function () {
        $(".select2").select2();
    });

    
    /* $(function () {
        $('.ajax-pagination').cakephpPagination({
            paginateDivId: "pagination-div"
        });
    }); */

    function changeDepartment(name) {
		var url = "<?php echo $this->Url->build(array('action' => 'index')) ?>";
		window.location.href = url + "/consult/" + name;				
    }
    
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

    function saveSchedule(id) {
    	$('#edit-schedule-'+id).submit();
    }

    $( ".sidebar-toggle" ).click(function() {
    	setTimeout( function(){ 
    		resiz_schedule()
    	  }  , 500 );
    });

    $(window).load(function () {
         resiz_schedule();
    });
    
    $(window).resize(function () {
    	resiz_schedule();
    });

    $('.content').resize(function () {
    	resiz_schedule();
    });

    function resiz_schedule() {
    	var element_width = $('.content').width() - ($('.th_photo').width() + $('.th_detail').width() + $('.th_action').width()) - 125;
    	$('.element').css('max-width', element_width);
	}    
</script>