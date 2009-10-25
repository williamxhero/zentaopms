<?php
/**
 * The browse view file of product dept of ZenTaoMS.
 *
 * ZenTaoMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * ZenTaoMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public License
 * along with ZenTaoMS.  If not, see <http://www.gnu.org/licenses/>.  
 *
 * @copyright   Copyright: 2009 Chunsheng Wang
 * @author      Chunsheng Wang <wwccss@263.net>
 * @package     product
 * @version     $Id: browse.html.php 1366 2009-09-29 01:37:22Z wwccss $
 * @link        http://www.zentao.cn
 */
?>
<?php include '../../common/header.html.php';?>
<?php include '../../common/treeview.html.php';?>
<?php include '../../common/tablesorter.html.php';?>
<div class="yui-d0 yui-t3">                 
  <div class="yui-b">
    <table class='table-1'>
     <caption><?php echo $lang->dept->common;?></caption>
      <tr>
        <td>
          <div id='main'><?php echo $deptTree;?></div>
          <div class='a-right'>
            <?php if(common::hasPriv('dept', 'browse')) echo html::a($this->createLink('dept', 'browse'), $lang->dept->manage);?>
            <?php if(common::hasPriv('user', 'create')) echo html::a($this->createLink('user', 'create', "companyID={$this->app->company->id}&from=company"), $lang->user->create);?>
          </div>
        </td>
      </tr>
    </table>

    </div>
    <div class="yui-main">
    <div class="yui-b">
      <table align='center' class='table-1 tablesorter'>
        <caption>
          <?php
          echo html::a($this->createLink('company', 'browse'), $app->company->name) . $lang->arrow;
          foreach($parentDepts as $dept)
          {
              echo html::a($this->createLink('company', 'browse', "deptID=$dept->id"), $dept->name) . $lang->arrow;
          }
          echo $lang->dept->users;
          ?>
        </caption>
        <thead>
        <tr>
          <th><?php echo $lang->user->id;?></th>
          <th><?php echo $lang->user->realname;?></th>
          <th><?php echo $lang->user->account;?></th>
          <th><?php echo $lang->user->nickname;?></th>
          <th><?php echo $lang->user->email;?></th>
          <th><?php echo $lang->user->gendar;?></th>
          <th><?php echo $lang->user->phone;?></th>
          <th><?php echo $lang->user->join;?></th>
          <th><?php echo $lang->user->visits;?></th>
          <th><?php echo $lang->action;?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($users as $user):?>
        <tr>
          <td class='a-right'><?php echo $user->id;?></td>
          <td><?php echo $user->realname;?></td>
          <td><?php if(common::hasPriv('user', 'view')) echo html::a($this->createLink('user', 'view', "account=$user->account"), $user->account); else echo $user->account;?></td>
          <td><?php echo $user->nickname;?></td>
          <td><?php echo html::mailto($user->email);?></td>
          <td class='a-center'><?php if(isset($lang->user->gendarList->{$user->gendar})) echo $lang->user->gendarList->{$user->gendar};?></td>
          <td><?php echo $user->phone;?></td>
          <td class='a-center'><?php echo $user->join;?></td>
          <td><?php echo $user->visits;?></td>
          <td>
            <?php if(common::hasPriv('user', 'edit'))   echo html::a($this->createLink('user', 'edit',   "userID=$user->id&from=company"), $lang->user->edit);?>
            <?php if(common::hasPriv('user', 'delete')) echo html::a($this->createLink('user', 'delete', "userID=$user->id"), $lang->user->delete, "hiddenwin");?>
          </td>
        </tr>
        <?php endforeach;?>
        </tbody>
      </table>
      <div class='a-right'>
      <?php 
      ?>
      </div>
    </div>
  </div>
</div>  
<?php include '../../common/footer.html.php';?>
