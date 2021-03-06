<?php
/**
 * The create view of project module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     project
 * @version     $Id: create.html.php 4728 2013-05-03 06:14:34Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php if(isset($tips)):?>
<?php $defaultURL = $this-> createLink('project', 'task', 'projectID=' . $projectID);?>
<?php include '../../common/view/header.lite.html.php';?>
<body>
  <div class='modal-dialog mw-500px' id='tipsModal'>
    <div class='modal-header'>
      <a href='<?php echo $defaultURL;?>' class='close'><i class="icon icon-close"></i></a>
      <h4 class='modal-title' id='myModalLabel'><?php echo $lang->project->tips;?></h4>
    </div>
    <div class='modal-body'>
    <?php echo $tips;?>
    </div>
  </div>
</body>
</html>
<?php exit;?>
<?php endif;?>

<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php js::import($jsRoot . 'misc/date.js');?>
<?php js::set('weekend', $config->project->weekend);?>
<?php js::set('holders', $lang->project->placeholder);?>
<?php js::set('errorSameProducts', $lang->project->errorSameProducts);?>
<div id='mainContent' class='main-content'>
  <div class='center-block'>
    <div class='main-header'>
      <h2><?php echo $lang->program->PGMCreate;?></h2>
    </div>
    <form class='form-indicator main-form form-ajax' method='post' target='hiddenwin' id='dataform'>
      <table class='table table-form'>
        <tr>
          <th><?php echo $lang->program->PGMParent;?></th>
          <td><?php echo html::select('parent', $parents, isset($parentProgram->id) ? $parentProgram->id : '', "class='form-control chosen' onchange=setAclList(this.value)");?>
          <td></td>
        </tr>
        <tr>
          <th class='w-120px'><?php echo $lang->program->PGMName;?></th>
          <td class="col-main"><?php echo html::input('name', '', "class='form-control' required");?></td>
          <td></td>
        </tr>
        <tr>
          <th><?php echo $lang->program->PGMCode;?></th>
          <td><?php echo html::input('code', '', "class='form-control' required");?></td><td></td><td></td>
        </tr>
        <tr>
          <th><?php echo $lang->program->PGMPM;?></th>
          <td><?php echo html::select('PM', $pmUsers, '', "class='form-control chosen'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->program->PO;?></th>
          <td><?php echo html::select('PO', $poUsers, '', "class='form-control chosen'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->program->PGMBudget;?></th>
          <td>
            <div class='input-group'>
              <?php echo html::input('budget', '', "class='form-control'");?>
              <span class='input-group-addon'></span>
              <?php echo html::select('budgetUnit', $lang->program->unitList, empty($parentProgram->budgetUnit) ? 'yuan' : $parentProgram->budgetUnit, "class='form-control'");?>
            </div>
          </td>
          <td class='muted'><?php if($parentProgram) printf($lang->program->parentBudget, $parentProgram->budget . zget($lang->program->unitList, $parentProgram->budgetUnit, ''));?></td>
        </tr>
        <tr>
          <th><?php echo $lang->program->dateRange;?></th>
          <td>
            <div class='input-group'>
              <?php echo html::input('begin', date('Y-m-d'), "class='form-control form-date' placeholder='" . $lang->program->begin . "' required");?>
              <span class='input-group-addon'><?php echo $lang->program->to;?></span>
              <?php echo html::input('end', '', "class='form-control form-date' placeholder='" . $lang->program->end . "' required");?>
            </div>
          </td>
        </tr>
        <tr class='hide'>
          <th><?php echo $lang->project->status;?></th>
          <td><?php echo html::hidden('status', 'wait');?></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <?php $this->printExtendFields('', 'table');?>
        <tr>
          <th><?php echo $lang->program->PGMDesc;?></th>
          <td colspan='3'>
            <?php echo $this->fetch('user', 'ajaxPrintTemplates', 'type=project&link=desc');?>
            <?php echo html::textarea('desc', '', "rows='6' class='form-control kindeditor' hidefocus='true'");?>
          </td>
        </tr>
        <tr>
          <th><?php echo $lang->project->acl;?></th>
          <td colspan='3' class='aclBox'><?php echo nl2br(html::radio('acl', $lang->program->PGMAclList, 'open', '', 'block'));?></td>
        </tr>
        <tr id='whitelistBox' class='hidden'>
          <th><?php echo $lang->project->whitelist;?></th>
          <td colspan='3'><?php echo html::checkbox('whitelist', $groups, $whitelist, '', '', 'inline');?></td>
        </tr>
        <tr>
          <td colspan='4' class='text-center form-actions'>
            <?php echo html::submitButton();?>
            <?php echo html::backButton();?>
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>
<div class='modal fade modal-scroll-inside' id='copyProjectModal'>
  <div class='modal-dialog mw-900px'>
    <div class='modal-header'>
      <button type='button' class='close' data-dismiss='modal'><i class="icon icon-close"></i></button>
      <h4 class='modal-title' id='myModalLabel'><?php echo $lang->project->copyTitle;?></h4>
    </div>
    <div class='modal-body'>
      <?php if(count($programs) == 1):?>
      <div class='alert with-icon'>
        <i class='icon-exclamation-sign'></i>
        <div class='content'><?php echo $lang->project->copyNoProject;?></div>
      </div>
      <?php else:?>
      <div id='copyProjects' class='row'>
      <?php foreach ($programs as $id => $name):?>
      <?php if(empty($id)):?>
      <?php if($copyProgramID != 0):?>
      <div class='col-md-4 col-sm-6'><a href='javascript:;' data-id='' class='cancel'><?php echo html::icon($lang->icons['cancel']) . ' ' . $lang->project->cancelCopy;?></a></div>
      <?php endif;?>
      <?php else: ?>
      <div class='col-md-4 col-sm-6'><a href='javascript:;' data-id='<?php echo $id;?>' class='nobr <?php echo ($copyProgramID == $id) ? ' active' : '';?>'><?php echo html::icon($lang->icons['project'], 'text-muted') . ' ' . $name;?></a></div>
      <?php endif; ?>
      <?php endforeach;?>
      </div>
      <?php endif;?>
    </div>
  </div>
</div>
<div id='PGMAcl' class='hidden'>
  <?php echo nl2br(html::radio('acl', $lang->program->PGMAclList, 'open', '', 'block'));?>
</div>
<div id='subPGMAcl' class='hidden'>
  <?php echo nl2br(html::radio('acl', $lang->program->subPGMAclList, 'open', '', 'block'));?>
</div>
<?php js::set('parentProgramID', isset($parentProgram->id) ? $parentProgram->id : 0);?>
<?php include '../../common/view/footer.html.php';?>
