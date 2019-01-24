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

<div class="modal-dialog modal-lg">
  <div class="box box-primary">
  <div class="box-header with-border">
  	<h3 class="box-title">Patient Care Team</h3>
  </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover table-vertical-align ajax-pagination layout-fixed">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Department</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($hospitalEmployeeData)) { ?>

                  <?php foreach ($hospitalEmployeeData as $patient): ?>
                    <tr role="row">
                        <td><?php  echo $this->Html->image($patient['photo'], [
                                        'class' => 'img img-circle',
                                        'width' => '50',
                                        'height' => '50',
                                        'alt' => $patient['name']
                                    ]); 
                            ?>
                        </td>
                        <td>
                            <?php echo h($patient['name']); ?>
                        </td>
                        <td>
                            <?php echo h($patient['designation']) ?>
                        </td>
                        <td>
                            <?php echo h($patient['department']); ?>
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
    <!-- /.box-body -->

  </div>
  <!-- /.box -->
</div>