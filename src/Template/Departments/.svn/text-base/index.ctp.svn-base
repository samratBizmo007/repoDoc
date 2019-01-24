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

$consultDepartment = !empty($this->request->getParam('pass')) ? $this->request->getParam('pass')[0] : 1;

?>

<?php echo $this->Html->css('Admin./plugins/cakephp-ajax-pagination/ajaxpagination') ?>
<?php echo $this->Html->css('Admin./plugins/bootstrap-switch/bootstrap-switch_min') ?>

<section class="content-header">
  <h1>
    <?php echo __('Departments') ?>
  </h1>
  <ol class="breadcrumb">
    <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i><?php echo __('Home'); ?></a></li>
    <li class="active"><?php echo __('Departments') ?></li>
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
                        <?php echo $this->Html->link(__('<i class="fa fa-fw fa-plus"></i> Add New'),['controller' => 'Departments', 'action' => 'add'],['class' => 'btn btn-primary ajax-modal-popup', 'escape' => false]); ?>
                        <?php echo $this->Html->link(__('<i class="fa fa-fw fa-file"></i> Upload CSV'),['controller' => 'Departments', 'action' => 'import-csv'],['class' => 'btn btn-primary ajax-modal-popup', 'escape' => false]); ?>
                        <?php echo $this->Html->link(__('Sample CSV'),['controller' => 'Departments', 'action' => 'download-csv'],['class' => 'btn btn-primary', 'escape' => false]); ?>
                     </div>
                
                      <?php 
                        if(!empty($search))
                          echo $this->Html->link(__('<i class="fa fa-fw fa-refresh"></i> Reset'),['controller' => 'Departments', 'action' => 'index'],['class' => 'btn btn-default', 'escape' => false]); 
                      ?>
                      <div class="box-tools search box-tools-csv">
                        <?php echo $this->Html->link(__('<i class="fa fa-fw fa-download"></i>'),['controller' => 'Departments', 'action' => 'exportLists'],['class' => 'csv-download btn btn-xs btn-info input-group pull-left btn-reset-link', 'title' => ' Export CSV', 'escape' => false]);?>

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
                      <li class='<?php if($consultDepartment == 1) { echo "active" ; } ?>'>
                          <a style="color: #555;"  href="<?php echo $this->Url->build(['controller' => 'Departments','action' => 'index', 1]); ?>" aria-expanded="false">
                              Consult Departments
                          </a>
                      </li class='<?php if($consultDepartment == 0) { echo "active" ; } ?>'>
                      <li>
                          <a style="color: #555;" href="<?php echo $this->Url->build(['controller' => 'Departments','action' => 'index', 0]); ?>" aria-expanded="false">
                              Non Consult Departments
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
                                    <!--<th><?php //echo $this->Paginator->sort('Hospitals.name', 'Hospital Name') ?></th>-->
                                    <th><?php echo __( 'Actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($departments->toArray())) { ?>

                                  <?php foreach ($departments as $department): ?>
                                  <tr role="row">
                                      <td>
                                          <?php echo h($department->name) ?>
                                      </td>
                                      <td>
                                          <?php echo h($department->short_name) ?>
                                      </td>
                                      <!-- <td>
                                          <?php //echo h($department->hospital->name) ?>
                                      </td> -->
                                      <td class="actions">
                                          <?php echo $this->Html->link(__('<i class="fa fa-fw fa-pencil"></i>'),['controller' => 'Departments', 'action' => 'edit', $department->id],['class' => 'btn btn-xs btn-warning ajax-modal-popup', 'escape' => false]); ?>

                                          <?php echo $this->Html->link(__('<i class="fa fa-fw fa-trash"></i>'),'javascript:void(0);',['class' => 'btn btn-xs btn-danger','data-href' => $this->Url->build(['controller' => 'Departments', 'action' => 'delete', $department->id]),'data-target'=> '#confirm-delete','data-toggle' => 'modal','escape' => false]); 
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
                    <?php if(!empty($departments->toArray())) { ?>
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
  
    </div>
  </div>
  <!-- /.row -->
</section>


<?php echo $this->Html->script('Admin./plugins/cakephp-ajax-pagination/ajaxpaginate.min')?>
<?php echo $this->Html->script('Admin./plugins/bootstrap-switch/bootstrap-switch_min')?>

<script>
  $(function () {
    $('.ajax-pagination').cakephpPagination({
        paginateDivId: "pagination-div"
    });
  });
</script>

