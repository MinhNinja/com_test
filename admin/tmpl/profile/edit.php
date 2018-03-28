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
JHtml::_('behavior.formvalidator');
?>

<form action="<?php echo JRoute::_('index.php?option=com_test&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="profile-form" class="form-validate">

	<div>
		<div class="row">
			<div class="col-md-12">
				<?php
				echo $this->form->renderField('user_id');
				echo $this->form->renderField('fields'); 
				echo $this->form->renderField('state'); 
				echo $this->form->renderField('id');
				?>
			</div> 
		</div>		
	</div>

	<input type="hidden" name="task" value="">
	<?php echo JHtml::_('form.token'); ?>
</form>
