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
    <?php echo __('Service Teams') ?>
  </h1>
  <ol class="breadcrumb">
    <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i><?php echo __('Home'); ?></a></li>
    <li class="active"><?php echo __('Service Teams') ?></li>
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
            <?php if($roleId == 3 || $roleId == 4) { ?>
            	<?php echo $this->Html->link(__('<i class="fa fa-fw fa-plus"></i> Add New'),['controller' => 'ServiceTeams', 'action' => 'add'],['class' => 'btn btn-primary ajax-modal-popup', 'escape' => false]); ?>
          		<?php echo $this->Html->link(__('<i class="fa fa-fw fa-file"></i> Upload CSV'),['controller' => 'ServiceTeams', 'action' => 'import-csv'],['class' => 'btn btn-primary ajax-modal-popup', 'escape' => false]); ?>
          		<?php echo $this->Html->link(__('Sample CSV'),['controller' => 'ServiceTeams', 'action' => 'download-csv'],['class' => 'btn btn-primary', 'escape' => false]); ?>
         	<?php }?>
         </div>
    	  <?php 
            if(!empty($search))
              echo $this->Html->link(__('<i class="fa fa-fw fa-refresh"></i> Reset'),['controller' => 'ServiceTeams', 'action' => 'index'],['class' => 'btn btn-default', 'escape' => false]); 
          ?>
          <div class="box-tools search box-tools-csv">
            <?php echo $this->Html->link(__('<i class="fa fa-fw fa-download"></i>'),['controller' => 'ServiceTeams', 'action' => 'exportLists'],['class' => 'csv-download btn btn-xs btn-info input-group pull-left btn-reset-link', 'title' => ' Export CSV', 'escape' => false]); ?>

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
                        <th><?php echo $this->Paginator->sort('name', 'Hospital Name') ?></th>
                        <th><?php echo $this->Paginator->sort('name', 'Service Team Name') ?></th>
                        <th><?php echo __( 'Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($serviceTeams->toArray())) { ?>

                      <?php foreach ($serviceTeams as $serviceTeam): ?>
                      <tr role="row">
                          <td>
                              <?php echo h($serviceTeam->hospital->name) ?>
                          </td>
                          <td>
                              <?php echo h($serviceTeam->name) ?>
                          </td>
                          <td class="actions">
                              <?php echo $this->Html->link(__('<i class="fa fa-fw fa-pencil"></i>'),['controller' => 'ServiceTeams', 'action' => 'edit', $serviceTeam->id],['class' => 'btn btn-xs btn-warning ajax-modal-popup', 'escape' => false]); ?>

                              <?php echo $this->Html->link(__('<i class="fa fa-fw fa-trash"></i>'),'javascript:void(0);',['class' => 'btn btn-xs btn-danger','data-href' => $this->Url->build(['controller' => 'ServiceTeams', 'action' => 'delete', $serviceTeam->id]),'data-target'=> '#confirm-delete','data-toggle' => 'modal','escape' => false]); 
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
        <?php if(!empty($serviceTeams->toArray())) { ?>
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
        paginateDivId: "pagination-div"
    });
  });
</script>