<?php
/**
 * The prjbrowse view file of program module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     program
 * @version     $Id: prjbrowse.html.php 4769 2013-05-05 07:24:21Z wwccss $
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.html.php';?>
<?php
js::set('orderBy', $orderBy);
js::set('programID', $programID);
js::set('browseType', $browseType);
?>
<div id="mainMenu" class="clearfix">
  <div id="sidebarHeader">
    <div class="title">
      <?php echo empty($program) ? $lang->program->PGMCommon : $program->name;?>
      <?php if($programID) echo html::a(inLink('PRJBrowse', 'programID=0'), "<i class='icon icon-sm icon-close'></i>", '', 'class="text-muted"');?>
    </div>
  </div>
  <div class="btn-toolBar pull-left">
    <?php foreach($lang->program->featureBar as $key => $label):?>
    <?php $active = $browseType == $key ? 'btn-active-text' : '';?>
    <?php $label = "<span class='text'>$label</span>";?>
    <?php if($browseType == $key) $label .= " <span class='label label-light label-badge'>{$pager->recTotal}</span>";?>
    <?php echo html::a(inlink('PRJBrowse', "programID=$programID&browseType=$key"), $label, '', "class='btn btn-link $active'");?>
    <?php endforeach;?>
    <?php echo html::checkbox('PRJMine', array('1' => $lang->program->mine), '', $this->cookie->PRJMine ? 'checked=checked' : '');?>
  </div>
  <div class="btn-toolbar pull-right">
    <?php common::printLink('program', 'createGuide', "programID=$programID", '<i class="icon icon-plus"></i>' . $lang->program->PRJCreate, '', 'class="btn btn-primary" data-toggle="modal" data-target="#guideDialog"');?>
  </div>
</div>
<div id='mainContent' class="main-row fade">
  <div id="sidebar" class="side-col">
    <div class="sidebar-toggle"><i class="icon icon-angle-left"></i></div>
    <div class="cell">
      <?php echo $PRJTree;?>
      <div class="text-center">
        <?php common::printLink('program', 'PRJProgramTitle', '', $lang->program->PRJModuleSetting, '', "class='btn btn-info btn-wide iframe'", true, true);?>
      </div>
    </div>
  </div>
  <div class="main-col">
    <?php if(empty($projectStats)):?>
    <div class="table-empty-tip">
      <p>
        <span class="text-muted"><?php echo $lang->program->noPRJ;?></span>
        <?php common::printLink('program', 'createGuide', "programID=$programID", '<i class="icon icon-plus"></i>' . $lang->program->PRJCreate, '', 'class="btn btn-info btn-wide " data-toggle="modal" data-target="#guideDialog"');?>
      </p>
    </div>
    <?php else:?>
    <form class='main-table' id='PRJForm' method='post'>
      <div class="table-header fixed-right">
        <nav class="btn-toolbar pull-right"></nav>
      </div>
      <?php
        include '../../common/view/datatable.html.php';
        $vars    = "programID=$programID&browseType=$browseType&param=$param&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}";
        $setting = $this->datatable->getSetting('program');
        $widths  = $this->datatable->setFixedFieldWidth($setting);
      ?>
      <table class='table has-sort-head datatable' data-fixed-left-width='<?php echo $widths['leftWidth'];?>' data-fixed-right-width='<?php echo $widths['rightWidth'];?>'>
        <thead>
          <tr>
            <?php
              foreach($setting as $value)
              {
                if($value->show)
                {
                  $this->datatable->printHead($value, $orderBy, $vars);
                }
              }
            ?>
          </tr>
        </thead>
        <tbody class="sortable" id='projectTableList'>
          <?php foreach($projectStats as $project):?>
          <tr data-id="<?php echo $project->id;?>">
            <?php foreach($setting as $value) $this->program->printCell($value, $project, $users, $programID);?>
          </tr>
          <?php endforeach;?>
        </tbody>
      </table>
      <?php if($projectStats):?>
      <div class='table-footer'>
        <?php $pager->show('right', 'pagerjs');?>
      </div>
      <?php endif;?>
    </form>
    <?php endif;?>
  </div>
</div>
<?php include '../../common/view/footer.html.php';?>
