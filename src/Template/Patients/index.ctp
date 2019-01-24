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
    <?php echo !empty($floorName) ? 'Patients - '.$floorName : 'Patients';  ?>
  </h1>
  <ol class="breadcrumb">
    <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i><?php echo __('Home'); ?></a></li>
    <li class="active"><?php echo __('Patients') ?></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header">
             <div class="box-title">
             <?php if($roleId == 3 || $roleId == 4) { ?>
                <?php echo $this->Html->link(__('<i class="fa fa-fw fa-plus"></i> Add patient'),['controller' => 'Patients', 'action' => 'add'],['class' => 'btn btn-primary', 'escape' => false]); ?>
                <?php echo $this->Html->link(__('<i class="fa fa-fw fa-file"></i> Upload CSV'),['controller' => 'Patients', 'action' => 'import-csv'],['class' => 'btn btn-primary ajax-modal-popup', 'escape' => false]); ?>
                <?php echo $this->Html->link(__('Sample CSV'),['controller' => 'Patients', 'action' => 'download-csv'],['class' => 'btn btn-primary', 'escape' => false]); ?>
             <?php }?>
             </div>
    	  <?php 
            if(!empty($search) || !empty($floor))
              echo $this->Html->link(__('<i class="fa fa-fw fa-refresh"></i> Reset'),['controller' => 'Patients', 'action' => 'index'],['class' => 'btn btn-default', 'escape' => false]); 
          ?>
          <div class="box-tools search box-tools-csv"  style="width: 550px;">
            <?php echo $this->Html->link(__('<i class="fa fa-fw fa-download"></i>'),['controller' => 'Patients', 'action' => 'exportLists'],['class' => 'csv-download btn btn-xs btn-info input-group pull-left btn-reset-link', 'title' => ' Export CSV', 'escape' => false]);?>

			<div class="input-group input-group-sm search" style="float: left;margin-right: 10px;">
     			<?php 
     			        echo $this->Form->input('floor',[
                            'id' => 'floor',
                            'type' => 'select',
                            'label' => false,
                            'value' => $floor,
                            'onChange' => 'changeDepartment(this.value)',
                            'options' => $floors,
     			            'empty' => 'Select Floor',
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
                        <th><?php echo $this->Paginator->sort('full_name','Name') ?></th>
                        <th><?php echo $this->Paginator->sort('floor','Floor Number') ?></th>
                        <th><?php echo $this->Paginator->sort('room','Bed Number') ?></th>
                        <th><?php echo $this->Paginator->sort('mrn','MRN') ?></th>
                        <th><?php echo $this->Paginator->sort('birthdate','Birth Date') ?></th>
                        <th><?php echo $this->Paginator->sort('admission_date','Admission Date') ?></th>
                        <th><?php echo __( 'Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($patients->toArray())) { ?>

                      <?php foreach ($patients as $patient): ?>
                        <tr role="row">
                            <td>
                                <?php
                                
                                    $photo_url = Configure::read('DEFAULT_PATIENT_IMAGE_URL');
                                    
                                    echo $this->Html->image($photo_url, [
                                        'class' => 'img img-circle',
                                        'width' => '50',
                                        'height' => '50',
                                        'alt' => $patient->full_name
                                    ]); 
                                ?>
                            </td>
                            <td>
                                <?php echo h($patient->full_name) ?>
                            </td>
                            <td>
                                <?php echo h($patient->floor->name) ?>
                            </td>
                            <td>
                                <?php echo (!empty($patient->room)  && !empty($patient->bed)) ?  $patient->room.'-'.$patient->bed : ( !empty($patient->room) ? $patient->room : (!empty($patient->bed) ? $patient->bed : '')); ?>
                            </td>
                            <td>
                                <?php echo $patient->mrn; ?>
                            </td>
                            <td>
                                <?php echo $patient->birthdate; ?>
                            </td>
                            <td>
                                <?php echo h($patient->admission_date) ?>
                            </td>
                            <td class="actions">
                                <?php echo $this->Html->link(__('<i class="fa fa-fw fa-eye"></i>'),['controller' => 'Patients', 'action' => 'view', $patient->id],['class' => 'btn btn-xs btn-info view-remote-modal ajax-modal-popup', 'escape' => false]); ?>
                                <?php if($roleId == 3 || $roleId == 4) { ?>
                                	<?php echo $this->Html->link(__('<i class="fa fa-fw fa-pencil"></i>'),['controller' => 'Patients', 'action' => 'edit', $patient->id],['class' => 'btn btn-xs btn-warning', 'escape' => false]); ?>
								<?php }?>
                                <?php echo $this->Html->link(__('<i class="fa fa-fw fa-trash"></i>'),'javascript:void(0);',['class' => 'btn btn-xs btn-danger','data-href' => $this->Url->build(['controller' => 'Patients', 'action' => 'delete', $patient->id]),'data-target'=> '#confirm-delete','data-toggle' => 'modal','escape' => false]); 
                                  ?>
                            </td>
                      </tr>
                      <?php endforeach; ?>

                      <?php } else { ?>
                      <tr>
                          <th colspan="7">
                            <div class="no-record">
                              <?php echo __(Configure::read('NO_RECORD_FOUND')) ?>
                            </div>
                          </th>
                      </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php if(!empty($patients->toArray())) { ?>
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
        var url = "<?php echo $this->Url->build(['controller' => 'Patients','action' => 'changeStatus']); ?>";
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