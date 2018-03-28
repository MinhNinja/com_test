<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_test
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('behavior.multiselect');


$purchaseTypes = array(
		'1' => 'UNLIMITED',
		'2' => 'YEARLY',
		'3' => 'MONTHLY',
		'4' => 'WEEKLY',
		'5' => 'DAILY',
);

$user       = JFactory::getUser();
$userId     = $user->get('id');
$listOrder  = $this->escape($this->state->get('list.ordering'));
$listDirn   = $this->escape($this->state->get('list.direction'));
$params     = $this->state->params ?? new JObject;
?>
<form action="<?php echo JRoute::_('index.php?option=com_test&view=profiles'); ?>" method="post" name="adminForm" id="adminForm">
	<div class="row">
		<div id="j-sidebar-container" class="col-md-2">
			<?php echo $this->sidebar; ?>
		</div>
		<div class="col-md-10">
			<div id="j-main-container" class="j-main-container">
				<?php
				// Search tools bar
				echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));
				?>
				<?php if (empty($this->items)) : ?>
					<div class="alert alert-warning alert-no-items">
						<?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
					</div>
				<?php else : ?>
					<table class="table table-striped">
						<thead>
							<tr>
								<th style="width:1%" class="text-center">
									<?php echo JHtml::_('grid.checkall'); ?>
								</th>
								<th style="width:1%" class="nowrap text-center">
									<?php echo JHtml::_('searchtools.sort', 'JSTATUS', 'a.state', $listDirn, $listOrder); ?>
								</th>
								<th>
									<?php echo JHtml::_('searchtools.sort', 'COM_TEST_HEADING_NAME', 'u.name', $listDirn, $listOrder); ?>
								</th>
								<th style="width:3%" class="nowrap hidden-sm-down text-center">
									<?php echo JHtml::_('searchtools.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
								</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<td colspan="4">
									<?php echo $this->pagination->getListFooter(); ?>
								</td>
							</tr>
						</tfoot>
						<tbody>
							<?php foreach ($this->items as $i => $item) :
								$canCreate  = $user->authorise('core.create',     'com_test');
								$canEdit    = $user->authorise('core.edit',       'com_test');
								$canCheckin = $user->authorise('core.manage',     'com_checkin') || $item->checked_out == $user->get('id') || $item->checked_out == 0;
								$canChange  = $user->authorise('core.edit.state', 'com_test') && $canCheckin;
								?>
								<tr class="row<?php echo $i % 2; ?>">
									<td class="text-center">
										<?php echo JHtml::_('grid.id', $i, $item->id); ?>
									</td>
									<td class="text-center">
										<div class="btn-group">
											<?php echo JHtml::_('jgrid.published', $item->state, $i, 'profiles.', $canChange); ?>
										</div>
									</td>
									<td class="nowrap has-context">
										<div>
											<?php if ($item->checked_out) : ?>
												<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'profiles.', $canCheckin); ?>
											<?php endif; ?>
											<?php if ($canEdit) : ?>
												<?php $editIcon = $item->checked_out ? '' : '<span class="fa fa-pencil-square mr-2" aria-hidden="true"></span>'; ?>
												<a class="hasTooltip" href="<?php echo JRoute::_('index.php?option=com_test&task=profile.edit&id=' . (int) $item->id); ?>" title="<?php echo JText::_('JACTION_EDIT'); ?> <?php echo $this->escape(addslashes($item->name)); ?>">
													<?php echo $editIcon; ?><?php echo $this->escape($item->name); ?></a>
											<?php else : ?>
												<?php echo $this->escape($item->name); ?>
											<?php endif; ?>
										</div>
									</td>
									<td class="hidden-sm-down text-center">
										<?php echo $item->id; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				<?php endif; ?>

				<input type="hidden" name="task" value="">
				<input type="hidden" name="boxchecked" value="0">
				<?php echo JHtml::_('form.token'); ?>
			</div>
		</div>
	</div>
</form>
