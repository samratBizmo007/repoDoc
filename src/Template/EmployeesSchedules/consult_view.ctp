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

<?php echo $this->Html->css("Admin./plugins/daterangepicker/daterangepicker-bs3.css"); ?>
<?php echo $this->Html->css("Admin./plugins/datepicker/datepicker3.css"); ?>
<?php echo $this->Html->css('Admin./plugins/cakephp-ajax-pagination/ajaxpagination')?>
<?php echo $this->Html->css('Admin./plugins/bootstrap-switch/bootstrap-switch_min')?>

<section class="content-header">
	<h1>
    <?php echo __('Consult Schedules Detail')?>
  </h1>
	<ol class="breadcrumb">
		<li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i><?php echo __('Home'); ?></a></li>
		<li><a href="javascript:void(0);"><?php echo $this->Html->link(__('Consult Schedules'),['controller' => 'EmployeesSchedules', 'action' => 'consult']); ?></a></li>
		<li class="active"><?php echo __('Consult Schedules Detail') ?></li>
	</ol>
</section>

<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<div class="box-header">
					<div class="box-title">
         <?php echo __('Consult Detail')?>
         </div>
				</div>
				<!-- /.box-header -->
				<div class="box-body table-responsive no-padding">
					<table
						class="table table-hover table-vertical-align ajax-pagination layout-fixed">
						<thead>
							<tr>
								<th>Photo</th>
								<th>Name</th>
								<th>Email</th>
								<th>Consult Role</th>
								<th>Designation</th>
								<th>Department</th>
								<th>View Detail</th>
							</tr>
						</thead>
						<tbody>
                    <?php if(!empty($employee)) { ?>
                        <tr role="row">
								<td>
                                <?php
                        if (! empty($employee->employee->photo)) {
                            $photo_url = Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_URL') . $employee->employee->photo;
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
                                <?php echo h($employee->employee->full_name)?>
                            </td>
							<td>
                                <?php echo h($employee->employee->email)?>
                            </td>
							<td>
                                <?php echo h($employee->employee->employee_role)?>
                            </td>
							<td>
                                <?php echo h($employee->employee->designation)?>
                            </td>
                            <td>
                                <?php echo h($employee->employee->department)?>
                            </td>
							<td>
                               <?php echo $this->Html->link(__('<i class="fa fa-fw fa-eye"></i>'),['controller' => 'Employees', 'action' => 'view', $employee->employee_id],['class' => 'btn btn-xs btn-info view-remote-modal ajax-modal-popup', 'escape' => false]); ?>
                            </td>
							</tr>
                     <?php } ?>
                </tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- /.box-body -->
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<div class="box-title">Schedules Detail</div>
    
          <?php
        if (! empty($search))
            echo $this->Html->link(__('<i class="fa fa-fw fa-refresh"></i> Reset'), [
                'controller' => 'EmployeesSchedules',
                'action' => 'consult-view',
                $employee->id
            ], [
                'class' => 'btn btn-default',
                'escape' => false
            ]);
        ?>
          <div class="box-tools search box-tools-csv">
            <?php echo $this->Form->create('',['type' => 'get']); ?>
            <div class="input-group input-group-sm search">
              <?php
            echo $this->Form->input('search', [
                'id' => 'search',
                'type' => 'text',
                'class' => 'form-control pull-right',
                'placeholder' => 'Search',
                'required' => true,
                'label' => false,
                'value' => $search,
                'templates' => [
                    'inputContainer' => '{{content}}'
                ]
            ]);
            ?>
              <div class="input-group-btn">
                <?php
                echo $this->Form->button(__('<i class="fa fa-search"></i>'), [
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
					<table
						class="table table-hover table-vertical-align ajax-pagination layout-fixed">
						<thead>
							<tr>
								<th>Date</th>
								<th>Time</th>
								<th>Department</th>
								<th>Subdepartment</th>
								<th>First Call</th>
								<th>Attending</th>
								
							</tr>
						</thead>
						<tbody>
                    <?php if(!empty($schedules)) { ?>

                      <?php foreach ($schedules as $sched_key => $sched_val): ?>
                        <?php
                        
                            $i = 0;
                            foreach ($sched_val as $key => $val) :
                                ?>
                            <tr role="row">
                            <?php if($i == 0) {?>
                                <td
									rowspan="<?php echo count($sched_val); ?>">
                                    <?php echo h($sched_key)?>
                                </td>
                             <?php }?>   
                                <td>
                                    <?php echo h($val['time'])?>
                                </td>
								<td>
                                    <?php echo h($val['department'])?>
                                </td>
                                <td>
                                    <?php echo h($val['subdepartment'])?>
                                </td>
                                <td>
                                    <?php echo $val['is_first_call'] == 1 ? 'Yes' : '-'; ?>
                                </td>
                                <td>
                                    <?php echo $val['is_attending'] == 1 ? 'Yes' : '-'; ?>
                                </td>
                                
							</tr>      
                      <?php
                                $i ++;
                            endforeach
                            ;
                            ?> 
                      <?php endforeach; ?>

                      <?php } else { ?>
                      <tr>
								<th colspan="6">
									<div class="no-record">
                              <?php echo __(Configure::read('NO_RECORD_FOUND'))?>
                            </div>
								</th>
							</tr>
                    <?php } ?>
                </tbody>
					</table>
				</div>
        <div class="box-footer clearfix">
        <?php if(!empty($schedules) && $total_pages > 1 ) { ?>
					<ul class="pagination pagination-sm no-margin pull-right">
						<?php if($current_page == 1) { ?>
							<li class="prev disabled"><a href="" onclick="return false;">&lsaquo;</span></a></li>
						<?php } else { ?> 
						<li><a href="?page=1">&laquo;</span></a></li>
						<li><a href="?page=<?php echo $current_page-1; ?>">&lsaquo;</span></a></li>
						<?php }?>	
               <?php
                if($total_pages == $current_page) {
                    $start = $current_page - 2 > 0 ? $current_page - 2 : 1;
                    $end = min($current_page + 1, $total_pages);
                } elseif($current_page == 1) {
                    $start = $current_page;
                    $end = min($current_page + 2, $total_pages);
                } else {
                    $start = $current_page -1;
                    $end = min($current_page + 1, $total_pages);
                }
                
                for ($i = $start; $i <= $end; $i ++) {
                
                    if ($i == $current_page) {
                        echo '<li class="active"><a href="#">';
                        echo $i . '</a></li>' . "\n";
                    } else {
                        echo ' <li><a href="?page=' . $i . '">';
                        echo $i . '</a></li>' . "\n";
                    }
                }
            ?> 
            <?php if($total_pages == $current_page) { ?>
				<li class="prev disabled"><a href="" onclick="return false;">&rsaquo;</span></a></li>
			<?php } else { ?> 
			<li><a href="?page=<?php echo $current_page+1; ?>">&rsaquo;</span></a></li>
			<li><a href="?page=<?php echo $total_pages; ?>">&raquo;</span></a></li>
			<?php }?>
					</ul>
				</div>
        <?php } else { ?>
        	<ul id="pagination-div" class="pagination pagination-sm no-margin pull-right">
            	<li class="prev disabled"><a href="" onclick="return false;">&lsaquo;</a></li>
				<li class="next disabled"><a href="" onclick="return false;">&rsaquo;</a></li>
			</ul>
        <?php }?>
       </div>
			<!-- /.box -->
		</div>
	</div>
	<!-- /.row -->
</section>

<?php echo $this->Html->script("//cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"); ?>
<?php echo $this->Html->script('Admin./plugins/cakephp-ajax-pagination/ajaxpaginate.min')?>
<?php echo $this->Html->script('Admin./plugins/bootstrap-switch/bootstrap-switch_min')?>
<?php echo $this->Html->script("Admin./plugins/daterangepicker/daterangepicker.js"); ?>
<?php echo $this->Html->script("Admin./plugins/datepicker/bootstrap-datepicker.js"); ?>

<script>
    $(function () {
        $('.ajax-pagination').cakephpPagination({
            paginateDivId: "pagination-div"
        });
    });

    $(document).ready(function () {
        //Date range picker
        $('#search').daterangepicker();
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
</script>