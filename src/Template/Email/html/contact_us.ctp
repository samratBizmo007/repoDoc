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


<table width="100%" bgcolor="#e5e5e1" cellspacing="0" cellpadding="0">
    <tbody>
       <tr>
          <td valign="bottom">
             <table style="background-color:#fff; padding:10px; border:solid 1px #cccccc;"  width="672" align="center" cellspacing="0" cellpadding="0">
                <tbody>
                   <tr>
                      <td height="78" align="left" style="background-color:#ffffff; border:none">
                         <table width="651" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                               <td align="center" valign="middle"><img src="<?php echo Configure::read('EMAIL_LOGO'); ?>" width="100" height="100" /></td>
                            </tr>
                         </table>
                      </td>
                   </tr>
                   <tr valign="top">
                      <td style="padding-top:20px;" height="218" align="center">
                         <table width="630" border="0" align="center" cellpadding="5px" cellspacing="0">
                            <tr align="left">
                               <td width="212" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#000;">Hi,</td>
                            </tr>
                            <tr>
                               <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#000; line-height:24px; word-spacing:1px;"> 
                               <?php echo $data['name']." " ?> wants to contact us.
                               </td>
                            </tr>
                            <tr>
                               <td height="20" valign="bottom" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#000; line-height:24px; word-spacing:1px; margin-top:10px;">
                                  Details:
                               </td>
                            </tr>
                            <tr>
                               <td height="20" valign="bottom" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#000; line-height:24px; word-spacing:1px; margin-top:10px;">
                                  <strong>Name : </strong> <?php echo $data['name'] ?>
                               </td>
                            </tr>
                            <tr>
                               <td height="20" valign="bottom" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#000; line-height:24px; word-spacing:1px; margin-top:10px;">
                                  <strong>Email : </strong> <?php echo $data['email'] ?>
                               </td>
                            </tr>
                            <tr>
                               <!-- <td height="20" valign="bottom" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#000; line-height:24px; word-spacing:1px; margin-top:10px;">
                                  <strong>Subject : </strong> <?php //echo $data['subject'] ?>
                               </td>-->
                            </tr>                            <tr>
                               <td height="20" valign="bottom" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#000; line-height:24px; word-spacing:1px; margin-top:10px;">
                                  <strong>Message : </strong> <?php echo $data['message'] ?>
                               </td>
                            </tr>
                         </table>
                      </td>
                   </tr>
                </tbody>
             </table>
          </td>
       </tr>
    </tbody>
</table>