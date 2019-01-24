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
?>

<?php echo $this->Html->css('Admin./plugins/cakephp-ajax-pagination/ajaxpagination') ?>
<section class="content-header">
  <h1>
    <?php echo __('History') ?>
  </h1>
  <ol class="breadcrumb">
    <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i><?php echo __('Home'); ?></a></li>
    <li class="active"><?php echo __('History') ?></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header">
             <div class="box-title">
             </div>
    	  <?php 
            if(!empty($search))
              echo $this->Html->link(__('<i class="fa fa-fw fa-refresh"></i> Reset'),['controller' => 'PatientHistories', 'action' => 'index'],['class' => 'btn btn-default', 'escape' => false]); 
          ?>
          <div class="box-tools search box-tools-csv">
            <?php echo $this->Html->link(__('<i class="fa fa-fw fa-download"></i>'),['controller' => 'PatientHistories', 'action' => 'exportLists'],['class' => 'csv-download btn btn-xs btn-info input-group pull-left btn-reset-link', 'title' => ' Export CSV', 'escape' => false]);?>
                  
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
                        <th><?php echo $this->Paginator->sort('patient_name','Patient Name') ?></th>
                        <th><?php echo $this->Paginator->sort('Users.firstname','User Name') ?></th>
                        <th><?php echo $this->Paginator->sort('Users.role_id','User Role') ?></th>
                        <th><?php echo $this->Paginator->sort('Hospitals.name','Hospital') ?></th>
                        <th><?php echo $this->Paginator->sort('created','Date') ?></th>
                        <th><?php echo __( 'Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($patientHistories->toArray())) { ?>

                      <?php foreach ($patientHistories as $patientHistory): ?>
                        <tr role="row">
                            <td>
                                <?php echo h($patientHistory->patient_name) ?>
                            </td>
                            <td>
                                <?php echo h($patientHistory->user->full_name) ?>
                            </td>
                            <td>
                                <?php echo $patientHistory->user->role->name; ?>
                            </td>
                            <td>
                                <?php echo $patientHistory->hospital->name; ?>
                            </td>
                            <td>
                                <?php echo h($patientHistory->created) ?>
                            </td>
                            <td><?php echo h($patientHistory->action) ?></td>
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
        <?php if(!empty($patientHistories->toArray())) { ?>
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
<?php echo $this->Html->script('Admin./plugins/bootstrap-switch/bootstrap-switch_min')?>
<?php echo $this->Html->script('Admin./plugins/select2/select2.full.min'); ?>

<script>
$(function () {
    $('.ajax-pagination').cakephpPagination({
    	paginateDivId: "pagination-div",
    	afterSuccess: function () {
        }
    });
});
</script>