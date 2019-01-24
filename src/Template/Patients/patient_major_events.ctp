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
  	<h3 class="box-title">Patient Major Events</h3>
  </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover table-vertical-align ajax-pagination layout-fixed">
            <thead>
                <tr>
                    <th>Doctor Name</th>
                    <th>Department</th>
                    <th>Content</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($patient['major_events'])) { ?>

                  <?php foreach ($patient['major_events'] as $patient): ?>
                    <tr role="row">
                        <td>
                            <?php echo h($patient->employee->full_name); ?>
                        </td>
                        <td>
                            <?php echo h($patient->employee->department); ?>
                        </td>
                        <td>
                        <?php if(!empty($patient->content) && file_exists(Configure::read('UPLOAD_MAJOR_EVENT_PATH').$patient->content)) {?>
                            <audio controls style=" width: 100px;">
                              <source src="<?php echo Configure::read('UPLOAD_MAJOR_EVENT_URL').$patient->content; ?>" type="audio/mpeg">
                              Your browser does not support the audio element.
                            </audio>
                        <?php } ?>
                        </td>
                        <td>
                            <?php echo h($patient->date) ?>
                        </td>
                        <td>
                            <?php echo h(date('H:i',strtotime($patient->time))); ?>
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